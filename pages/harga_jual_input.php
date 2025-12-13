<?php
  
    $ref_otomatis = "PRC-" . date('YmdHis');


    $barang_data = [];
    $sql_brg = "SELECT b.kode, b.nama, h.harga_beli, h.harga_jual 
                FROM databarang b
                LEFT JOIN harga h ON b.kode = h.kode
                WHERE b.aktif = 1 OR b.aktif = 'Y'
                ORDER BY b.nama ASC";
    $q_brg = $conn->query($sql_brg);
    while($row = $q_brg->fetch_assoc()){
        $barang_data[$row['kode']] = $row;
    }
?>

<div class="user-management">
    <h3 class="fw-bold mb-3 text-light">Setting Harga Jual (Pasar)</h3>
    <hr class="border-secondary">

    <div class="card bg-dark border-secondary shadow-sm mb-5">
        <div class="card-header bg-secondary text-white fw-bold">
            <i class="bi bi-pencil-square me-2"></i> Form Perubahan Harga
        </div>
        <div class="card-body">
            <form action="pages/harga_jual_save.php" method="POST">

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label text-info">No. Referensi:</label>
                        <input type="text" name="ref" class="form-control bg-secondary text-white" value="<?= $ref_otomatis ?>" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Update:</label>
                        <input type="date" name="tanggal" class="form-control" value="<?= date('Y-m-d') ?>" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label text-warning">Pilih Barang:</label>
                    <select name="kode" id="kode_barang" class="form-select" required onchange="isiOtomatis()">
                        <option value="">-- Cari Barang --</option>
                        <?php foreach($barang_data as $brg): ?>
                            <option value="<?= $brg['kode'] ?>">
                                <?= $brg['nama'] ?> (Kode: <?= $brg['kode'] ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold text-muted">Harga Modal (Beli):</label>
                        <div class="input-group">
                            <span class="input-group-text bg-secondary text-light border-secondary">Rp</span>
                            <input type="text" id="harga_beli_disp" class="form-control bg-dark text-white border-secondary" readonly value="0">
                            <input type="hidden" id="harga_beli_asli"> 
                        </div>
                        <small class="text-muted fst-italic">Otomatis dari pembelian terakhir.</small>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold text-success">Set Harga Jual Baru:</label>
                        <input type="number" name="harga_jual" id="harga_jual_input" class="form-control border-success fw-bold" placeholder="0" required oninput="hitungProfit()">
                    </div>
                    
                    <div class="col-md-4">
                        <label class="form-label text-info">Estimasi Keuntungan:</label>
                        <input type="text" id="profit_display" class="form-control bg-dark text-info fw-bold" readonly value="Rp 0">
                        <small id="persen_profit" class="text-white">(0%)</small>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <button type="reset" class="btn btn-secondary" onclick="resetForm()">Reset</button>
                    <button type="submit" name="simpan_harga" class="btn btn-warning fw-bold px-4">
                        <i class="bi bi-check-circle-fill me-2"></i> Update Harga
                    </button>
                </div>

            </form>
        </div>
    </div>

    <h4 class="fw-bold text-light mb-3"><i class="bi bi-list-ul me-2"></i> Daftar Harga Barang Saat Ini</h4>
    <div class="table-responsive">
        <table class="table table-dark table-striped align-middle rounded-3 overflow-hidden border border-secondary">
            <thead class="bg-gradient-primary text-white text-center">
                <tr>
                    <th>No</th> 
                    <th>Kode</th> 
                    <th>Nama Barang</th> 
                    <th>Harga Modal</th> 
                    <th>Harga Jual</th> 
                    <th>Profit (Rp)</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <?php 
                    $no = 1;
                    
                    foreach($barang_data as $row):
                        $modal = $row['harga_beli'];
                        $jual  = $row['harga_jual'];
                        $untung = $jual - $modal;
                        
                     
                        $warna = ($untung > 0) ? "text-success" : (($untung < 0) ? "text-danger" : "text-muted");
                ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td class="text-warning"><?= $row['kode'] ?></td>
                    <td class="text-start ps-4 fw-bold"><?= $row['nama'] ?></td>
                    <td>Rp <?= number_format($modal, 0, ',', '.') ?></td>
                    <td class="fw-bold fs-6">Rp <?= number_format($jual, 0, ',', '.') ?></td>
                    <td class="<?= $warna ?> fw-bold">
                        <?= ($untung >= 0 ? "+" : "") . number_format($untung, 0, ',', '.') ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>

const dbBarang = <?= json_encode($barang_data) ?>;

function isiOtomatis() {
    let kode = document.getElementById('kode_barang').value;
    
    if (kode && dbBarang[kode]) {
        let modal = parseInt(dbBarang[kode].harga_beli);
        let jualLama = parseInt(dbBarang[kode].harga_jual);

   
        document.getElementById('harga_beli_asli').value = modal;
        document.getElementById('harga_beli_disp').value = modal.toLocaleString('id-ID');
        
     
        document.getElementById('harga_jual_input').value = jualLama;
        
        hitungProfit(); 
    } else {
        resetForm();
    }
}

function hitungProfit() {
    let modal = parseInt(document.getElementById('harga_beli_asli').value) || 0;
    let jual  = parseInt(document.getElementById('harga_jual_input').value) || 0;
    
    let profit = jual - modal;
    
    let profitText = "Rp " + profit.toLocaleString('id-ID');
    document.getElementById('profit_display').value = profitText;
    
    let persen = 0;
    if (modal > 0) {
        persen = ((profit / modal) * 100).toFixed(1);
    }
    
    let labelPersen = document.getElementById('persen_profit');
    labelPersen.innerText = "(" + persen + "%)";
    
    if(profit > 0) {
        document.getElementById('profit_display').classList.remove('text-danger', 'text-muted');
        document.getElementById('profit_display').classList.add('text-success');
        labelPersen.className = "text-success fw-bold";
    } else if (profit < 0) {
        document.getElementById('profit_display').classList.remove('text-success', 'text-muted');
        document.getElementById('profit_display').classList.add('text-danger');
        labelPersen.className = "text-danger fw-bold";
    } else {
        document.getElementById('profit_display').classList.remove('text-success', 'text-danger');
        document.getElementById('profit_display').classList.add('text-muted');
        labelPersen.className = "text-muted";
    }
}

function resetForm() {
    document.getElementById('harga_beli_asli').value = 0;
    document.getElementById('harga_beli_disp').value = "0";
    document.getElementById('harga_jual_input').value = "";
    document.getElementById('profit_display').value = "Rp 0";
    document.getElementById('persen_profit').innerText = "(0%)";
}
</script>