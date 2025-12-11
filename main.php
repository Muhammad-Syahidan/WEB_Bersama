<?php
session_start(); // HARUS DI BARIS PERTAMA

// =========================================================
// 🔒 CEK LOGIN SESSION
// =========================================================
if (!isset($_SESSION["iduser"])) {
    header("Location: login.php");
    exit();
}

// =========================================================
// 🔗 KONEKSI DATABASE
// =========================================================
include "assets/koneksi.php";
$iduser = $_SESSION["iduser"];

// =========================================================
// 👤 AMBIL DATA USER
// =========================================================
$sql = "SELECT * FROM user_list WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $iduser);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $avatar    = htmlspecialchars($row["avatar"]);
    $user      = htmlspecialchars($row["user"]);
    $auth      = htmlspecialchars($row["auth"]);
    $timestamp = htmlspecialchars($row["timestamp"]);

    if (!isset($_SESSION["auth"])) {
        $_SESSION["auth"] = $auth;
    }
} else {
    session_destroy();
    header("Location: login.php?error=user_not_found");
    exit();
}

// =========================================================
// 📂 AMBIL DATA GALERI
// =========================================================

// 🎥 Video
$video = [];
$vquery = "SELECT * FROM video WHERE hapus=1 ORDER BY id DESC LIMIT 5";
$vresult = $conn->query($vquery);
if ($vresult && $vresult->num_rows > 0) {
    while ($v = $vresult->fetch_assoc()) {
        $video[] = $v;
    }
}

// 📰 News
$news = [];
$nquery = "SELECT * FROM news WHERE hapus=1 ORDER BY kode DESC LIMIT 5";
$nresult = $conn->query($nquery);
if ($nresult && $nresult->num_rows > 0) {
    while ($n = $nresult->fetch_assoc()) {
        $news[] = $n;
    }
}

// 🖼️ Images
$images = [];
$iquery = "SELECT * FROM images WHERE hapus=1 ORDER BY id DESC LIMIT 5";
$iresult = $conn->query($iquery);
if ($iresult && $iresult->num_rows > 0) {
    while ($i = $iresult->fetch_assoc()) {
        $images[] = $i;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>3B - User Management</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/main.css">
  
    
</head>

<body>
<!-- ===================================================== -->
<!-- 🏷️ HEADER -->
<!-- ===================================================== -->
<div class="container text-center p-4">
    <div class="row align-items-center">
        <div class="col-sm-2">
            <img src="img/Avatar3.png" width="150" alt="Logo" class="shadow-sm">
        </div>

        <div class="col-sm-10">
            <h1>Program Aplikasi Sistem Inventory</h1>
            <h3>PT. Minecraft Lovers</h3>
            <p>Jl. Lambung Mangkurat</p>
            <h5 class="">Melayani Konsumen dengan Senyuman :)</h5>
            <hr>
        </div>
    </div>
</div>

<!-- ===================================================== -->
<!-- 🌐 NAVBAR -->
<!-- ===================================================== -->
<nav class="navbar navbar-expand-sm bg-dark navbar-dark sticky-top shadow-sm">
    <div class="container-fluid justify-content-center">
        <ul class="navbar-nav">
            <li class="nav-item"><a class="nav-link" href="main.php?p=home">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="main.php?p=profil">Profil</a></li>

            <?php if ($auth === "Administrator"): ?>
            
                   <li class="nav-item"><a class="nav-link" href="main.php?p=manajuser">Manajemen User</a></li>

            <?php endif; ?>

             <?php if ($auth === "Administrator"): ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">Galeri</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="main.php?p=manajvideo">Video</a></li>
                        <li><a class="dropdown-item" href="main.php?p=manajimg">Images</a></li>
                        <li><a class="dropdown-item" href="main.php?p=manajnews">News</a></li>
                    </ul>
                </li>
            <?php endif; ?>

            <?php if ($auth === "Administrator"): ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">Laporan</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="main.php?p=databarang">Data Barang</a></li>
                        <li><a class="dropdown-item" href="main.php?p=stock">Stock</a></li>
                        <li><a class="dropdown-item" href="main.php?p=harga">Harga Barang</a></li>
                        <li><a class="dropdown-item" href="main.php?p=penjualan">Penjualan</a></li>
                        <li><a class="dropdown-item" href="main.php?p=detail_jual">Detail Penjualan</a></li>
                        <li><a class="dropdown-item" href="main.php?p=pembelian">Pembelian</a></li>
                        <li><a class="dropdown-item" href="main.php?p=detail_beli">Detail pembelian</a></li>
                    </ul>
                </li>
            <?php endif; ?>

            <?php if ($auth === "Gudang"): ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">Master Data</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="main.php?p=databarang">Data Barang</a></li>
                        <li><a class="dropdown-item" href="main.php?p=stock">Set Harga</a></li>
                         <li><a class="dropdown-item" href="main.php?p=stock">Stock</a></li>

                    </ul>
                </li>
            <?php endif; ?>

            <?php if ($auth === "Penjualan"): ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">Penjualan</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="main.php?p=databarang">Penjualan</a></li>
                    </ul>
                </li>
            <?php endif; ?>

            <?php if ($auth === "Pembelian"): ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">Pembelian</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="main.php?p=penjualan">Pembelian</a></li>
                    </ul>
                </li>
            <?php endif; ?>

             <?php if ($auth === "Ahli"): ?>
            
                   <li class="nav-item"><a class="nav-link" href="main.php?p=manajuser">Manajemen User</a></li>

            <?php endif; ?>

             <?php if ($auth === "Ahli"): ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">Galeri</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="main.php?p=manajvideo">Video</a></li>
                        <li><a class="dropdown-item" href="main.php?p=manajimg">Images</a></li>
                        <li><a class="dropdown-item" href="main.php?p=manajnews">News</a></li>
                    </ul>
                </li>
            <?php endif; ?>

            <?php if ($auth === "Ahli"): ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">Laporan</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="main.php?p=databarang">Data Barang</a></li>
                        <li><a class="dropdown-item" href="main.php?p=stock">Stock</a></li>
                        <li><a class="dropdown-item" href="main.php?p=harga">Harga Barang</a></li>
                        <li><a class="dropdown-item" href="main.php?p=penjualan">Penjualan</a></li>
                        <li><a class="dropdown-item" href="main.php?p=detail_jual">Detail Penjualan</a></li>
                        <li><a class="dropdown-item" href="main.php?p=pembelian">Pembelian</a></li>
                        <li><a class="dropdown-item" href="main.php?p=detail_beli">Detail pembelian</a></li>
                    </ul>
                </li>
            <?php endif; ?>

            <?php if ($auth === "Ahli"): ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">Master Data</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="main.php?p=databarang">Data Barang</a></li>
                        <li><a class="dropdown-item" href="main.php?p=stock">Set Harga</a></li>
                         <li><a class="dropdown-item" href="main.php?p=stock">Stock</a></li>

                    </ul>
                </li>
            <?php endif; ?>

            <?php if ($auth === "Ahli"): ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">Penjualan</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="main.php?p=databarang">Penjualan</a></li>
                    </ul>
                </li>
            <?php endif; ?>

            <?php if ($auth === "Ahli"): ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">Pembelian</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="main.php?p=penjualan">Pembelian</a></li>
                    </ul>
                </li>
            <?php endif; ?>

        </ul>
    </div>
</nav>

<!-- ===================================================== -->
<!-- 📄 KONTEN UTAMA -->
<!-- ===================================================== -->
<div class="container mt-4">
    <div class="row">

        <!-- 👤 SIDEBAR PROFIL -->
        <div class="col-lg-3 col-md-4 mb-4">
            <div class="profile-card text-white p-4 rounded-4 shadow-lg h-100">
                <h4 class="text-center mb-3">Profil User</h4>
                <hr class="border-secondary opacity-50 mb-3">
                <div class="text-center mb-4">
                    <div class="avatar-frame mx-auto">
                        <img src="img/<?= $avatar ?>" alt="Avatar User" class="avatar-image">
                    </div>
                </div>
                <p><strong>Nama:</strong> <span class="text-info"><?= $user ?></span></p>
                <p><strong>Authorize:</strong> <span class="badge bg-primary"><?= $auth ?></span></p>
                <p><strong>Login:</strong> <span class="text-start-emphasis small"><?= $timestamp ?></span></p>
                <hr class="border-secondary opacity-50">
                <a href="assets/logout.php" class="btn btn-logout w-100 fw-semibold">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </div>
        </div>

        <!-- 🧱 HALAMAN DINAMIS -->
        <div class="col-lg-6 col-md-8">
            <div class="content-card p-3 rounded-3 bg-dark shadow">
                <?php
                $pages_dir = 'pages';
                if (isset($_GET['p']) && !empty($_GET['p'])) {
                    $page = basename($_GET['p']);
                    $file_path = "$pages_dir/$page.php";
                    if (file_exists($file_path)) include $file_path;
                    else echo '<div class="alert alert-warning">Halaman tidak ditemukan.</div>';
                } else include 'pages/home.php';
                ?>
            </div>
        </div>

        <!--  GALERI -->
        <div class="col-lg-3 col-md-12">

            <!-- 🎥 Gallery Video -->
            <div class="bg-dark text-white p-3 rounded mb-4 shadow-sm">
                <h4 class="text-center">Gallery Videos</h4>
                <hr>
                <?php if (!empty($video)): ?>
                    <?php foreach ($video as $v): 
                        $videoUrl = htmlspecialchars($v['video']);

                        // Deteksi YouTube dan ubah ke embed
                        if (preg_match('/(youtube\.com|youtu\.be)/', $videoUrl)) {
                            $embed = preg_replace(
                                '/^(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/))([a-zA-Z0-9_-]+)/',
                                'https://www.youtube.com/embed/$1',
                                $videoUrl
                            );
                        } else {
                            $embed = $videoUrl;
                        }?>

                        <div class="video-wrapper mb-3">
                            <iframe src="<?= $embed ?>" allowfullscreen></iframe>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center text-muted">Belum ada video.</p>
                <?php endif; ?>
            </div>

            <!-- 📰 Gallery News -->
            <div class="bg-dark text-white p-3 rounded mb-4 shadow-sm">
                <h5 class="text-center">Gallery News</h5>
                <hr>
                <?php 
                if (!empty($news) && is_array($news)): ?>
                    <ul class="list-group list-group-flush bg-dark">
                        <?php 
                        foreach ($news as $n): 
                            if (!is_array($n)) continue; // 🔒 skip kalau bukan array
                        ?>
                            <li class="list-group-item bg-dark border-secondary small">
                                <a href="main.php?p=detail_news&kode=<?= htmlspecialchars($n['kode'] ?? '') ?>" class="news-link">
                                    <strong><?= htmlspecialchars($n['jenis_berita'] ?? 'Tanpa Judul') ?></strong><br>
                                    <span class="text-muted"><?= htmlspecialchars(substr($n['isi_berita'] ?? '', 0, 60)) ?>...</span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="text-center text-muted">Belum ada berita.</p>
                <?php endif; ?>
            </div>


            <!-- 🖼️ Gallery Images -->
            <div class="bg-dark text-white p-3 rounded shadow-sm">
                <h4 class="text-center">Gallery Images</h4>
                <hr>
                <?php if (!empty($images)): ?>
                    <div id="demo" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <?php $active = true; foreach ($images as $img): ?>
                                <div class="carousel-item <?= $active ? 'active' : '' ?>">
                                    <img src="img/<?= htmlspecialchars($img['images']) ?>" 
                                        alt="Gallery Image" class="d-block w-100 rounded"
                                        style="height:200px;object-fit:cover;">
                                    <!-- <div class="carousel-caption d-none d-md-block">
                                        <small><?= htmlspecialchars($img['keterangan']) ?></small>
                                    </div> -->
                                </div>
                            <?php $active = false; endforeach; ?>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                    </div>
                <?php else: ?>
                    <p class="text-center text-muted">Belum ada gambar.</p>
                <?php endif; ?>
            </div>
    

</div>

<footer class="mt-5 p-3 bg-dark text-white text-center border-top border-secondary">
    <p>&copy; 2025 - Aplikasi Manajemen User & Inventory</p>
</footer>

</body>
</html>
