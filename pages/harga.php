<div class="user-management">
    <h3 class="fw-bold mb-3 text-light">Data Harga Barang</h3>
    <hr class="border-secondary">

    <?php 
        // Query Join Harga & Databarang
        $sql = "SELECT 
                    harga.idharga, 
                    databarang.nama, 
                    harga.harga_jual,
                    harga.harga_beli
                FROM 
                    harga
                INNER JOIN 
                    databarang 
                ON 
                    harga.kode = databarang.id"; 
        
        $result = $conn->query($sql);
    ?>

    <div class="table-responsive mt-3">
        <table class="table table-dark table-striped table-hover align-middle rounded-3 overflow-hidden">
            <thead class="text-center bg-gradient-primary text-white">
                <tr>
                    <th style="width: 60px;">ID</th>
                    <th>Nama Barang</th> <th style="width: 180px">Harga Jual</th>
                    <th style="width: 180px">Harga Beli</th>
            </thead>

            <tbody class="text-center">
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td class="fw-semibold"><?= htmlspecialchars($row['idharga']); ?></td>

                            <td class="text-capitalize text-start ps-4">
                                <?= htmlspecialchars($row['nama']); ?>
                            </td>

                            <td class="text-info fw-bold">
                                Rp <?= number_format($row['harga_jual'], 0, ',', '.'); ?>
                            </td>

                            <td class="text-warning fw-bold">
                                Rp <?= number_format($row['harga_beli'], 0, ',', '.'); ?>
                            </td>

                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center text-white py-3">
                            Belum ada data harga.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>