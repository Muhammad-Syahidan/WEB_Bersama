<?php
include "../assets/koneksi.php";

if(isset($_POST['simpan'])){
    
    // Pastikan teks di dalam kurung siku ['...'] SAMA PERSIS dengan name di form
    $idharga = $_POST['idharga'];     // Mengambil dari <input name="idharga">
    $harga   = $_POST['harga_jual'];  // Mengambil dari <input name="harga_jual">

    // Query Update
    $sql = "UPDATE harga SET harga_jual='$harga' WHERE idharga='$idharga'";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Anda Berhasil Mengubah harga jual');window.location.href='../main.php?p=harga';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>