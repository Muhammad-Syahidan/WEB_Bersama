<?php
include "assets/koneksi.php";

// ✅ Validasi parameter kode berita
if (!isset($_GET['kode']) || !is_numeric($_GET['kode'])) {
    echo "<div class='alert alert-warning text-center mt-4'> Berita tidak ditemukan.</div>";
    exit;
}

$kode = intval($_GET['kode']);

// ✅ Query berita
$sql = "SELECT * FROM news WHERE kode = ? AND hapus = 1";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo "<div class='alert alert-danger text-center mt-4'> Gagal mempersiapkan query.</div>";
    exit;
}

$stmt->bind_param("i", $kode);
$stmt->execute();
$result = $stmt->get_result();

// ✅ Jika tidak ada data
if (!$result || $result->num_rows === 0) {
    echo "<div class='alert alert-danger text-center mt-4'> Data berita tidak tersedia.</div>";
    exit;
}

// ✅ Ambil data berita
$news = $result->fetch_assoc();

// ✅ Pastikan hasil adalah array
if (!is_array($news)) {
    echo "<div class='alert alert-danger text-center mt-4'> Terjadi kesalahan saat membaca data berita.</div>";
    exit;
}
?>

<!-- =============================== -->
<!-- 📰 DETAIL BERITA -->
<!-- =============================== -->
<div class="news-detail card bg-dark border-0 shadow-lg text-light p-4 mt-4 rounded-4">

    <!-- Judul -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold mb-0 text-light">
            <?= htmlspecialchars($news['jenis_berita'] ?? 'Tidak ada judul') ?>
        </h3>
        <a href="main.php?p=manajnews" class="btn btn-outline-light btn-sm px-3">
            ← Kembali
        </a>
    </div>

    <hr class="border-secondary mb-4">

    <!-- Isi Berita -->
    <div class="isi-berita text-justify px-1 mb-4">
        <?= nl2br(htmlspecialchars($news['isi_berita'] ?? 'Konten berita tidak tersedia.')) ?>
    </div>

    <!-- 🔗 Sumber Berita -->
    <div class="sumber-berita px-1 mt-3 pt-3 border-top border-secondary">
        <strong>Sumber:</strong><br>
        <?php
        $sumber = trim($news['sumber'] ?? '');

        if (!empty($sumber)) {
            if (filter_var($sumber, FILTER_VALIDATE_URL)) {
                // Jika berupa URL valid
                echo '<a href="' . htmlspecialchars($sumber) . '" target="_blank" rel="noopener noreferrer" class="link-sumber">'
                    . htmlspecialchars($sumber)
                    . '</a>';
            } else {
                // Jika bukan URL, tampilkan teks biasa
                echo nl2br(htmlspecialchars($sumber));
            }
        } else {
            echo "Tidak ada sumber berita.";
        }
        ?>
    </div>

</div>

<!-- =============================== -->
<!-- 🧭 STYLE -->
<!-- =============================== -->
<style>
.news-detail {
    max-width: 900px;
    margin: 0 auto;
    letter-spacing: 0.3px;
    line-height: 1.8;
}

.news-detail h3 {
    font-size: 1.6rem;
    letter-spacing: 0.5px;
}

.news-detail .isi-berita {
    font-size: 1rem;
    color: #f8f9fa;
    text-align: justify;
    text-indent: 25px;
}

.news-detail .isi-berita::first-letter {
    font-size: 1.3rem;
    font-weight: 600;
    color: #adb5bd;
}

.sumber-berita {
    font-size: 0.95rem;
    color: #ccc;
}

.link-sumber {
    color: #00c3ff;
    text-decoration: none;
    transition: 0.2s;
}
.link-sumber:hover {
    text-decoration: underline;
    color: #66e0ff;
}

.news-detail .btn-outline-light {
    transition: all 0.25s ease;
    border-radius: 8px;
}
.news-detail .btn-outline-light:hover {
    background: #f8f9fa;
    color: #000;
}
</style>
