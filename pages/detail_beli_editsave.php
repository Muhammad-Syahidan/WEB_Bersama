<?php
include "../assets/koneksi.php";

if(isset($_POST['update'])){
    $id     = $_POST['id'];
    $jumlah = $_POST['jumlah'];
    

    $sql = "UPDATE detail_beli SET jumlah = '$jumlah' WHERE iddetailbeli = '$id'";
    
    if($conn->query($sql)){
        
      
        echo "<script>
                alert('Data Berhasil Diupdate!'); 
                window.location.href='../main.php?p=detail_beli';
              </script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>