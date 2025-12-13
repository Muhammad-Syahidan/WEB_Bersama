<?php 
    include "../assets/koneksi.php";

    $kode = $_POST["kode"];
    $nama = $_POST["nama"];
    $satuan = $_POST["satuan"];
   
    if (isset($_POST["simpan"])) {
        $sqldataBarang = "INSERT INTO databarang (kode, nama, satuan, aktif, hapus)
        VALUES ('$kode', '$nama', '$satuan', 1, 0)";

        $sqlstock = "INSERT INTO stock (kode, jumlah) VALUES ('$kode', 0)";
        $sqlharga = "INSERT INTO harga (kode, harga_jual, harga_beli) VALUES ('$kode', 0, 0)";

        if (mysqli_query($conn, $sqldataBarang)) {
            mysqli_query($conn, $sqlstock);
            mysqli_query($conn, $sqlharga);

        
            echo '
            <form id="redirectForm" action="../main.php" method="POST">
                <input type="hidden" name="p" value="databarang_input">
            </form>
            <script>document.getElementById("redirectForm").submit();</script>
            ';
        }
        else {
             echo "<script>alert('Gagal menyimpan...'); window.history.back();</script>";
        }
    }
?>