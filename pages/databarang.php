<?php 
    // Ambil data barang (Pastikan query benar)
    $sql = "SELECT * FROM databarang WHERE hapus = 0 ORDER BY nama ASC";
    $result = $conn->query($sql);
    
    // Simpan data ke array dulu agar bisa dipakai 2 kali (Tampilan Web & Tampilan Cetak)
    $data_barang = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data_barang[] = $row;
        }
    }
?>

<div class="user-management no-print">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold text-light">Data Barang</h3>
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
                    <th style="width: 120px;">Kode</th>
                    <th>Nama Barang</th>
                    <th style="width: 150px;">Satuan</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <?php if (!empty($data_barang)): $no = 1; foreach ($data_barang as $row): ?>
                    <tr>
                        <td class="fw-semibold"><?= $no++ ?></td>
                        <td class="fw-bold text-warning"><?= htmlspecialchars($row['kode']) ?></td>
                        <td class="text-start ps-4 text-capitalize"><?= htmlspecialchars($row['nama']) ?></td>
                        <td><?= htmlspecialchars($row['satuan']) ?></td>
                    </tr>
                <?php endforeach; else: ?>
                    <tr><td colspan="4" class="py-4">Belum ada data.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div id="print-area">
    
    <div class="header-print">
        <img src="img/Avatar3.png" alt="Logo">
        <h2>PT. MINECRAFT LOVERS</h2>
        <h3>Laporan Data Barang</h3>
    </div>

    <table class="table-print">
        <thead>
            <tr>
                <th style="width: 50px;">No</th>
                <th style="width: 120px;">Kode Barang</th>
                <th>Nama Barang</th>
                <th style="width: 100px;">Satuan</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($data_barang)): $no = 1; foreach ($data_barang as $row): ?>
                <tr>
                    <td style="text-align: center;"><?= $no++ ?></td>
                    <td style="text-align: center;"><?= htmlspecialchars($row['kode']) ?></td>
                    <td><?= htmlspecialchars($row['nama']) ?></td>
                    <td style="text-align: center;"><?= htmlspecialchars($row['satuan']) ?></td>
                </tr>
            <?php endforeach; else: ?>
                <tr><td colspan="4" style="text-align: center;">Data Kosong</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<style>
    /* Default: Sembunyikan area cetak di layar laptop */
    #print-area { display: none; }

    /* SAAT DIPRINT (CTRL+P) */
    @media print {
        
        /* 1. Hilangkan Header Browser (Tanggal, Judul Page, URL di pojok kertas) */
        @page { margin: 0; size: auto; }

        /* 2. Sembunyikan SEMUA elemen website asli (Sidebar, Navbar, Profil, dll) */
        body * {
            visibility: hidden !important; 
        }

        /* 3. Munculkan HANYA #print-area dan isinya */
        #print-area, #print-area * {
            visibility: visible !important;
        }

        /* 4. POSISI MUTLAK: Paksa area print nempel di pojok kiri atas kertas putih */
        #print-area {
            display: block !important;
            position: absolute !important; /* Kunci rahasianya disini */
            left: 0 !important;
            top: 0 !important;
            width: 100% !important;
            margin: 0 !important;
            padding: 40px !important; /* Beri jarak aman dari pinggir kertas */
            background-color: white !important;
            color: black !important;
            z-index: 99999 !important; /* Pastikan dia di layer paling atas */
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