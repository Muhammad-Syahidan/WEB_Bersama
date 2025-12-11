<?php
include "assets/koneksi.php";

    $id = $_GET["id"];

    $sql = "SELECT * FROM databarang WHERE id=$id";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0){
        while($row=mysqli_fetch_assoc($result)){
            $kode = $row['kode'];
            $nama = $row['nama'];
            $satuan = $row['satuan'];
            $aktif = $row['aktif'];
            $hapus = $row['hapus'];
        }
    }

?>

<form action="pages/databarang_editsave.php?id=<?php echo $id ?>" method="POST" enctype="multipart/form-data">

    <div class="mb-3 mt-3">
        <label for="user" class="form-label">kode:</label>
        <input type="text" class="form-control" id="kode" placeholder="Masukkan kode anda" name="kode" value="<?php echo $kode; ?>">
    </div>

    <div class="mb-3 mt-3">
        <label for="user" class="form-label">nama:</label>
        <input type="text" class="form-control" id="nama" placeholder="Masukkan nama anda" name="nama" value="<?php echo $nama; ?>">
    </div>
   
     <div class="mb-3 mt-3">
        <label for="user" class="form-label">satuan:</label>
        <input type="text" class="form-control" id="satuan" placeholder="Masukkan satuan" name="satuan" value="<?php echo $satuan; ?>">
    </div>


    <button type="submit" name="simpan" class="btn btn-primary">Submit</button>
    <button type="reset" class="btn btn-primary">Reset</button>

    <a href="main.php?p=databarang" class="btn btn-warning">Data barang</a>

</form>