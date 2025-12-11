<?php 
    // QUERY: Join Harga & Databarang (by Kode)
    $sql = "SELECT 
                harga.idharga, 
                databarang.nama, 
                databarang.kode AS kode_barang, -- Ambil kode dari databarang biar aman
                harga.harga_jual,
                harga.harga_beli
            FROM 
                harga
            LEFT JOIN 
                databarang 
            ON 
                harga.kode = databarang.kode
            ORDER BY harga.idharga ASC"; 
    
    $result = $conn->query($sql);

    // Simpan data ke array agar bisa diloop 2 kali (Tampilan Web & Print)
    $data_harga = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data_harga[] = $row;
        }
    }
?>

<div class="user-management no-print">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold text-light">Laporan Harga Barang</h3>
        <button onclick="window.print()" class="btn btn-success shadow-sm">
            <i class="bi bi-printer-fill me-2"></i> Cetak Laporan
        </button>
    </div>
    
    <hr class="border-secondary">

    <div class="table-responsive mt-3">
        <table class="table table-dark table-striped table-hover align-middle rounded-3 overflow-hidden">
            <thead class="text-center bg-gradient-primary text-white">
                <tr>
                    <th style="width: 60px;">ID</th>
                    <th style="width: 100px;">Kode</th>
                    <th>Nama Barang</th> 
                    <th style="width: 180px">Harga Beli</th>
                    <th style="width: 180px">Harga Jual</th>
                </tr>
            </thead>

            <tbody class="text-center">
                <?php if (!empty($data_harga)): foreach ($data_harga as $row): ?>
                    <tr>
                        <td class="fw-semibold"><?= htmlspecialchars($row['idharga']) ?></td>
                        <td class="text-warning fw-bold"><?= htmlspecialchars($row['kode_barang']) ?></td>
                        
                        <td class="text-capitalize text-start ps-4">
                            <?= htmlspecialchars($row['nama']) ?>
                        </td>

                        <td class="text-secondary fw-bold">
                            Rp <?= number_format($row['harga_beli'], 0, ',', '.') ?>
                        </td>

                        <td class="text-info fw-bold">
                            Rp <?= number_format($row['harga_jual'], 0, ',', '.') ?>
                        </td>
                    </tr>
                <?php endforeach; else: ?>
                    <tr><td colspan="5" class="py-4">Belum ada data harga.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div id="print-area">
    <div class="header-print">
        <img src="img/Avatar3.png" alt="Logo">
        <h2>PT. MINECRAFT LOVERS</h2>
        <h3>Laporan Harga Barang</h3>
    </div>

    <table class="table-print">
        <thead>
            <tr>
                <th style="width: 50px;">ID</th>
                <th style="width: 100px;">Kode</th>
                <th>Nama Barang</th>
                <th>Harga Beli</th>
                <th>Harga Jual</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($data_harga)): foreach ($data_harga as $row): ?>
                <tr>
                    <td style="text-align: center;"><?= htmlspecialchars($row['idharga']) ?></td>
                    <td style="text-align: center;"><?= htmlspecialchars($row['kode_barang']) ?></td>
                    <td><?= htmlspecialchars($row['nama']) ?></td>
                    <td style="text-align: right; padding-right: 15px;">Rp <?= number_format($row['harga_beli'], 0, ',', '.') ?></td>
                    <td style="text-align: right; padding-right: 15px;">Rp <?= number_format($row['harga_jual'], 0, ',', '.') ?></td>
                </tr>
            <?php endforeach; else: ?>
                <tr><td colspan="5" style="text-align: center;">Data Kosong</td></tr>
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

        .header-print { text-align: center; margin-bottom: 25px; padding-bottom: 10px; }
        .header-print img { width: 80px; height: auto; display: block; margin: 0 auto 10px auto; }
        .header-print h2 { font-size: 22px; font-weight: bold; margin: 5px 0; text-transform: uppercase; color: black; }
        .header-print h3 { font-size: 16px; font-weight: normal; margin: 0; color: black; }

        .table-print { width: 100%; border-collapse: collapse; font-family: Arial, sans-serif; font-size: 11pt; color: black; }
        .table-print th, .table-print td { border: 1px solid black !important; padding: 6px 8px; }
        
        /* FIX WARNING CSS */
        .table-print th { 
            background-color: #f0f0f0 !important; 
            font-weight: bold; 
            text-align: center; 
            -webkit-print-color-adjust: exact; 
            print-color-adjust: exact;
        }
    }
</style>