<?php
    // Ambil ID dari URL
    $id = $_GET['id'];

    // 1. Cek Data Dulu (Kita butuh No Faktur untuk menghapus detailnya)
    $cek = $conn->query("SELECT faktur FROM pembelian WHERE idbeli = '$id'");
    
    if($cek->num_rows > 0){
        $data = $cek->fetch_assoc();
        $faktur = $data['faktur'];

        $q_detail = $conn->query("SELECT * FROM detail_beli WHERE faktur='$faktur'");
        while($r = $q_detail->fetch_assoc()){
            $kd = $r['kode'];
            $jml = $r['jumlah'];
            $conn->query("UPDATE stock SET jumlah = jumlah - $jml WHERE kode='$kd'");
        }

        // 2. Hapus data di tabel DETAIL_BELI (Rinciannya)
        $sql_detail = "DELETE FROM detail_beli WHERE faktur = '$faktur'";
        $conn->query($sql_detail);

        // 3. Hapus data di tabel PEMBELIAN (Headernya)
        $sql_induk = "DELETE FROM pembelian WHERE idbeli = '$id'";
        
        if($conn->query($sql_induk)){
            echo "<script>
                    alert('Data Pembelian Berhasil Dihapus!');
                    window.location.href = 'main.php?p=pembelian';
                  </script>";
        } else {
            echo "<script>
                    alert('Gagal Menghapus Data!');
                    window.location.href = 'main.php?p=pembelian';
                  </script>";
        }

    } else {
        echo "<script>alert('Data tidak ditemukan!'); window.location.href = 'main.php?p=pembelian';</script>";
    }
?>