<form action="pages/manajuser_save.php" method="POST" enctype="multipart/form-data">

    <div class="mb-3 mt-3">
        <label for="user" class="form-label">user:</label>
        <input type="text" class="form-control" id="user" placeholder="Masukkan user anda" name="user">
    </div>

    <div class="mb-3">
        <label for="pasw" class="form-label">Password:</label>
        <input type="password" class="form-control" id="pasw" placeholder="Masukan password anda " name="pasw">
    </div>

    <div class="mb-3">
        <label for="auth" class="form-label">Authorize:</label>
        <select class="form-select" id="auth" name="auth">
            <option>Administrator</option>
            <option>Gudang</option>
            <option>Penjualan</option>
            <option>Pembelian</option>
            <option>Ahli</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="avatar" class="form-label">Avatar:</label>
        <input type="file" class="form-control" id="avatar" name="avatar">
    </div>

    <div class="mb-3">
        <label for="keterangan" class="form-label">Keterangan:</label>
        <input type="text" class="form-control" id="keterangan" name="keterangan">
    </div>

    <button name="simpan" type="submit" class="btn btn-primary">Submit</button>
    <button type="reset" class="btn btn-primary">Reset</button>

    <a href="main.php?p=manajuser" class="btn btn-warning">Manajemen User</a>

</form>