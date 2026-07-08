<?= $this->include('layouts/header') ?>
<?php
$formatRupiah = static fn($value): string => 'Rp ' . number_format((float) $value, 0, ',', '.');
$statusLabel = static function ($status, $transactionStatus = null): array {
    $status = strtolower((string) $status);
    $transactionStatus = strtolower((string) $transactionStatus);
    if (in_array($status, ['berhasil', 'verified', 'success', 'paid'], true) || in_array($transactionStatus, ['settlement', 'capture'], true)) {
        return ['Berhasil', 'success', 'fa-circle-check'];
    }
    if ($status === 'pending' || $transactionStatus === 'pending') {
        return ['Menunggu Pembayaran', 'warning', 'fa-clock'];
    }
    if (in_array($status, ['expired'], true) || in_array($transactionStatus, ['expire', 'expired'], true)) {
        return ['Expired', 'secondary', 'fa-hourglass-end'];
    }
    if (in_array($status, ['dibatalkan', 'cancel', 'cancelled'], true) || $transactionStatus === 'cancel') {
        return ['Dibatalkan', 'danger', 'fa-circle-xmark'];
    }
    return [ucfirst($status ?: 'Pending'), 'secondary', 'fa-circle-info'];
};
?>

<style>
    .history-page { padding: 54px 0 70px; background: #f5f8ff; }
    .page-head { display: flex; justify-content: space-between; align-items: end; gap: 18px; margin-bottom: 24px; }
    .page-title { font-size: clamp(34px, 5vw, 54px); font-weight: 950; color: var(--dk-navy); letter-spacing: -1.2px; margin: 0; }
    .page-subtitle { color: var(--dk-muted); font-weight: 750; margin: 8px 0 0; }
    .stats-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 18px; margin-bottom: 24px; }
    .stat-card { background: #fff; border: 1px solid var(--dk-border); border-radius: 28px; padding: 24px; box-shadow: var(--dk-shadow); }
    .stat-card small { color: var(--dk-muted); font-weight: 850; }
    .stat-card strong { display: block; margin-top: 8px; color: var(--dk-navy); font-size: 34px; font-weight: 950; }
    .history-card { background: #fff; border: 1px solid var(--dk-border); border-radius: 32px; box-shadow: var(--dk-shadow); padding: 22px; }
    .history-row { display: grid; grid-template-columns: 1.4fr .9fr .85fr auto; gap: 16px; align-items: center; padding: 18px; border: 1px solid #eef3fb; border-radius: 24px; margin-bottom: 12px; background: #fff; }
    .history-row:last-child { margin-bottom: 0; }
    .campaign-name { font-weight: 950; color: var(--dk-navy); font-size: 18px; }
    .invoice { display: inline-flex; align-items: center; gap: 7px; color: var(--dk-primary); background: rgba(37,99,235,.09); border-radius: 999px; padding: 7px 11px; font-weight: 900; font-size: 13px; margin-top: 8px; }
    .muted-line { color: var(--dk-muted); font-weight: 750; font-size: 14px; }
    .nominal { font-weight: 950; color: var(--dk-navy); font-size: 22px; }
    .status-pill { display: inline-flex; align-items: center; gap: 7px; border-radius: 999px; padding: 9px 12px; font-weight: 950; white-space: nowrap; }
    .status-success { color: #15803d; background: rgba(34,197,94,.16); }
    .status-warning { color: #92400e; background: rgba(245,158,11,.18); }
    .status-danger { color: #b91c1c; background: rgba(239,68,68,.14); }
    .status-secondary { color: #475569; background: #e9eef6; }
    .icon-btn { width: 48px; height: 48px; display: inline-flex; align-items: center; justify-content: center; border-radius: 16px; text-decoration: none; font-weight: 950; }
    .icon-detail { color: #0369a1; background: #e0f2fe; }
    .empty-state { text-align: center; padding: 60px 20px; color: var(--dk-muted); font-weight: 800; }
    .empty-state i { width: 80px; height: 80px; border-radius: 28px; display: inline-flex; align-items: center; justify-content: center; background: #f2f6ff; color: var(--dk-primary); font-size: 30px; margin-bottom: 18px; }
    @media(max-width: 991px) { .page-head { display: block; } .stats-grid { grid-template-columns: 1fr; } .history-row { grid-template-columns: 1fr; } .icon-btn { width: 100%; } }
</style>

<main class="history-page">
    <div class="container">
        <div class="page-head">
            <div>
                <h1 class="page-title">Riwayat Donasi</h1>
                <p class="page-subtitle">Pantau transaksi Midtrans dan campaign yang pernah Anda bantu.</p>
            </div>
            <a href="<?= base_url('/#campaign') ?>" class="btn btn-dk-primary"><i class="fa-solid fa-hand-holding-heart me-2"></i> Donasi Lagi</a>
        </div>

        <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success rounded-4 fw-bold"><?= esc(session()->getFlashdata('success')) ?></div>
        <?php endif; ?>
        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger rounded-4 fw-bold"><?= esc(session()->getFlashdata('error')) ?></div>
        <?php endif; ?>

        <div class="stats-grid">
            <div class="stat-card"><small>Total Transaksi</small><strong><?= esc($stats['total_transaksi'] ?? 0) ?></strong></div>
            <div class="stat-card"><small>Total Donasi Berhasil</small><strong><?= esc($formatRupiah($stats['total_berhasil'] ?? 0)) ?></strong></div>
        </div>

        <section class="history-card">
            <?php if (empty($donations)): ?>
                <div class="empty-state">
                    <i class="fa-solid fa-receipt"></i>
                    <h3 class="fw-black text-dark">Belum ada riwayat donasi</h3>
                    <p>Mulai donasi dari daftar campaign aktif di halaman utama.</p>
                </div>
            <?php else: ?>
                <?php foreach ($donations as $donation): ?>
                    <?php [$label, $type, $icon] = $statusLabel($donation['status'] ?? 'pending', $donation['transaction_status'] ?? null); ?>
                    <article class="history-row">
                        <div>
                            <div class="campaign-name"><?= esc($donation['judul'] ?? 'Campaign') ?></div>
                            <div class="muted-line"><?= esc($donation['nama_yayasan'] ?? 'Yayasan') ?><?= !empty($donation['nama_kategori']) ? ' · ' . esc($donation['nama_kategori']) : '' ?></div>
                            <span class="invoice"><i class="fa-solid fa-receipt"></i><?= esc($donation['invoice'] ?? '-') ?></span>
                        </div>
                        <div>
                            <div class="nominal"><?= esc($formatRupiah($donation['nominal'] ?? 0)) ?></div>
                            <div class="muted-line"><?= !empty($donation['tanggal_donasi']) ? date('d M Y H:i', strtotime($donation['tanggal_donasi'])) : '-' ?></div>
                        </div>
                        <div><span class="status-pill status-<?= esc($type) ?>"><i class="fa-solid <?= esc($icon) ?>"></i><?= esc($label) ?></span></div>
                        <div><a href="<?= base_url('donatur/history/' . $donation['id']) ?>" class="icon-btn icon-detail" title="Detail"><i class="fa-solid fa-eye"></i></a></div>
                    </article>
                <?php endforeach; ?>

                <div class="mt-4">
                    <?= $pager ? $pager->links('donor_history', 'default_full') : '' ?>
                </div>
            <?php endif; ?>
        </section>
    </div>
</main>

<?= $this->include('layouts/footer') ?>
