<?php
    // Ambil ID dari URL
    $id = $_GET['id'];

    // Ambil data yang mau diedit
    $sql = "SELECT * FROM detail_beli WHERE iddetailbeli = '$id'";
    $res = $conn->query($sql);
    $data = $res->fetch_assoc();
?>

<div class="user-management">
    <h3 class="fw-bold mb-3 text-light">Edit Detail Pembelian</h3>
    <hr class="border-secondary">

    <div class="card bg-dark text-white border-info shadow-lg">
        <div class="card-body p-4">
            <form action="pages/detail_beli_editsave.php" method="POST">
                
                <input type="hidden" name="id" value="<?= $data['iddetailbeli'] ?>">

                <div class="mb-3">
                    <label class="form-label text-warning">Faktur:</label>
                    <input type="text" name="faktur" class="form-control" value="<?= $data['faktur'] ?>" readonly>
                    <small class="text-muted">*Faktur tidak bisa diubah</small>
                </div>

                <div class="mb-3">
                    <label class="form-label text-info">Kode Barang:</label>
                    <input type="text" name="kode" class="form-control" value="<?= $data['kode'] ?>" readonly>
                    <small class="text-muted">*Kode barang tidak bisa diubah di sini</small>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Jumlah (Update Stok):</label>
                    <input type="number" name="jumlah" class="form-control" value="<?= $data['jumlah'] ?>" required>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="main.php?p=detail_beli" class="btn btn-secondary">Batal</a>
                    <button type="submit" name="update" class="btn btn-primary px-4">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>