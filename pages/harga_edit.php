<?php
    include "assets/koneksi.php";

    $idharga = $_GET["idharga"];

   
    $sql = "SELECT 
                harga.*, 
                databarang.nama 
            FROM harga 
            INNER JOIN databarang ON harga.kode = databarang.kode
            WHERE harga.idharga = $idharga";
            
    $result = mysqli_query($conn, $sql);

  
    $nama_barang = "";
    $harga_jual = 0;
    $harga_beli = 0;

    if (mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            $nama_barang = $row['nama'];
            $harga_jual = $row['harga_jual'];
            $harga_beli = $row['harga_beli'];
        }
    }
?>

<div class="user-management">
    <h3 class="fw-bold mb-3 text-light">Edit Data Harga</h3>
    <hr class="border-secondary">

    <div class="card bg-dark text-white border-secondary shadow-lg">
        <div class="card-body p-4">
            
            <form action="pages/harga_editsave.php" method="POST">

                <input type="hidden" name="idharga" value="<?php echo $idharga; ?>">

                <div class="mb-3">
                    <label class="form-label text-muted">Nama Barang:</label>
                    <input type="text" class="form-control bg-secondary text-white border-0" value="<?= $nama_barang; ?>" readonly>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-warning fw-bold">Harga Beli (Rp):</label>
                        <input type="number" class="form-control" name="harga_beli" value="<?php echo $harga_beli; ?>" required>
                        <small class="text-muted">Harga modal dari supplier.</small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label text-info fw-bold">Harga Jual (Rp):</label>
                        <input type="number" class="form-control" name="harga_jual" value="<?php echo $harga_jual; ?>" required>
                        <small class="text-muted">Harga untuk konsumen.</small>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-3">
                    <a href="main.php?p=harga" class="btn btn-secondary">Batal</a>
                    <button type="submit" name="simpan" class="btn btn-primary px-4">
                        <i class="bi bi-save me-1"></i> Simpan Perubahan
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>