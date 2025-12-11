<?php 
    // QUERY JOIN 3 TABEL:
    // 1. detail_jual (Isi: iddetailjual, nota, kode, jumlah, total_harga)
    // 2. penjualan   (Ambil 'tanggal' berdasarkan 'nota')
    // 3. databarang  (Ambil 'nama' berdasarkan 'kode')
    
    $sql = "SELECT 
                detail_jual.iddetailjual,
                detail_jual.nota,
                detail_jual.kode,
                detail_jual.jumlah,
                detail_jual.total_harga,
                penjualan.tanggal,
                databarang.nama
            FROM 
                detail_jual
            LEFT JOIN 
                penjualan ON detail_jual.nota = penjualan.nota
            LEFT JOIN 
                databarang ON detail_jual.kode = databarang.kode
            ORDER BY 
                penjualan.tanggal DESC, detail_jual.iddetailjual DESC";
    
    $result = $conn->query($sql);
    
    // Simpan data ke array
    $data_laporan = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data_laporan[] = $row;
        }
    }
?>

<div class="user-management no-print">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold text-light">Laporan Detail Penjualan</h3>
        <button onclick="window.print()" class="btn btn-success shadow-sm">
            <i class="bi bi-printer-fill me-2"></i> Cetak Laporan
        </button>
    </div>
    
    <hr class="border-secondary">

    <div class="table-responsive mt-3">
        <table class="table table-dark table-striped table-hover align-middle rounded-3 overflow-hidden">
            <thead class="text-center bg-gradient-primary text-white">
                <tr>
                    <th style="width: 50px;">No</th>
                    <th style="width: 150px;">Nota</th>
                    <th style="width: 120px;">Tanggal</th>
                    <th>Nama Barang</th>
                    <th style="width: 100px;">Kode</th>
                    <th style="width: 80px;">Jml</th>
                    <th style="width: 150px;">Subtotal</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <?php if (!empty($data_laporan)): $no = 1; $grand_total = 0; foreach ($data_laporan as $row): 
                    $grand_total += $row['total_harga'];
                ?>
                    <tr>
                        <td class="fw-semibold"><?= $no++ ?></td>
                        <td class="fw-bold text-warning"><?= htmlspecialchars($row['nota']) ?></td>
                        <td><?= htmlspecialchars($row['tanggal']) ?></td>
                        <td class="text-start ps-4 text-capitalize"><?= htmlspecialchars($row['nama']) ?></td>
                        <td class="text-white small"><?= htmlspecialchars($row['kode']) ?></td>
                        <td><?= htmlspecialchars($row['jumlah']) ?></td>
                        <td class="text-info fw-bold">
                            Rp <?= number_format($row['total_harga'], 0, ',', '.') ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                    <tr class="fw-bold bg-secondary">
                        <td colspan="6" class="text-end pe-3">TOTAL PENDAPATAN:</td>
                        <td class="text-info fs-5">Rp <?= number_format($grand_total, 0, ',', '.') ?></td>
                    </tr>
                <?php else: ?>
                    <tr><td colspan="7" class="py-4">Belum ada detail penjualan.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div id="print-area">
    
    <div class="header-print">
        <img src="img/Avatar3.png" alt="Logo">
        <h2>PT. MINECRAFT LOVERS</h2>
        <h3>Laporan Rincian Penjualan</h3>
    </div>

    <table class="table-print">
        <thead>
            <tr>
                <th style="width: 40px;">No</th>
                <th style="width: 120px;">Nota</th>
                <th style="width: 100px;">Tanggal</th>
                <th>Nama Barang</th>
                <th style="width: 60px;">Kode</th>
                <th style="width: 50px;">Qty</th>
                <th style="width: 120px;">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($data_laporan)): $no = 1; $grand_total_print = 0; foreach ($data_laporan as $row): 
                $grand_total_print += $row['total_harga'];
            ?>
                <tr>
                    <td style="text-align: center;"><?= $no++ ?></td>
                    <td style="text-align: center;"><?= htmlspecialchars($row['nota']) ?></td>
                    <td style="text-align: center;"><?= htmlspecialchars($row['tanggal']) ?></td>
                    <td><?= htmlspecialchars($row['nama']) ?></td>
                    <td style="text-align: center;"><?= htmlspecialchars($row['kode']) ?></td>
                    <td style="text-align: center;"><?= htmlspecialchars($row['jumlah']) ?></td>
                    <td style="text-align: right; padding-right: 10px;">
                        Rp <?= number_format($row['total_harga'], 0, ',', '.') ?>
                    </td>
                </tr>
            <?php endforeach; ?>
                <tr>
                    <td colspan="6" style="text-align: right; font-weight: bold; padding-right: 15px; border: 1px solid black;">TOTAL :</td>
                    <td style="text-align: right; font-weight: bold; padding-right: 10px; border: 1px solid black;">
                        Rp <?= number_format($grand_total_print, 0, ',', '.') ?>
                    </td>
                </tr>
            <?php else: ?>
                <tr><td colspan="7" style="text-align: center;">Data Kosong</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<style>
    /* Default: Sembunyikan area cetak di layar laptop */
    #print-area { display: none; }

    /* SAAT DIPRINT (CTRL+P) */
    @media print {
        @page { margin: 0; size: auto; }
        body * { visibility: hidden !important; }
        #print-area, #print-area * { visibility: visible !important; }

        #print-area {
            display: block !important;
            position: absolute !important;
            left: 0 !important;
            top: 0 !important;
            width: 100% !important;
            margin: 0 !important;
            padding: 40px !important;
            background-color: white !important;
            color: black !important;
            z-index: 99999 !important;
        }

        .header-print { 
            text-align: center; margin-bottom: 20px; border-bottom: 2px solid black; padding-bottom: 10px; 
        }
        .header-print img { width: 80px; height: auto; display: block; margin: 0 auto 5px auto; }
        .header-print h2 { font-size: 22px; font-weight: bold; margin: 5px 0; text-transform: uppercase; color: black; }
        .header-print h3 { font-size: 16px; font-weight: normal; margin: 0; color: black; }

        .table-print { width: 100%; border-collapse: collapse; font-family: Arial, sans-serif; font-size: 11pt; color: black; }
        .table-print th, .table-print td { border: 1px solid black !important; padding: 6px 8px; }
        .table-print th { background-color: #f0f0f0 !important; font-weight: bold; text-align: center; }
    }
</style>