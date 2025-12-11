<?php 
include "assets/koneksi.php";
$id = $_GET['id'];

$sql = "UPDATE images SET hapus=0 WHERE id=$id";


if (mysqli_query($conn, $sql)) {

    echo "<script>alert('Data berhasil dihapus');</script>";
    echo "<meta http-equiv='refresh' content='0; url=main.php?p=manajimg'>";
}

?>