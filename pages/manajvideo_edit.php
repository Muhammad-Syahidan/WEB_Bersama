<?php
include "assets/koneksi.php";

$id = $_GET["id"] ?? null;
if (!$id) {
    echo "<script>alert('ID tidak ditemukan!'); window.location='main.php?p=manajvideo';</script>";
    exit;
}

$sql = "SELECT * FROM video WHERE id=$id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
?>

<h3>Edit Data Video</h3>
<hr>

<form action="pages/manajvideo_editsave.php" method="POST">
    <!-- ID dikirim lewat hidden input -->
    <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">

    <div class="mb-3">
        <label for="video" class="form-label">Video:</label>
        <input type="text" class="form-control" id="video" name="video" value="<?= htmlspecialchars($row['video']) ?>" required>
    </div>

    <div class="mb-3">
        <label for="keterangan" class="form-label">Keterangan:</label>
        <input type="text" class="form-control" id="keterangan" name="keterangan" value="<?= htmlspecialchars($row['keterangan']) ?>" required>
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="main.php?p=manajvideo" class="btn btn-warning">Kembali</a>
</form>
