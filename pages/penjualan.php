<?php 
    
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
        <h3 class="fw-bold text-light">Laporan Penjualan</h3>
        <button onclick="window.print()" class="btn btn-success shadow-sm">
            <i class="bi bi-printer-fill me-2"></i> Cetak Laporan
        </button>
    </div>
    
    <hr class="border-secondary">

    <div class="table-responsive mt-3">
        <table class="table table-dark table-striped table-hover align-middle rounded-3 overflow-hidden">
            <thead class="text-center bg-gradient-primary text-white">
                <tr>
                    <th style="width: 60px;">No</th>
                    <th style="width: 200px;">Nota</th>
                    <th style="width: 150px;">Tanggal</th>
                    <th>Grand Total</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <?php if (!empty($data_laporan)): 
                    $no = 1; 
                    $total_omset = 0; 
                    foreach ($data_laporan as $row): 
                        $total_omset += $row['grand_total_jual'];
                ?>
                    <tr>
                        <td class="fw-semibold"><?= $no++ ?></td>
                        <td class="fw-bold text-warning"><?= htmlspecialchars($row['nota']) ?></td>
                        <td><?= htmlspecialchars($row['tanggal']) ?></td>
                        <td class="text-info fw-bold">
                            Rp <?= number_format($row['grand_total_jual'], 0, ',', '.') ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                    <tr class="fw-bold bg-secondary">
                        <td colspan="3" class="text-end pe-3">TOTAL PENDAPATAN:</td>
                        <td class="text-success fs-5">Rp <?= number_format($total_omset, 0, ',', '.') ?></td>
                    </tr>
                <?php else: ?>
                    <tr><td colspan="4" class="py-4">Belum ada data penjualan.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div id="print-area">
    <div class="header-print">
        <img src="img/Avatar3.png" alt="Logo">
        <h2>PT. MINECRAFT LOVERS</h2>
        <h3>Laporan Rekap Penjualan</h3>
    </div>

    <table class="table-print">
        <thead>
            <tr>
                <th style="width: 50px;">No</th>
                <th style="width: 150px;">Nota</th>
                <th style="width: 120px;">Tanggal</th>
                <th>Grand Total</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($data_laporan)): 
                $no = 1; 
                $total_print = 0; 
                foreach ($data_laporan as $row): 
                    $total_print += $row['grand_total_jual'];
            ?>
                <tr>
                    <td style="text-align: center;"><?= $no++ ?></td>
                    <td style="text-align: center;"><?= htmlspecialchars($row['nota']) ?></td>
                    <td style="text-align: center;"><?= htmlspecialchars($row['tanggal']) ?></td>
                    <td style="text-align: right; padding-right: 20px;">
                        Rp <?= number_format($row['grand_total_jual'], 0, ',', '.') ?>
                    </td>
                </tr>
            <?php endforeach; ?>
                <tr>
                    <td colspan="3" style="text-align: right; font-weight: bold; padding-right: 15px; border: 1px solid black;">TOTAL :</td>
                    <td style="text-align: right; font-weight: bold; padding-right: 20px; border: 1px solid black;">
                        Rp <?= number_format($total_print, 0, ',', '.') ?>
                    </td>
                </tr>
            <?php else: ?>
                <tr><td colspan="4" style="text-align: center;">Data Kosong</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<style>
    #print-area { display: none; }

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

        .header-print { text-align: center; margin-bottom: 20px; border-bottom: 2px solid black; padding-bottom: 10px; }
        .header-print img { width: 80px; height: auto; display: block; margin: 0 auto 5px auto; }
        .header-print h2 { font-size: 22px; font-weight: bold; margin: 5px 0; text-transform: uppercase; color: black; }
        .header-print h3 { font-size: 16px; font-weight: normal; margin: 0; color: black; }

        .table-print { width: 100%; border-collapse: collapse; font-family: Arial, sans-serif; font-size: 12pt; color: black; }
        .table-print th, .table-print td { border: 1px solid black !important; padding: 8px; }
        .table-print th { 
            background-color: #f0f0f0 !important; 
            font-weight: bold; 
            text-align: center; 
            -webkit-print-color-adjust: exact; 
            print-color-adjust: exact;
        }
    }
</style>