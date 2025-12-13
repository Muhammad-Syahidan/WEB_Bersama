<div class="user-management">
    <h3 class="fw-bold mb-3 text-light">Riwayat Transaksi Penjualan</h3>
    <hr class="border-secondary">

    <div class="mb-4">
        <a href="main.php?p=penjualan_input" class="btn btn-primary fw-bold shadow-sm">
            <i class="bi bi-cart-plus me-2"></i> Input Transaksi Baru
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-dark table-striped align-middle rounded-3 overflow-hidden border border-secondary">
            <thead class="bg-secondary text-white text-center">
                <tr>
                    <th>ID Jual</th> 
                    <th>No. Nota</th> 
                    <th>Tanggal</th> 
                    <th>Grand Total</th> 
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <?php 
                
                    $sql = "SELECT idjual, nota, tanggal, grand_total_jual 
                            FROM penjualan 
                            ORDER BY idjual DESC";
                    $res = $conn->query($sql);
                    
                    if ($res && $res->num_rows > 0): 
                        while($r=$res->fetch_assoc()):
                ?>
                <tr>
                    <td class="text-muted fw-bold"><?= $r['idjual'] ?></td>
                    <td class="text-warning fw-bold"><?= $r['nota'] ?></td>
                    <td><?= date('d-m-Y', strtotime($r['tanggal'])) ?></td>
                    <td class="text-success fw-bold">Rp <?= number_format($r['grand_total_jual'], 0, ',', '.') ?></td>
                    <td>
                        <a href="main.php?p=penjualan_hapus&id=<?= $r['idjual'] ?>" 
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Hapus Riwayat Nota <?= $r['nota'] ?>?')">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; else: ?>
                <tr><td colspan="5" class="text-white py-4">Belum ada transaksi.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>