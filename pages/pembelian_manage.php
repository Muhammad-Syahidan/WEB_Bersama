<div class="user-management">
    <h3 class="fw-bold mb-3 text-light">Manajemen Pembelian (Restock)</h3>
    
    <div class="mb-4">
        <a href="main.php?p=pembelian_input" class="btn btn-primary shadow-lg px-4 py-2 fw-bold">
            <i class="bi bi-box-seam me-2"></i> Input Pembelian Baru
        </a>
    </div>

    <hr class="border-secondary mb-4">

    <h4 class="fw-bold text-light mb-3">Riwayat Pembelian</h4>
    <div class="table-responsive">
        <table class="table table-dark table-striped align-middle rounded-3 overflow-hidden border border-secondary">
            <thead class="bg-secondary text-white text-center">
                <tr>
                    <th>No</th> <th>Faktur</th> <th>Tanggal</th> <th>Total Belanja</th> <th>Aksi</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <?php 
                    $sql = "SELECT * FROM pembelian ORDER BY idbeli DESC";
                    $res = $conn->query($sql);
                    if ($res && $res->num_rows > 0): $no=1; while($r=$res->fetch_assoc()):
                ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td class="text-info"><?= $r['faktur'] ?></td>
                    <td><?= $r['tanggal'] ?></td>
                    <td class="fw-bold">Rp <?= number_format($r['grand_total_beli']) ?></td>
                    <td>
                        <a href="main.php?p=pembelian_hapus&id=<?= $r['idbeli'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus faktur ini?')">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; else: ?>
                <tr><td colspan="5" class="text-white py-4">Belum ada data pembelian.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>