<?php
include "../assets/koneksi.php";

if (isset($_POST['simpan_beli'])) {
    
    // Tangkap Data
    $faktur      = $_POST['faktur'];
    $tanggal     = $_POST['tanggal'];
    $kode        = $_POST['kode'];       // ID Barang
    $harga_beli  = $_POST['harga_beli']; // Harga Modal Baru
    $jumlah      = $_POST['jumlah'];     // Jumlah Tambahan
    $grand_total = $_POST['grand_total_beli'];

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

    // 3. UPDATE STOK (BERTAMBAH)
    // Cek dulu apakah barang ini sudah ada di tabel stock?
    $cek_stok = $conn->query("SELECT * FROM stock WHERE kode = '$kode'");
    
    if ($cek_stok->num_rows > 0) {
        // Barang sudah ada -> Update tambah jumlah
        $sql3 = "UPDATE stock SET jumlah = jumlah + $jumlah WHERE kode = '$kode'";
        $conn->query($sql3);
    } else {
        // Barang belum ada di stok -> Insert baru
        $sql3 = "INSERT INTO stock (kode, jumlah) VALUES ('$kode', '$jumlah')";
        $conn->query($sql3);
    }

    // 4. UPDATE HARGA BELI (Di Tabel Harga)
    // Agar nanti profit margin-nya update sesuai harga kulakan terakhir
    $cek_harga = $conn->query("SELECT * FROM harga WHERE kode = '$kode'");

    if ($cek_harga->num_rows > 0) {
        // Update harga beli terbaru
        $sql4 = "UPDATE harga SET harga_beli = '$harga_beli' WHERE kode = '$kode'";
        $conn->query($sql4);
    } else {
        // Insert jika belum ada di tabel harga
        $sql4 = "INSERT INTO harga (kode, harga_jual, harga_beli) VALUES ('$kode', 0, '$harga_beli')";
        $conn->query($sql4);
    }

    echo "<script>
            alert('Stok Berhasil Ditambahkan!\\nHarga Beli Diperbarui.'); 
            window.location.href = '../main.php?p=pembelian';
          </script>";
}
?>