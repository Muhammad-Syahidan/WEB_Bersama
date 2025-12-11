<?php
include "../assets/koneksi.php";

if(isset($_POST['simpan'])){
    

    $idjual = $_POST['idjual'];    
    $nota   = $_POST['nota'];  
    $grand_total_jual = $_POST['grand_total_jual'];  
    // Query Update
    $sql = "UPDATE penjualan SET nota='$nota', grand_total_jual='$grand_total_jual' WHERE idjual='$idjual'";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Anda Berhasil Mengubah harga jual');window.location.href='../main.php?p=penjualan';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>