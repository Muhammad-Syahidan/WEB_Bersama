<?php
include "../assets/koneksi.php";

if (isset($_POST['simpan_beli'])) {
    

    $faktur      = $_POST['faktur'];
    $tanggal     = $_POST['tanggal'];
    $kode        = $_POST['kode'];       
    $harga_beli  = $_POST['harga_beli']; 
    $jumlah      = $_POST['jumlah'];     
    $grand_total = $_POST['grand_total_beli'];

 
    if (empty($kode) || $kode == "") {
        echo "<script>
                alert('GAGAL: Kode Barang tidak terdeteksi! Silakan pilih barang ulang.'); 
                window.history.back();
              </script>";
        exit(); 
    }


    $sql1 = "INSERT INTO pembelian (faktur, tanggal, grand_total_beli) 
             VALUES ('$faktur', '$tanggal', '$grand_total')";
    
    if (!$conn->query($sql1)) {
        die("Gagal Simpan Header: " . $conn->error);
    }

    $sql2 = "INSERT INTO detail_beli (faktur, kode, jumlah, total_harga) 
             VALUES ('$faktur', '$kode', '$jumlah', '$grand_total')";
    $conn->query($sql2);

  
    $cek_stok = $conn->query("SELECT * FROM stock WHERE kode = '$kode'");
    
    if ($cek_stok->num_rows > 0) {
      
        $sql3 = "UPDATE stock SET jumlah = jumlah + $jumlah WHERE kode = '$kode'";
        $conn->query($sql3);
    } else {
     
        $sql3 = "INSERT INTO stock (kode, jumlah) VALUES ('$kode', '$jumlah')";
        $conn->query($sql3);
    }


    $cek_harga = $conn->query("SELECT * FROM harga WHERE kode = '$kode'");

    if ($cek_harga->num_rows > 0) {
     
        $sql4 = "UPDATE harga SET harga_beli = '$harga_beli' WHERE kode = '$kode'";
        $conn->query($sql4);
    } else {
     
        $sql4 = "INSERT INTO harga (kode, harga_jual, harga_beli) VALUES ('$kode', 0, '$harga_beli')";
        $conn->query($sql4);
    }


    echo "<script>
            alert('Stok Berhasil Ditambahkan & Harga Diperbarui!'); 
            // Kembali ke halaman transaksi pembelian (Bukan Laporan)
            window.location.href = '../main.php?p=pembelian'; 
          </script>";
}
?>