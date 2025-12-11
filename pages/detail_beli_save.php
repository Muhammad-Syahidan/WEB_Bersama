<?php 
    include "../assets/koneksi.php";
    $faktur = $_POST["faktur"];
    $kode = $_POST["kode"];
    $jumlah = $_POST["jumlah"];
    $harga = $_POST["harga"];
   
    
    
    if (isset($_POST["simpan"])) {
        $sqldetail_beli = "INSERT INTO detail_beli (faktur, kode, harga)
        VALUES ('$faktur', '$kode', '$harga')";

        $sqlstock = "INSERT INTO stock (kode, jumlah)
        VALUES ('$kode',   0)";

        $sqlharga = "INSERT INTO harga (kode, harga_jual, harga_beli)
        VALUES ('$kode', 0, 0)";



        if (mysqli_query($conn, $sqldetail_beli)) {

            mysqli_query($conn, $sqlstock);
            mysqli_query($conn, $sqlharga);

            header("location:../main.php?p=databarang");

            echo "<script>alert('Anda Berhasil Menyimpan data barang...');</script>";
        }
        else {
             echo "<script>alert('Anda gagal menyimpan...');</script>";
    }

}
?>