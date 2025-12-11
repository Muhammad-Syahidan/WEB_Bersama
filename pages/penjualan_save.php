<?php
// 1. WAJIB INCLUDE KONEKSI
include "../assets/koneksi.php"; 

// Cek apakah tombol ditekan
if (isset($_POST['beli_sekarang'])) {
    
    // 2. TANGKAP DATA & CEK APAKAH KOSONG
    $nota             = $_POST['nota'];
    $tanggal          = $_POST['tanggal'];
    $kode             = $_POST['kode'];
    $jumlah           = $_POST['jumlah'];
    $grand_total_jual = $_POST['grand_total_jual'];

    // Debugging: Cek data sebelum disimpan (Bisa dihapus nanti)
    if(empty($nota) || empty($kode) || empty($grand_total_jual)) {
        die("STOP! Data tidak lengkap. <br>Nota: $nota <br>Kode: $kode <br>Total: $grand_total_jual");
    }

    // 3. PROSES SIMPAN KE TABEL PENJUALAN (HEADER)
    // Cek dulu, notanya sudah ada belum?
    $cek_nota = $conn->query("SELECT * FROM penjualan WHERE nota = '$nota'");
    
    if ($cek_nota->num_rows == 0) {
        // Jika belum ada, buat baru
        $sql_header = "INSERT INTO penjualan (nota, tanggal, grand_total_jual) 
                       VALUES ('$nota', '$tanggal', '$grand_total_jual')";
        
        if (!$conn->query($sql_header)) {
            die("GAGAL SIMPAN TABEL PENJUALAN: " . $conn->error);
        }
    } else {
        // Jika sudah ada (jarang terjadi di mode ini), update totalnya
        $sql_header = "UPDATE penjualan SET grand_total_jual = grand_total_jual + $grand_total_jual 
                       WHERE nota = '$nota'";
        $conn->query($sql_header);
    }

    // 4. PROSES SIMPAN KE TABEL DETAIL_JUAL (RINCIAN) -- INI BAGIAN PENTINGNYA
    // Pastikan nama kolom SAMA PERSIS dengan database Anda: 
    // (nota, kode, jumlah, total_harga)
    
    $sql_detail = "INSERT INTO detail_jual (nota, kode, jumlah, total_harga) 
                   VALUES ('$nota', '$kode', '$jumlah', '$grand_total_jual')";
             
    if (!$conn->query($sql_detail)) {
        // Jika error, tampilkan pesan error SQL-nya biar ketahuan salahnya dimana
        die("GAGAL SIMPAN KE DETAIL_JUAL: " . $conn->error . "<br>Query: " . $sql_detail);
    }

    // 5. UPDATE STOK GUDANG (KURANGI STOK)
    $sql_stock = "UPDATE stock SET jumlah = jumlah - $jumlah WHERE kode = '$kode'";
    
    if (!$conn->query($sql_stock)) {
        die("GAGAL UPDATE STOCK: " . $conn->error);
    }

    // 6. SUKSES
    echo "<script>
            alert('Pembelian Berhasil Disimpan!\\nNota: $nota'); 
            window.location.href = '../main.php?p=penjualan';
          </script>";
} else {
    echo "Akses dilarang. Silakan dari form pembelian.";
}
?>