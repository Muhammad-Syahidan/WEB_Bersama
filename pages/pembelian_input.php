<?php
    // Generate Faktur Otomatis: BUY-TanggalJam
    $faktur_otomatis = "BUY-" . date('YmdHis');
?>

<div class="user-management">
    <h3 class="fw-bold mb-3 text-light">Input Pembelian (Restock)</h3>
    <hr class="border-secondary">

    <form action="pages/pembelian_save.php" method="POST">

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label text-info">No. Faktur:</label>
                <input type="text" name="faktur" class="form-control bg-secondary text-white" value="<?= $faktur_otomatis ?>" readonly>
            </div>
            <div class="col-md-6">
                <label class="form-label">Tanggal Masuk:</label>
                <input type="date" name="tanggal" class="form-control" value="<?= date('Y-m-d') ?>" required>
            </div>
        </div>

        <hr class="border-secondary">

        <div class="mb-3">
            <label class="form-label text-warning">Pilih Barang:</label>
            <select name="kode" class="form-select" required>
                <option value="">-- Pilih Barang --</option>
                <?php 
                    // Ambil data barang dari databarang
                    $sql_brg = "SELECT * FROM databarang WHERE hapus = 0 ORDER BY nama ASC";
                    $q_brg = $conn->query($sql_brg);
                    
                    while($r = $q_brg->fetch_assoc()){
                        // PENTING: Value diisi KODE (A1), bukan ID (1)
                        echo "<option value='".$r['kode']."'>".$r['nama']." (Kode: ".$r['kode'].")</option>";
                    }
                ?>
            </select>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label fw-bold">Harga Beli Satuan (Rp):</label>
                <input type="number" name="harga_beli" id="harga_beli" class="form-control" placeholder="0" required oninput="hitungModal()">
                <small class="text-muted">Harga modal dari supplier.</small>
            </div>

            <div class="col-md-4">
                <label class="form-label fw-bold">Jumlah Masuk:</label>
                <input type="number" name="jumlah" id="jumlah" class="form-control" placeholder="0" required oninput="hitungModal()">
            </div>
            
            <div class="col-md-4">
                <label class="form-label text-warning">Total Modal:</label>
                <input type="text" id="total_display" class="form-control bg-dark text-warning fw-bold" readonly value="Rp 0">
                <input type="hidden" name="grand_total_beli" id="grand_total_beli">
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2 mt-4">
            <a href="main.php?p=pembelian_manage" class="btn btn-secondary">Batal</a>
            <button type="submit" name="simpan_beli" class="btn btn-primary px-4">
                <i class="bi bi-save me-2"></i> Simpan Stok
            </button>
        </div>

    </form>
</div>

<script>
function hitungModal() {
    let harga = document.getElementById('harga_beli').value || 0;
    let jumlah = document.getElementById('jumlah').value || 0;
    let total = parseInt(harga) * parseInt(jumlah);
    
    document.getElementById('grand_total_beli').value = total;
    document.getElementById('total_display').value = "Rp " + total.toLocaleString('id-ID');
}
</script>