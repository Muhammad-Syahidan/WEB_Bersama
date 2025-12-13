<?php
session_start();
if (!isset($_SESSION["iduser"])) { header("Location: login.php"); exit(); }
include "assets/koneksi.php";
$iduser = $_SESSION["iduser"];

// Cek User
$sql = "SELECT * FROM user_list WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $iduser);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $avatar = $row["avatar"]; $user = $row["user"]; $auth = $row["auth"]; $timestamp = $row["timestamp"];
    if (!isset($_SESSION["auth"])) $_SESSION["auth"] = $auth;
} else { session_destroy(); header("Location: login.php"); exit(); }

// FUNGSI UBAH LINK YOUTUBE JADI EMBED
function convertYoutube($string) {
    return preg_replace(
        "/\s*[a-zA-Z\/\/:\.]*youtu(be.com\/watch\?v=|.be\/)([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i",
        "https://www.youtube.com/embed/$2",
        $string
    );
}

// Data Sidebar
$video=[]; $v=$conn->query("SELECT * FROM video WHERE hapus=1 ORDER BY id DESC LIMIT 5"); if($v)while($r=$v->fetch_assoc())$video[]=$r;
$news=[]; $n=$conn->query("SELECT * FROM news WHERE hapus=1 ORDER BY kode DESC LIMIT 5"); if($n)while($r=$n->fetch_assoc())$news[]=$r;
$images=[]; $i=$conn->query("SELECT * FROM images WHERE hapus=1 ORDER BY id DESC LIMIT 5"); if($i)while($r=$i->fetch_assoc())$images[]=$r;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"> <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>3B Inventory</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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
        <div class="col-sm-2"><img src="img/Avatar3.png" width="150" alt="Logo" class="shadow-sm"></div>
        <div class="col-sm-10"><h1>Program Aplikasi Sistem Inventory</h1><h3>PT. Minecraft Lovers</h3><p>Jl. Lambung Mangkurat</p><hr></div>
    </div>
</div>

<nav class="navbar navbar-expand-sm bg-dark navbar-dark sticky-top shadow-sm">
    <div class="container-fluid justify-content-center">
        <ul class="navbar-nav">
            <li class="nav-item"><a class="nav-link" href="main.php?p=home">Home</a></li>

            <?php if ($auth === "Administrator"): ?>
                <li class="nav-item"><a class="nav-link" href="main.php?p=manajuser">Manajemen User</a></li>
                <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">Galeri</a>
                    <ul class="dropdown-menu"><li><a class="dropdown-item" href="main.php?p=manajvideo">Video</a></li><li><a class="dropdown-item" href="main.php?p=manajimg">Images</a></li><li><a class="dropdown-item" href="main.php?p=manajnews">News</a></li></ul></li>
                <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">Laporan</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="main.php?p=databarang">Lap. Barang</a></li>
                        <li><a class="dropdown-item" href="main.php?p=stock">Lap. Stock</a></li>
                        <li><a class="dropdown-item" href="main.php?p=harga">Lap. Harga</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="main.php?p=penjualan">Lap. Penjualan</a></li>
                        <li><a class="dropdown-item" href="main.php?p=detail_jual">Detail Jual</a></li>
                        <li><a class="dropdown-item" href="main.php?p=pembelian">Lap. Pembelian</a></li>
                        <li><a class="dropdown-item" href="main.php?p=detail_beli">Detail Beli</a></li>
                    </ul></li>
            <?php endif; ?>

            <?php if ($auth === "Gudang"): ?>
                <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">Master Data</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#" onclick="goToPage('databarang_input'); return false;">Kelola Data Barang</a></li>
                        <li><a class="dropdown-item" href="main.php?p=stock_input">Kelola Stock</a></li>
                        <li><a class="dropdown-item" href="main.php?p=harga_input">Set Harga Beli</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">Laporan</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="main.php?p=databarang">Lap. Barang</a></li>
                        <li><a class="dropdown-item" href="main.php?p=stock">Lap. Stock</a></li>
                    </ul>
                </li>
            <?php endif; ?>

            <?php if ($auth === "Ahli"): ?>
                <li class="nav-item"><a class="nav-link" href="main.php?p=manajuser">User</a></li>
                <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">Galeri</a>
                    <ul class="dropdown-menu"><li><a class="dropdown-item" href="main.php?p=manajvideo">Video</a></li><li><a class="dropdown-item" href="main.php?p=manajimg">Images</a></li><li><a class="dropdown-item" href="main.php?p=manajnews">News</a></li></ul></li>
                
                <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">Master Data</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#" onclick="goToPage('databarang_input'); return false;">Kelola Data Barang</a></li>
                        <li><a class="dropdown-item" href="main.php?p=stock_input">Kelola Stock</a></li>
                        <li><a class="dropdown-item" href="main.php?p=harga_input">Set Harga Beli</a></li>
                    </ul>
                </li>
                
                <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">Laporan</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="main.php?p=databarang">Lap. Barang</a></li>
                        <li><a class="dropdown-item" href="main.php?p=stock">Lap. Stock</a></li>
                        <li><a class="dropdown-item" href="main.php?p=harga">Lap. Harga</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="main.php?p=penjualan">Lap. Penjualan</a></li>
                        <li><a class="dropdown-item" href="main.php?p=detail_jual">Detail Jual</a></li>
                        <li><a class="dropdown-item" href="main.php?p=pembelian">Lap. Pembelian</a></li>
                        <li><a class="dropdown-item" href="main.php?p=detail_beli">Detail Beli</a></li>
                    </ul>
                </li>
                
                <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">Penjualan</a>
                    <ul class="dropdown-menu"><li><a class="dropdown-item" href="main.php?p=harga_jual_input">Set Harga Jual</a></li><li><a class="dropdown-item" href="main.php?p=detail_jual_manage">Detail Jual</a></li></ul></li>
                
                <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">Pembelian</a>
                    <ul class="dropdown-menu"><li><a class="dropdown-item" href="main.php?p=pembelian_manage">Transaksi Pembelian</a></li><li><a class="dropdown-item" href="main.php?p=detail_beli_manage">Detail Beli</a></li></ul></li>
            <?php endif; ?>

            <?php if ($auth === "Penjualan"): ?>
                <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">Menu Penjualan</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="main.php?p=harga_jual_input">Set Harga Jual</a></li>
                        <li><a class="dropdown-item" href="main.php?p=detail_jual_manage">Detail Jual</a></li>
                    </ul>
                </li>
            <?php endif; ?>

            <?php if ($auth === "Pembelian"): ?>
                <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">Menu Pembelian</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="main.php?p=pembelian_manage">Transaksi Pembelian</a></li>
                        <li><a class="dropdown-item" href="main.php?p=detail_beli_manage">Detail Beli</a></li>
                    </ul>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

<div class="container mt-4">
    <div class="row">
        <div class="col-lg-3 col-md-4 mb-4">
            <div class="profile-card text-white p-4 rounded-4 shadow-lg h-100">
                <h4 class="text-center mb-3">Profil User</h4><hr class="border-secondary opacity-50 mb-3">
                <div class="text-center mb-4"><div class="avatar-frame mx-auto"><img src="img/<?= $avatar ?>" alt="Avatar" class="avatar-image"></div></div>
                <p><strong>Nama:</strong> <span class="text-info"><?= $user ?></span></p>
                <p><strong>Authorize:</strong> <span class="badge bg-primary"><?= $auth ?></span></p>
                <p><strong>Login:</strong> <span class="text-start-emphasis small"><?= $timestamp ?></span></p>
                <hr class="border-secondary opacity-50"><a href="assets/logout.php" class="btn btn-logout w-100 fw-semibold">Logout</a>
            </div>
        </div>
        <div class="col-lg-6 col-md-8">
            <div class="content-card p-3 rounded-3 bg-dark shadow">
                <?php
                $pages_dir = 'pages'; $page = '';
                if (isset($_GET['p']) && !empty($_GET['p'])) $page = basename($_GET['p']);
                else if (isset($_POST['p']) && !empty($_POST['p'])) $page = basename($_POST['p']);
                else $page = 'home';
                $file_path = "$pages_dir/$page.php";
                if (file_exists($file_path)) include $file_path; else echo '<div class="alert alert-warning">Halaman tidak ditemukan.</div>';
                ?>
            </div>
        </div>
        <div class="col-lg-3 col-md-12">
            <div class="bg-dark text-white p-3 rounded mb-4 shadow-sm"><h4 class="text-center">Gallery Videos</h4><hr>
                <?php if(!empty($video)) foreach($video as $v) { 
                    echo '<div class="video-wrapper mb-3"><iframe src="'. convertYoutube($v['video']) .'" allowfullscreen></iframe></div>'; 
                } else echo "<p class='text-muted text-center'>Kosong</p>"; ?>
            </div>
            <div class="bg-dark text-white p-3 rounded shadow-sm"><h4 class="text-center">Gallery Images</h4><hr>
                <?php if(!empty($images)): ?><div id="d" class="carousel slide" data-bs-ride="carousel"><div class="carousel-inner"><?php $a=true;foreach($images as $i){echo '<div class="carousel-item '.($a?'active':'').'"><img src="img/'.$i['images'].'" class="d-block w-100 rounded" style="height:200px;object-fit:cover;"></div>';$a=false;} ?></div></div><?php else: echo "<p class='text-muted text-center'>Kosong</p>"; endif; ?>
            </div>
        </div>
    </div>
</div>
<footer class="mt-5 p-3 bg-dark text-white text-center border-top border-secondary"><p>&copy; 2025 - Aplikasi Inventory</p></footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>