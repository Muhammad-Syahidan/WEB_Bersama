<?php 
include "../assets/koneksi.php";

if (!isset($_POST['kode'])) {
    echo "<script>alert('Kode tidak ditemukan saat simpan!'); window.location='../main.php?p=manajnews';</script>";
    exit;
}



$kode = intval($_POST['kode']);
$tanggal = mysqli_real_escape_string($conn, $_POST['tanggal']);
$jenis_berita = mysqli_real_escape_string($conn, $_POST['jenis_berita']);
$isi_berita = mysqli_real_escape_string($conn, $_POST['isi_berita']);
$sumber = mysqli_real_escape_string($conn, $_POST['sumber']);
$hapus = 1;

$sql = "UPDATE news SET tanggal='$tanggal', jenis_berita='$jenis_berita', isi_berita='$isi_berita', sumber='$sumber', hapus='$hapus' WHERE kode=$kode";

if (mysqli_query($conn, $sql)) {
    echo "<script>alert('Data berita berhasil diperbarui!'); window.location='../main.php?p=manajnews';</script>";
} else {
    echo "<script>alert('Gagal menyimpan data: " . mysqli_error($conn) . "'); window.location='../main.php?p=manajnews';</script>";
}
?>
