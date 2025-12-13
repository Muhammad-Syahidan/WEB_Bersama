<?php

include "../assets/koneksi.php";


if (isset($_POST['simpan_jual'])) {
    
    $nota        = $_POST['nota'];        
    $tanggal     = $_POST['tanggal'];      
    $kode        = $_POST['kode'];         
    $jumlah      = (int)$_POST['jumlah']; 
    $total_harga = (int)$_POST['grand_total']; 

    if(empty($nota) || empty($kode) || $jumlah <= 0 || $total_harga <= 0) {
        echo "<script>alert('Data transaksi tidak valid!'); window.history.back();</script>";
        exit;
    }
    
 
    $cek_stok = $conn->query("SELECT jumlah FROM stock WHERE kode = '$kode'");
    $data_stok = $cek_stok->fetch_assoc();
    if ($data_stok['jumlah'] < $jumlah) {
         echo "<script>alert('Gagal! Stok di database tidak mencukupi.'); window.history.back();</script>";
         exit;
    }

 
    $conn->begin_transaction();

    try {
       
        $cek_nota = $conn->query("SELECT nota FROM penjualan WHERE nota = '$nota'");
        if ($cek_nota->num_rows == 0) {
           
            $sql_head = "INSERT INTO penjualan (nota, tanggal, grand_total_jual) VALUES ('$nota', '$tanggal', $total_harga)";
            $conn->query($sql_head);
        } else {
      
            $sql_head = "UPDATE penjualan SET grand_total_jual = grand_total_jual + $total_harga WHERE nota = '$nota'";
            $conn->query($sql_head);
        }

     
        $sql_detail = "INSERT INTO detail_jual (nota, kode, jumlah, total_harga) 
                       VALUES ('$nota', '$kode', $jumlah, $total_harga)";
        $conn->query($sql_detail);
     
        $sql_stok = "UPDATE stock SET jumlah = jumlah - $jumlah WHERE kode = '$kode'";
        $conn->query($sql_stok);

        
        $conn->commit();

        echo "<script>
            alert('Transaksi Penjualan Berhasil Disimpan!'); 
            window.location.href = '../main.php?p=detail_jual_manage';
        </script>";

    } catch (Exception $e) {
        
        $conn->rollback();
        echo "Terjadi Error Database: " . $e->getMessage();
       
    }

} else {
   
    header("Location: ../main.php?p=penjualan_input");
    exit;
}
?>