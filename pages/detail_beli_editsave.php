<?php
include "../assets/koneksi.php";

if(isset($_POST['update'])){
    $id     = $_POST['id'];
    $jumlah = $_POST['jumlah'];
    
    // Kita update jumlahnya saja. 
    // (Total harga dihitung otomatis di tampilan view, jadi tidak perlu update total_harga di database secara manual jika logika Anda menggunakan Stock x Harga)
    
    $sql = "UPDATE detail_beli SET jumlah = '$jumlah' WHERE iddetailbeli = '$id'";
    
    if($conn->query($sql)){
        
        // OPSI TAMBAHAN: Sinkronisasi ke Tabel Stock?
        // Jika Anda ingin saat detail diedit, stok di gudang juga berubah, perlu logika tambahan disini.
        // Untuk sekarang, kita update tabel detail_beli saja sesuai request.

        echo "<script>
                alert('Data Berhasil Diupdate!'); 
                window.location.href='../main.php?p=detail_beli';
              </script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>