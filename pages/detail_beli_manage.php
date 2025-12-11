<div class="user-management">
    <h3 class="fw-bold mb-3 text-light">Manajemen Detail Pembelian</h3>
    <hr class="border-secondary">

    <div class="table-responsive">
        <table class="table table-dark table-striped align-middle rounded-3 overflow-hidden border border-secondary">
            <thead class="bg-secondary text-white text-center">
                <tr>
                    <th>No</th> <th>Faktur</th> <th>Kode</th> <th>Jml</th> <th>Total</th> <th>Aksi</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <?php 
                    $sql = "SELECT * FROM detail_beli ORDER BY iddetailbeli DESC";
                    $res = $conn->query($sql);
                    if ($res && $res->num_rows > 0): $no=1; while($r=$res->fetch_assoc()):
                ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td class="text-info"><?= $r['faktur'] ?></td>
                    <td><?= $r['kode'] ?></td>
                    <td><?= $r['jumlah'] ?></td>
                    <td>Rp <?= number_format($r['total_harga']) ?></td>
                    <td>
                        <a href="main.php?p=detail_beli_hapus&id=<?= $r['iddetailbeli'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus item ini?')">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; else: ?>
                <tr><td colspan="6" class="text-white py-4">Belum ada data detail.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>