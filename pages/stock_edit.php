<?php
include "assets/koneksi.php";

    $idstock = $_GET["idstock"];

   
    $sql = "SELECT * FROM stock WHERE idstock=$idstock";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0){
        while($row=mysqli_fetch_assoc($result)){
            $idstock = $row['idstock'];
            $kode = $row['kode'];
            $jumlah = $row['jumlah'];
        }
    }
?>

<div class="user-management">
    <h3 class="fw-bold mb-3 text-light">Update Stok Barang</h3>
    <hr class="border-secondary">

    <div class="card bg-dark text-white border-info shadow-lg">
        <div class="card-body p-4">
            <form action="pages/stock_editsave.php" method="POST">

                <input type="hidden" name="idstock" value="<?php echo $idstock; ?>">

                <div class="mb-3">
                    <label class="form-label text-muted">Kode Barang (System ID):</label>
                    <input type="text" class="form-control bg-secondary text-white border-0" value="<?= $kode ?>" readonly>
                </div>

                <div class="mb-3 mt-3">
                    <label for="jumlah" class="form-label fw-bold text-warning">Jumlah Stok Terbaru:</label>
                    <input type="number" class="form-control" id="jumlah" name="jumlah" value="<?= $jumlah ?>" placeholder="Masukkan Jumlah Stok" required>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="main.php?p=stock_input" class="btn btn-secondary">Batal / Kembali</a>
                    
                    <button type="submit" name="simpan" class="btn btn-primary px-4">
                        <i class="bi bi-save me-1"></i> Simpan Stok
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>