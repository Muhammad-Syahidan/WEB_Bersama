<?php
include "../assets/koneksi.php";

if(isset($_POST['simpan'])){
    $idstock = $_POST['idstock'];
    $jumlah  = $_POST['jumlah']; 

    $sql = "UPDATE stock SET jumlah='$jumlah' WHERE idstock='$idstock'";
    $query = mysqli_query($conn, $sql);

    if($query){
        header('Location: ../main.php?p=stock');
    } else {
        echo "Gagal update: " . mysqli_error($conn);
    }
}
?>