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
    }
}
?>

<div class="user-management">
    <h3 class="fw-bold mb-3 text-light">Edit Barang</h3>
    <hr class="border-secondary">

    <div class="card bg-dark text-white border-secondary shadow-lg">
        <div class="card-body">
            <form action="pages/databarang_editsave.php?id=<?php echo $id ?>" method="POST">
                <div class="mb-3 mt-3">
                    <label for="kode" class="form-label text-warning">Kode:</label>
                    <input type="text" class="form-control" name="kode" value="<?php echo $kode; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="nama" class="form-label text-info">Nama Barang:</label>
                    <input type="text" class="form-control" name="nama" value="<?php echo $nama; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="satuan" class="form-label text-success">Satuan:</label>
                    <input type="text" class="form-control" name="satuan" value="<?php echo $satuan; ?>" required>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <button type="button" class="btn btn-secondary" onclick="goToPage('databarang_input')">Batal / Kembali</button>
                    
                    <button type="submit" name="simpan" class="btn btn-primary px-4">
                        <i class="bi bi-save me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>