<?php 
    // QUERY: Mengambil data stock dan Kode Barang (String/Huruf) dari tabel databarang
    // Kita Join agar yang muncul adalah Kode (misal: A1, B2) bukan ID angkanya.
    $sql = "SELECT 
                stock.idstock, 
                databarang.kode AS kode_barang, 
                stock.jumlah
            FROM 
                stock
            LEFT JOIN 
                databarang ON stock.kode = databarang.id
            ORDER BY 
                stock.idstock ASC";
    
    $result = $conn->query($sql);
    
    // Simpan data ke array agar bisa dipakai 2 kali (Tampilan Web & Tampilan Cetak)
    $data_stock = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data_stock[] = $row;
        }
    }
?>

<div class="user-management no-print">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold text-light">Data Stock Gudang</h3>
        <button onclick="window.print()" class="btn btn-success shadow-sm">
            <i class="bi bi-printer-fill me-2"></i> Cetak Laporan
        </button>
    </div>
    
    <hr class="border-secondary">

    <div class="table-responsive mt-3">
        <table class="table table-dark table-striped table-hover align-middle rounded-3 overflow-hidden">
            <thead class="text-center bg-gradient-primary text-white">
                <tr>
                    <th style="width: 100px;">ID Stock</th>
                    <th>Kode Barang</th>
                    <th style="width: 150px;">Jumlah</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <?php if (!empty($data_stock)): foreach ($data_stock as $row): ?>
                    <tr>
                        <td class="fw-semibold"><?= htmlspecialchars($row['idstock']) ?></td>
                        <td class="fw-bold text-warning"><?= htmlspecialchars($row['kode_barang']) ?></td>
                        <td class="fs-5"><?= htmlspecialchars($row['jumlah']) ?></td>
                    </tr>
                <?php endforeach; else: ?>
                    <tr><td colspan="3" class="py-4">Belum ada data stock.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div id="print-area">
    
    <div class="header-print">
        <img src="img/Avatar3.png" alt="Logo">
        <h2>PT. MINECRAFT LOVERS</h2>
        <h3>Laporan Stock Barang</h3>
    </div>

    <table class="table-print">
        <thead>
            <tr>
                <th style="width: 80px;">ID Stock</th>
                <th>Kode Barang</th>
                <th style="width: 100px;">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($data_stock)): foreach ($data_stock as $row): ?>
                <tr>
                    <td style="text-align: center;"><?= htmlspecialchars($row['idstock']) ?></td>
                    <td style="text-align: center;"><?= htmlspecialchars($row['kode_barang']) ?></td>
                    <td style="text-align: center;"><?= htmlspecialchars($row['jumlah']) ?></td>
                </tr>
            <?php endforeach; else: ?>
                <tr><td colspan="3" style="text-align: center;">Data Kosong</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<style>
    /* Default: Sembunyikan area cetak di layar laptop */
    #print-area { display: none; }

    /* SAAT DIPRINT (CTRL+P) */
    @media print {
        
        /* 1. Hilangkan Header Browser */
        @page { margin: 0; size: auto; }

        /* 2. Sembunyikan SEMUA elemen website asli */
        body * {
            visibility: hidden !important; 
        }

        /* 3. Munculkan HANYA #print-area */
        #print-area, #print-area * {
            visibility: visible !important;
        }

        /* 4. POSISI MUTLAK: Paksa area print nempel di pojok kiri atas kertas */
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

        /* Styling Header Print */
        .header-print { 
            text-align: center; margin-bottom: 20px; border-bottom: 2px solid black; padding-bottom: 10px; 
        }
        .header-print img { width: 80px; height: auto; display: block; margin: 0 auto 5px auto; }
        .header-print h2 { font-size: 22px; font-weight: bold; margin: 5px 0; text-transform: uppercase; color: black; }
        .header-print h3 { font-size: 16px; font-weight: normal; margin: 0; color: black; }

        /* Styling Tabel Print */
        .table-print { width: 100%; border-collapse: collapse; font-family: Arial, sans-serif; font-size: 12pt; color: black; }
        .table-print th, .table-print td { border: 1px solid black !important; padding: 8px; }
        .table-print th { background-color: #f0f0f0 !important; font-weight: bold; text-align: center; }
    }
</style>