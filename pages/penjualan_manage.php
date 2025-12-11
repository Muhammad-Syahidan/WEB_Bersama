<div class="user-management">
    <h3 class="fw-bold mb-3 text-light">Manajemen Penjualan</h3>
    
    <div class="card bg-dark text-white border-secondary shadow mb-4">
        <div class="card-header border-secondary fw-bold bg-gradient-primary">
            <i class="bi bi-cart-plus me-2"></i> Katalog Produk (Klik Beli untuk Transaksi)
        </div>
        <div class="card-body">
            <div class="row">
                <?php 
                    // Query Barang yg stoknya > 0
                    $sql = "SELECT stock.kode, databarang.nama, stock.jumlah, harga.harga_jual 
                            FROM stock
                            LEFT JOIN databarang ON stock.kode = databarang.kode
                            LEFT JOIN harga ON stock.kode = harga.kode
                            WHERE stock.jumlah > 0 ORDER BY stock.kode ASC";
                    $result = $conn->query($sql);

                    if ($result && $result->num_rows > 0):
                        while ($row = $result->fetch_assoc()):
                ?>
                    <div class="col-md-3 mb-3">
                        <div class="card bg-secondary text-white h-100 border-0 shadow-sm">
                            <div class="card-body text-center">
                                <h5 class="card-title fw-bold text-warning"><?= htmlspecialchars($row['nama']) ?></h5>
                                <p class="small mb-1">Stok: <?= $row['jumlah'] ?></p>
                                <h4 class="text-light fw-bold">Rp <?= number_format($row['harga_jual'], 0, ',', '.') ?></h4>
                                <a href="main.php?p=penjualan_input&kode=<?= $row['kode'] ?>" class="btn btn-primary btn-sm w-100 mt-2 fw-bold">
                                    BELI SEKARANG
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; else: ?>
                    <div class="col-12 text-center text-white py-4">Stok Barang Kosong.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <hr class="border-secondary my-4">

    <h4 class="fw-bold text-light mb-3">Riwayat Penjualan (Hapus Data)</h4>
    <div class="table-responsive">
        <table class="table table-dark table-striped align-middle rounded-3 overflow-hidden border border-secondary">
            <thead class="bg-secondary text-white text-center">
                <tr>
                    <th>No</th> <th>Nota</th> <th>Tanggal</th> <th>Total</th> <th>Aksi</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <?php 
                    $sql2 = "SELECT * FROM penjualan ORDER BY idjual DESC LIMIT 20";
                    $res2 = $conn->query($sql2);
                    if ($res2 && $res2->num_rows > 0): $no=1; while($r=$res2->fetch_assoc()):
                ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td class="text-warning"><?= $r['nota'] ?></td>
                    <td><?= $r['tanggal'] ?></td>
                    <td class="fw-bold">Rp <?= number_format($r['grand_total_jual']) ?></td>
                    <td>
                        <a href="main.php?p=penjualan_hapus&id=<?= $r['idjual'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus nota ini?')">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; else: ?>
                <tr><td colspan="5" class="text-white py-4">Belum ada data penjualan.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>