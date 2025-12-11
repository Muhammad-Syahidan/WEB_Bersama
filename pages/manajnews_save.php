<?php 
    include "../assets/koneksi.php";
    $tanggal = $_POST["tanggal"];
    $jenis_berita = $_POST["jenis_berita"];
    $isi_berita = $_POST["isi_berita"];
    $sumber = $_POST["sumber"];

    

   
        $sql = "INSERT INTO news (tanggal, jenis_berita, isi_berita, sumber, hapus)
        VALUES ('$tanggal', '$jenis_berita', '$isi_berita', '$sumber', '1')";



        if (mysqli_query($conn, $sql)) {

            header("location:../main.php?p=manajnews");

            echo "<script>alert('Anda Berhasil Menyimpan data User...');</script>";
        }

?>