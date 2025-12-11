<?php
include "koneksi.php";

$user = $_POST['user'];
$pasw = $_POST['pasw'];
$auth = $_POST['auth'];
$keterangan = $_POST['keterangan'] ?? '';

$target_dir = "../img/";
$avatar = "default.png"; // default jika tidak upload
$uploadOk = 1;

if (!is_dir($target_dir)) {
    mkdir($target_dir, 0777, true);
}

if (isset($_FILES["avatar"]) && $_FILES["avatar"]["error"] == 0) {
    $imageFileType = strtolower(pathinfo($_FILES["avatar"]["name"], PATHINFO_EXTENSION));
    if (in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
        $avatar = time() . "_" . uniqid() . "." . $imageFileType;
        $target_file = $target_dir . $avatar;
        if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)) {
            // Upload sukses
        } else {
            $uploadOk = 0;
        }
    } else {
        $uploadOk = 0;
    }
}

if ($uploadOk == 1) {
    $sql = "INSERT INTO user_list (user, pasw, auth, avatar, keterangan) 
            VALUES ('$user', '$pasw', '$auth', '$avatar', '$keterangan')";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: Location: ../main.php");
        exit();
  } else {
  echo "<script>alert('Anda tidak punya akses ke sistem');</script>";
  header("Location: ../index.php");

}
}
?>