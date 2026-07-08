<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<style>
.admin-campaign-detail .summary-card,
.admin-campaign-detail .info-card {
    background: #ffffff;
    border-radius: 28px;
    padding: 28px;
    box-shadow: 0 14px 34px rgba(15, 23, 42, .08);
    border: 1px solid #eef2f7;
}

.admin-campaign-detail .campaign-cover {
    width: 100%;
    height: 330px;
    object-fit: cover;
    border-radius: 24px;
    background: #e2e8f0;
}

.admin-campaign-detail .detail-title {
    font-weight: 900;
    color: #0f172a;
    margin-top: 22px;
    margin-bottom: 8px;
}

.admin-campaign-detail .badge-soft {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 8px 12px;
    border-radius: 999px;
    font-weight: 900;
    font-size: 12px;
}

.admin-campaign-detail .badge-soft.success { background: #dcfce7; color: #15803d; }
.admin-campaign-detail .badge-soft.warning { background: #fef3c7; color: #92400e; }
.admin-campaign-detail .badge-soft.danger { background: #fee2e2; color: #b91c1c; }
.admin-campaign-detail .badge-soft.dark { background: #e2e8f0; color: #334155; }

.admin-campaign-detail .progress {
    height: 12px;
    border-radius: 999px;
    background: #edf2f7;
    overflow: hidden;
}

.admin-campaign-detail .progress-bar {
    background: linear-gradient(135deg, #2563eb, #4f46e5);
}

.admin-campaign-detail .money strong {
    display: block;
    font-size: 26px;
    font-weight: 900;
    color: #0f172a;
}

.admin-campaign-detail .money small {
    color: #64748b;
}

.admin-campaign-detail .field-box {
    background: #f8fafc;
    border: 1px solid #edf2f7;
    border-radius: 20px;
    padding: 18px;
    height: 100%;
}

.admin-campaign-detail .field-box small {
    display: block;
    color: #64748b;
    font-weight: 900;
    margin-bottom: 8px;
}

.admin-campaign-detail .field-box h5 {
    margin: 0;
    font-weight: 900;
    color: #0f172a;
}

.admin-campaign-detail .btn-action {
    border: none;
    border-radius: 16px;
    padding: 12px 18px;
    font-weight: 900;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.admin-campaign-detail .btn-back { background: #f8fafc; color: #0f172a; }
.admin-campaign-detail .btn-edit { background: #facc15; color: #111827; }
.admin-campaign-detail .btn-approve { background: #16a34a; color: #ffffff; }
.admin-campaign-detail .btn-reject { background: #64748b; color: #ffffff; }
.admin-campaign-detail .btn-delete { background: #e11d48; color: #ffffff; }
.admin-campaign-detail .btn-locked { background: #e2e8f0; color: #64748b; cursor: not-allowed; }
.admin-campaign-detail form { display: inline-flex; margin: 0; }

.admin-campaign-detail .icon-btn{min-width:48px;height:48px;padding:0 14px;border:0;border-radius:16px;font-weight:900;text-decoration:none;display:inline-flex;align-items:center;justify-content:center;gap:8px}
.donasiku-confirm{position:fixed;inset:0;background:rgba(15,23,42,.55);z-index:2147483000;display:none;align-items:center;justify-content:center;padding:22px}.donasiku-confirm.show{display:flex}.donasiku-confirm-card{width:410px;max-width:100%;background:#fff;border-radius:28px;padding:30px;text-align:center;box-shadow:0 28px 80px rgba(15,23,42,.25)}.donasiku-confirm-icon{width:72px;height:72px;margin:0 auto 16px;border-radius:22px;background:#eef2ff;color:#2563eb;font-size:30px;display:flex;align-items:center;justify-content:center}.donasiku-confirm-title{font-weight:900;color:#0f172a;margin-bottom:8px}.donasiku-confirm-message{color:#64748b;margin-bottom:24px;line-height:1.6}.donasiku-confirm-actions{display:flex;justify-content:center;gap:10px;flex-wrap:wrap}.donasiku-btn{border:0;border-radius:16px;padding:12px 22px;font-weight:900}.donasiku-btn-cancel{background:#f1f5f9;color:#334155}.donasiku-btn-primary{background:#2563eb;color:#fff}.donasiku-btn-success{background:#16a34a;color:#fff}.donasiku-btn-danger{background:#e11d48;color:#fff}.donasiku-btn-secondary{background:#64748b;color:#fff}
</style>

<?= $this->section('content') ?>

<?php
    $statusVerifikasi = $campaign['status_verifikasi'] ?? 'pending';
    $statusCampaign = $campaign['status'] ?? 'draft';

    $verifClass = 'dark';
    $verifText = 'Menunggu Verifikasi';
    if ($statusVerifikasi === 'approved') {
        $verifClass = 'success';
        $verifText = 'Disetujui';
    } elseif ($statusVerifikasi === 'rejected') {
        $verifClass = 'danger';
        $verifText = 'Ditolak';
    }

    $statusClass = 'dark';
    $statusText = ucfirst($statusCampaign);
    if ($statusCampaign === 'aktif') {
        $statusClass = 'success';
        $statusText = 'Aktif';
    } elseif ($statusCampaign === 'selesai') {
        $statusClass = 'dark';
        $statusText = 'Selesai';
    } elseif ($statusCampaign === 'draft') {
        $statusClass = 'warning';
        $statusText = 'Draft';
    }

    $targetDana = (float) ($campaign['target_dana'] ?? 0);
    $danaTerkumpul = (float) ($campaign['dana_terkumpul'] ?? 0);
    $jumlahDonatur = (int) ($campaign['jumlah_donatur'] ?? 0);
    $persen = $targetDana > 0 ? min(($danaTerkumpul / $targetDana) * 100, 100) : 0;
    $hasDonation = ($hasDonation ?? false) || $danaTerkumpul > 0 || $jumlahDonatur > 0;

    $imageUrl = function ($file) {
        if (empty($file)) {
            return base_url('assets/img/default-campaign.jpg');
        }

        $paths = [
            'uploads/campaign/' . $file,
            'uploads/campaigns/' . $file,
        ];

        foreach ($paths as $path) {
            if (defined('FCPATH') && file_exists(FCPATH . $path)) {
                return base_url($path);
            }
        }

        return base_url('uploads/campaign/' . $file);
    };

    $gambar = $imageUrl($campaign['gambar'] ?? null);
?>

<div class="admin-campaign-detail">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1">Detail Campaign</h2>
            <p class="text-muted mb-0">Lihat data campaign, status verifikasi, dan aksi admin.</p>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success rounded-4 mb-4"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger rounded-4 mb-4"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <div class="row g-4">
        <div class="col-lg-5">
            <div class="summary-card">
                <img src="<?= $gambar ?>" alt="Campaign" class="campaign-cover">

                <h3 class="detail-title"><?= esc($campaign['judul'] ?? '-') ?></h3>
                <p class="text-muted mb-3">
                    <i class="fa-solid fa-building-user me-2"></i>
                    <?= esc($campaign['nama_yayasan'] ?? '-') ?>
                </p>

                <div class="d-flex flex-wrap gap-2 mb-4">
                    <?php if ($statusVerifikasi === 'approved'): ?>
                        <span class="badge-soft <?= $statusCampaign === 'aktif' ? 'success' : 'dark' ?>">
                            <i class="fa-solid fa-circle"></i>
                            <?= $statusCampaign === 'aktif' ? 'Aktif' : esc(ucfirst($statusCampaign)) ?>
                        </span>
                        <span class="badge-soft success">
                            <i class="fa-solid fa-shield-halved"></i>
                            Disetujui
                        </span>
                    <?php elseif ($statusVerifikasi === 'rejected'): ?>
                        <span class="badge-soft danger">
                            <i class="fa-solid fa-xmark"></i>
                            Ditolak
                        </span>
                    <?php else: ?>
                        <span class="badge-soft warning">
                            <i class="fa-solid fa-clock"></i>
                            Menunggu Verifikasi
                        </span>
                    <?php endif; ?>
                </div>

                <div class="progress mb-3">
                    <div class="progress-bar" style="width: <?= $persen ?>%;"></div>
                </div>

                <div class="money">
                    <strong>Rp <?= number_format($danaTerkumpul, 0, ',', '.') ?></strong>
                    <small>dari Rp <?= number_format($targetDana, 0, ',', '.') ?> · <?= $jumlahDonatur ?> donatur</small>
                </div>

                <?php if ($hasDonation): ?>
                    <div class="alert alert-warning rounded-4 mt-4 mb-0">
                        <i class="fa-solid fa-lock me-2"></i>
                        Campaign sudah memiliki donasi. Admin tetap bisa edit data campaign, tetapi tidak bisa menolak atau menghapus campaign ini.
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="info-card">
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="field-box">
                            <small>Kategori</small>
                            <h5><?= esc($campaign['nama_kategori'] ?? '-') ?></h5>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="field-box">
                            <small>Lokasi</small>
                            <h5><?= esc($campaign['lokasi'] ?? '-') ?></h5>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="field-box">
                            <small>Tanggal Mulai</small>
                            <h5><?= esc($campaign['tanggal_mulai'] ?? '-') ?></h5>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="field-box">
                            <small>Tanggal Berakhir</small>
                            <h5><?= esc($campaign['tanggal_berakhir'] ?? '-') ?></h5>
                        </div>
                    </div>
                </div>

                <h5 class="fw-bold mb-3">Deskripsi Campaign</h5>
                <p class="text-muted" style="line-height:1.85;">
                    <?= nl2br(esc($campaign['deskripsi'] ?? '-')) ?>
                </p>

                <?php if (!empty($campaignImages)): ?>
                    <h5 class="fw-bold mt-4 mb-3">Galeri Campaign</h5>
                    <div class="row g-3">
                        <?php foreach ($campaignImages as $image): ?>
                            <div class="col-md-4">
                                <img
                                    src="<?= $imageUrl($image['image'] ?? null) ?>"
                                    class="img-fluid rounded-4"
                                    style="height:130px;width:100%;object-fit:cover;"
                                    alt="Campaign Image">
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <div class="d-flex flex-wrap gap-2 mt-4">
                    <a href="<?= base_url('admin/campaign') ?>" class="btn-action btn-back">
                        <i class="fa-solid fa-arrow-left"></i>
                        Kembali
                    </a>

                    <a href="<?= base_url('admin/campaign/edit/' . $campaign['id']) ?>" class="btn-action btn-edit">
                        <i class="fa-solid fa-pen"></i>
                        Edit
                    </a>

                    <?php if ($statusVerifikasi !== 'approved'): ?>
                        <form action="<?= base_url('admin/campaign/approve/' . $campaign['id']) ?>" method="post" class="js-donasiku-confirm" data-title="Setujui Campaign" data-message="Campaign akan aktif dan bisa menerima donasi." data-confirm-text="Ya, Setujui" data-confirm-class="donasiku-btn-success">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn-action btn-approve">
                                <i class="fa-solid fa-check"></i>
                                Approve
                            </button>
                        </form>
                    <?php endif; ?>

                    <?php if ($statusVerifikasi !== 'rejected'): ?>
                        <?php if ($hasDonation): ?>
                            <button type="button" class="btn-action btn-locked" disabled>
                                <i class="fa-solid fa-lock"></i>
                                Reject
                            </button>
                        <?php else: ?>
                            <form action="<?= base_url('admin/campaign/reject/' . $campaign['id']) ?>" method="post" class="js-donasiku-confirm" data-title="Tolak Campaign" data-message="Campaign akan ditolak dan yayasan perlu memperbaiki pengajuan." data-confirm-text="Ya, Tolak" data-confirm-class="donasiku-btn-secondary">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn-action btn-reject">
                                    <i class="fa-solid fa-xmark"></i>
                                    Reject
                                </button>
                            </form>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php if ($hasDonation): ?>
                        <button type="button" class="btn-action btn-locked" disabled>
                            <i class="fa-solid fa-lock"></i>
                            Hapus
                        </button>
                    <?php else: ?>
                        <form action="<?= base_url('admin/campaign/delete/' . $campaign['id']) ?>" method="post" class="js-donasiku-confirm" data-title="Hapus Campaign" data-message="Data campaign akan dihapus dan tidak dapat dikembalikan." data-confirm-text="Ya, Hapus" data-confirm-class="donasiku-btn-danger">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn-action btn-delete">
                                <i class="fa-solid fa-trash"></i>
                                Hapus
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="donasiku-confirm" id="donasikuConfirm" aria-hidden="true">
    <div class="donasiku-confirm-card">
        <div class="donasiku-confirm-icon"><i class="fa-solid fa-circle-question"></i></div>
        <h4 class="donasiku-confirm-title" data-title>Konfirmasi</h4>
        <p class="donasiku-confirm-message" data-message>Apakah Anda yakin?</p>
        <div class="donasiku-confirm-actions">
            <button type="button" class="donasiku-btn donasiku-btn-cancel" data-cancel>Batal</button>
            <button type="button" class="donasiku-btn donasiku-btn-primary" data-confirm>Ya, Lanjutkan</button>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
(function(){
    let activeForm = null;
    const modal = document.getElementById('donasikuConfirm');
    if (!modal) return;
    const title = modal.querySelector('[data-title]');
    const message = modal.querySelector('[data-message]');
    const btnConfirm = modal.querySelector('[data-confirm]');
    const btnCancel = modal.querySelector('[data-cancel]');
    document.querySelectorAll('.js-donasiku-confirm').forEach(function(form){
        form.addEventListener('submit', function(e){
            e.preventDefault();
            activeForm = form;
            title.textContent = form.dataset.title || 'Konfirmasi';
            message.textContent = form.dataset.message || 'Apakah Anda yakin ingin melanjutkan?';
            btnConfirm.textContent = form.dataset.confirmText || 'Ya, Lanjutkan';
            btnConfirm.className = 'donasiku-btn ' + (form.dataset.confirmClass || 'donasiku-btn-primary');
            modal.classList.add('show');
            modal.setAttribute('aria-hidden', 'false');
        });
    });
    function closeModal(){ modal.classList.remove('show'); modal.setAttribute('aria-hidden','true'); activeForm = null; }
    btnCancel.addEventListener('click', closeModal);
    modal.addEventListener('click', function(e){ if(e.target === modal) closeModal(); });
    document.addEventListener('keydown', function(e){ if(e.key === 'Escape' && modal.classList.contains('show')) closeModal(); });
    btnConfirm.addEventListener('click', function(){
        if (!activeForm) return;
        btnConfirm.disabled = true;
        btnConfirm.textContent = 'Memproses...';
        HTMLFormElement.prototype.submit.call(activeForm);
    });
})();
</script>
<?= $this->endSection() ?>
