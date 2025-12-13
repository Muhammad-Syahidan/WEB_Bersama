<?php
include "assets/koneksi.php";

$kode = $_GET["kode"] ?? null;
if (!$kode) {
    echo "<script>alert('Kode tidak ditemukan!'); window.location='main.php?p=manajnews';</script>";
    exit;
}

$sql = "SELECT * FROM news WHERE kode=$kode";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
?>

<h3>Edit Data Berita</h3>
<hr>

<form action="pages/manajnews_editsave.php" method="POST" enctype="multipart/form-data">
    
    <input type="hidden" name="kode" value="<?= htmlspecialchars($kode) ?>">

    <div class="mb-3 mt-3">
        <label for="tanggal" class="form-label">Tanggal</label>
        <input type="date" class="form-control" id="tanggal" required name="tanggal" value="<?= htmlspecialchars($row['tanggal']) ?>">
    </div>

    <div class="mb-3">
        <label for="jenis_berita" class="form-label">Jenis Berita</label>
        <input type="text" class="form-control" id="jenis_berita" name="jenis_berita" value="<?= htmlspecialchars($row['jenis_berita']) ?>" required>
    </div>
    <div class="mb-3">
        <label for="isi_berita" class="form-label">Isi Berita</label>
        <input type="text" class="form-control" id="isi_berita" name="isi_berita" value="<?= htmlspecialchars($row['isi_berita']) ?>" required>
    </div>

    <div class="mb-3">
        <label for="sumber" class="form-label">Sumber</label>
        <input type="text" class="form-control" id="sumber" name="sumber" value="<?= htmlspecialchars($row['sumber']) ?>" required>
    </div>

    <button name="simpan" type="submit" class="btn btn-primary">Submit</button>
    <button type="reset" class="btn btn-primary">Reset</button>

    <a href="main.php?p=manajuser" class="btn btn-warning">Manajemen User</a>

</form>
