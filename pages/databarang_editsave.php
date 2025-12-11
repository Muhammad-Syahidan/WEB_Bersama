<?php
include "../assets/koneksi.php";

$id = $_GET['id'];
$kode = $_POST['kode'];
$nama = $_POST['nama'];
$satuan = $_POST['satuan'];


if (isset($_POST["simpan"]))

        $sql = "UPDATE databarang SET 
            kode='$kode',
            nama='$nama',
            satuan='$satuan'
            WHERE id=$id";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Anda Berhasil Mengubah data barang');window.location.href='../main.php?p=databarang';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

?>