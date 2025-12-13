<?php 
    // Query Data Penjualan
    $sql = "SELECT idjual, nota, tanggal, grand_total_jual 
            FROM penjualan 
            ORDER BY tanggal DESC, idjual DESC";
    $result = $conn->query($sql);
    
    $data_laporan = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data_laporan[] = $row;
        }
    }
?>

<div class="user-management no-print">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold text-light">Laporan Penjualan (Rekap)</h3>
        <button onclick="window.print()" class="btn btn-success shadow-sm">
            <i class="bi bi-printer-fill me-2"></i> Cetak Laporan
        </button>
    </div>
    <hr class="border-secondary">

    <div class="table-responsive">
        <table class="table table-dark table-hover align-middle rounded-3 overflow-hidden">
            <thead class="text-center bg-gradient-primary text-white">
                <tr>
                    <th>ID Jual</th>
                    <th>Nota</th>
                    <th>Tanggal</th>
                    <th>Grand Total</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($data_laporan)): 
                    $total_omset = 0;
                    foreach ($data_laporan as $row): 
                        $total_omset += $row['grand_total_jual'];
                ?>
                <tr class="text-center">
                    <td><?= $row['idjual'] ?></td>
                    <td class="text-warning fw-bold"><?= $row['nota'] ?></td>
                    <td><?= date('d/m/Y', strtotime($row['tanggal'])) ?></td>
                    <td class="text-end pe-5">Rp <?= number_format($row['grand_total_jual'], 0, ',', '.') ?></td>
                </tr>
                <?php endforeach; ?>
                <tr class="fw-bold bg-secondary">
                    <td colspan="3" class="text-end pe-3">TOTAL PENDAPATAN:</td>
                    <td class="text-end pe-5 text-warning fs-5">Rp <?= number_format($total_omset, 0, ',', '.') ?></td>
                </tr>
                <?php else: ?>
                <tr><td colspan="4" class="text-center py-4">Data Kosong</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div id="print-area">
    <div class="header-print">
        <img src="img/Avatar3.png" alt="Logo">
        <h2>PT. MINECRAFT LOVERS</h2>
        <h3>LAPORAN REKAPITULASI PENJUALAN</h3>
        <p>Dicetak pada: <?= date('d-m-Y H:i:s') ?></p>
    </div>

    <table class="table-print">
        <thead>
            <tr>
                <th style="width: 10%;">ID Jual</th>
                <th style="width: 25%;">No. Nota</th>
                <th style="width: 25%;">Tanggal</th>
                <th style="width: 40%;">Grand Total (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($data_laporan)): 
                $print_total = 0;
                foreach ($data_laporan as $row): 
                    $print_total += $row['grand_total_jual'];
            ?>
            <tr>
                <td style="text-align: center;"><?= $row['idjual'] ?></td>
                <td style="text-align: center;"><?= $row['nota'] ?></td>
                <td style="text-align: center;"><?= date('d/m/Y', strtotime($row['tanggal'])) ?></td>
                <td style="text-align: right; padding-right: 20px;">Rp <?= number_format($row['grand_total_jual'], 0, ',', '.') ?></td>
            </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="3" style="text-align: right; font-weight: bold; padding-right: 15px;">TOTAL PENDAPATAN:</td>
                <td style="text-align: right; font-weight: bold; padding-right: 20px;">Rp <?= number_format($print_total, 0, ',', '.') ?></td>
            </tr>
            <?php else: ?>
            <tr><td colspan="4" style="text-align: center;">Data Kosong</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
    
    <div style="margin-top: 40px; text-align: right; margin-right: 50px;">
        <p>Samarinda, <?= date('d F Y') ?></p>
        <br><br><br>
        <p style="text-decoration: underline; font-weight: bold;">( Pimpinan / Admin )</p>
    </div>
</div>

<style>
    #print-area { display: none; }
    @media print {
        @page { size: A4; margin: 20mm; }
        body * { visibility: hidden !important; }
        #print-area, #print-area * { visibility: visible !important; }
        #print-area {
            display: block !important;
            position: absolute !important;
            left: 0 !important;
            top: 0 !important;
            width: 100% !important;
            background: white !important;
            color: black !important;
            font-family: 'Times New Roman', serif;
        }
        .header-print { text-align: center; margin-bottom: 25px; border-bottom: 2px solid black; padding-bottom: 10px; }
        .header-print img { width: 80px; height: auto; display: block; margin: 0 auto 5px auto; }
        .header-print h2 { font-size: 20px; font-weight: bold; margin: 5px 0; text-transform: uppercase; }
        .table-print { width: 100%; border-collapse: collapse; font-size: 12px; margin-top: 10px; }
        .table-print th, .table-print td { border: 1px solid black !important; padding: 8px; }
        .table-print th { background-color: #eee !important; font-weight: bold; text-align: center; }
        .table-print tr:nth-child(even) { background-color: #f9f9f9 !important; }
    }
</style>