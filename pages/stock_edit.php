<?php
include "assets/koneksi.php";

    $idstock = $_GET["idstock"];

    $sql = "SELECT * FROM stock WHERE idstock=$idstock";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0){
        while($row=mysqli_fetch_assoc($result)){
            $idstock = $row['idstock'];
            $kode = $row['kode'];
            $jumlah = $row['jumlah'];
        }
    }

?>

<form action="pages/stock_editsave.php" method="POST">

    <input type="hidden" name="idstock" value="<?php echo $idstock; ?>">

    <div class="mb-3 mt-3">
        <label for="jumlah" class="form-label">Jumlah Stok :</label>
        <input type="number" class="form-control" id="jumlah" name="jumlah" placeholder="Masukkan Jumlah Stok" required>
    </div>

    <button type="submit" name="simpan" class="btn btn-primary">Simpan Perubahan</button>
    <a href="main.php?p=stock" class="btn btn-warning">Kembali</a>

</form>