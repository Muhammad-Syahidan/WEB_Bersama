<?php
include "../assets/koneksi.php";

$id = $_GET['id'];
$user = $_POST['user'];
$pasw = $_POST['pasw'];
$auth = $_POST['auth'];
$keterangan = $_POST['keterangan'];



$target_dir = "../img/";
$target_file = $target_dir . basename($_FILES["avatar"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if (isset($_POST["submit"])) {
    $check = getimagesize($_FILES["avatar"]["tmp_name"]);
    $uploadOk = ($check !== false) ? 1 : 0;
}
// Allow certain file formats
if (
    $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif"
) {

    $uploadOk = 0;
}



if (isset($_POST["simpan"])) {

    $avatar = $target_file;
    if ($uploadOk == 1 && !empty($_FILES["avatar"]["name"])) {
        if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)) {
            echo "The file " . htmlspecialchars(basename($_FILES["avatar"]["name"])) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
        $sql = "UPDATE user_list SET 
            user='$user',
            pasw='$pasw',
            auth='$auth',
            avatar='$avatar',
            keterangan='$keterangan'
            WHERE id=$id";
    } else {
        // If no file uploaded or upload failed, do not update avatar
        $sql = "UPDATE user_list SET 
            user='$user',
            pasw='$pasw',
            auth='$auth',
            keterangan='$keterangan'
            WHERE id=$id";
    }

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Anda Berhasil Menyimpan data user');window.location.href='../main.php?p=manajuser';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>