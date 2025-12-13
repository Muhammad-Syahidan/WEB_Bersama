<?php
include "../assets/koneksi.php";

// Pastikan tombol 'simpan_harga' ditekan (sesuai name di form)
if (isset($_POST['simpan_harga'])) {
    
    $kode       = $_POST['kode'];
    $harga_jual = $_POST['harga_jual'];
    
    // Validasi sederhana
    if (empty($kode) || $harga_jual === "") {
        echo "<script>alert('Pilih barang dan isi harga jual dengan benar!'); window.history.back();</script>";
        exit;
    }

    // Proses Update ke Database
    $sql = "UPDATE harga SET harga_jual = '$harga_jual' WHERE kode = '$kode'";
    
    if ($conn->query($sql)) {
        // Ambil nama barang untuk pesan notifikasi
        $cek = $conn->query("SELECT nama FROM databarang WHERE kode='$kode'");
        $d = $cek->fetch_assoc();
        $nama = $d['nama'];

        echo "<script>
                alert('SUKSES! Harga Jual [$nama] berhasil diperbarui menjadi Rp " . number_format($harga_jual,0,',','.') . "'); 
                window.location.href = '../main.php?p=harga_jual_input'; 
              </script>";
    } else {
        echo "Error: " . $conn->error;
    }

} else {
    // Jika diakses langsung tanpa submit
    header("Location: ../main.php?p=harga_jual_input");
}
?>