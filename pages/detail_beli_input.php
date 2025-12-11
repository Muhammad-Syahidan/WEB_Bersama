<form action="pages/detail_beli_save.php" method="POST" enctype="multipart/form-data">


    <div class="mb-3">
        <label for="tanggal" class="form-label">Faktur:</label>
        <input type="text" class="form-control" name="faktur" value="<?php echo $faktur; ?>" required>      
    </div>

     <div class="mb-3">
        <label for="tanggal" class="form-label">Kode:</label>
        <input type="text" class="form-control" name="kode" value="<?php echo $kode; ?>" required>      
    </div>

   <div class="mb-3">
        <label for="tanggal" class="form-label">Jumlah:</label>
        <input type="text" class="form-control" name="jumlah" value="<?php echo $jumlah; ?>" required>      
    </div>

    <div class="mb-3">
        <label for="tanggal" class="form-label">Harga:</label>
        <input type="text" class="form-control" name="harga" value="<?php echo $harga; ?>" required>      
    </div>

    <button name="simpan" type="submit" class="btn btn-primary">Submit</button>
    <button type="reset" class="btn btn-primary">Reset</button>

    <a href="main.php?p=penjualan" class="btn btn-warning">Daftar penjualan</a>

</form>