<div class="user-management">
    <h3 class="fw-bold mb-3 text-light">Laporan Semua Detail Penjualan</h3>
    <hr class="border-secondary">

    <div class="mb-3">
        <a href="main.php?p=penjualan" class="btn btn-secondary shadow-sm">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Menu Utama
        </a>
    </div>

    <?php 
        // QUERY: AMBIL SEMUA DATA (Tanpa WHERE nota)
        // Kita gabungkan dengan tabel databarang untuk ambil nama barangnya
        
        $sql = "SELECT 
                    detail_jual.iddetailjual,
                    detail_jual.nota,
                    detail_jual.kode,
                    detail_jual.jumlah,
                    detail_jual.total_harga,
                    databarang.nama AS nama_barang
                FROM 
                    detail_jual
                LEFT JOIN 
                    databarang ON detail_jual.kode = databarang.kode
                ORDER BY 
                    detail_jual.iddetailjual DESC"; // Urut dari yang paling baru
                    
        $result = $conn->query($sql);
    ?>

    <div class="table-responsive mt-3">
        <table class="table table-dark table-striped table-hover align-middle rounded-3 overflow-hidden">
            <thead class="text-center bg-gradient-primary text-white">
                <tr>
                    <th style="width: 50px;">No</th>
                    <th>Nota</th> <th>Nama Barang</th>
                    <th>Kode</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                </tr>
            </thead>

            <tbody class="text-center">
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php 
                        $no = 1; 
                        $grand_total_semua = 0; // Untuk hitung total omset
                    ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <?php
                            // Nama Barang
                            $nama_show = !empty($row['nama_barang']) ? $row['nama_barang'] : 'Barang #'.$row['kode'];
                            
                            // Hitung Total Keseluruhan
                            $grand_total_semua += $row['total_harga'];
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>

                            <td class="fw-bold text-warning"><?= $row['nota'] ?></td>
                            
                            <td class="text-start ps-4 text-info text-capitalize">
                                <?= htmlspecialchars($nama_show) ?>
                            </td>

                            <td class="text-white small"><?= $row['kode'] ?></td>

                            <td><?= $row['jumlah'] ?></td>

                            <td class="text-end pe-5">
                                Rp <?= number_format($row['total_harga'], 0, ',', '.') ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>

                    <tr class="fw-bold bg-success text-white">
                        <td colspan="5" class="text-end pe-3">TOTAL PENDAPATAN KESELURUHAN:</td>
                        <td class="text-end pe-5 fs-5">
                            Rp <?= number_format($grand_total_semua, 0, ',', '.') ?>
                        </td>
                    </tr>

                <?php else: ?>
                    <tr>
                        <td colspan="6" class="py-5 text-center text-white">
                            <i class="bi bi-folder-x fs-1 d-block mb-3 text-muted"></i>
                            Belum ada data penjualan sama sekali.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>