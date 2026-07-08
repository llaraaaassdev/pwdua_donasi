<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<style>
    .yr-page{max-width:100%;overflow:hidden}.yr-card,.yr-stat{background:#fff;border:1px solid #edf2f7;border-radius:28px;box-shadow:0 18px 46px rgba(15,23,42,.07)}.yr-card{padding:26px}.yr-title{font-weight:950;color:#0f172a;margin:0}.yr-subtitle{color:#64748b;line-height:1.65;margin:.35rem 0 0}.yr-stat{padding:20px;display:flex;align-items:center;justify-content:space-between;gap:14px}.yr-stat small{display:block;color:#64748b;font-weight:900}.yr-stat h3{font-weight:950;color:#0f172a;margin:6px 0 0}.yr-icon{width:54px;height:54px;border-radius:18px;display:flex;align-items:center;justify-content:center;background:#dbeafe;color:#2563eb;font-size:22px}.yr-filter{display:grid;grid-template-columns:1fr 220px 170px;gap:14px}.yr-filter .form-control,.yr-filter .form-select{border-radius:18px;min-height:52px;border:1px solid #e5edf6}.yr-table{width:100%;border-collapse:separate;border-spacing:0 12px;table-layout:fixed}.yr-table th{font-size:12px;color:#64748b;text-transform:uppercase;letter-spacing:.06em;padding:0 14px 8px}.yr-table td{background:#fff;border-top:1px solid #edf2f7;border-bottom:1px solid #edf2f7;padding:16px 14px;vertical-align:middle}.yr-table td:first-child{border-left:1px solid #edf2f7;border-radius:18px 0 0 18px}.yr-table td:last-child{border-right:1px solid #edf2f7;border-radius:0 18px 18px 0}.yr-main strong{display:block;font-weight:950;color:#0f172a;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}.yr-main small{display:block;color:#64748b;margin-top:4px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}.yr-badge{display:inline-flex;align-items:center;gap:6px;padding:8px 12px;border-radius:999px;font-size:12px;font-weight:950;white-space:nowrap}.yr-badge.success{background:#dcfce7;color:#15803d}.yr-badge.warning{background:#fef3c7;color:#92400e}.yr-badge.danger{background:#fee2e2;color:#b91c1c}.yr-actions{display:flex;align-items:center;gap:8px;justify-content:flex-end}.yr-btn-icon{width:42px;height:42px;border-radius:14px;display:inline-flex;align-items:center;justify-content:center;text-decoration:none;border:0;font-size:17px}.yr-btn-icon.view{background:#e0f2fe;color:#0369a1}.yr-btn-icon.edit{background:#fef3c7;color:#92400e}.yr-empty{text-align:center;border:1px dashed #dbe3ef;border-radius:22px;background:#f8fafc;padding:38px;color:#64748b}.alert{border:0;border-radius:18px}.btn{border-radius:16px;font-weight:900}@media(max-width:992px){.yr-filter{grid-template-columns:1fr}.yr-table thead{display:none}.yr-table,.yr-table tbody,.yr-table tr,.yr-table td{display:block;width:100%}.yr-table tr{background:#fff;border:1px solid #edf2f7;border-radius:22px;margin-bottom:14px;padding:14px}.yr-table td{border:0!important;border-radius:0!important;padding:8px 0}.yr-table td:before{content:attr(data-label);display:block;font-size:11px;font-weight:900;color:#64748b;text-transform:uppercase;margin-bottom:4px}.yr-actions{justify-content:flex-start}}
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php
$currency = fn($v) => 'Rp ' . number_format((float) $v, 0, ',', '.');
$statusMeta = function ($status) {
    $status = strtolower((string) $status);
    if ($status === 'approved') return ['class' => 'success', 'text' => 'Disetujui', 'icon' => 'fa-circle-check'];
    if ($status === 'rejected') return ['class' => 'danger', 'text' => 'Perlu Perbaikan', 'icon' => 'fa-circle-xmark'];
    return ['class' => 'warning', 'text' => 'Menunggu Verifikasi', 'icon' => 'fa-clock'];
};
?>
<div class="yr-page">
    <?php if(session()->getFlashdata('success')): ?><div class="alert alert-success fw-bold mb-3"><?= session()->getFlashdata('success') ?></div><?php endif; ?>
    <?php if(session()->getFlashdata('error')): ?><div class="alert alert-danger fw-bold mb-3"><?= session()->getFlashdata('error') ?></div><?php endif; ?>

    <div class="yr-card mb-4">
        <div class="row align-items-center g-3">
            <div class="col-lg-8">
                <h2 class="yr-title">Laporan Penggunaan Dana</h2>
                <p class="yr-subtitle">Jika admin meminta perbaikan, cukup edit laporan yang sama lalu kirim ulang. Tidak perlu membuat laporan baru.</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="<?= base_url('yayasan/report/create') ?>" class="btn btn-primary px-4 py-3"><i class="fa-solid fa-file-circle-plus me-2"></i> Buat Laporan</a>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4"><div class="yr-stat"><div><small>Total Laporan</small><h3><?= number_format((int)($stats['total'] ?? 0),0,',','.') ?></h3></div><div class="yr-icon"><i class="fa-solid fa-file-invoice"></i></div></div></div>
        <div class="col-md-4"><div class="yr-stat"><div><small>Menunggu Admin</small><h3><?= number_format((int)($stats['pending'] ?? 0),0,',','.') ?></h3></div><div class="yr-icon"><i class="fa-solid fa-clock"></i></div></div></div>
        <div class="col-md-4"><div class="yr-stat"><div><small>Dipublikasikan</small><h3><?= number_format((int)($stats['approved'] ?? 0),0,',','.') ?></h3></div><div class="yr-icon"><i class="fa-solid fa-circle-check"></i></div></div></div>
    </div>

    <div class="yr-card mb-4">
        <form method="get" action="<?= base_url('yayasan/report') ?>" class="yr-filter">
            <input type="text" name="keyword" value="<?= esc($keyword ?? '') ?>" class="form-control" placeholder="Cari laporan atau campaign...">
            <select name="status" class="form-select">
                <option value="">Semua Status</option>
                <option value="pending" <?= ($status ?? '') === 'pending' ? 'selected' : '' ?>>Menunggu</option>
                <option value="approved" <?= ($status ?? '') === 'approved' ? 'selected' : '' ?>>Disetujui</option>
                <option value="rejected" <?= ($status ?? '') === 'rejected' ? 'selected' : '' ?>>Perlu Perbaikan</option>
            </select>
            <button class="btn btn-primary"><i class="fa-solid fa-magnifying-glass me-2"></i> Filter</button>
        </form>
    </div>

    <div class="yr-card">
        <h4 class="yr-title fs-3 mb-3">Daftar Laporan</h4>
        <?php if(empty($reports)): ?>
            <div class="yr-empty"><i class="fa-solid fa-file-circle-plus fa-2x mb-3"></i><p class="mb-0 fw-bold">Belum ada laporan penggunaan dana.</p></div>
        <?php else: ?>
            <table class="yr-table">
                <thead>
                    <tr>
                        <th style="width:54px">No</th>
                        <th>Laporan</th>
                        <th>Campaign</th>
                        <th style="width:160px">Pengeluaran</th>
                        <th style="width:170px">Status</th>
                        <th style="width:110px" class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($reports as $i => $report): $meta = $statusMeta($report['status_verifikasi'] ?? 'pending'); $canEdit = in_array(($report['status_verifikasi'] ?? 'pending'), ['pending','rejected'], true); ?>
                    <tr>
                        <td data-label="No"><?= $i + 1 ?></td>
                        <td data-label="Laporan"><div class="yr-main"><strong><?= esc($report['judul_laporan'] ?? '-') ?></strong><small><?= !empty($report['tanggal_laporan']) ? date('d M Y', strtotime($report['tanggal_laporan'])) : '-' ?></small></div></td>
                        <td data-label="Campaign"><div class="yr-main"><strong><?= esc($report['campaign_judul'] ?? '-') ?></strong><small><?= esc($report['nama_yayasan'] ?? '-') ?></small></div></td>
                        <td data-label="Pengeluaran"><strong><?= $currency($report['total_pengeluaran'] ?? 0) ?></strong></td>
                        <td data-label="Status"><span class="yr-badge <?= $meta['class'] ?>"><i class="fa-solid <?= $meta['icon'] ?>"></i> <?= esc($meta['text']) ?></span></td>
                        <td data-label="Aksi">
                            <div class="yr-actions">
                                <a class="yr-btn-icon view" href="<?= base_url('yayasan/report/detail/' . $report['id']) ?>" title="Detail"><i class="fa-solid fa-eye"></i></a>
                                <?php if($canEdit): ?><a class="yr-btn-icon edit" href="<?= base_url('yayasan/report/edit/' . $report['id']) ?>" title="Edit / Perbaiki"><i class="fa-solid fa-pen-to-square"></i></a><?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="mt-3"><?= $pager->links('yayasan_reports') ?></div>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>
