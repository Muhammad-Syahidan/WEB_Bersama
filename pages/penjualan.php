<div class="user-management">
    <h3 class="fw-bold mb-3 text-light">Katalog Produk (Mode Buyer)</h3>
    <hr class="border-secondary">

    <div class="row">
        <?php 
            // QUERY LENGKAP:
            // Mengambil data stock, digabungkan dengan databarang (untuk nama) dan harga (untuk harga jual)
            // Pastikan kolom penghubungnya benar (stock.kode = databarang.id ATAU stock.kode = databarang.kode)
            // Di sini saya pakai asumsi stock.kode = databarang.kode (atau id sesuai struktur data Anda)
            
            $sql = "SELECT 
                        stock.kode, 
                        stock.jumlah, 
                        harga.harga_jual,
                        databarang.nama AS nama_barang -- PENTING: Ambil kolom nama
                    FROM stock
                    LEFT JOIN databarang ON stock.kode = databarang.id -- Coba join ke ID dulu
                    LEFT JOIN harga ON stock.kode = harga.kode
                    WHERE stock.jumlah > 0 
                    ORDER BY stock.kode ASC";
            
            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0):
                while ($row = $result->fetch_assoc()):
                    
                    // Cek jika nama barang kosong, pakai kodenya saja biar tetap ada teksnya
                    $nama_produk = !empty($row['nama_barang']) ? $row['nama_barang'] : "Barang #".$row['kode'];
                    
                    // Cek harga
                    $harga = $row['harga_jual'] ? $row['harga_jual'] : 0;
        ?>
            <div class="col-md-3 mb-4">
                <div class="card h-100 bg-dark border-secondary text-white shadow-lg hover-effect">
                    
                    <div class="card-body text-center d-flex flex-column justify-content-between">
                        
                        <div>
                            <i class="bi bi-box-seam text-secondary" style="font-size: 3rem;"></i>
                            
                            <h4 class="card-title mt-3 fw-bold text-warning text-uppercase" style="letter-spacing: 1px;">
                                <?= $nama_produk ?>
                            </h4>
                            
                            <p class="text-muted small mb-4">Kode: <?= $row['kode'] ?></p>
                        </div>

                        <div>
                            <h3 class="text-success fw-bold mb-2">
                                Rp <?= number_format($harga, 0, ',', '.') ?>
                            </h3>
                            
                            <span class="badge bg-info text-dark mb-3 px-3 py-2 rounded-pill">
                                Stok Tersedia: <?= $row['jumlah'] ?>
                            </span>
                        </div>

                        <div class="d-grid mt-3">
                            <a href="main.php?p=penjualan_input&kode=<?= $row['kode'] ?>" 
                               class="btn btn-primary fw-bold py-2">
                               <i class="bi bi-cart-plus me-1"></i> BELI SEKARANG
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        <?php 
                endwhile;
            else:
        ?>
            <div class="col-12 text-center text-muted py-5">
                <i class="bi bi-shop display-1 mb-3"></i>
                <h3>Stok Barang Sedang Kosong</h3>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
    /* Efek saat mouse diarahkan ke kartu */
    .hover-effect { transition: transform 0.3s; }
    .hover-effect:hover { transform: translateY(-10px); border-color: #ffc107 !important; }
</style>