<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<style>
    .rd-card,.rd-panel{background:#fff;border:1px solid #edf2f7;border-radius:28px;box-shadow:0 18px 46px rgba(15,23,42,.07);padding:26px}.rd-title{font-weight:950;color:#0f172a}.rd-subtitle{color:#64748b;line-height:1.75}.rd-badge{display:inline-flex;align-items:center;gap:7px;padding:9px 13px;border-radius:999px;font-size:12px;font-weight:950}.rd-badge.success{background:#dcfce7;color:#15803d}.rd-badge.warning{background:#fef3c7;color:#92400e}.rd-badge.danger{background:#fee2e2;color:#b91c1c}.rd-table{width:100%;border-collapse:separate;border-spacing:0 12px;table-layout:fixed}.rd-table th,.rd-table td{padding:14px 12px}.rd-table td{border-top:1px solid #edf2f7;border-bottom:1px solid #edf2f7;background:#fff}.rd-table th{color:#64748b;font-size:12px;text-transform:uppercase;letter-spacing:.06em}.rd-table td:first-child{border-left:1px solid #edf2f7;border-radius:16px 0 0 16px}.rd-table td:last-child{border-right:1px solid #edf2f7;border-radius:0 16px 16px 0}.doc-link{width:42px;height:42px;border-radius:14px;background:#e0f2fe;color:#0369a1;display:inline-flex;align-items:center;justify-content:center;text-decoration:none}.alert{border:0;border-radius:18px}.btn{border-radius:16px;font-weight:900}@media(max-width:768px){.rd-table thead{display:none}.rd-table,.rd-table tbody,.rd-table tr,.rd-table td{display:block;width:100%}.rd-table tr{border:1px solid #edf2f7;border-radius:20px;padding:12px;margin-bottom:12px}.rd-table td{border:0!important;border-radius:0!important;padding:8px 0}.rd-table td:before{content:attr(data-label);display:block;font-size:11px;font-weight:900;color:#64748b;text-transform:uppercase;margin-bottom:4px}}
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php
$currency = fn($v) => 'Rp ' . number_format((float)$v, 0, ',', '.');
$status = strtolower((string)($report['status_verifikasi'] ?? 'pending'));
$meta = $status === 'approved' ? ['class'=>'success','text'=>'Disetujui','icon'=>'fa-circle-check'] : ($status === 'rejected' ? ['class'=>'danger','text'=>'Perlu Perbaikan','icon'=>'fa-circle-xmark'] : ['class'=>'warning','text'=>'Menunggu Verifikasi','icon'=>'fa-clock']);
$canEdit = in_array($status, ['pending','rejected'], true);
?>
<?php if(session()->getFlashdata('success')): ?><div class="alert alert-success fw-bold mb-3"><?= session()->getFlashdata('success') ?></div><?php endif; ?>
<?php if(session()->getFlashdata('error')): ?><div class="alert alert-danger fw-bold mb-3"><?= session()->getFlashdata('error') ?></div><?php endif; ?>

<div class="rd-card mb-4">
    <div class="d-flex justify-content-between align-items-start gap-3 flex-wrap">
        <div>
            <span class="rd-badge <?= $meta['class'] ?>"><i class="fa-solid <?= $meta['icon'] ?>"></i> <?= esc($meta['text']) ?></span>
            <h2 class="rd-title mt-3 mb-2"><?= esc($report['judul_laporan'] ?? '-') ?></h2>
            <p class="rd-subtitle mb-0"><?= esc($report['campaign_judul'] ?? '-') ?> • <?= !empty($report['tanggal_laporan']) ? date('d M Y', strtotime($report['tanggal_laporan'])) : '-' ?></p>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <?php if($canEdit): ?><a href="<?= base_url('yayasan/report/edit/' . $report['id']) ?>" class="btn btn-warning px-4 py-3"><i class="fa-solid fa-pen-to-square me-2"></i> Edit / Perbaiki</a><?php endif; ?>
            <a href="<?= base_url('yayasan/report') ?>" class="btn btn-light px-4 py-3"><i class="fa-solid fa-arrow-left me-2"></i> Kembali</a>
        </div>
    </div>
</div>

<?php if($status === 'rejected'): ?>
    <div class="alert alert-danger fw-bold mb-4"><i class="fa-solid fa-triangle-exclamation me-2"></i> Admin meminta perbaikan. Tekan tombol Edit / Perbaiki, revisi laporan yang sama, lalu kirim ulang ke admin.</div>
<?php elseif($status === 'pending'): ?>
    <div class="alert alert-warning fw-bold mb-4"><i class="fa-solid fa-clock me-2"></i> Laporan sedang menunggu verifikasi. Kamu masih bisa mengedit sebelum admin menyetujui.</div>
<?php endif; ?>

<div class="row g-4">
    <div class="col-xl-8">
        <div class="rd-panel">
            <h4 class="rd-title fs-4 mb-3">Deskripsi Laporan</h4>
            <p class="rd-subtitle"><?= nl2br(esc($report['deskripsi'] ?? '-')) ?></p>
            <h4 class="rd-title fs-4 mt-4 mb-3">Rincian Pengeluaran</h4>
            <?php if(empty($details)): ?>
                <div class="alert alert-light fw-bold">Belum ada rincian.</div>
            <?php else: ?>
                <table class="rd-table">
                    <thead><tr><th>Pengeluaran</th><th style="width:160px">Nominal</th><th>Keterangan</th><th style="width:90px">Dokumen</th></tr></thead>
                    <tbody>
                        <?php foreach($details as $detail): ?>
                            <tr>
                                <td data-label="Pengeluaran"><strong><?= esc($detail['nama_pengeluaran'] ?? '-') ?></strong></td>
                                <td data-label="Nominal"><strong><?= $currency($detail['nominal'] ?? 0) ?></strong></td>
                                <td data-label="Keterangan"><?= esc($detail['keterangan'] ?? '-') ?></td>
                                <td data-label="Dokumen"><?php if(!empty($detail['foto'])): ?><a class="doc-link" href="<?= base_url('uploads/laporan/'.$detail['foto']) ?>" target="_blank" title="Lihat dokumentasi"><i class="fa-solid fa-file-arrow-down"></i></a><?php else: ?><span class="text-muted">-</span><?php endif; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="rd-panel">
            <h4 class="rd-title fs-4 mb-3">Ringkasan</h4>
            <div class="mb-3"><small class="text-muted fw-bold">Total Pengeluaran</small><h3 class="rd-title"><?= $currency($report['total_pengeluaran'] ?? 0) ?></h3></div>
            <div class="mb-3"><small class="text-muted fw-bold">Dana Campaign Terkumpul</small><h5 class="fw-bold"><?= $currency($report['dana_terkumpul'] ?? 0) ?></h5></div>
            <div class="mb-3"><small class="text-muted fw-bold">Status Publikasi</small><div class="mt-2"><span class="rd-badge <?= $meta['class'] ?>"><?= esc($meta['text']) ?></span></div></div>
            <?php if($status==='approved'): ?><div class="alert alert-success fw-bold">Laporan sudah dipublikasikan.</div><?php elseif($status==='rejected'): ?><div class="alert alert-danger fw-bold">Perlu diperbaiki dan dikirim ulang.</div><?php else: ?><div class="alert alert-warning fw-bold">Menunggu verifikasi admin.</div><?php endif; ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
