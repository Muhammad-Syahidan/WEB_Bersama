<?php 
include "../assets/koneksi.php";

$id = $_GET['id'];


$sql = "DELETE FROM detail_beli WHERE iddetailbeli='$id'";

if ($conn->query($sql)) {
    echo "<script>alert('Item Berhasil Dihapus');</script>";
   
    echo "<meta http-equiv='refresh' content='0; url=main.php?p=detail_beli_manage'>";
} else {
    echo "<script>alert('Gagal Hapus');</script>";
    echo "<meta http-equiv='refresh' content='0; url=main.php?p=detail_beli_manage'>";
}
?>