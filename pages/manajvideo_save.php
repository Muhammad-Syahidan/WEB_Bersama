<?php 
    include "../assets/koneksi.php";
    $video = $_POST["video"];
    $keterangan = $_POST["keterangan"];
    

   
        $sql = "INSERT INTO video (video, keterangan, hapus)
        VALUES ('$video', '$keterangan', '1')";



        if (mysqli_query($conn, $sql)) {

            header("location:../main.php?p=manajvideo");

            echo "<script>alert('Anda Berhasil Menyimpan data User...');</script>";
        }

?>