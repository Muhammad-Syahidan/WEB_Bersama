<?php
session_start();
// Cek sesi login
if (!isset($_SESSION["iduser"])) { header("Location: login.php"); exit(); }

include "assets/koneksi.php";
$iduser = $_SESSION["iduser"];

// Ambil Data User
$sql = "SELECT * FROM user_list WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $iduser);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $avatar = $row["avatar"]; 
    $user = $row["user"]; 
    $auth = $row["auth"]; 
    $timestamp = $row["timestamp"];
    if (!isset($_SESSION["auth"])) $_SESSION["auth"] = $auth;
} else { 
    session_destroy(); header("Location: login.php"); exit(); 
}

// FUNGSI YOUTUBE
function convertYoutube($string) {
    return preg_replace(
        "/\s*[a-zA-Z\/\/:\.]*youtu(be.com\/watch\?v=|.be\/)([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i",
        "https://www.youtube.com/embed/$2",
        $string
    );
}

// QUERY DATA SIDEBAR (Pastikan logika hapus=1 sesuai data Anda)
$video=[]; $v=$conn->query("SELECT * FROM video WHERE hapus=1 ORDER BY id DESC LIMIT 3"); 
if($v)while($r=$v->fetch_assoc())$video[]=$r;

$news=[]; $n=$conn->query("SELECT * FROM news WHERE hapus=1 ORDER BY kode DESC LIMIT 3"); 
if($n)while($r=$n->fetch_assoc())$news[]=$r;

$images=[]; $i=$conn->query("SELECT * FROM images WHERE hapus=1 ORDER BY id DESC LIMIT 5"); 
if($i)while($r=$i->fetch_assoc())$images[]=$r;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"> <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>3B Inventory System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/main.css">
    <script>
    function goToPage(pageName) {
        let form = document.createElement('form'); form.method = 'POST'; form.action = 'main.php';
        let input = document.createElement('input'); input.type = 'hidden'; input.name = 'p'; input.value = pageName;
        form.appendChild(input); document.body.appendChild(form); form.submit();
    }
    </script>
</head>
<body>

<div class="container text-center p-4">
    <div class="row align-items-center">
        <div class="col-sm-2"><img src="img/Avatar3.png" width="120" alt="Logo" class="shadow-sm rounded-circle"></div>
        <div class="col-sm-10">
            <h1 class="fw-bold">Sistem Informasi Inventory</h1>
            <h4 class="text-muted">PT. Minecraft Lovers Indonesia</h4>
            <hr class="border-primary opacity-50">
        </div>
    </div>
</div>

<nav class="navbar navbar-expand-sm bg-dark navbar-dark sticky-top shadow border-bottom border-secondary">
    <div class="container-fluid justify-content-center">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="mynavbar">
            <ul class="navbar-nav gap-3">
                <li class="nav-item"><a class="nav-link active" href="main.php?p=home"><i class="bi bi-house-door-fill"></i> Home</a></li>

                 <?php if (in_array($auth, ["Administrator", "Ahli"])): ?>
                    <li class="nav-item"><a class="nav-link" href="main.php?p=manajuser">Manajemen User</a></li>
                    <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">Galeri</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="main.php?p=manajvideo">Kelola Video</a></li>
                            <li><a class="dropdown-item" href="main.php?p=manajimg">Kelola Gambar</a></li>
                            <li><a class="dropdown-item" href="main.php?p=manajnews">Kelola Berita</a></li>
                        </ul>
                    </li>
                <?php endif; ?>

                <?php if (in_array($auth, ["Gudang", "Ahli"])): ?>
                    <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Master Data</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#" onclick="goToPage('databarang_input');">Kelola Data Barang</a></li>
                            <li><a class="dropdown-item" href="main.php?p=stock_input">Kelola Stok</a></li>
                            <li><a class="dropdown-item" href="main.php?p=harga_input">Set Harga Beli</a></li>
                        </ul>
                    </li>
                <?php endif; ?>

                <?php if (in_array($auth, ["Penjualan", "Ahli"])): ?>
                    <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Penjualan</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="main.php?p=harga_jual_input">Set Harga Jual</a></li>
                            <li><a class="dropdown-item" href="main.php?p=penjualan_input">Input Transaksi</a></li>
                            <li><a class="dropdown-item" href="main.php?p=detail_jual_manage">Riwayat Penjualan</a></li>
                        </ul>
                    </li>
                <?php endif; ?>

                <?php if (in_array($auth, ["Pembelian", "Ahli"])): ?>
                    <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Pembelian</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="main.php?p=pembelian_input">Input Pembelian</a></li>
                            <li><a class="dropdown-item" href="main.php?p=detail_beli_manage">Riwayat Pembelian</a></li>
                        </ul>
                    </li>
                <?php endif; ?>

                 <?php if (in_array($auth, ["Gudang", "Ahli"])): ?>
                    <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Laporan</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="main.php?p=databarang">Laporan Barang</a></li>
                            <li><a class="dropdown-item" href="main.php?p=stock">Laporan Stok</a></li>
                            <li><a class="dropdown-item" href="main.php?p=harga">Laporan Harga</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="main.php?p=detail_jual">Laporan Penjualan</a></li>
                            <li><a class="dropdown-item" href="main.php?p=detail_beli">Laporan Pembelian</a></li>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid mt-4">
    <div class="row">
        
        <div class="col-lg-3 col-md-4 mb-4">
            <div class="card bg-dark text-white shadow rounded-4 border-secondary">
                <div class="card-body text-center">
                    <h4 class="card-title fw-bold">Profil Pengguna</h4>
                    <hr class="border-secondary">
                    <img src="img/<?= $avatar ?>" class="rounded-circle border border-3 border-warning mb-3" width="100" height="100" style="object-fit:cover;">
                    <h5 class="text-info"><?= $user ?></h5>
                    <span class="badge bg-primary mb-3"><?= $auth ?></span>
                    <p class="small text-muted mb-0">Login: <?= $timestamp ?></p>
                    <hr class="border-secondary">
                    <a href="assets/logout.php" class="btn btn-danger w-100 btn-sm fw-bold">Logout</a>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-8 mb-4">
            <div class="card bg-dark text-white shadow-lg border-secondary" style="min-height: 500px;">
                <div class="card-body p-4">
                    <?php
                        // Logika Halaman (Route) yang sudah diperbaiki
                        $pages_dir = __DIR__ . '/pages'; 
                        $page = isset($_GET['p']) ? $_GET['p'] : (isset($_POST['p']) ? $_POST['p'] : 'home');
                        $page = str_replace('.php', '', $page); // Bersihkan ekstensi
                        
                        $file_path = $pages_dir . '/' . $page . '.php';

                        if (file_exists($file_path)) {
                            include $file_path;
                        } else {
                            echo '<div class="alert alert-warning text-center">Halaman <strong>'.$page.'</strong> tidak ditemukan.</div>';
                        }
                    ?>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-12">
            
            <div class="card bg-dark text-white border-secondary mb-4 shadow">
                <div class="card-header fw-bold text-center border-secondary bg-secondary bg-opacity-25">Gallery Videos</div>
                <div class="card-body">
                    <?php if(!empty($video)): foreach($video as $v): ?>
                        <div class="ratio ratio-16x9 mb-3 rounded overflow-hidden border border-secondary">
                            <iframe src="<?= convertYoutube($v['video']) ?>" allowfullscreen></iframe>
                        </div>
                    <?php endforeach; else: echo "<p class='text-center text-muted'>Tidak ada video.</p>"; endif; ?>
                </div>
            </div>

            <div class="card bg-dark text-white border-secondary mb-4 shadow">
                <div class="card-header fw-bold text-center border-secondary bg-secondary bg-opacity-25">Gallery Images</div>
                <div class="card-body p-2">
                    <?php if(!empty($images)): ?>
                        <div id="sideCarousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner rounded">
                                <?php $first=true; foreach($images as $i): ?>
                                    <div class="carousel-item <?= $first?'active':'' ?>">
                                        <img src="img/<?= $i['images'] ?>" class="d-block w-100" style="height: 200px; object-fit: cover;">
                                        <div class="carousel-caption p-1 bg-dark bg-opacity-75 bottom-0 w-100 start-0">
                                            <small><?= $i['keterangan'] ?></small>
                                        </div>
                                    </div>
                                <?php $first=false; endforeach; ?>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#sideCarousel" data-bs-slide="prev"><span class="carousel-control-prev-icon"></span></button>
                            <button class="carousel-control-next" type="button" data-bs-target="#sideCarousel" data-bs-slide="next"><span class="carousel-control-next-icon"></span></button>
                        </div>
                    <?php else: echo "<p class='text-center text-muted'>Tidak ada gambar.</p>"; endif; ?>
                </div>
            </div>

            <div class="card bg-dark text-white border-secondary mb-4 shadow">
                <div class="card-header fw-bold text-center border-secondary bg-secondary bg-opacity-25">Gallery News</div>
                <div class="card-body">
                    <?php if(!empty($news)): foreach($news as $n): ?>
                        <div class="mb-3 border-bottom border-secondary pb-2">
                            <span class="badge bg-warning text-dark mb-1"><?= htmlspecialchars($n['jenis_berita']) ?></span>
                            <h6 class="card-title fw-bold text-info small mb-1"><?= htmlspecialchars($n['isi_berita']) ?></h6>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted" style="font-size: 10px;"><?= $n['tanggal'] ?></small>
                                <a href="<?= $n['sumber'] ?>" target="_blank" class="btn btn-sm btn-outline-light py-0" style="font-size: 10px;">Lihat &raquo;</a>
                            </div>
                        </div>
                    <?php endforeach; else: echo "<p class='text-center text-muted'>Tidak ada berita.</p>"; endif; ?>
                </div>
            </div>

        </div>
    </div>
</div>

<footer class="mt-5 p-3 bg-dark text-white text-center border-top border-secondary">
    <p class="mb-0">&copy; 2025 - Aplikasi Inventory PT. Minecraft Lovers</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>