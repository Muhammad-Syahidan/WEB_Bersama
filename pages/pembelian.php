<div class="user-management">
    <h3 class="fw-bold mb-3 text-light">Data Pembelian (Restock Gudang)</h3>
    <hr class="border-secondary">

    <div class="mb-3">
        <a href="main.php?p=pembelian_input" class="btn btn-primary shadow-sm">
            <i class="bi bi-box-seam-fill me-1"></i> Input Barang Masuk
        </a>
    </div>

    <?php 
        // QUERY: Ambil data pembelian urut dari yang terbaru
        $sql = "SELECT * FROM pembelian ORDER BY idbeli DESC";
        $result = $conn->query($sql);
    ?>

    <div class="table-responsive mt-3">
        <table class="table table-dark table-striped table-hover align-middle rounded-3 overflow-hidden">
            <thead class="text-center bg-gradient-primary text-white">
                <tr>
                    <th style="width: 60px;">ID</th>
                    <th>Faktur</th>
                    <th>Tanggal</th>
                    <th>Total Belanja (Modal)</th>
                    <th style="width: 150px;">Aksi</th>
                </tr>
            </thead>

            <tbody class="text-center">
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['idbeli'] ?></td>
                            
                            <td class="fw-bold text-info"><?= $row['faktur'] ?></td>
                            
                            <td><?= $row['tanggal'] ?></td>
                            
                            <td class="text-end pe-5 fw-bold text-warning">
                                Rp <?= number_format($row['grand_total_beli'], 0, ',', '.') ?>
                            </td>
                            
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="main.php?p=detail_beli" class="btn btn-secondary btn-sm px-3">Lihat Stok</a>
                                    
                                    <a href="main.php?p=pembelian_hapus&id=<?= $row['idbeli'] ?>" 
                                       class="btn btn-danger btn-sm px-2"
                                       onclick="return confirm('Hapus riwayat pembelian ini?')">Hapus</a>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="5" class="py-4 text-center">Belum ada data pembelian.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>