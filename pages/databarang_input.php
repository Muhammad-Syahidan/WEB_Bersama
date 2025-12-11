<div class="user-management">
    <h3 class="fw-bold mb-3 text-light">Kelola Data Barang (Master)</h3>
    
    <div class="card bg-dark text-white border-secondary shadow mb-4">
        <div class="card-header border-secondary fw-bold bg-gradient-primary">
            <i class="bi bi-plus-square me-2"></i> Form Input Barang Baru
        </div>
        <div class="card-body">
            <form action="pages/databarang_save.php" method="POST">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label text-warning">Kode Barang:</label>
                        <input type="text" class="form-control" name="kode" placeholder="Contoh: A1" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label text-info">Nama Barang:</label>
                        <input type="text" class="form-control" name="nama" placeholder="Contoh: Meja Belajar" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label text-success">Satuan:</label>
                        <input type="text" class="form-control" name="satuan" placeholder="Pcs / Unit / Box" required>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-2">
                    <button type="reset" class="btn btn-secondary btn-sm px-3">Reset</button>
                    <button name="simpan" type="submit" class="btn btn-primary btn-sm px-4 fw-bold">
                        <i class="bi bi-save me-1"></i> SIMPAN BARANG
                    </button>
                </div>
            </form>
        </div>
    </div>

    <hr class="border-secondary my-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold text-light mb-0">Daftar Barang Tersedia</h4>
    </div>
    
    <?php 
        $sql = "SELECT * FROM databarang WHERE hapus = 0 ORDER BY nama ASC";
        $result = $conn->query($sql);
    ?>

    <div class="table-responsive">
        <table class="table table-dark table-striped table-hover align-middle rounded-3 overflow-hidden border border-secondary">
            <thead class="text-center bg-secondary text-white">
                <tr>
                    <th style="width: 50px;">No</th>
                    <th style="width: 100px;">Kode</th>
                    <th>Nama Barang</th>
                    <th style="width: 100px;">Satuan</th>
                    <th style="width: 180px;">Aksi</th>
                </tr>
            </thead>

            <tbody class="text-center">
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php $no = 1; ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td class="fw-semibold"><?= $no++ ?></td>
                            <td class="text-warning fw-bold"><?= htmlspecialchars($row['kode']) ?></td>
                            <td class="text-start ps-4 text-capitalize"><?= htmlspecialchars($row['nama']) ?></td>
                            <td><?= htmlspecialchars($row['satuan']) ?></td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="main.php?p=databarang_edit&id=<?= $row['id'] ?>" 
                                       class="btn btn-info btn-sm px-3 text-white" 
                                       title="Edit Data">
                                       Edit
                                    </a>
                                    
                                    <a href="main.php?p=databarang_hapus&id=<?= $row['id'] ?>" 
                                       class="btn btn-danger btn-sm px-3"
                                       onclick="return confirm('Yakin ingin menghapus barang: <?= htmlspecialchars($row['nama']) ?>?')"
                                       title="Hapus Data">
                                       Hapus
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center py-4 text-white">
                            Belum ada data barang. Silakan input di form atas.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>