<?php 
include "assets/koneksi.php";
$kode = $_GET['kode'];

$sql = "UPDATE news SET hapus=0 WHERE kode=$kode";

if (mysqli_query($conn, $sql)) {

    echo "<script>alert('Data berhasil dihapus');</script>";
    echo "<meta http-equiv='refresh' content='0; url=main.php?p=manajnews'>";
}

?>