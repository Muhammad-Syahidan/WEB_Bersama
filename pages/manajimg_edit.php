<?php
include "assets/koneksi.php";

$id = $_GET["id"];
$sql = "SELECT * FROM images WHERE id=$id";
$result = mysqli_query($conn, $sql);

if ($row = mysqli_fetch_assoc($result)) {
    $images = $row['images'];
    $keterangan = $row['keterangan'];
} else {
    echo "<p>Data tidak ditemukan!</p>";
    exit;
}
?>

<h3>Edit Data Gambar</h3>
<hr>

<form action="pages/manajimg_editsave.php" method="POST" enctype="multipart/form-data">
    <!-- Kirim ID dan nama file lama -->
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    <div class="mb-3">
        <label for="images" class="form-label">Gambar Baru:</label>
        <input type="file" class="form-control" id="images" name="images" required>
        <br>
        <img src="img/<?php echo htmlspecialchars($images); ?>" alt="Preview" width="20%">
    </div>

    <div class="mb-3">
        <label for="keterangan" class="form-label">Keterangan:</label>
        <input type="text" class="form-control" id="keterangan" name="keterangan" value="<?= htmlspecialchars($keterangan) ?>" required>
    </div>

    <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
    <a href="main.php?p=manajimg" class="btn btn-warning">Kembali</a>
</form>
