<?= $this->extend('yayasan/layouts/main') ?>
<?= $this->section('content') ?>
<link rel="stylesheet" href="<?= base_url('assets/css/yayasan_campaign.css') ?>">
<div class="campaign-page">
    <!-- HEADER -->
    <div class="page-header mb-4">
        <div>
            <h2 class="page-title">
                Detail Campaign
            </h2>
            <p class="page-subtitle">
                Informasi lengkap campaign yayasan.
            </p>
        </div>
        <a href="<?= base_url('yayasan/campaign/index') ?>"
           class="btn btn-light">
            <i class="fa-solid fa-arrow-left"></i>
            Kembali
        </a>
    </div>
    <div class="row g-4">
        <!-- KONTEN UTAMA -->
        <div class="col-lg-8">
            <div class="campaign-detail-card">

                <!-- STATUS -->
                <?php
                $statusVerifikasi = $campaign['status_verifikasi'] ?? 'pending';
                if($statusVerifikasi == 'approved'){
                    $badgeClass = 'success';
                    $badgeText = 'Aktif';
                    $infoStatus = 'Campaign sudah disetujui Admin dan dapat menerima donasi.';
                }elseif($statusVerifikasi == 'rejected'){
                    $badgeClass = 'danger';
                    $badgeText = 'Ditolak';
                    $infoStatus = 'Campaign ditolak oleh Admin.';
                }else{
                    $badgeClass = 'secondary';
                    $badgeText = 'Menunggu Verifikasi';
                    $infoStatus = 'Campaign sedang menunggu persetujuan Admin.';
                }
                ?>
                <span class="badge bg-<?= $badgeClass ?> mb-3">
                    <?= $badgeText ?>
                </span>
                <p class="text-muted">
                    <?= $infoStatus ?></p>

                <!-- GALLERY -->
                <?php if(!empty($campaignImages)): ?>
                <div id="campaignGallery"
                     class="carousel slide mb-4"
                     data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <?php foreach($campaignImages as $key=>$image): ?>
                        <button
                        type="button"
                        data-bs-target="#campaignGallery"
                        data-bs-slide-to="<?= $key ?>"
                        class="<?= $key==0?'active':'' ?>">
                        </button>
                        <?php endforeach; ?>
                    </div>
                    <div class="carousel-inner rounded">
                        <?php foreach($campaignImages as $key=>$image): ?>
                        <div class="carousel-item <?= $key==0?'active':'' ?>">
                            <img
                            src="<?= base_url('uploads/campaign/'.$image['image']) ?>"
                            class="d-block w-100"
                            style="height:420px;object-fit:cover;">
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php if(count($campaignImages)>1): ?>
                    <button
                    class="carousel-control-prev"
                    type="button"
                    data-bs-target="#campaignGallery"
                    data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button
                    class="carousel-control-next"
                    type="button"
                    data-bs-target="#campaignGallery>
                    data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                    <?php endif; ?>
                </div>
                <?php elseif(!empty($campaign['gambar'])): ?>
                    <img
                    src="<?= base_url('uploads/campaign/'.$campaign['gambar']) ?>"
                    class="img-fluid rounded mb-4"
                    style="height:420px;width:100%;object-fit:cover;">
                <?php endif; ?>
                <h3 class="fw-bold">
                    <?= esc($campaign['judul']) ?>
                </h3>
                <hr>
                <h5>
                    Deskripsi Campaign
                </h5>
                <p class="text-muted">
                    <?= nl2br(esc($campaign['deskripsi'])) ?>
                </p>
            </div>
        </div>

        <!-- SIDEBAR INFO -->
        <div class="col-lg-4">
            <div class="campaign-detail-card">
                <h5 class="fw-bold mb-4">
                    Informasi Campaign
                </h5>

                <div class="mb-4">
                    <small class="text-muted">
                        Target Dana
                    </small>
                    <h4 class="text-success">
                        Rp <?= number_format($campaign['target_dana'],0,',','.') ?>
                    </h4>
                </div>

                <div class="mb-4">
                    <small class="text-muted"> Dana Terkumpul </small>
                    <h4>
                        Rp <?= number_format($campaign['dana_terkumpul'],0,',','.') ?>
                    </h4>
                </div>

                <div class="mb-4">
                    <small class="text-muted">Jumlah Donatur  </small>
                    <h4><?= esc($campaign['jumlah_donatur']) ?> Orang </h4>
                </div>

                <div class="mb-4">
                    <small class="text-muted">
                        Periode Campaign
                    </small>
                    <p class="mb-1">
                        <?= esc($campaign['tanggal_mulai']) ?>
                    </p>
                    <p>
                        s/d <?= esc($campaign['tanggal_berakhir']) ?>
                    </p>
                </div>

                <a
                href="<?= base_url('yayasan/campaign/edit/'.$campaign['id']) ?>"
                class="btn btn-warning w-100 mb-2">
                    <i class="fa-solid fa-pen"></i>
                    Edit Campaign
                </a>
                <a
                href="<?= base_url('yayasan/campaign/index') ?>"
                class="btn btn-light w-100">
                    Kembali
                </a>
            </div>
        </div>
    </div>
</div>


<style>
.campaign-detail-card{
    background:white;
    border-radius:20px;
    padding:30px;
    box-shadow:0 5px 20px rgba(0,0,0,.08);
}
.carousel-inner{
    border-radius:18px;
}
.badge{
    font-size:14px;
    padding:9px 15px;
    border-radius:20px;
}
</style>
<?= $this->endSection() ?>