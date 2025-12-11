<?php
include "../assets/koneksi.php";
if(isset($_POST['simpan'])){
    $id = $_POST['idharga'];
    $jual = $_POST['harga_jual'];
    
    $sql = "UPDATE harga SET harga_jual='$jual' WHERE idharga='$id'";
    if($conn->query($sql)){
        echo "<script>alert('Harga Jual Berhasil Diupdate!'); window.location.href='../main.php?p=harga_jual_input';</script>";
    }
}
?>