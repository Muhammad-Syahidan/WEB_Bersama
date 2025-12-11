<div class="user-management">
    <h3 class="fw-bold mb-3 text-light">Manajemen Penjualan</h3>
    <hr class="border-secondary">

    <div class="mb-4 d-flex gap-2">
        <a href="main.php?p=penjualan_input" class="btn btn-primary fw-bold shadow-sm">
            <i class="bi bi-cart-plus me-2"></i> Input Transaksi Baru
        </a>
        <a href="main.php?p=penjualan_manage" class="btn btn-outline-warning fw-bold shadow-sm">
            <i class="bi bi-file-earmark-text me-2"></i> Lihat Riwayat Nota (Hapus Nota)
        </a>
    </div>

    <h4 class="fw-bold text-light mb-3">Detail Barang Terjual</h4>
    <div class="table-responsive">
        <table class="table table-dark table-striped align-middle rounded-3 overflow-hidden border border-secondary">
            <thead class="bg-secondary text-white text-center">
                <tr>
                    <th>No</th> 
                    <th>No. Nota</th> 
                    <th>Nama Barang</th>
                    <th>Kode</th> 
                    <th>Jumlah</th> 
                    <th>Subtotal</th> 
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <?php 
                    // Join ke Databarang
                    $sql = "SELECT detail_jual.*, databarang.nama 
                            FROM detail_jual 
                            LEFT JOIN databarang ON detail_jual.kode = databarang.kode
                            ORDER BY iddetailjual DESC";
                    
                    $res = $conn->query($sql);
                    
                    if ($res && $res->num_rows > 0): 
                        $no=1; 
                        while($r=$res->fetch_assoc()):
                ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td class="text-warning"><?= $r['nota'] ?></td>
                    <td class="text-start ps-4"><?= htmlspecialchars($r['nama'] ?? 'Item Terhapus') ?></td>
                    <td class="text-muted small"><?= $r['kode'] ?></td>
                    <td><?= $r['jumlah'] ?></td>
                    <td class="text-success fw-bold">Rp <?= number_format($r['total_harga']) ?></td>
                    <td>
                        <a href="main.php?p=detail_jual_hapus&id=<?= $r['iddetailjual'] ?>" 
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Hapus item ini?')">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; else: ?>
                <tr><td colspan="7" class="text-white py-4">Belum ada item terjual.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>