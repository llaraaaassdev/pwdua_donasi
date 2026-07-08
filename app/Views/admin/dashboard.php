<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<style>
    .admin-dashboard-final{max-width:100%;overflow:hidden}.admin-dashboard-final .page-title{font-weight:950;color:#0f172a;margin:0}.admin-dashboard-final .page-subtitle{color:#64748b;margin:.35rem 0 0;line-height:1.7}.admin-dashboard-final .hero-card,.admin-dashboard-final .stat-card,.admin-dashboard-final .panel-card{background:#fff;border:1px solid #edf2f7;border-radius:28px;box-shadow:0 18px 46px rgba(15,23,42,.07)}.admin-dashboard-final .hero-card{padding:26px 28px;position:relative;overflow:hidden}.admin-dashboard-final .hero-card:after{content:"";position:absolute;right:-90px;top:-110px;width:260px;height:260px;border-radius:50%;background:linear-gradient(135deg,rgba(37,99,235,.18),rgba(79,70,229,.14));pointer-events:none}.admin-dashboard-final .hero-badge{display:inline-flex;align-items:center;gap:8px;padding:9px 14px;border-radius:999px;background:#eff6ff;color:#2563eb;font-weight:900;font-size:13px}.admin-dashboard-final .stat-card{padding:22px;min-height:134px;display:flex;align-items:center;justify-content:space-between;gap:14px;transition:.2s}.admin-dashboard-final .stat-card:hover{transform:translateY(-3px)}.admin-dashboard-final .stat-card small{display:block;color:#64748b;font-weight:900;margin-bottom:8px}.admin-dashboard-final .stat-card h2{font-weight:950;color:#0f172a;margin:0;font-size:clamp(26px,3vw,36px);line-height:1.12}.admin-dashboard-final .stat-card p{margin:8px 0 0;color:#64748b;font-size:14px;line-height:1.45}.admin-dashboard-final .stat-icon{width:62px;height:62px;border-radius:22px;display:flex;align-items:center;justify-content:center;font-size:24px;flex:0 0 62px}.admin-dashboard-final .stat-icon.blue{background:#dbeafe;color:#2563eb}.admin-dashboard-final .stat-icon.green{background:#dcfce7;color:#16a34a}.admin-dashboard-final .stat-icon.orange{background:#ffedd5;color:#f97316}.admin-dashboard-final .stat-icon.purple{background:#ede9fe;color:#7c3aed}.admin-dashboard-final .panel-card{padding:26px;height:100%}.admin-dashboard-final .section-title{font-weight:950;color:#0f172a;margin:0}.admin-dashboard-final .soft-btn{border:0;text-decoration:none;border-radius:16px;padding:10px 14px;background:#f8fafc;color:#0f172a;font-weight:900;display:inline-flex;align-items:center;gap:8px}.admin-dashboard-final .soft-btn:hover{background:#eff6ff;color:#2563eb}.admin-dashboard-final .list-stack{display:flex;flex-direction:column;gap:12px}.admin-dashboard-final .list-item{display:flex;align-items:center;justify-content:space-between;gap:12px;padding:15px;border:1px solid #edf2f7;border-radius:18px;background:#f8fafc}.admin-dashboard-final .item-main{min-width:0}.admin-dashboard-final .item-main strong{display:block;color:#0f172a;font-weight:900;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}.admin-dashboard-final .item-main small{display:block;color:#64748b;margin-top:3px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}.admin-dashboard-final .badge-soft{display:inline-flex;align-items:center;gap:6px;padding:7px 11px;border-radius:999px;font-size:12px;font-weight:950;white-space:nowrap}.admin-dashboard-final .badge-soft.success{background:#dcfce7;color:#15803d}.admin-dashboard-final .badge-soft.warning{background:#fef3c7;color:#92400e}.admin-dashboard-final .badge-soft.danger{background:#fee2e2;color:#b91c1c}.admin-dashboard-final .badge-soft.dark{background:#e2e8f0;color:#334155}.admin-dashboard-final .quick-grid{display:grid;gap:12px}.admin-dashboard-final .quick-link{text-decoration:none;border:1px solid #edf2f7;border-radius:20px;padding:17px 18px;background:#f8fafc;color:#0f172a;font-weight:950;display:flex;align-items:center;justify-content:space-between;gap:14px;transition:.2s}.admin-dashboard-final .quick-link:hover{transform:translateY(-2px);background:#eff6ff;color:#2563eb}.admin-dashboard-final .quick-link i:first-child{width:40px;height:40px;border-radius:14px;display:inline-flex;align-items:center;justify-content:center;background:#fff;color:#2563eb;margin-right:10px}.admin-dashboard-final .empty-state{border:1px dashed #dbe3ef;border-radius:20px;background:#f8fafc;padding:34px;text-align:center;color:#64748b}@media(max-width:576px){.admin-dashboard-final .hero-card,.admin-dashboard-final .panel-card{padding:20px}.admin-dashboard-final .list-item{align-items:flex-start;flex-direction:column}.admin-dashboard-final .stat-card{min-height:auto}}
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php
    $statusMeta = function ($status, $transactionStatus = null) {
        $status = strtolower((string) $status);
        $transactionStatus = strtolower((string) $transactionStatus);
        if (in_array($status, ['berhasil', 'verified'], true) || in_array($transactionStatus, ['settlement', 'capture'], true)) return ['class' => 'success', 'text' => 'Berhasil', 'icon' => 'fa-circle-check'];
        if (in_array($status, ['ditolak', 'rejected'], true) || $transactionStatus === 'deny') return ['class' => 'danger', 'text' => 'Ditolak', 'icon' => 'fa-circle-xmark'];
        if (in_array($status, ['expired'], true) || in_array($transactionStatus, ['expire', 'expired'], true)) return ['class' => 'dark', 'text' => 'Expired', 'icon' => 'fa-clock-rotate-left'];
        if (in_array($status, ['dibatalkan', 'cancel', 'cancelled'], true) || $transactionStatus === 'cancel') return ['class' => 'dark', 'text' => 'Dibatalkan', 'icon' => 'fa-ban'];
        return ['class' => 'warning', 'text' => 'Pending', 'icon' => 'fa-clock'];
    };

    $maskName = function ($name) {
        $name = trim((string) $name);
        if ($name === '' || $name === '-') return '********';
        $parts = preg_split('/\s+/', $name);
        $masked = array_map(function ($part) {
            $first = mb_substr($part, 0, 1);
            $len = max(3, mb_strlen($part) - 1);
            return $first . str_repeat('*', $len);
        }, $parts);
        return implode(' ', $masked);
    };
?>

<div class="admin-dashboard-final">
    <div class="hero-card mb-4">
        <div class="row align-items-center g-3 position-relative">
            <div class="col-lg-8">
                <span class="hero-badge"><i class="fa-solid fa-shield-heart"></i> Admin Control Center</span>
                <h2 class="page-title mt-3">Ringkasan Dashboard</h2>
                <p class="page-subtitle">Pantau yayasan, campaign, kategori, user, dan transaksi Midtrans dalam tampilan yang rapi tanpa tabel melebar.</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="<?= base_url('admin/donation') ?>" class="btn btn-primary px-4 py-3 rounded-4 fw-bold"><i class="fa-solid fa-receipt me-2"></i> Lihat Donasi</a>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6"><div class="stat-card"><div><small>Total User</small><h2><?= number_format((int) ($totalUser ?? 0), 0, ',', '.') ?></h2><p><?= number_format((int) ($totalDonatur ?? 0), 0, ',', '.') ?> user donatur</p></div><div class="stat-icon blue"><i class="fa-solid fa-users"></i></div></div></div>
        <div class="col-xl-3 col-md-6"><div class="stat-card"><div><small>Total Yayasan</small><h2><?= number_format((int) ($totalFoundation ?? 0), 0, ',', '.') ?></h2><p><?= number_format((int) ($waitingFoundation ?? 0), 0, ',', '.') ?> menunggu verifikasi</p></div><div class="stat-icon green"><i class="fa-solid fa-building-user"></i></div></div></div>
        <div class="col-xl-3 col-md-6"><div class="stat-card"><div><small>Total Campaign</small><h2><?= number_format((int) ($totalCampaign ?? 0), 0, ',', '.') ?></h2><p><?= number_format((int) ($activeCampaign ?? 0), 0, ',', '.') ?> aktif, <?= number_format((int) ($pendingCampaign ?? 0), 0, ',', '.') ?> pending</p></div><div class="stat-icon orange"><i class="fa-solid fa-bullhorn"></i></div></div></div>
        <div class="col-xl-3 col-md-6"><div class="stat-card"><div><small>Donasi Berhasil</small><h2>Rp <?= number_format((float) ($totalDonation ?? 0), 0, ',', '.') ?></h2><p><?= number_format((int) ($successDonationTransaction ?? 0), 0, ',', '.') ?> transaksi berhasil</p></div><div class="stat-icon purple"><i class="fa-solid fa-hand-holding-dollar"></i></div></div></div>
    </div>

    <div class="row g-4">
        <div class="col-xl-7">
            <div class="panel-card">
                <div class="d-flex justify-content-between align-items-center gap-3 mb-3">
                    <h4 class="section-title">Donasi Terbaru</h4>
                    <a href="<?= base_url('admin/donation') ?>" class="soft-btn" title="Lihat semua donasi"><i class="fa-solid fa-arrow-right"></i></a>
                </div>
                <?php if (empty($latestDonations)): ?>
                    <div class="empty-state"><i class="fa-solid fa-receipt fa-2x mb-3"></i><p class="mb-0 fw-bold">Belum ada transaksi donasi.</p></div>
                <?php else: ?>
                    <div class="list-stack">
                        <?php foreach ($latestDonations as $donation): ?>
                            <?php $meta = $statusMeta($donation['status'] ?? 'pending', $donation['transaction_status'] ?? null); ?>
                            <div class="list-item">
                                <div class="item-main">
                                    <strong><?= esc($maskName($donation['donor_nama'] ?? $donation['nama'] ?? '')) ?></strong>
                                    <small><?= esc($donation['judul'] ?? '-') ?> • Invoice <?= esc($donation['invoice'] ?? '-') ?></small>
                                </div>
                                <span class="badge-soft <?= $meta['class'] ?>"><i class="fa-solid <?= $meta['icon'] ?>"></i> <?= esc($meta['text']) ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="col-xl-5">
            <div class="panel-card mb-4">
                <h4 class="section-title mb-3">Aksi Cepat</h4>
                <div class="quick-grid">
                    <a class="quick-link" href="<?= base_url('admin/yayasan') ?>"><span><i class="fa-solid fa-building-user"></i> Kelola Yayasan</span><i class="fa-solid fa-chevron-right"></i></a>
                    <a class="quick-link" href="<?= base_url('admin/campaign') ?>"><span><i class="fa-solid fa-bullhorn"></i> Kelola Campaign</span><i class="fa-solid fa-chevron-right"></i></a>
                    <a class="quick-link" href="<?= base_url('admin/category') ?>"><span><i class="fa-solid fa-tags"></i> Kategori Donasi</span><i class="fa-solid fa-chevron-right"></i></a>
                    <a class="quick-link" href="<?= base_url('admin/users') ?>"><span><i class="fa-solid fa-users"></i> Kelola User</span><i class="fa-solid fa-chevron-right"></i></a>
                </div>
            </div>

            <div class="panel-card">
                <h4 class="section-title mb-3">Campaign Terbaru</h4>
                <?php if (empty($latestCampaign)): ?>
                    <div class="empty-state"><p class="mb-0 fw-bold">Belum ada campaign.</p></div>
                <?php else: ?>
                    <div class="list-stack">
                        <?php foreach ($latestCampaign as $campaign): ?>
                            <?php $approved = ($campaign['status_verifikasi'] ?? '') === 'approved'; ?>
                            <div class="list-item">
                                <div class="item-main">
                                    <strong><?= esc($campaign['judul'] ?? '-') ?></strong>
                                    <small>Target Rp <?= number_format((float) ($campaign['target_dana'] ?? 0), 0, ',', '.') ?></small>
                                </div>
                                <span class="badge-soft <?= $approved ? 'success' : 'warning' ?>"><?= $approved ? 'Disetujui' : 'Pending' ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
