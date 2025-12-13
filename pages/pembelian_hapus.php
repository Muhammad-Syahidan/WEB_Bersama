<?php 
include "../assets/koneksi.php";

$id = $_GET['id'];

$conn->query("DELETE FROM detail_beli WHERE faktur = (SELECT faktur FROM pembelian WHERE idbeli='$id')");
$q2 = "DELETE FROM pembelian WHERE idbeli='$id'";

if ($conn->query($q2)) {
    echo "<script>alert('Data Pembelian Berhasil Dihapus');</script>";

    echo "<meta http-equiv='refresh' content='0; url=main.php?p=pembelian_manage'>";
} else {
    echo "<script>alert('Gagal Hapus');</script>";
    echo "<meta http-equiv='refresh' content='0; url=main.php?p=pembelian_manage'>";
}
?>