<?php
    // Tangkap Kode Barang yang dipilih buyer
    $kode_dipilih = isset($_GET['kode']) ? $_GET['kode'] : '';

    // Ambil Info Barang tersebut dari Database
    $sql_info = "SELECT stock.kode, databarang.nama, stock.jumlah, harga.harga_jual 
                 FROM stock
                 LEFT JOIN databarang ON stock.kode = databarang.kode
                 LEFT JOIN harga ON stock.kode = harga.kode
                 WHERE stock.kode = '$kode_dipilih'";
    $q_info = $conn->query($sql_info);
    $data = $q_info->fetch_assoc();

    // Generate Nota Otomatis (INV + TanggalJamDetik) -> Unik
    $nota_otomatis = "INV-" . date('YmdHis');
?>

<div class="user-management">
    <h3 class="fw-bold mb-3 text-light">Konfirmasi Pembelian</h3>
    <hr class="border-secondary">

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card bg-dark text-white border-primary shadow-lg">
                <div class="card-header bg-primary text-white fw-bold">
                    Formulir Pemesanan
                </div>
                <div class="card-body p-4">
                    <form action="pages/penjualan_save.php" method="POST">
                        
                        <input type="hidden" name="kode" value="<?= $data['kode'] ?>">
                        <input type="hidden" name="nota" value="<?= $nota_otomatis ?>"> 
                        <input type="hidden" name="tanggal" value="<?= date('Y-m-d') ?>">
                        <input type="hidden" name="grand_total_jual" id="grand_total_jual" value="<?= $data['harga_jual'] ?>">

                        <div class="text-center mb-4">
                            <i class="bi bi-box-seam text-warning fs-1"></i>
                            <h4 class="fw-bold mt-2"><?= $data['nama'] ?></h4>
                            <p class="text-muted">Harga: Rp <?= number_format($data['harga_jual']) ?> / Unit</p>
                            <span class="badge bg-secondary">Sisa Stok: <?= $data['jumlah'] ?></span>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Mau beli berapa?</label>
                            <input type="number" name="jumlah" id="jumlah" class="form-control form-control-lg text-center fw-bold" 
                                   value="1" min="1" max="<?= $data['jumlah'] ?>" required oninput="hitungTotal()">
                        </div>

                        <div class="mb-4 text-center">
                            <label class="text-muted small">Total yang harus dibayar:</label>
                            <h2 class="text-success fw-bold" id="tampilan_total">
                                Rp <?= number_format($data['harga_jual']) ?>
                            </h2>
                            <input type="hidden" name="grand_total_jual" id="grand_total_jual" value="<?= $data['harga_jual'] ?>">
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" name="beli_sekarang" class="btn btn-success btn-lg fw-bold">
                                <i class="bi bi-whatsapp me-2"></i> BAYAR SEKARANG
                            </button>
                            <a href="main.php?p=penjualan" class="btn btn-outline-secondary">Batal / Kembali Belanja</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function hitungTotal() {
        let harga = document.getElementById('harga_satuan').value;
        let jumlah = document.getElementById('jumlah').value;
        
        // Hitung
        let total = parseInt(harga) * parseInt(jumlah);

        // Update Tampilan
        document.getElementById('grand_total_jual').value = total;
        document.getElementById('tampilan_total').innerText = "Rp " + total.toLocaleString('id-ID');
    }
</script>