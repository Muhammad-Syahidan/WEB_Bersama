<form action="pages/databarang_save.php" method="POST" enctype="multipart/form-data">

    <div class="mb-3 mt-3">
        <label for="kode" class="form-label">kode:</label>
        <input type="text" class="form-control" id="user" placeholder="Masukkan kode barang" name="kode">
    </div>

    <div class="mb-3">
        <label for="nama" class="form-label">nama:</label>
        <input type="text" class="form-control" id="nama" placeholder="Masukan nama barang " name="nama">
    </div>

    <div class="mb-3">
        <label for="satuan" class="form-label">satuan:</label>
        <input type="text" class="form-control" id="satuan" placeholder="Masukan jumlah barang" name="satuan">
    </div>

    <button name="simpan" type="submit" class="btn btn-primary">Submit</button>
    <button type="reset" class="btn btn-primary">Reset</button>

    <a href="main.php?p=databarang" class="btn btn-warning">Daftar Barang</a>

</form>