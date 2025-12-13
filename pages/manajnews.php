<div class="news-management">
    <h3 class="fw-bold mb-3 text-light">Manajemen Gallery Berita</h3>
    <hr class="border-secondary">

    <div class="mb-3">
        <a href="main.php?p=manajnews_input" class="btn btn-primary shadow-sm">
            Tambah Berita
        </a>
    </div>

    <?php 
        $sql = "SELECT * FROM news WHERE hapus = 1";
        $result = $conn->query($sql);
    ?>

    <div class="table-responsive mt-3">
        <table class="table table-dark table-striped table-hover align-middle rounded-3 overflow-hidden">
            <thead class="text-center bg-gradient-primary text-white">
                <tr>
                    <th scope="col">Kode</th>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Jenis Berita</th>
                    <th scope="col" style="width: 25%;">Isi Berita</th>
                    <th scope="col" style="width: 25%;">Sumber</th>
                    <th scope="col">Opsi</th>
                </tr>
            </thead>

            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td class="text-center"><?= htmlspecialchars($row['kode']); ?></td>
                            <td class="text-center"><?= htmlspecialchars($row['tanggal']); ?></td>
                            <td class="text-center"><?= htmlspecialchars($row['jenis_berita']); ?></td>

                            <td class="text-start">
                                <span class="isi-berita" 
                                      data-bs-toggle="tooltip" 
                                      data-bs-placement="top" 
                                      title="<?= htmlspecialchars($row['isi_berita']); ?>">
                                    <?= htmlspecialchars(mb_strimwidth($row['isi_berita'], 0, 80, '...')); ?>
                                </span>
                            </td>

                            <td class="text-start">
                                <a href="<?= htmlspecialchars($row['sumber']); ?>" 
                                   target="_blank" 
                                   class="link-info text-decoration-none">
                                    <?= htmlspecialchars($row['sumber']); ?>
                                </a>
                            </td>

                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="main.php?p=manajnews_edit&kode=<?= $row['kode']; ?>" 
                                       class="btn btn-info btn-sm px-3">
                                        Edit
                                    </a>
                                    <a href="main.php?p=manajnews_hapus&kode=<?= $row['kode']; ?>" 
                                       class="btn btn-danger btn-sm px-3" 
                                       onclick="return confirm('Yakin ingin menghapus berita ini?')">
                                        Hapus
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted py-3">
                            Belum ada data berita.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(el => new bootstrap.Tooltip(el));
});
</script>

<style>
.isi-berita {
    color: #f8f9fa; 
    cursor: pointer; 
    transition: color 0.2s ease-in-out;
}
.isi-berita:hover {
    color: #adb5bd;
}
.tooltip-inner {
    max-width: 400px;
    text-align: left;
    font-size: 0.9rem;
}
</style>
