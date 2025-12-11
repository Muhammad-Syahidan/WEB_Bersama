<div class="user-management">
    <h3 class="fw-bold mb-3 text-light">Kelola Harga Jual (Pasar)</h3>
    <hr class="border-secondary">

    <div class="table-responsive">
        <table class="table table-dark table-striped align-middle rounded-3 overflow-hidden border border-secondary">
            <thead class="bg-secondary text-white text-center">
                <tr>
                    <th>No</th> 
                    <th>Kode</th> 
                    <th>Nama Barang</th> 
                    <th class="text-white">Harga Beli (Modal)</th> 
                    <th class="text-white">Harga Jual (Pasar)</th> 
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <?php 
                    $sql = "SELECT harga.*, databarang.nama, databarang.kode AS kode_view 
                            FROM harga 
                            LEFT JOIN databarang ON harga.kode = databarang.kode 
                            ORDER BY harga.idharga ASC";
                    $res = $conn->query($sql);
                    
                    if ($res && $res->num_rows > 0): $no=1; while($r=$res->fetch_assoc()):
                ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td class="text-warning"><?= htmlspecialchars($r['kode_view']) ?></td>
                    <td class="text-start ps-4"><?= htmlspecialchars($r['nama']) ?></td>
                    
                    <td class="text-white">Rp <?= number_format($r['harga_beli']) ?></td>
                    
                    <td class="text-success fw-bold">Rp <?= number_format($r['harga_jual']) ?></td>
                    <td>
                        <a href="main.php?p=harga_jual_edit&id=<?= $r['idharga'] ?>" class="btn btn-success btn-sm text-white">
                            <i class="bi bi-pencil me-1"></i> Atur Jual
                        </a>
                    </td>
                </tr>
                <?php endwhile; else: ?>
                <tr><td colspan="6" class="text-white py-4">Data harga kosong.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>