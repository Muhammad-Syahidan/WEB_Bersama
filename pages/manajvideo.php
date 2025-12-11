<div class="video-management">
    <h3 class="fw-bold mb-3 text-light">Manajemen Gallery Video</h3>
    <hr class="border-secondary">

    <!-- Tombol Tambah Video -->
    <div class="mb-3">
        <a href="main.php?p=manajvideo_input" class="btn btn-primary shadow-sm">
            Tambah Video
        </a>
    </div>

    <?php 
        // Ambil data video yang belum dihapus
        $sql = "SELECT * FROM video WHERE hapus = 1";
        $result = $conn->query($sql);
    ?>

    <div class="table-responsive mt-3">
        <table class="table table-dark table-striped table-hover align-middle rounded-3 overflow-hidden">
            <thead class="text-center bg-gradient-primary text-white">
                <tr>
                    <th scope="col" style="width: 60px;">No</th>
                    <th scope="col" style="width: 260px;">Video</th>
                    <th scope="col">Keterangan</th>
                    <th scope="col" style="width: 160px;">Opsi</th>
                </tr>
            </thead>

            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <?php 
                            $id = htmlspecialchars($row['id']);
                            $videoUrl = htmlspecialchars($row['video']);
                            $keterangan = htmlspecialchars($row['keterangan']);
                        ?>
                        <tr>
                            <!-- Nomor -->
                            <td class="text-center fw-semibold"><?= $id; ?></td>

                            <!-- Kolom Video -->
                            <td class="text-center">
                                <div class="video-wrapper mx-auto">
                                    <?php if (preg_match('/(youtube\.com|youtu\.be)/', $videoUrl)): ?>
                                        <?php 
                                            // Konversi link menjadi embed YouTube
                                            $embedUrl = preg_replace(
                                                '/^(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/))([a-zA-Z0-9_-]+)/',
                                                'https://www.youtube.com/embed/$1',
                                                $videoUrl
                                            );
                                        ?>
                                        <iframe 
                                            src="<?= $embedUrl; ?>" 
                                            title="Video Preview"
                                            class="rounded-3 shadow-sm"
                                            allowfullscreen>
                                        </iframe>
                                    <?php else: ?>
                                        <a href="<?= $videoUrl; ?>" 
                                           target="_blank"
                                           class="video-link text-light"
                                           title="Buka Video di Tab Baru">
                                           <?= $videoUrl; ?>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>

                            <!-- Kolom Keterangan -->
                            <td class="text-start">
                                <span class="keterangan"
                                      data-bs-toggle="tooltip"
                                      data-bs-placement="top"
                                      title="<?= $keterangan; ?>">
                                      <?= mb_strimwidth($keterangan, 0, 90, '...'); ?>
                                </span>
                            </td>

                            <!-- Kolom Opsi -->
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="main.php?p=manajvideo_edit&id=<?= $id; ?>" 
                                       class="btn btn-info btn-sm px-3">
                                        Edit
                                    </a>
                                    <a href="main.php?p=manajvideo_hapus&id=<?= $id; ?>" 
                                       class="btn btn-danger btn-sm px-3"
                                       onclick="return confirm('Yakin ingin menghapus video ini?')">
                                        Hapus
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center text-muted py-3">
                            Belum ada data video.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Aktifkan Tooltip Bootstrap -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(el => new bootstrap.Tooltip(el));
});
</script>

<!-- CSS Tambahan -->
<style>
.video-management h3 {
    letter-spacing: 0.5px;
}

.video-wrapper {
    width: 220px;
    height: 125px;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #1a1a1a;
    border-radius: 10px;
}

.video-wrapper iframe {
    width: 100%;
    height: 100%;
    border: none;
}

.video-link {
    display: inline-block;
    color: #f8f9fa;
    text-decoration: none;
    transition: all 0.2s ease-in-out;
    word-break: break-all;
    font-size: 0.9rem;
}
.video-link:hover {
    color: #adb5bd;
    text-decoration: underline dotted;
}

.keterangan {
    color: #f8f9fa;
    cursor: pointer;
    transition: color 0.2s ease-in-out;
}
.keterangan:hover {
    color: #adb5bd;
}

.tooltip-inner {
    max-width: 400px;
    text-align: left;
    font-size: 0.9rem;
}
</style>
