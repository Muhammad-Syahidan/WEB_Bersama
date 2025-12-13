<?php
include "assets/koneksi.php";
?>

<div class="image-management text-light">
    <h3 class="fw-bold mb-3"> Manajemen Gallery Foto</h3>
    <hr class="border-secondary">

    
    <div class="mb-3">
        <a href="main.php?p=manajimg_input" class="btn btn-primary shadow-sm">
            Tambah Foto
        </a>
    </div>

    <?php 
        $sql = "SELECT * FROM images WHERE hapus = 1";
        $result = $conn->query($sql);
    ?>

    <div class="table-responsive mt-3">
        <table class="table table-dark table-striped table-hover align-middle rounded-3 overflow-hidden">
            <thead class="text-center bg-gradient-primary text-white">
                <tr>
                    <th scope="col" style="width: 60px;">No</th>
                    <th scope="col" style="width: 200px;">Gambar</th>
                    <th scope="col">Keterangan</th>
                    <th scope="col" style="width: 160px;">Opsi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <?php 
                            $id = htmlspecialchars($row['id']);
                            $image = htmlspecialchars($row['images']);
                            $keterangan = htmlspecialchars($row['keterangan']);
                        ?>
                        <tr>
                            <td class="text-center fw-semibold"><?= $id; ?></td>

                            <td class="text-center">
                                <div class="image-box mx-auto">
                                    <img src="img/<?= $image; ?>" 
                                         alt="Foto <?= $id; ?>" 
                                         class="img-thumbnail rounded-3 shadow-sm preview-image"
                                         onclick="zoomImage(this)">
                                </div>
                            </td>

                            <td class="text-start">
                                <span class="keterangan"
                                      data-bs-toggle="tooltip"
                                      title="<?= $keterangan; ?>">
                                      <?= mb_strimwidth($keterangan, 0, 90, '...'); ?>
                                </span>
                            </td>

                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="main.php?p=manajimg_edit&id=<?= $id; ?>" 
                                       class="btn btn-info btn-sm px-3">Edit</a>
                                    <a href="main.php?p=manajimg_hapus&id=<?= $id; ?>" 
                                       class="btn btn-danger btn-sm px-3"
                                       onclick="return confirm('Yakin ingin menghapus foto ini?')">
                                       Hapus
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center text-muted py-3">
                            Belum ada data foto.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>


<div id="zoomModal" class="zoom-modal" onclick="closeZoom()">
    <img id="zoomedImage" class="zoomed-image" src="" alt="">
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {
   
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(el => new bootstrap.Tooltip(el));
});


function zoomImage(img) {
    const zoomModal = document.getElementById("zoomModal");
    const zoomedImage = document.getElementById("zoomedImage");
    zoomedImage.src = img.src;
    zoomModal.style.display = "flex";
    document.body.style.overflow = "hidden";
}


function closeZoom() {
    const zoomModal = document.getElementById("zoomModal");
    zoomModal.style.display = "none";
    document.body.style.overflow = "";
}
</script>


<style>
.image-management h3 {
    letter-spacing: 0.5px;
}

.image-box {
    width: 120px;
    height: 80px;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #1a1a1a;
    border-radius: 10px;
    transition: transform 0.25s ease-in-out, box-shadow 0.25s;
    cursor: zoom-in;
}
.image-box:hover {
    transform: scale(1.05);
    box-shadow: 0 0 12px rgba(255,255,255,0.2);
}

.preview-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border: none;
    transition: filter 0.3s;
}
.preview-image:hover {
    filter: brightness(1.15);
}

.keterangan {
    color: #f8f9fa;
    cursor: pointer;
    transition: color 0.2s ease-in-out;
}
.keterangan:hover {
    color: #adb5bd;
}

/* Tooltip */
.tooltip-inner {
    max-width: 400px;
    text-align: left;
    font-size: 0.9rem;
}

/* Zoom Modal */
.zoom-modal {
    display: none;
    position: fixed;
    z-index: 1050;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(10, 10, 10, 0.9);
    justify-content: center;
    align-items: center;
    cursor: zoom-out;
    backdrop-filter: blur(5px);
    transition: opacity 0.3s ease;
}

.zoomed-image {
    max-width: 85%;
    max-height: 85%;
    border-radius: 10px;
    box-shadow: 0 0 30px rgba(255,255,255,0.2);
    object-fit: contain;
}
</style>
