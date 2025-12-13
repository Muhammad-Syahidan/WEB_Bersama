<div class="user-management no-print">
    
    <div id="sliderGambar" class="carousel slide mb-5 shadow-lg rounded-4 overflow-hidden border border-secondary" data-bs-ride="carousel">
        
        <div class="carousel-indicators">
            <?php
                
                $q_img = $conn->query("SELECT * FROM images WHERE hapus = 0");
                $i = 0;
               
                foreach($q_img as $row){
                    $active = ($i == 0) ? 'active' : ''; 
                    echo '<button type="button" data-bs-target="#sliderGambar" data-bs-slide-to="'.$i.'" class="'.$active.'"></button>';
                    $i++;
                }
            ?>
        </div>

        <div class="carousel-inner">
            <?php
              
                $q_img->data_seek(0); 
                $i = 0;
                while($row = $q_img->fetch_assoc()){
                    $active = ($i == 0) ? 'active' : '';
            ?>
            <div class="carousel-item <?= $active ?>" data-bs-interval="3000">
                <img src="img/<?= $row['images'] ?>" class="d-block w-100" alt="Gambar" style="height: 400px; object-fit: cover;">
                
                <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-75 rounded-3 p-2">
                    <h5 class="fw-bold text-warning mb-0"><?= htmlspecialchars($row['keterangan']) ?></h5>
                </div>
            </div>
            <?php $i++; } ?>
        </div>
        
        <button class="carousel-control-prev" type="button" data-bs-target="#sliderGambar" data-bs-slide="prev">
            <span class="carousel-control-prev-icon bg-dark rounded-circle p-3" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        
        <button class="carousel-control-next" type="button" data-bs-target="#sliderGambar" data-bs-slide="next">
            <span class="carousel-control-next-icon bg-dark rounded-circle p-3" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <h3 class="fw-bold text-light mb-3 pb-2 border-bottom border-secondary">
        <i class="bi bi-megaphone-fill me-2 text-warning"></i> Berita & Pengumuman Terbaru
    </h3>
    
    <div class="row">
        <?php
           
            $q_news = $conn->query("SELECT * FROM news WHERE hapus = 0 ORDER BY tanggal DESC LIMIT 6");
            
            if($q_news && $q_news->num_rows > 0):
                while($news = $q_news->fetch_assoc()):
        ?>
        <div class="col-md-4 mb-4">
            <div class="card bg-dark text-white border-secondary h-100 shadow-sm hover-effect">
                <div class="card-header bg-transparent border-secondary d-flex justify-content-between">
                    <span class="badge bg-primary"><?= $news['jenis_berita'] ?></span>
                    <small class="text-muted"><i class="bi bi-calendar3"></i> <?= date('d M Y', strtotime($news['tanggal'])) ?></small>
                </div>
                <div class="card-body">
                    <h5 class="card-title fw-bold text-info"><?= htmlspecialchars($news['isi_berita']) ?></h5>
                    <p class="card-text small text-secondary">Klik tombol di bawah untuk informasi detail dari sumber terkait.</p>
                </div>
                <div class="card-footer bg-transparent border-secondary text-end">
                    <a href="<?= $news['sumber'] ?>" target="_blank" class="btn btn-sm btn-outline-warning">
                        Baca Selengkapnya <i class="bi bi-box-arrow-up-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
        <?php 
                endwhile; 
            else: 
        ?>
        <div class="col-12">
            <div class="alert alert-secondary text-center">
                <i class="bi bi-info-circle me-2"></i> Belum ada berita yang ditampilkan.
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<style>
    .hover-effect:hover {
        transform: translateY(-5px);
        transition: 0.3s;
        border-color: #ffc107 !important; 
    }
</style>