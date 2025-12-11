<?php
    // Generate Nota Otomatis
    $nota_otomatis = "INV-" . date('YmdHis');
?>

<div class="user-management">
    <h3 class="fw-bold mb-3 text-light">Input Penjualan (Kasir)</h3>
    <hr class="border-secondary">

    <form action="pages/penjualan_save.php" method="POST">

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label text-info">No. Nota:</label>
                <input type="text" name="nota" class="form-control bg-secondary text-white" value="<?= $nota_otomatis ?>" readonly>
            </div>
            <div class="col-md-6">
                <label class="form-label">Tanggal Transaksi:</label>
                <input type="date" name="tanggal" class="form-control" value="<?= date('Y-m-d') ?>" required>
            </div>
        </div>

        <div class="card bg-dark border-secondary p-3 mb-3">
            <div class="row">
                
                <div class="col-md-6 mb-3">
                    <label class="form-label text-warning">Pilih Barang:</label>
                    <select name="kode" id="kode_barang" class="form-select" required onchange="cekHarga()">
                        <option value="" data-harga="0" data-stok="0">-- Pilih Barang --</option>
                        <?php 
                            // Query Aman: Menggunakan COALESCE agar jika harga/stok belum ada, dianggap 0 (Tidak Error)
                            $sql = "SELECT 
                                        d.kode, 
                                        d.nama, 
                                        COALESCE(h.harga_jual, 0) as harga_jual, 
                                        COALESCE(s.jumlah, 0) as jumlah 
                                    FROM databarang d
                                    LEFT JOIN harga h ON d.kode = h.kode
                                    LEFT JOIN stock s ON d.kode = s.kode
                                    WHERE d.hapus = 0 
                                    ORDER BY d.nama ASC";
                            
                            $q = $conn->query($sql);
                            
                            if ($q) {
                                while($r = $q->fetch_assoc()){
                                    // PENTING: Value diisi KODE (A1)
                                    // Data harga & stok disimpan di atribut 'data-'
                                    echo "<option value='".$r['kode']."' 
                                                  data-harga='".$r['harga_jual']."' 
                                                  data-stok='".$r['jumlah']."'>
                                          ".$r['nama']." (Stok: ".$r['jumlah'].")
                                          </option>";
                                }
                            }
                        ?>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label text-muted">Stok Tersedia:</label>
                    <input type="text" id="stok_tersedia" class="form-control bg-secondary text-white border-0" readonly value="0">
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Harga Jual (Rp):</label>
                    <input type="number" name="harga_jual" id="harga_jual" class="form-control bg-secondary text-white" readonly required>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold text-success">Jumlah Beli:</label>
                    <input type="number" name="jumlah" id="jumlah" class="form-control border-success" placeholder="0" min="1" required oninput="hitungTotal()">
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label text-info">Total Bayar:</label>
                    <input type="text" id="total_disp" class="form-control bg-dark text-info fw-bold" readonly value="Rp 0">
                    <input type="hidden" name="grand_total" id="grand_total">
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2">
            <a href="main.php?p=penjualan_manage" class="btn btn-secondary">Batal</a>
            <button type="submit" name="simpan_jual" class="btn btn-primary px-4">
                <i class="bi bi-cart-check me-2"></i> Proses Bayar
            </button>
        </div>

    </form>
</div>

<script>
function cekHarga() {
    var select = document.getElementById("kode_barang");
    var selectedOption = select.options[select.selectedIndex];
    
    // Ambil data dari atribut HTML
    var harga = selectedOption.getAttribute("data-harga") || 0;
    var stok = selectedOption.getAttribute("data-stok") || 0;

    document.getElementById("harga_jual").value = harga;
    document.getElementById("stok_tersedia").value = stok;
    
    hitungTotal(); 
}

function hitungTotal() {
    var harga = parseInt(document.getElementById("harga_jual").value) || 0;
    var jumlah = parseInt(document.getElementById("jumlah").value) || 0;
    var stok = parseInt(document.getElementById("stok_tersedia").value) || 0;

    // Validasi Stok
    if(jumlah > stok) {
        alert("Stok tidak cukup! Sisa stok hanya: " + stok);
        document.getElementById("jumlah").value = stok; 
        jumlah = stok;
    }

    var total = harga * jumlah;
    document.getElementById("grand_total").value = total;
    document.getElementById("total_disp").value = "Rp " + total.toLocaleString('id-ID');
}
</script>