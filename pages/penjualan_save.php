<?php
// pages/penjualan_save.php
// Pastikan path ke koneksi benar (relatif dari folder pages/)
include "../assets/koneksi.php";

// 1. Cek apakah tombol simpan diklik
if (isset($_POST['simpan_jual'])) {
    
    // 2. Tangkap semua data dari form
    $nota        = $_POST['nota'];         // "PJ-231025-0001"
    $tanggal     = $_POST['tanggal'];      // "2023-10-25"
    $kode        = $_POST['kode'];         // "A001"
    $jumlah      = (int)$_POST['jumlah'];  // 5 (pastikan jadi angka)
    $total_harga = (int)$_POST['grand_total']; // 500000 (ambil dari hidden input)

    // Validasi Server-side (jaga-jaga jika JS dibypass)
    if(empty($nota) || empty($kode) || $jumlah <= 0 || $total_harga <= 0) {
        echo "<script>alert('Data transaksi tidak valid!'); window.history.back();</script>";
        exit;
    }
    
    // Cek Stok di Database lagi untuk keamanan
    $cek_stok = $conn->query("SELECT jumlah FROM stock WHERE kode = '$kode'");
    $data_stok = $cek_stok->fetch_assoc();
    if ($data_stok['jumlah'] < $jumlah) {
         echo "<script>alert('Gagal! Stok di database tidak mencukupi.'); window.history.back();</script>";
         exit;
    }

    // Mulai Transaksi Database (agar atomik: semua berhasil atau semua gagal)
    $conn->begin_transaction();

    try {
        // 3. Simpan ke Tabel PENJUALAN (Header Nota)
        // Cek dulu, nota ini udah ada belum?
        $cek_nota = $conn->query("SELECT nota FROM penjualan WHERE nota = '$nota'");
        if ($cek_nota->num_rows == 0) {
            // Nota baru: INSERT
            $sql_head = "INSERT INTO penjualan (nota, tanggal, grand_total_jual) VALUES ('$nota', '$tanggal', $total_harga)";
            $conn->query($sql_head);
        } else {
            // Nota sudah ada (nambah barang di nota yg sama): UPDATE totalnya
            $sql_head = "UPDATE penjualan SET grand_total_jual = grand_total_jual + $total_harga WHERE nota = '$nota'";
            $conn->query($sql_head);
        }

        // 4. Simpan ke Tabel DETAIL_JUAL (Item Barang)
        $sql_detail = "INSERT INTO detail_jual (nota, kode, jumlah, total_harga) 
                       VALUES ('$nota', '$kode', $jumlah, $total_harga)";
        $conn->query($sql_detail);
        
        // 5. Update Kurangi Stok Barang
        $sql_stok = "UPDATE stock SET jumlah = jumlah - $jumlah WHERE kode = '$kode'";
        $conn->query($sql_stok);

        // Jika semua query berhasil, commit (simpan permanen)
        $conn->commit();

        // Redirect sukses ke halaman Laporan Detail Jual
        echo "<script>
            alert('Transaksi Penjualan Berhasil Disimpan!'); 
            window.location.href = '../main.php?p=detail_jual_manage';
        </script>";

    } catch (Exception $e) {
        // Jika ada error di salah satu query, rollback (batalkan semua)
        $conn->rollback();
        echo "Terjadi Error Database: " . $e->getMessage();
        // Bisa tambahkan log error di sini jika perlu
    }

} else {
    // Akses langsung tanpa form dilarang
    header("Location: ../main.php?p=penjualan_input");
    exit;
}
?>