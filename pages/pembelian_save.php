<?php
include "../assets/koneksi.php";

if (isset($_POST['simpan_beli'])) {
    
    // Tangkap Data
    $faktur      = $_POST['faktur'];
    $tanggal     = $_POST['tanggal'];
    $kode        = $_POST['kode'];       
    $harga_beli  = $_POST['harga_beli']; 
    $jumlah      = $_POST['jumlah'];     
    $grand_total = $_POST['grand_total_beli'];

    // --- VALIDASI PENTING ---
    // Mencegah masuknya data kosong / hantu
    if (empty($kode) || $kode == "") {
        echo "<script>
                alert('GAGAL: Kode Barang tidak terdeteksi! Silakan pilih barang ulang.'); 
                window.history.back();
              </script>";
        exit(); 
    }

    // 1. SIMPAN KE TABEL PEMBELIAN (Header)
    $sql1 = "INSERT INTO pembelian (faktur, tanggal, grand_total_beli) 
             VALUES ('$faktur', '$tanggal', '$grand_total')";
    
    if (!$conn->query($sql1)) {
        die("Gagal Simpan Header: " . $conn->error);
    }

    // 2. SIMPAN KE DETAIL_BELI (Arsip)
    $sql2 = "INSERT INTO detail_beli (faktur, kode, jumlah, total_harga) 
             VALUES ('$faktur', '$kode', '$jumlah', '$grand_total')";
    $conn->query($sql2);

    // 3. UPDATE STOK (LOGIKA MERGE)
    // Cek apakah kode barang ini sudah ada di tabel stock?
    $cek_stok = $conn->query("SELECT * FROM stock WHERE kode = '$kode'");
    
    if ($cek_stok->num_rows > 0) {
        // SUDAH ADA -> Update tambah jumlah (Stok Lama + Stok Baru)
        $sql3 = "UPDATE stock SET jumlah = jumlah + $jumlah WHERE kode = '$kode'";
        $conn->query($sql3);
    } else {
        // BELUM ADA -> Insert baru (Hanya terjadi jika barang benar-benar baru diinput)
        $sql3 = "INSERT INTO stock (kode, jumlah) VALUES ('$kode', '$jumlah')";
        $conn->query($sql3);
    }

    // 4. UPDATE HARGA BELI (Di Tabel Harga)
    $cek_harga = $conn->query("SELECT * FROM harga WHERE kode = '$kode'");

    if ($cek_harga->num_rows > 0) {
        // SUDAH ADA -> Update harga beli terbaru
        $sql4 = "UPDATE harga SET harga_beli = '$harga_beli' WHERE kode = '$kode'";
        $conn->query($sql4);
    } else {
        // BELUM ADA -> Insert baru
        $sql4 = "INSERT INTO harga (kode, harga_jual, harga_beli) VALUES ('$kode', 0, '$harga_beli')";
        $conn->query($sql4);
    }

    // 5. REDIRECT KE MANAJEMEN PEMBELIAN
    echo "<script>
            alert('Stok Berhasil Ditambahkan & Harga Diperbarui!'); 
            // Kembali ke halaman transaksi pembelian (Bukan Laporan)
            window.location.href = '../main.php?p=pembelian'; 
          </script>";
}
?>