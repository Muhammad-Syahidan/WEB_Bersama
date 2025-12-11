<div class="user-management">
    <h3 class="fw-bold mb-3 text-light">Data Barang</h3>
    <hr class="border-secondary">

    <!-- Tombol Tambah barang -->

        <div class="mb-3">
            <a href="main.php?p=databarang_input" class="btn btn-primary shadow-sm">Tambah Barang</a>
        </div>
  

    <?php 
        $sql = "SELECT * FROM databarang WHERE hapus = 0";
        $result = $conn->query($sql);
    ?>

    <div class="table-responsive mt-3">
        <table class="table table-dark table-striped table-hover align-middle rounded-3 overflow-hidden">
            <thead class="text-center bg-gradient-primary text-white">
                <tr>
                    <th style="width: 60px;">ID</th>
                    <th style="width: 90px;">Kode</th>
                    <th>Nama</th>
                    <th>Satuan</th>
                    <th style="width: 220px;">Opsi</th>
                    
                </tr>
            </thead>

            <tbody class="text-center">
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <?php 
                            $id = htmlspecialchars($row['id']);
                            $kode = htmlspecialchars($row['kode']);
                            $nama = htmlspecialchars($row['nama']);
                            $satuan = htmlspecialchars($row['satuan']);
                            $aktif = $row['aktif'];
                        ?>
                        <tr>
                            <!-- No -->
                            <td class="fw-semibold"><?= $id ?></td>

                            <!-- User -->
                            <td class="text-capitalize"><?= $kode ?></td>

                            <!-- Timestamp -->
                            <td class="text-white small"><?= $nama ?></td>

                            <!-- Keterangan -->
                            <td class="text-center"><?= $satuan ?></td>

                            <?php if ($auth === "Administrator"): ?>
           
                                <!-- Opsi -->

                                <td>
                                    <div class="d-flex justify-content-center flex-wrap gap-2">
                                        <a href="main.php?p=databarang_edit&id=<?= $id ?>" 
                                        class="btn btn-info btn-sm px-3">Edit</a>
                                        <a href="main.php?p=databarang_hapus&id=<?= $id ?>" 
                                        class="btn btn-danger btn-sm px-3"
                                        onclick="return confirm('Yakin ingin menghapus user ini?')">Hapus</a>
                                    </div>
                                </td>
                             <?php endif; ?>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center text-white py-3">
                            Belum ada data user.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- =============================== -->
<!-- ✨ STYLE TAMBAHAN -->
<!-- =============================== -->
<style>
.user-management {
    letter-spacing: 0.3px;
}

.user-management h3 {
    font-size: 1.6rem;
    letter-spacing: 0.5px;
}

/* Avatar kecil di tabel */
.avatar-img {
    width: 55px;
    height: 55px;
    border-radius: 50%;
    object-fit: cover;
    cursor: zoom-in;
    border: 2px solid #343a40;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.avatar-img:hover {
    transform: scale(1.05);
    box-shadow: 0 0 8px rgba(255,255,255,0.3);
}

/* Overlay saat gambar di-zoom */
#imageOverlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.9);
    justify-content: center;
    align-items: center;
    z-index: 9999;
    cursor: zoom-out;
}
#imageOverlay img {
    max-width: 90%;
    max-height: 90%;
    border-radius: 10px;
    box-shadow: 0 0 25px rgba(255,255,255,0.4);
    image-rendering: -webkit-optimize-contrast;
    transition: transform 0.3s ease-in-out;
}
</style>

<!-- =============================== -->
<!-- ⚡ SCRIPT ZOOM -->
<!-- =============================== -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const overlay = document.createElement("div");
    overlay.id = "imageOverlay";
    overlay.innerHTML = "<img src='' alt='Zoomed Avatar'>";
    document.body.appendChild(overlay);

    const zoomables = document.querySelectorAll(".zoomable");
    zoomables.forEach(img => {
        img.addEventListener("click", () => {
            const fullImg = overlay.querySelector("img");
            fullImg.src = img.dataset.full;
            overlay.style.display = "flex";
        });
    });

    // Klik overlay untuk menutup zoom
    overlay.addEventListener("click", () => {
        overlay.style.display = "none";
    });
});
</script>
