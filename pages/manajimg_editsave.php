<?php 
include "../assets/koneksi.php";

if (isset($_POST["simpan"])) {

    $id = intval($_POST['id']);
    $keterangan = mysqli_real_escape_string($conn, $_POST['keterangan']);
    $hapus = 1;

    $target_dir = "../img/";
    $avatar = basename($_FILES["images"]["name"]);
    $target_file = $target_dir . $avatar;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Validasi file gambar
    $check = getimagesize($_FILES["images"]["tmp_name"]);
    if($check === false) {
        echo "File bukan gambar.";
        $uploadOk = 0;
    }

    // Validasi tipe file
    if(!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
        echo "Hanya file JPG, JPEG, PNG, & GIF yang diizinkan.";
        $uploadOk = 0;
    }

    // Upload file jika lolos validasi
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["images"]["tmp_name"], $target_file)) {
            $sql = "UPDATE images 
                    SET images='$avatar', keterangan='$keterangan', hapus='$hapus' 
                    WHERE id=$id";

            if (mysqli_query($conn, $sql)) {
                echo "<script>alert('Data gambar berhasil diperbarui!'); window.location='../main.php?p=manajimg';</script>";
            } else {
                echo "<script>alert('Gagal menyimpan data: " . mysqli_error($conn) . "'); window.location='../main.php?p=manajimg';</script>";
            }
        } else {
            echo "Terjadi kesalahan saat mengunggah file.";
        }
    }
}
?>
