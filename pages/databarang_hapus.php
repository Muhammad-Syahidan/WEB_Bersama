<?php 
include __DIR__ . '/../assets/koneksi.php';
$id = (int) $_GET['id'];

$sql = "UPDATE databarang SET hapus=1 WHERE id=$id";


if (mysqli_query($conn, $sql)) {

    echo "<script>alert('Data berhasil dihapus');</script>";
    echo "<meta http-equiv='refresh' content='0; url=main.php?p=databarang'>";
}

?>