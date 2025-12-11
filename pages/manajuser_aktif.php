<?php
include "assets/koneksi.php";
$id = $_GET['id'];
$aktif =$_GET['ak'];


if ($aktif == 1) {
    $sql = "UPDATE user_list SET activ='0' WHERE id=$id";
    if (mysqli_query($conn, $sql)) {

        echo "<script>alert('User berhasil dinonaktifkan');</script>";
        echo "<meta http-equiv='refresh' content='0; url=main.php?p=manajuser'>";
    }
    
} else {
    $sql = "UPDATE user_list SET activ='1' WHERE id=$id";
     if (mysqli_query($conn, $sql)) {

        echo "<script>alert('User berhasil aktifkan');</script>";
        echo "<meta http-equiv='refresh' content='0; url=main.php?p=manajuser'>";
    }
}





?>