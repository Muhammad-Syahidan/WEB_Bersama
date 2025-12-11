<div class="user-management">
    <h3 class="fw-bold mb-3 text-light">Detail Pembelian</h3>
    <hr class="border-secondary">

    <div class="mb-3">
        <a href="main.php?p=pembelian_input" class="btn btn-primary shadow-sm">Tambah Pembelian</a>
    </div>

    <?php 
        // QUERY JOIN: Ambil Detail + Stock + Harga
        $sql = "SELECT 
                    detail_beli.iddetailbeli,
                    detail_beli.faktur,
                    detail_beli.kode,
                    stock.jumlah AS stok_real,
                    harga.harga_beli
                FROM 
                    detail_beli
                LEFT JOIN 
                    stock ON detail_beli.kode = stock.kode
                LEFT JOIN 
                    harga ON detail_beli.kode = harga.kode
                ORDER BY 
                    detail_beli.faktur ASC";
        
        $result = $conn->query($sql);
    ?>

    <div class="table-responsive mt-3">
        <table class="table table-dark table-striped table-hover align-middle rounded-3 overflow-hidden">
            <thead class="text-center bg-gradient-primary text-white">
                <tr>
                    <th style="width: 60px;">ID</th>
                    <th>Faktur</th>
                    <th>Kode</th>
                    <th>Jumlah (Stock)</th>
                    <th>Total Harga</th>
                    <th style="width: 150px;">Aksi</th>
                </tr>
            </thead>

            <tbody class="text-center">
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php 
                        $grand_total_semua = 0; // Variabel penampung total
                    ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <?php 
                            $id     = $row['iddetailbeli'];
                            $faktur = $row['faktur'];
                            $kode   = $row['kode'];
                            $jumlah = !empty($row['stok_real']) ? $row['stok_real'] : 0;
                            $harga  = !empty($row['harga_beli']) ? $row['harga_beli'] : 0;
                            
                            // Hitung Per Baris
                            $total_baris = $jumlah * $harga;
                            
                            // Tambahkan ke Grand Total
                            $grand_total_semua += $total_baris;

                            // Warna Faktur
                            $warna = 'text-warning';
                            if($faktur == 'A1') $warna = 'text-info';
                            if($faktur == 'A2') $warna = 'text-success';
                        ?>
                        <tr>
                            <td><?= $id ?></td>
                            <td class="fw-bold <?= $warna ?>"><?= $faktur ?></td>
                            <td class="text-light"><?= $kode ?></td>
                            <td><?= $jumlah ?></td>
                            <td class="text-end pe-4 text-success fw-bold">
                                Rp <?= number_format($total_baris, 0, ',', '.') ?>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="main.php?p=detail_beli_edit&id=<?= $id ?>" 
                                       class="btn btn-info btn-sm px-2 text-white">Edit</a>
                                    
                                    <a href="main.php?p=detail_beli_hapus&id=<?= $id ?>" 
                                       class="btn btn-danger btn-sm px-2"
                                       onclick="return confirm('Hapus data ini?')">Hapus</a>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    
                    <tr class="fw-bold bg-secondary text-white" style="border-top: 2px solid white;">
                        <td colspan="4" class="text-end pe-3 fs-5">TOTAL PENGELUARAN KESELURUHAN:</td>
                        <td class="text-end pe-4 text-warning fs-4">
                            Rp <?= number_format($grand_total_semua, 0, ',', '.') ?>
                        </td>
                        <td></td> </tr>

                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center py-4">Data Kosong</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>