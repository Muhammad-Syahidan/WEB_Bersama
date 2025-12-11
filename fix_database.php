<?php
include "assets/koneksi.php";

echo "<h1>SYSTEM REPAIR TOOL - 3B INVENTORY</h1>";
echo "<hr>";

// 1. UBAH STRUKTUR TABEL (Paksa jadi VARCHAR/TEKS)
$tables = ['databarang', 'stock', 'harga', 'detail_beli', 'detail_jual'];
foreach ($tables as $table) {
    $sql = "ALTER TABLE $table MODIFY COLUMN kode VARCHAR(50)";
    if ($conn->query($sql)) {
        echo "<p style='color:green'>[BERHASIL] Tabel <b>$table</b> kolom 'kode' diubah menjadi TEXT.</p>";
    } else {
        echo "<p style='color:red'>[GAGAL] Tabel $table: " . $conn->error . "</p>";
    }
}

// 2. UBAH NOTA & FAKTUR
$conn->query("ALTER TABLE penjualan MODIFY COLUMN nota VARCHAR(50)");
$conn->query("ALTER TABLE detail_jual MODIFY COLUMN nota VARCHAR(50)");
$conn->query("ALTER TABLE pembelian MODIFY COLUMN faktur VARCHAR(50)");
$conn->query("ALTER TABLE detail_beli MODIFY COLUMN faktur VARCHAR(50)");
echo "<p style='color:green'>[BERHASIL] Struktur Nota dan Faktur diperbarui.</p>";

// 3. BERSIHKAN DATA SAMPAH (Hapus data error 0, 1, atau kosong)
$trash_tables = ['stock', 'harga', 'detail_beli', 'detail_jual'];
foreach ($trash_tables as $table) {
    $sql = "DELETE FROM $table WHERE kode = '0' OR kode = '1' OR kode = '' OR kode IS NULL";
    if ($conn->query($sql)) {
        echo "<p style='color:green'>[BERSIH] Data sampah (Kode 0/1) di tabel <b>$table</b> dihapus.</p>";
    }
}

echo "<hr>";
echo "<h3>SELESAI! Database sudah diperbaiki.</h3>";
echo "<a href='main.php?p=home' style='font-size:20px; font-weight:bold;'>KLIK DISINI UNTUK KEMBALI KE APLIKASI</a>";
?>