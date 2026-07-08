<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<style>
    .yd-page{max-width:100%;overflow:hidden}.yd-hero,.yd-panel,.yd-stat{background:#fff;border:1px solid #edf2f7;border-radius:28px;box-shadow:0 18px 46px rgba(15,23,42,.07)}.yd-hero{padding:26px 28px}.yd-title{font-weight:950;color:#0f172a;margin:0}.yd-subtitle{color:#64748b;margin:.35rem 0 0;line-height:1.7}.yd-stat{padding:20px;display:flex;align-items:center;justify-content:space-between;gap:12px}.yd-stat small{display:block;color:#64748b;font-weight:900}.yd-stat h3{font-weight:950;margin:6px 0 0;color:#0f172a}.yd-icon{width:52px;height:52px;border-radius:18px;display:flex;align-items:center;justify-content:center;font-size:21px}.yd-icon.blue{background:#dbeafe;color:#2563eb}.yd-icon.green{background:#dcfce7;color:#16a34a}.yd-icon.orange{background:#ffedd5;color:#f97316}.yd-panel{padding:26px}.yd-filter{display:grid;grid-template-columns:1fr 220px 180px;gap:14px}.yd-filter .form-control,.yd-filter .form-select{border-radius:18px;border:1px solid #e5edf6;min-height:52px}.yd-table{width:100%;border-collapse:separate;border-spacing:0 12px;table-layout:fixed}.yd-table th{font-size:12px;color:#64748b;text-transform:uppercase;letter-spacing:.06em;padding:0 14px 8px}.yd-table td{background:#fff;border-top:1px solid #edf2f7;border-bottom:1px solid #edf2f7;padding:16px 14px;vertical-align:middle}.yd-table td:first-child{border-left:1px solid #edf2f7;border-radius:18px 0 0 18px}.yd-table td:last-child{border-right:1px solid #edf2f7;border-radius:0 18px 18px 0}.yd-main{min-width:0}.yd-main strong{display:block;font-weight:950;color:#0f172a;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}.yd-main small{display:block;color:#64748b;margin-top:4px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}.yd-badge{display:inline-flex;align-items:center;gap:6px;padding:8px 11px;border-radius:999px;font-size:12px;font-weight:950;white-space:nowrap}.yd-badge.success{background:#dcfce7;color:#15803d}.yd-badge.warning{background:#fef3c7;color:#92400e}.yd-badge.danger{background:#fee2e2;color:#b91c1c}.yd-badge.dark{background:#e2e8f0;color:#334155}.yd-btn-icon{width:42px;height:42px;border-radius:14px;display:inline-flex;align-items:center;justify-content:center;text-decoration:none;border:0;background:#e0f2fe;color:#0369a1;font-size:17px}.yd-empty{text-align:center;border:1px dashed #dbe3ef;border-radius:22px;background:#f8fafc;padding:36px;color:#64748b}@media(max-width:992px){.yd-filter{grid-template-columns:1fr}.yd-table thead{display:none}.yd-table,.yd-table tbody,.yd-table tr,.yd-table td{display:block;width:100%}.yd-table tr{background:#fff;border:1px solid #edf2f7;border-radius:22px;margin-bottom:14px;padding:14px}.yd-table td{border:0!important;border-radius:0!important;padding:8px 0}.yd-table td:before{content:attr(data-label);display:block;font-size:11px;font-weight:900;color:#64748b;text-transform:uppercase;margin-bottom:4px}}
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php
    $currency = fn($value) => 'Rp ' . number_format((float) $value, 0, ',', '.');
    $maskName = function ($name, $anonim = false) {
        $name = trim((string) $name);
        if ($anonim || $name === '' || $name === '-') return '********';
        $parts = preg_split('/\s+/', $name);
        return implode(' ', array_map(fn($p) => mb_substr($p,0,1) . str_repeat('*', max(3, mb_strlen($p)-1)), $parts));
    };
    $statusMeta = function ($status, $transactionStatus = null) {
        $status = strtolower((string) $status);
        $transactionStatus = strtolower((string) $transactionStatus);
        if (in_array($status, ['berhasil','verified','paid','success'], true) || in_array($transactionStatus, ['settlement','capture'], true)) return ['class'=>'success','text'=>'Berhasil','icon'=>'fa-circle-check'];
        if (in_array($status, ['ditolak','rejected'], true) || $transactionStatus === 'deny') return ['class'=>'danger','text'=>'Ditolak','icon'=>'fa-circle-xmark'];
        if (in_array($status, ['expired'], true) || in_array($transactionStatus, ['expire','expired'], true)) return ['class'=>'dark','text'=>'Expired','icon'=>'fa-clock-rotate-left'];
        if (in_array($status, ['dibatalkan','cancel','cancelled'], true) || $transactionStatus === 'cancel') return ['class'=>'dark','text'=>'Batal','icon'=>'fa-ban'];
        return ['class'=>'warning','text'=>'Pending','icon'=>'fa-clock'];
    };
?>
<div class="yd-page">
    <div class="yd-hero mb-4">
        <div class="row align-items-center g-3">
            <div class="col-lg-8">
                <h2 class="yd-title">Donasi Masuk</h2>
                <p class="yd-subtitle">Pantau transaksi donasi dari campaign yayasan. Status pembayaran mengikuti Midtrans, tanpa verifikasi manual.</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="<?= base_url('yayasan/report/create') ?>" class="btn btn-primary rounded-4 px-4 py-3 fw-bold"><i class="fa-solid fa-file-circle-plus me-2"></i> Buat Laporan Dana</a>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4"><div class="yd-stat"><div><small>Dana Berhasil</small><h3><?= $currency($stats['total_berhasil'] ?? 0) ?></h3></div><div class="yd-icon blue"><i class="fa-solid fa-wallet"></i></div></div></div>
        <div class="col-md-4"><div class="yd-stat"><div><small>Transaksi Berhasil</small><h3><?= number_format((int) ($stats['transaksi_berhasil'] ?? 0), 0, ',', '.') ?></h3></div><div class="yd-icon green"><i class="fa-solid fa-circle-check"></i></div></div></div>
        <div class="col-md-4"><div class="yd-stat"><div><small>Pending</small><h3><?= number_format((int) ($stats['pending'] ?? 0), 0, ',', '.') ?></h3></div><div class="yd-icon orange"><i class="fa-solid fa-clock"></i></div></div></div>
    </div>

    <div class="yd-panel mb-4">
        <form method="get" action="<?= base_url('yayasan/donation/index') ?>" class="yd-filter">
            <input type="text" name="keyword" value="<?= esc($keyword ?? '') ?>" class="form-control" placeholder="Cari campaign atau invoice...">
            <select name="status" class="form-select">
                <option value="">Semua Status</option>
                <option value="berhasil" <?= ($status ?? '') === 'berhasil' ? 'selected' : '' ?>>Berhasil</option>
                <option value="pending" <?= ($status ?? '') === 'pending' ? 'selected' : '' ?>>Pending</option>
                <option value="expired" <?= ($status ?? '') === 'expired' ? 'selected' : '' ?>>Expired</option>
                <option value="dibatalkan" <?= ($status ?? '') === 'dibatalkan' ? 'selected' : '' ?>>Dibatalkan</option>
            </select>
            <button class="btn btn-primary rounded-4 fw-bold" type="submit"><i class="fa-solid fa-magnifying-glass me-2"></i> Filter</button>
        </form>
    </div>

    <div class="yd-panel">
        <div class="d-flex justify-content-between align-items-center gap-3 mb-3">
            <h4 class="yd-title fs-3">Data Donasi</h4>
            <span class="text-muted fw-semibold"><?= number_format((int) count($donations ?? []), 0, ',', '.') ?> data tampil</span>
        </div>
        <?php if (empty($donations)): ?>
            <div class="yd-empty"><i class="fa-solid fa-receipt fa-2x mb-3"></i><p class="mb-0 fw-bold">Belum ada data donasi.</p></div>
        <?php else: ?>
            <table class="yd-table">
                <thead><tr><th style="width:54px">No</th><th>Donatur</th><th>Campaign</th><th>Invoice</th><th style="width:140px">Nominal</th><th style="width:140px">Status</th></tr></thead>
                <tbody>
                    <?php foreach ($donations as $i => $donation): ?>
                        <?php $meta = $statusMeta($donation['status'] ?? 'pending', $donation['transaction_status'] ?? null); ?>
                        <tr>
                            <td data-label="No"><?= $i + 1 ?></td>
                            <td data-label="Donatur"><div class="yd-main"><strong><?= esc($maskName($donation['donor_nama'] ?? $donation['nama'] ?? '', !empty($donation['anonim']))) ?></strong><small>Data pribadi disamarkan</small></div></td>
                            <td data-label="Campaign"><div class="yd-main"><strong><?= esc($donation['judul'] ?? '-') ?></strong><small><?= esc($donation['nama_kategori'] ?? '-') ?></small></div></td>
                            <td data-label="Invoice"><span class="yd-badge dark"><i class="fa-solid fa-receipt"></i> <?= esc($donation['invoice'] ?? '-') ?></span></td>
                            <td data-label="Nominal"><strong><?= $currency($donation['nominal'] ?? 0) ?></strong></td>
                            <td data-label="Status"><span class="yd-badge <?= $meta['class'] ?>"><i class="fa-solid <?= $meta['icon'] ?>"></i> <?= esc($meta['text']) ?></span></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php if (!empty($pager)): ?><div class="mt-3"><?= $pager->links('yayasan_donations', 'default_full') ?></div><?php endif; ?>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>
