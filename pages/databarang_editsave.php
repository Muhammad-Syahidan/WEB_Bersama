<?php
include "../assets/koneksi.php";

$id = $_GET['id'];
$kode = $_POST['kode'];
$nama = $_POST['nama'];
$satuan = $_POST['satuan'];

if (isset($_POST["simpan"])) {

    $sql = "UPDATE databarang SET kode='$kode', nama='$nama', satuan='$satuan' WHERE id=$id";

    if (mysqli_query($conn, $sql)) {
     
        echo '<script>alert("Data Berhasil Diubah");</script>';
        echo '
        <form id="redirectForm" action="../main.php" method="POST">
            <input type="hidden" name="p" value="databarang_input">
        </form>
        <script>document.getElementById("redirectForm").submit();</script>
        ';
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>