<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<style>
    .foundation-dashboard{max-width:100%;overflow:hidden}.fd-hero,.fd-stat,.fd-panel{background:#fff;border:1px solid #edf2f7;border-radius:28px;box-shadow:0 18px 46px rgba(15,23,42,.07)}.fd-hero{padding:26px 28px;position:relative;overflow:hidden}.fd-hero:after{content:"";position:absolute;right:-80px;top:-90px;width:260px;height:260px;border-radius:50%;background:linear-gradient(135deg,rgba(37,99,235,.17),rgba(79,70,229,.14));pointer-events:none}.fd-badge{display:inline-flex;align-items:center;gap:8px;padding:9px 14px;border-radius:999px;background:#eff6ff;color:#2563eb;font-weight:900;font-size:13px}.fd-title{font-weight:950;color:#0f172a;margin:12px 0 0}.fd-subtitle{color:#64748b;margin:.45rem 0 0;line-height:1.7}.fd-stat{padding:22px;display:flex;align-items:center;justify-content:space-between;gap:16px;min-height:132px}.fd-stat small{display:block;color:#64748b;font-weight:900;margin-bottom:8px}.fd-stat h2{font-weight:950;color:#0f172a;margin:0;font-size:clamp(24px,2.4vw,34px);line-height:1.15}.fd-stat p{margin:8px 0 0;color:#64748b;font-size:14px}.fd-icon{width:60px;height:60px;border-radius:22px;display:flex;align-items:center;justify-content:center;font-size:24px;flex:0 0 60px}.fd-icon.blue{background:#dbeafe;color:#2563eb}.fd-icon.green{background:#dcfce7;color:#16a34a}.fd-icon.orange{background:#ffedd5;color:#f97316}.fd-icon.purple{background:#ede9fe;color:#7c3aed}.fd-panel{padding:26px;height:100%}.fd-panel-title{font-weight:950;color:#0f172a;margin:0}.fd-soft-btn{border:0;text-decoration:none;border-radius:16px;padding:10px 14px;background:#f8fafc;color:#0f172a;font-weight:900;display:inline-flex;align-items:center;gap:8px}.fd-soft-btn:hover{background:#eff6ff;color:#2563eb}.fd-list{display:flex;flex-direction:column;gap:12px}.fd-item{display:flex;align-items:center;justify-content:space-between;gap:14px;padding:15px;border:1px solid #edf2f7;border-radius:18px;background:#f8fafc}.fd-main{min-width:0}.fd-main strong{display:block;color:#0f172a;font-weight:900;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}.fd-main small{display:block;color:#64748b;margin-top:3px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}.fd-badge-soft{display:inline-flex;align-items:center;gap:6px;padding:7px 11px;border-radius:999px;font-size:12px;font-weight:950;white-space:nowrap}.fd-badge-soft.success{background:#dcfce7;color:#15803d}.fd-badge-soft.warning{background:#fef3c7;color:#92400e}.fd-badge-soft.danger{background:#fee2e2;color:#b91c1c}.fd-badge-soft.dark{background:#e2e8f0;color:#334155}.fd-progress{height:10px;background:#eaf0f6;border-radius:999px;overflow:hidden}.fd-progress span{height:100%;display:block;border-radius:999px;background:linear-gradient(135deg,#2563eb,#4f46e5)}.fd-quick{display:grid;gap:12px}.fd-quick a{text-decoration:none;border:1px solid #edf2f7;border-radius:20px;padding:17px 18px;background:#f8fafc;color:#0f172a;font-weight:950;display:flex;align-items:center;justify-content:space-between;gap:14px;transition:.2s}.fd-quick a:hover{transform:translateY(-2px);background:#eff6ff;color:#2563eb}.fd-quick i:first-child{width:40px;height:40px;border-radius:14px;display:inline-flex;align-items:center;justify-content:center;background:#fff;color:#2563eb;margin-right:10px}.fd-empty{border:1px dashed #dbe3ef;border-radius:20px;background:#f8fafc;padding:32px;text-align:center;color:#64748b}.fd-alert{border:0;border-radius:22px;padding:16px 18px;background:#fff7ed;color:#9a3412;font-weight:700}@media(max-width:576px){.fd-hero,.fd-panel{padding:20px}.fd-item{align-items:flex-start;flex-direction:column}}
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php
    $currency = fn($value) => 'Rp ' . number_format((float) $value, 0, ',', '.');
    $statusMeta = function ($status, $verification = null) {
        $status = strtolower((string) $status);
        $verification = strtolower((string) $verification);
        if ($verification === 'approved' && $status === 'aktif') return ['class'=>'success','text'=>'Aktif','icon'=>'fa-circle-check'];
        if ($verification === 'approved') return ['class'=>'success','text'=>'Disetujui','icon'=>'fa-shield-check'];
        if ($verification === 'rejected') return ['class'=>'danger','text'=>'Ditolak','icon'=>'fa-circle-xmark'];
        return ['class'=>'warning','text'=>'Menunggu','icon'=>'fa-clock'];
    };
    $donationStatus = function ($status, $transactionStatus = null) {
        $status = strtolower((string) $status);
        $transactionStatus = strtolower((string) $transactionStatus);
        if (in_array($status, ['berhasil','verified','paid','success'], true) || in_array($transactionStatus, ['settlement','capture'], true)) return ['class'=>'success','text'=>'Berhasil','icon'=>'fa-circle-check'];
        if (in_array($status, ['expired'], true) || in_array($transactionStatus, ['expire','expired'], true)) return ['class'=>'dark','text'=>'Expired','icon'=>'fa-clock-rotate-left'];
        if (in_array($status, ['dibatalkan','cancel','cancelled'], true) || $transactionStatus === 'cancel') return ['class'=>'dark','text'=>'Batal','icon'=>'fa-ban'];
        return ['class'=>'warning','text'=>'Pending','icon'=>'fa-clock'];
    };
    $maskName = function ($name, $anonim = false) {
        $name = trim((string) $name);
        if ($anonim || $name === '' || $name === '-') return '********';
        $parts = preg_split('/\s+/', $name);
        return implode(' ', array_map(fn($p) => mb_substr($p,0,1) . str_repeat('*', max(3, mb_strlen($p)-1)), $parts));
    };
?>
<div class="foundation-dashboard">
    <div class="fd-hero mb-4">
        <div class="row align-items-center g-3 position-relative">
            <div class="col-lg-8">
                <span class="fd-badge"><i class="fa-solid fa-building-user"></i> Dashboard Yayasan</span>
                <h2 class="fd-title">Halo, <?= esc($foundation['nama_yayasan'] ?? session()->get('nama') ?? 'Yayasan') ?></h2>
                <p class="fd-subtitle">Pantau campaign, donasi masuk, dan laporan penggunaan dana sesuai alur verifikasi sistem.</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="<?= base_url('yayasan/campaign/create') ?>" class="btn btn-primary px-4 py-3 rounded-4 fw-bold"><i class="fa-solid fa-circle-plus me-2"></i> Ajukan Campaign</a>
            </div>
        </div>
    </div>

    <?php if (!empty($pendingProfileChange)): ?>
        <div class="fd-alert mb-4"><i class="fa-solid fa-clock-rotate-left me-2"></i> Perubahan profil yayasan sedang menunggu verifikasi admin.</div>
    <?php endif; ?>

    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6"><div class="fd-stat"><div><small>Dana Berhasil</small><h2><?= $currency($totalDana ?? 0) ?></h2><p>Dari transaksi Midtrans berhasil</p></div><div class="fd-icon blue"><i class="fa-solid fa-wallet"></i></div></div></div>
        <div class="col-xl-3 col-md-6"><div class="fd-stat"><div><small>Campaign Aktif</small><h2><?= number_format((int) ($campaignAktif ?? 0), 0, ',', '.') ?></h2><p><?= number_format((int) ($campaignPending ?? 0), 0, ',', '.') ?> menunggu verifikasi</p></div><div class="fd-icon green"><i class="fa-solid fa-bullhorn"></i></div></div></div>
        <div class="col-xl-3 col-md-6"><div class="fd-stat"><div><small>Total Donatur</small><h2><?= number_format((int) ($totalDonatur ?? 0), 0, ',', '.') ?></h2><p>Donatur unik berhasil</p></div><div class="fd-icon orange"><i class="fa-solid fa-users"></i></div></div></div>
        <div class="col-xl-3 col-md-6"><div class="fd-stat"><div><small>Laporan Pending</small><h2><?= number_format((int) ($reportPending ?? 0), 0, ',', '.') ?></h2><p>Menunggu verifikasi admin</p></div><div class="fd-icon purple"><i class="fa-solid fa-file-invoice-dollar"></i></div></div></div>
    </div>

    <div class="row g-4">
        <div class="col-xl-7">
            <div class="fd-panel mb-4">
                <div class="d-flex justify-content-between align-items-center gap-3 mb-3">
                    <h4 class="fd-panel-title">Donasi Terbaru</h4>
                    <a href="<?= base_url('yayasan/donation/index') ?>" class="fd-soft-btn" title="Lihat semua"><i class="fa-solid fa-arrow-right"></i></a>
                </div>
                <?php if (empty($recentDonation)): ?>
                    <div class="fd-empty"><i class="fa-solid fa-receipt fa-2x mb-3"></i><p class="mb-0 fw-bold">Belum ada donasi berhasil.</p></div>
                <?php else: ?>
                    <div class="fd-list">
                        <?php foreach ($recentDonation as $donation): ?>
                            <?php $meta = $donationStatus($donation['status'] ?? 'pending', $donation['transaction_status'] ?? null); ?>
                            <div class="fd-item">
                                <div class="fd-main">
                                    <strong><?= esc($maskName($donation['donor_nama'] ?? $donation['nama'] ?? '', !empty($donation['anonim']))) ?></strong>
                                    <small><?= esc($donation['judul'] ?? '-') ?> • <?= $currency($donation['nominal'] ?? 0) ?></small>
                                </div>
                                <span class="fd-badge-soft <?= $meta['class'] ?>"><i class="fa-solid <?= $meta['icon'] ?>"></i> <?= esc($meta['text']) ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="fd-panel">
                <div class="d-flex justify-content-between align-items-center gap-3 mb-3">
                    <h4 class="fd-panel-title">Progress Campaign</h4>
                    <a href="<?= base_url('yayasan/campaign/index') ?>" class="fd-soft-btn" title="Kelola campaign"><i class="fa-solid fa-arrow-right"></i></a>
                </div>
                <?php if (empty($campaignProgress)): ?>
                    <div class="fd-empty"><p class="mb-0 fw-bold">Belum ada campaign.</p></div>
                <?php else: ?>
                    <div class="fd-list">
                        <?php foreach ($campaignProgress as $campaign): ?>
                            <?php $percent = (float) ($campaign['target_dana'] ?? 0) > 0 ? min(100, ((float) ($campaign['dana_terkumpul'] ?? 0) / (float) $campaign['target_dana']) * 100) : 0; ?>
                            <?php $meta = $statusMeta($campaign['status'] ?? 'draft', $campaign['status_verifikasi'] ?? 'pending'); ?>
                            <div class="fd-item align-items-start">
                                <div class="fd-main w-100">
                                    <strong><?= esc($campaign['judul'] ?? '-') ?></strong>
                                    <small><?= $currency($campaign['dana_terkumpul'] ?? 0) ?> dari <?= $currency($campaign['target_dana'] ?? 0) ?></small>
                                    <div class="fd-progress mt-2"><span style="width:<?= $percent ?>%"></span></div>
                                </div>
                                <span class="fd-badge-soft <?= $meta['class'] ?>"><i class="fa-solid <?= $meta['icon'] ?>"></i> <?= esc($meta['text']) ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="col-xl-5">
            <div class="fd-panel mb-4">
                <h4 class="fd-panel-title mb-3">Aksi Cepat</h4>
                <div class="fd-quick">
                    <a href="<?= base_url('yayasan/campaign/create') ?>"><span><i class="fa-solid fa-circle-plus"></i> Pengajuan Campaign</span><i class="fa-solid fa-chevron-right"></i></a>
                    <a href="<?= base_url('yayasan/donation/index') ?>"><span><i class="fa-solid fa-money-bill-wave"></i> Donasi Masuk</span><i class="fa-solid fa-chevron-right"></i></a>
                    <a href="<?= base_url('yayasan/report/create') ?>"><span><i class="fa-solid fa-file-circle-plus"></i> Buat Laporan Dana</span><i class="fa-solid fa-chevron-right"></i></a>
                    <a href="<?= base_url('yayasan/profile') ?>"><span><i class="fa-solid fa-user-pen"></i> Profil Yayasan</span><i class="fa-solid fa-chevron-right"></i></a>
                </div>
            </div>

            <div class="fd-panel">
                <h4 class="fd-panel-title mb-3">Laporan Terbaru</h4>
                <?php if (empty($recentReports)): ?>
                    <div class="fd-empty"><p class="mb-0 fw-bold">Belum ada laporan penggunaan dana.</p></div>
                <?php else: ?>
                    <div class="fd-list">
                        <?php foreach ($recentReports as $report): ?>
                            <?php $m = $statusMeta('draft', $report['status_verifikasi'] ?? 'pending'); ?>
                            <div class="fd-item">
                                <div class="fd-main">
                                    <strong><?= esc($report['judul_laporan'] ?? '-') ?></strong>
                                    <small><?= esc($report['campaign_judul'] ?? '-') ?> • <?= $currency($report['total_pengeluaran'] ?? 0) ?></small>
                                </div>
                                <span class="fd-badge-soft <?= $m['class'] ?>"><?= esc($m['text']) ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
