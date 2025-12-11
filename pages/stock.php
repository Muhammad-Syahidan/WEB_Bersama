<div class="user-management">
    <h3 class="fw-bold mb-3 text-light">Data Stock</h3>
    <hr class="border-secondary">

    <?php 
        // PERBAIKAN QUERY: Ambil idstock, nama (dari databarang), dan jumlah
        $sql = "SELECT 
                    stock.idstock, 
                    databarang.nama, 
                    stock.jumlah
                FROM 
                    stock
                INNER JOIN 
                    databarang 
                ON 
                    stock.kode = databarang.id";
        
        $result = $conn->query($sql);
    ?>

    <div class="table-responsive mt-3">
        <table class="table table-dark table-striped table-hover align-middle rounded-3 overflow-hidden">
            <thead class="text-center bg-gradient-primary text-white">
                <tr>
                    <th style="width: 60px;">ID Stock</th>
                    <th style="width: 210px;">Nama Barang</th> 
                    <th style="width: 150px">Jumlah</th>
                    <th style="width: 150px">Aksi</th> 
                </tr>
            </thead>

            <tbody class="text-center">
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td class="fw-semibold"><?= htmlspecialchars($row['idstock']); ?></td>

                            <td class="text-capitalize"><?= htmlspecialchars($row['nama']); ?></td>

                            <td><?= htmlspecialchars($row['jumlah']); ?></td>

                            <td>
                                <div class="d-flex justify-content-center flex-wrap gap-2">
                                    <a href="main.php?p=stock_edit&idstock=<?= $row['idstock']; ?>" 
                                       class="btn btn-info btn-sm px-3">Edit Stock</a>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center text-white py-3">
                            Belum ada data stock. <br>
                            <small class="text-muted">Silakan input data manual di database tabel 'stock' dulu.</small>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>