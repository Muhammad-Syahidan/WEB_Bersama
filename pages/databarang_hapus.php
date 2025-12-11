<?php 
include __DIR__ . '/../assets/koneksi.php';
$id = (int) $_GET['id'];

$sql = "UPDATE databarang SET hapus=1 WHERE id=$id";

if (mysqli_query($conn, $sql)) {
    echo '<script>alert("Data Berhasil Dihapus");</script>';
    // REDIRECT PAKE POST
    echo '
    <form id="redirectForm" action="main.php" method="POST">
        <input type="hidden" name="p" value="databarang_input">
    </form>
    <script>document.getElementById("redirectForm").submit();</script>
    ';
} else {
    echo "<script>alert('Gagal menghapus data'); window.history.back();</script>";
}
?>