<?php 
include "../assets/koneksi.php";

if (isset($_POST["simpan"])) {
    $keterangan = mysqli_real_escape_string($conn, $_POST["keterangan"]);

    // Pastikan folder tujuan benar
    $target_dir = "../img/";
    $file_name = basename($_FILES["images"]["name"]);
    $target_file = $target_dir . $file_name;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Cek apakah file benar-benar gambar
    $check = getimagesize($_FILES["images"]["tmp_name"]);
    if ($check === false) {
        echo "<script>alert('File bukan gambar!'); window.history.back();</script>";
        $uploadOk = 0;
    }

    // Cek ekstensi
    if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
        echo "<script>alert('Hanya format JPG, JPEG, PNG, GIF!'); window.history.back();</script>";
        $uploadOk = 0;
    }

    // Upload dan simpan ke database
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["images"]["tmp_name"], $target_file)) {
            $sql = "INSERT INTO images (images, keterangan, hapus)
                    VALUES ('$file_name', '$keterangan', 1)";
            if (mysqli_query($conn, $sql)) {
                echo "<script>alert('Upload berhasil!'); window.location='../main.php?p=manajimg';</script>";
            } else {
                echo "<script>alert('Gagal simpan database!'); window.history.back();</script>";
            }
        } else {
            echo "<script>alert('Gagal memindahkan file!'); window.history.back();</script>";
        }
    }
}
?>
