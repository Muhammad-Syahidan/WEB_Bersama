<?php
    $id = $_GET['id'];
    // Ambil data harga
    $sql = "SELECT harga.*, databarang.nama FROM harga 
            LEFT JOIN databarang ON harga.kode = databarang.kode 
            WHERE idharga='$id'";
    $res = $conn->query($sql);
    $data = $res->fetch_assoc();
?>
<div class="user-management">
    <h3 class="fw-bold mb-3 text-light">Update Harga Jual</h3>
    <div class="card bg-dark border-success shadow-lg text-white">
        <div class="card-body p-4">
            <form action="pages/harga_jual_save.php" method="POST">
                <input type="hidden" name="idharga" value="<?= $id ?>">
                
                <div class="mb-3">
                    <label class="text-light">Nama Barang:</label>
                    <input type="text" class="form-control bg-secondary text-white border-0 fw-bold" value="<?= $data['nama'] ?>" readonly>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="text-white">Harga Beli (Modal):</label>
                        <input type="text" class="form-control bg-secondary text-white border-0" value="Rp <?= number_format($data['harga_beli']) ?>" readonly>
                        <small class="text-white">*Anda tidak dapat mengubah harga beli.</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-success fw-bold">Harga Jual (Baru):</label>
                        <input type="number" name="harga_jual" class="form-control text-white bg-dark border-success" value="<?= $data['harga_jual'] ?>" required>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="main.php?p=harga_jual_input" class="btn btn-secondary">Batal</a>
                    <button type="submit" name="simpan" class="btn btn-success">Simpan Harga Jual</button>
                </div>
            </form>
        </div>
    </div>
</div>