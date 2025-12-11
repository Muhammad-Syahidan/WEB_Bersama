<?php 
include "../assets/koneksi.php";

$id = $_GET['id'];

// Hapus Item
$sql = "DELETE FROM detail_jual WHERE iddetailjual='$id'";

if ($conn->query($sql)) {
    echo "<script>alert('Item Berhasil Dihapus');</script>";
    // Redirect kembali ke halaman detail manage
    echo "<meta http-equiv='refresh' content='0; url=main.php?p=detail_jual_manage'>";
} else {
    echo "<script>alert('Gagal Hapus');</script>";
    echo "<meta http-equiv='refresh' content='0; url=main.php?p=detail_jual_manage'>";
}
?>