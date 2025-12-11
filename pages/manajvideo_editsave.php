<?php 
    include "../assets/koneksi.php";
    $id = $_GET['id'];
   

    $user = $_POST["user"];
    $pasw = $_POST["pasw"];
    $auth = $_POST["auth"];
    $keterangan = $_POST["keterangan"];
    
    if($avatar<>""){

    $target_dir = "../img/";
    $target_file = $target_dir . basename($_FILES["avatar"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        // Check if image file is a actual image or fake image
            if(isset($_POST["submit"])) {
                $check = getimagesize($_FILES["avatar"]["tmp_name"]);
            if($check !== false) {
                $uploadOk = 1;
            } else {
            $uploadOk = 0;
        }
    }


    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
        $uploadOk = 0;
    }
        $avatar = basename($_FILES["avatar"]["name"]);

    }
    

    
    if (isset($_POST["simpan"])) {

        $avatar = basename($_FILES["avatar"]["name"]);

        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)) {
                echo "The file ". htmlspecialchars( basename( $_FILES["avatar"]["name"])). " has been uploaded.";
            }
        }
      

            $sql = "UPDATE user_list SET user='$user', pasw='$pasw', auth='$auth', avatar='$avatar', keterangan='$keterangan', activ='1' WHERE id=$id";
        if (mysqli_query($conn, $sql)) {

            header("location:../main.php?p=manajuser");

            echo "<script>alert('Anda Berhasil Menyimpan data User...');</script>";
        }
    }

?>