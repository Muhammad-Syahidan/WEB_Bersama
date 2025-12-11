<form action="pages/manajnews_save.php" method="POST" enctype="multipart/form-data">

    <div class="mb-3 mt-3">
        <label for="tanggal" class="form-label">Tanggal</label>
        <input type="date" class="form-control" id="tanggal" placeholder="Masukkan user anda" name="tanggal">
    </div>

    <div class="mb-3">
        <label for="jenis_berita" class="form-label">Jenis Berita</label>
        <input type="text" class="form-control" id="jenis_berita" name="jenis_berita">
    </div>
    <div class="mb-3">
        <label for="isi_berita" class="form-label">Isi Berita</label>
        <input type="text" class="form-control" id="isi_berita" name="isi_berita">
    </div>

    <div class="mb-3">
        <label for="sumber" class="form-label">Sumber</label>
        <input type="text" class="form-control" id="sumber" name="sumber">
    </div>

    <button name="simpan" type="submit" class="btn btn-primary">Submit</button>
    <button type="reset" class="btn btn-primary">Reset</button>

    <a href="main.php?p=manajuser" class="btn btn-warning">Manajemen User</a>

</form>