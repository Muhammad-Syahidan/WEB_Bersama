<form action="pages/manajvideo_save.php" method="POST" enctype="multipart/form-data">

    <div class="mb-3">
        <label for="video" class="form-label">Video:</label>
        <input type="text" class="form-control" id="video" name="video">
    </div>

    <div class="mb-3">
        <label for="keterangan" class="form-label">Keterangan:</label>
        <input type="text" class="form-control" id="keterangan" name="keterangan">
    </div>

    <button name="simpan" type="submit" class="btn btn-primary">Submit</button>
    <button type="reset" class="btn btn-primary">Reset</button>

    <a href="main.php?p=manajuser" class="btn btn-warning">Manajemen User</a>

</form>