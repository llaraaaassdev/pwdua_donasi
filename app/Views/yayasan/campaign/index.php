<?= $this->extend('yayasan/layouts/main') ?>

<?= $this->section('content') ?>

<link rel="stylesheet" href="<?= base_url('assets/css/yayasan_campaign.css') ?>">

<div class="campaign-page">

    <div class="page-header mb-4">
        <div>
            <h2 class="page-title">Kampanye Saya</h2>
            <p class="page-subtitle">Kelola seluruh campaign donasi yayasan.</p>
        </div>
    </div>

    <div class="row g-4 mb-4">

        <div class="col-lg-3">
            <div class="stat-card">
                <small>Total Campaign</small>
                <h2><?= count($campaigns) ?></h2>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="stat-card success">
                <small>Campaign Aktif</small>
                <h2>
                    <?= count(array_filter($campaigns, function ($c) {
                        return ($c['status_verifikasi'] ?? '') === 'approved'
                            && ($c['status'] ?? '') === 'aktif';
                    })) ?>
                </h2>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="stat-card warning">
                <small>Total Dana</small>
                <h2>
                    Rp <?= number_format(array_sum(array_column($campaigns, 'dana_terkumpul')), 0, ',', '.') ?>
                </h2>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="stat-card danger">
                <small>Target Dana</small>
                <h2>
                    Rp <?= number_format(array_sum(array_column($campaigns, 'target_dana')), 0, ',', '.') ?>
                </h2>
            </div>
        </div>

    </div>

    <div class="toolbar">
        <input
            type="text"
            id="searchCampaign"
            class="form-control"
            placeholder="Cari Campaign...">
    </div>

    <div class="row mt-4">

        <?php if (empty($campaigns)): ?>

            <div class="col-12">
                <div class="empty-state">
                    <i class="fa-solid fa-box-open"></i>
                    <h4>Belum ada campaign</h4>
                    <p>Mulai buat campaign pertamamu.</p>
                </div>
            </div>

        <?php endif; ?>

        <?php foreach ($campaigns as $campaign): ?>

            <?php
                $targetDana = (float) ($campaign['target_dana'] ?? 0);
                $danaTerkumpul = (float) ($campaign['dana_terkumpul'] ?? 0);

                $persen = 0;

                if ($targetDana > 0) {
                    $persen = ($danaTerkumpul / $targetDana) * 100;
                }

                $statusVerifikasi = $campaign['status_verifikasi'] ?? 'pending';
                $statusCampaign = $campaign['status'] ?? 'aktif';

                $badgeClass = 'secondary';
                $badgeText  = 'Menunggu Verifikasi';
                $statusInfo = 'Campaign sedang menunggu persetujuan Admin.';

                if ($statusVerifikasi === 'approved') {
                    if ($statusCampaign === 'aktif') {
                        $badgeClass = 'success';
                        $badgeText  = 'Aktif';
                        $statusInfo = 'Campaign sedang menerima donasi.';
                    } else {
                        $badgeClass = 'dark';
                        $badgeText  = 'Nonaktif';
                        $statusInfo = 'Campaign tidak sedang aktif.';
                    }
                } elseif ($statusVerifikasi === 'rejected') {
                    $badgeClass = 'danger';
                    $badgeText  = 'Ditolak';
                    $statusInfo = 'Campaign ditolak oleh Admin.';
                }

                $bolehHapus = $statusVerifikasi !== 'approved';

                $gambar = !empty($campaign['gambar'])
                    ? base_url('uploads/campaign/' . $campaign['gambar'])
                    : base_url('assets/img/default-campaign.jpg');
            ?>

            <div class="col-lg-4 campaign-item mb-4">

                <div class="campaign-card">

                    <img
                        src="<?= $gambar ?>"
                        class="campaign-image"
                        alt="<?= esc($campaign['judul']) ?>">

                    <div class="campaign-body">

                        <span class="badge bg-<?= $badgeClass ?>">
                            <?= $badgeText ?>
                        </span>

                        <small class="d-block mt-2 text-muted">
                            <?= $statusInfo ?>
                        </small>

                        <h4>
                            <?= esc($campaign['judul']) ?>
                        </h4>

                        <div class="progress mt-3">
                            <div
                                class="progress-bar"
                                style="width:<?= min($persen, 100) ?>%">
                            </div>
                        </div>

                        <div class="campaign-money mt-3">

                            <strong>
                                Rp <?= number_format($danaTerkumpul, 0, ',', '.') ?>
                            </strong>

                            <small>
                                dari Rp <?= number_format($targetDana, 0, ',', '.') ?>
                            </small>

                        </div>

                        <div class="campaign-action mt-4">

                            <a
                                href="<?= base_url('yayasan/campaign/detail/' . $campaign['id']) ?>"
                                class="btn btn-light">
                                Detail
                            </a>

                            <a
                                href="<?= base_url('yayasan/campaign/edit/' . $campaign['id']) ?>"
                                class="btn btn-warning">
                                Edit
                            </a>

                            <?php if ($bolehHapus): ?>

                                <a
                                    href="<?= base_url('yayasan/campaign/delete/' . $campaign['id']) ?>"
                                    class="btn btn-danger btn-delete">
                                    Hapus
                                </a>

                            <?php else: ?>

                                <button
                                    type="button"
                                    class="btn btn-secondary"
                                    disabled
                                    title="Campaign yang sudah disetujui tidak dapat dihapus.">
                                    Hapus
                                </button>

                            <?php endif; ?>

                        </div>

                    </div>

                </div>

            </div>

        <?php endforeach; ?>

    </div>

</div>

<style>
.campaign-popup-overlay {
    position: fixed;
    inset: 0;
    background: rgba(15, 23, 42, 0.45);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 99999;
}

.campaign-popup-box {
    width: 360px;
    max-width: 90%;
    background: #fff;
    border-radius: 22px;
    padding: 28px;
    text-align: center;
    box-shadow: 0 20px 60px rgba(0,0,0,.18);
}

.campaign-popup-icon {
    width: 64px;
    height: 64px;
    margin: 0 auto 16px;
    border-radius: 50%;
    color: #fff;
    font-size: 34px;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
}

.campaign-popup-icon.success {
    background: #22c55e;
}

.campaign-popup-icon.error {
    background: #ef4444;
}

.campaign-popup-box h4 {
    margin-bottom: 8px;
    font-weight: 700;
}

.campaign-popup-box p {
    color: #64748b;
    margin-bottom: 20px;
}

.campaign-popup-box button {
    border: none;
    background: #2563eb;
    color: white;
    padding: 10px 28px;
    border-radius: 12px;
    font-weight: 600;
}
</style>

<script>
function showCampaignPopup(type, message) {
    const oldPopup = document.querySelector('.campaign-popup-overlay');

    if (oldPopup) {
        oldPopup.remove();
    }

    const overlay = document.createElement('div');
    overlay.className = 'campaign-popup-overlay';

    overlay.innerHTML = `
        <div class="campaign-popup-box">
            <div class="campaign-popup-icon ${type}">
                ${type === 'success' ? '✓' : '!' }
            </div>
            <h4>${type === 'success' ? 'Berhasil' : 'Gagal'}</h4>
            <p>${message}</p>
            <button type="button" onclick="this.closest('.campaign-popup-overlay').remove()">
                Oke
            </button>
        </div>
    `;

    document.body.appendChild(overlay);
}
</script>

<?php if (session()->getFlashdata('success')): ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    showCampaignPopup('success', '<?= esc(session()->getFlashdata('success')) ?>');
});
</script>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    showCampaignPopup('error', '<?= esc(session()->getFlashdata('error')) ?>');
});
</script>
<?php endif; ?>

<script src="<?= base_url('assets/js/yayasan_campaign.js') ?>"></script>

<?= $this->endSection() ?>