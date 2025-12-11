<?php
include "../assets/koneksi.php";

if(isset($_POST['simpan'])){
    
    $idharga = $_POST['idharga'];
    // Harga Jual TIDAK DIAMBIL / TIDAK DIUPDATE
    $harga_beli = $_POST['harga_beli']; 

    // Query Update HANYA harga_beli
    $sql = "UPDATE harga SET harga_beli='$harga_beli' WHERE idharga='$idharga'";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
                alert('Harga Beli Berhasil Diperbarui!');
                window.location.href='../main.php?p=harga_input';
              </script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>