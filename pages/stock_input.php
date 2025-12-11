<div class="user-management">
    <h3 class="fw-bold mb-3 text-light">Manajemen Stock Gudang</h3>
    <hr class="border-secondary">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold text-light mb-0">Daftar Stock Barang</h4>
    </div>
    
    <?php 
        $sql = "SELECT 
                    stock.idstock, 
                    stock.kode, 
                    stock.jumlah,
                    databarang.nama,
                    databarang.kode AS kode_view
                FROM stock
                LEFT JOIN databarang ON stock.kode = databarang.kode 
                ORDER BY stock.idstock ASC";
        $result = $conn->query($sql);
    ?>

    <div class="table-responsive">
        <table class="table table-dark table-striped table-hover align-middle rounded-3 overflow-hidden border border-secondary">
            <thead class="text-center bg-secondary text-white">
                <tr>
                    <th style="width: 50px;">No</th>
                    <th style="width: 100px;">Kode</th>
                    <th>Nama Barang</th>
                    <th style="width: 150px;">Jumlah Stok</th>
                    <th style="width: 120px;">Aksi</th>
                </tr>
            </thead>

            <tbody class="text-center">
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php $no = 1; ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td class="fw-semibold"><?= $no++ ?></td>
                            <td class="text-warning fw-bold"><?= htmlspecialchars($row['kode_view']) ?></td>
                            <td class="text-start ps-4 text-capitalize"><?= htmlspecialchars($row['nama']) ?></td>
                            <td class="fs-5 fw-bold"><?= htmlspecialchars($row['jumlah']) ?></td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="main.php?p=stock_edit&idstock=<?= $row['idstock'] ?>" 
                                       class="btn btn-info btn-sm px-3 text-white" 
                                       title="Update Stok">
                                       <i class="bi bi-pencil-square"></i> Update
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center py-4 text-white">Belum ada data stock.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>