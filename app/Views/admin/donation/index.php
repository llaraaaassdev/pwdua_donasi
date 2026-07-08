<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<style>
    .admin-donation-final{max-width:100%;overflow:hidden}.admin-donation-final .page-title{font-weight:950;color:#0f172a;margin:0}.admin-donation-final .page-subtitle{color:#64748b;margin:.35rem 0 0;line-height:1.6}.admin-donation-final .stat-card,.admin-donation-final .filter-card,.admin-donation-final .list-card,.admin-donation-final .privacy-card{background:#fff;border:1px solid #edf2f7;border-radius:26px;box-shadow:0 16px 42px rgba(15,23,42,.07)}.admin-donation-final .stat-card{padding:18px;display:flex;align-items:center;justify-content:space-between;gap:12px;min-height:106px}.admin-donation-final .stat-card small{display:block;color:#64748b;font-weight:900}.admin-donation-final .stat-card h3{font-weight:950;color:#0f172a;margin:8px 0 0;font-size:clamp(22px,2.2vw,30px)}.admin-donation-final .stat-icon{width:52px;height:52px;border-radius:18px;display:flex;align-items:center;justify-content:center;font-size:21px}.admin-donation-final .stat-icon.blue{background:#dbeafe;color:#2563eb}.admin-donation-final .stat-icon.green{background:#dcfce7;color:#16a34a}.admin-donation-final .stat-icon.orange{background:#ffedd5;color:#f97316}.admin-donation-final .stat-icon.red{background:#fee2e2;color:#ef4444}.admin-donation-final .privacy-card{padding:16px 18px;color:#475569;background:#f8fafc}.admin-donation-final .filter-card{padding:20px}.admin-donation-final .list-card{padding:24px}.admin-donation-final .donation-head,.admin-donation-final .donation-row{display:grid;grid-template-columns:50px minmax(150px,1fr) minmax(190px,1.35fr) minmax(155px,.95fr) 120px 54px;gap:12px;align-items:center}.admin-donation-final .donation-head{padding:0 16px 12px;color:#64748b;font-size:12px;text-transform:uppercase;letter-spacing:.08em;font-weight:950}.admin-donation-final .donation-row{padding:16px;border:1px solid #edf2f7;border-radius:22px;background:#fff;margin-bottom:12px;box-shadow:0 8px 20px rgba(15,23,42,.045)}.admin-donation-final .main-text{min-width:0}.admin-donation-final .main-text strong{display:block;color:#0f172a;font-weight:950;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}.admin-donation-final .main-text small{display:block;color:#64748b;margin-top:2px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}.admin-donation-final .donor-wrap{display:flex;align-items:center;gap:12px;min-width:0}.admin-donation-final .donor-avatar{width:42px;height:42px;border-radius:50%;background:linear-gradient(135deg,#2563eb,#4f46e5);color:#fff;display:flex;align-items:center;justify-content:center;flex:0 0 42px}.admin-donation-final .invoice-chip{display:inline-flex;max-width:100%;align-items:center;gap:7px;border-radius:999px;background:#e0f2fe;color:#0369a1;padding:8px 11px;font-weight:950;font-size:12px}.admin-donation-final .invoice-chip span{white-space:nowrap;overflow:hidden;text-overflow:ellipsis}.admin-donation-final .badge-soft{display:inline-flex;align-items:center;justify-content:center;gap:6px;padding:8px 11px;border-radius:999px;font-weight:950;font-size:12px;white-space:nowrap}.admin-donation-final .badge-soft.success{background:#dcfce7;color:#15803d}.admin-donation-final .badge-soft.warning{background:#fef3c7;color:#92400e}.admin-donation-final .badge-soft.danger{background:#fee2e2;color:#b91c1c}.admin-donation-final .badge-soft.dark{background:#e2e8f0;color:#334155}.admin-donation-final .icon-btn{width:42px;height:42px;border:0;border-radius:14px;text-decoration:none;display:inline-flex;align-items:center;justify-content:center;font-size:16px;font-weight:950;transition:.2s;background:#e0f2fe;color:#0369a1}.admin-donation-final .icon-btn:hover{transform:translateY(-2px);color:#0369a1}.admin-donation-final .empty-state{border:1px dashed #dbe3ef;border-radius:22px;background:#f8fafc;text-align:center;color:#64748b;padding:42px}@media(max-width:1180px){.admin-donation-final .donation-head{display:none}.admin-donation-final .donation-row{grid-template-columns:1fr auto;gap:12px}.admin-donation-final .donation-row>div:first-child{display:none}.admin-donation-final .donation-row .status-cell{justify-self:start}.admin-donation-final .mobile-meta{display:flex!important;gap:8px;flex-wrap:wrap;margin-top:8px}.admin-donation-final .invoice-cell,.admin-donation-final .status-cell{display:none!important}}@media(min-width:1181px){.admin-donation-final .mobile-meta{display:none!important}}@media(max-width:576px){.admin-donation-final .list-card,.admin-donation-final .filter-card{padding:18px}.admin-donation-final .donation-row{grid-template-columns:1fr}.admin-donation-final .icon-btn{width:40px;height:40px}.admin-donation-final .donor-wrap{align-items:flex-start}}
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php
$donations = $donations ?? [];
$stats = $stats ?? [];
$page = (int) (service('request')->getGet('page_donations') ?? 1);
$perPage = (int) ($perPage ?? 25);
$startNo = (($page - 1) * $perPage) + 1;

$statusMeta = function ($status, $transactionStatus = null) {
    $status = strtolower((string) $status);
    $transactionStatus = strtolower((string) $transactionStatus);
    if (in_array($status, ['berhasil', 'verified'], true) || in_array($transactionStatus, ['settlement', 'capture'], true)) return ['class'=>'success','text'=>'Berhasil','icon'=>'fa-circle-check'];
    if (in_array($status, ['ditolak', 'rejected'], true) || $transactionStatus === 'deny') return ['class'=>'danger','text'=>'Ditolak','icon'=>'fa-circle-xmark'];
    if (in_array($status, ['expired'], true) || in_array($transactionStatus, ['expire', 'expired'], true)) return ['class'=>'dark','text'=>'Expired','icon'=>'fa-clock-rotate-left'];
    if (in_array($status, ['dibatalkan', 'cancel', 'cancelled'], true) || $transactionStatus === 'cancel') return ['class'=>'dark','text'=>'Dibatalkan','icon'=>'fa-ban'];
    return ['class'=>'warning','text'=>'Pending','icon'=>'fa-clock'];
};

$maskName = function ($name, $hidden = false) {
    if ($hidden) return '********';
    $name = trim((string) $name);
    if ($name === '' || $name === '-') return '********';
    $parts = preg_split('/\s+/', $name);
    return implode(' ', array_map(function($part){ return mb_substr($part,0,1) . str_repeat('*', max(3, mb_strlen($part)-1)); }, $parts));
};

$maskEmail = function ($email) {
    $email = trim((string) $email);
    if ($email === '' || !str_contains($email, '@')) return '***@***';
    [$local, $domain] = explode('@', $email, 2);
    $domainParts = explode('.', $domain);
    $main = $domainParts[0] ?? 'mail';
    $tld = count($domainParts) > 1 ? '.' . end($domainParts) : '';
    return mb_substr($local,0,1) . str_repeat('*', max(3, mb_strlen($local)-1)) . '@' . mb_substr($main,0,1) . str_repeat('*', max(3, mb_strlen($main)-1)) . $tld;
};
?>

<div class="admin-donation-final">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="page-title">Kelola Donasi</h2>
            <p class="page-subtitle">DonasiKu Terpercaya dan Aman</p>
        </div>
    </div>

    <?php if(session()->getFlashdata('success')): ?><div class="alert alert-success rounded-4"><?= esc(session()->getFlashdata('success')) ?></div><?php endif; ?>
    <?php if(session()->getFlashdata('error')): ?><div class="alert alert-danger rounded-4"><?= esc(session()->getFlashdata('error')) ?></div><?php endif; ?>

    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6"><div class="stat-card"><div><small>Total Transaksi</small><h3><?= number_format((int)($stats['total_donasi'] ?? 0),0,',','.') ?></h3></div><div class="stat-icon blue"><i class="fa-solid fa-receipt"></i></div></div></div>
        <div class="col-xl-3 col-md-6"><div class="stat-card"><div><small>Nominal Berhasil</small><h3>Rp <?= number_format((float)($stats['nominal_berhasil'] ?? 0),0,',','.') ?></h3></div><div class="stat-icon green"><i class="fa-solid fa-hand-holding-dollar"></i></div></div></div>
        <div class="col-xl-3 col-md-6"><div class="stat-card"><div><small>Pending</small><h3><?= number_format((int)($stats['pending'] ?? 0),0,',','.') ?></h3></div><div class="stat-icon orange"><i class="fa-solid fa-clock"></i></div></div></div>
    </div>

    <div class="privacy-card mb-4"><i class="fa-solid fa-shield-halved me-2 text-primary"></i>Nama dan email donatur tidak ditampilkan terbuka. Donatur anonim tampil sebagai bintang penuh, sedangkan donatur biasa tetap dimasking sebagian.</div>

    <form method="get" class="filter-card mb-4">
        <div class="row g-3 align-items-end">
            <div class="col-lg-7"><label class="form-label fw-bold">Cari Donasi</label><input type="text" name="keyword" class="form-control" placeholder="Cari invoice, campaign, yayasan, atau transaction ID..." value="<?= esc($keyword ?? '') ?>"></div>
            <div class="col-lg-3"><label class="form-label fw-bold">Status</label><select name="status" class="form-select"><option value="">Semua</option><option value="pending" <?= ($status ?? '') === 'pending' ? 'selected' : '' ?>>Pending</option><option value="berhasil" <?= ($status ?? '') === 'berhasil' ? 'selected' : '' ?>>Berhasil</option><option value="expired" <?= ($status ?? '') === 'expired' ? 'selected' : '' ?>>Expired</option><option value="dibatalkan" <?= ($status ?? '') === 'dibatalkan' ? 'selected' : '' ?>>Dibatalkan</option><option value="ditolak" <?= ($status ?? '') === 'ditolak' ? 'selected' : '' ?>>Ditolak</option></select></div>
            <div class="col-lg-2 d-flex gap-2"><button type="submit" class="btn btn-primary flex-fill" title="Filter"><i class="fa-solid fa-magnifying-glass"></i></button><a href="<?= base_url('admin/donation') ?>" class="btn btn-light px-4" title="Reset"><i class="fa-solid fa-rotate-left"></i></a></div>
        </div>
    </form>

    <div class="list-card">
        <div class="d-flex justify-content-between align-items-center gap-3 mb-3">
            <h4 class="fw-bold mb-0">Data Donasi</h4>
            <span class="text-muted small">Tidak ada scroll horizontal</span>
        </div>
        <div class="donation-head"><div>No</div><div>Nama</div><div>Campaign</div><div>Invoice</div><div>Status</div><div>Aksi</div></div>
        <?php if(!empty($donations)): ?>
            <?php $no = $startNo; foreach($donations as $donation): ?>
                <?php
                    $hidden = (int)($donation['anonim'] ?? 0) === 1;
                    $meta = $statusMeta($donation['status'] ?? 'pending', $donation['transaction_status'] ?? null);
                    $donorName = $maskName($donation['donor_nama'] ?? '', $hidden);
                    $donorEmail = $hidden ? '***@***' : $maskEmail($donation['donor_email'] ?? '');
                ?>
                <div class="donation-row">
                    <div><?= $no++ ?></div>
                    <div class="donor-wrap">
                        <div class="donor-avatar"><i class="fa-solid <?= $hidden ? 'fa-user-secret' : 'fa-user' ?>"></i></div>
                        <div class="main-text">
                            <strong><?= esc($donorName) ?></strong>
                            <small><?= esc($donorEmail) ?></small>
                            <div class="mobile-meta"><span class="invoice-chip"><i class="fa-solid fa-receipt"></i><span><?= esc($donation['invoice'] ?? '-') ?></span></span><span class="badge-soft <?= $meta['class'] ?>"><i class="fa-solid <?= $meta['icon'] ?>"></i> <?= esc($meta['text']) ?></span></div>
                        </div>
                    </div>
                    <div class="main-text"><strong><?= esc($donation['judul'] ?? '-') ?></strong><small><?= esc($donation['nama_yayasan'] ?? '-') ?></small></div>
                    <div class="invoice-cell"><span class="invoice-chip"><i class="fa-solid fa-receipt"></i><span><?= esc($donation['invoice'] ?? '-') ?></span></span></div>
                    <div class="status-cell"><span class="badge-soft <?= $meta['class'] ?>"><i class="fa-solid <?= $meta['icon'] ?>"></i> <?= esc($meta['text']) ?></span></div>
                    <div><a href="<?= base_url('admin/donation/detail/'.$donation['id']) ?>" class="icon-btn" title="Detail" aria-label="Detail"><i class="fa-solid fa-eye"></i></a></div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="empty-state"><i class="fa-solid fa-receipt fa-2x mb-3"></i><h5 class="fw-bold">Belum ada data donasi</h5><p class="mb-0">Transaksi Midtrans akan tampil otomatis di sini.</p></div>
        <?php endif; ?>
        <?php if(isset($pager)): ?><div class="mt-3"><?= $pager->links('donations', 'default_full') ?></div><?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>
