<?= $this->include('layouts/header') ?>
<?php
$formatRupiah = static fn($value): string => 'Rp ' . number_format((float) $value, 0, ',', '.');
$status = strtolower((string) ($donation['status'] ?? 'pending'));
$trx = strtolower((string) ($donation['transaction_status'] ?? ''));
$isSuccess = in_array($status, ['berhasil', 'verified', 'success', 'paid'], true) || in_array($trx, ['settlement', 'capture'], true);
$isPending = $status === 'pending' || $trx === 'pending';
$statusText = $isSuccess ? 'Berhasil' : ($isPending ? 'Menunggu Pembayaran' : ucfirst($status ?: 'Pending'));
$statusClass = $isSuccess ? 'success' : ($isPending ? 'warning' : 'secondary');
?>

<style>
    .detail-history-page { padding: 54px 0 70px; background: #f5f8ff; }
    .detail-wrap { max-width: 960px; margin: 0 auto; }
    .detail-card { background: #fff; border: 1px solid var(--dk-border); border-radius: 34px; box-shadow: var(--dk-shadow); overflow: hidden; }
    .detail-head { padding: 30px; background: linear-gradient(135deg, var(--dk-navy), #28426c); color: #fff; }
    .detail-head h1 { margin: 0; font-size: 34px; font-weight: 950; }
    .detail-head p { margin: 8px 0 0; color: rgba(255,255,255,.74); font-weight: 750; }
    .detail-body { padding: 30px; }
    .status-pill { display: inline-flex; align-items: center; gap: 8px; border-radius: 999px; padding: 10px 14px; font-weight: 950; }
    .status-success { color: #15803d; background: rgba(34,197,94,.16); }
    .status-warning { color: #92400e; background: rgba(245,158,11,.20); }
    .status-secondary { color: #475569; background: #e9eef6; }
    .info-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px; margin-top: 24px; }
    .info-box { background: #f8fbff; border: 1px solid var(--dk-border); border-radius: 22px; padding: 18px; }
    .info-box small { display: block; color: var(--dk-muted); font-weight: 850; margin-bottom: 6px; }
    .info-box strong { color: var(--dk-navy); font-size: 18px; font-weight: 950; word-break: break-word; }
    .message-box { margin-top: 16px; padding: 18px; border-radius: 22px; background: #fffaf0; border: 1px solid rgba(245,158,11,.22); color: #78350f; font-weight: 750; }
    @media(max-width: 768px) { .info-grid { grid-template-columns: 1fr; } }
</style>

<main class="detail-history-page">
    <div class="container">
        <div class="detail-wrap">
            <div class="detail-card">
                <div class="detail-head">
                    <h1>Detail Donasi</h1>
                    <p>Invoice <?= esc($donation['invoice'] ?? '-') ?></p>
                </div>
                <div class="detail-body">
                    <span class="status-pill status-<?= esc($statusClass) ?>">
                        <i class="fa-solid <?= $isSuccess ? 'fa-circle-check' : ($isPending ? 'fa-clock' : 'fa-circle-info') ?>"></i>
                        <?= esc($statusText) ?>
                    </span>

                    <div class="info-grid">
                        <div class="info-box"><small>Campaign</small><strong><?= esc($donation['judul'] ?? '-') ?></strong></div>
                        <div class="info-box"><small>Yayasan</small><strong><?= esc($donation['nama_yayasan'] ?? '-') ?></strong></div>
                        <div class="info-box"><small>Nominal</small><strong><?= esc($formatRupiah($donation['nominal'] ?? 0)) ?></strong></div>
                        <div class="info-box"><small>Tanggal Donasi</small><strong><?= !empty($donation['tanggal_donasi']) ? date('d M Y H:i', strtotime($donation['tanggal_donasi'])) : '-' ?></strong></div>
                        <div class="info-box"><small>Metode Pembayaran</small><strong><?= esc(strtoupper($donation['payment_type'] ?: $donation['metode_pembayaran'] ?: 'MIDTRANS')) ?></strong></div>
                        <div class="info-box"><small>Status Midtrans</small><strong><?= esc($donation['transaction_status'] ?: '-') ?></strong></div>
                        <div class="info-box"><small>Anonim</small><strong><?= !empty($donation['anonim']) ? 'Ya, nama disembunyikan' : 'Tidak' ?></strong></div>
                        <div class="info-box"><small>Invoice</small><strong><?= esc($donation['invoice'] ?? '-') ?></strong></div>
                    </div>

                    <?php if (!empty($donation['pesan'])): ?>
                        <div class="message-box"><strong>Pesan:</strong><br><?= nl2br(esc($donation['pesan'])) ?></div>
                    <?php endif; ?>

                    <div class="d-flex flex-wrap gap-3 mt-4">
                        <?php if ($isPending): ?>
                            <a href="<?= base_url('payment/checkout/' . $donation['id']) ?>" class="btn btn-dk-primary"><i class="fa-solid fa-wallet me-2"></i> Lanjutkan Pembayaran</a>
                        <?php endif; ?>
                        <a href="<?= base_url('donatur/history') ?>" class="btn btn-dk-outline"><i class="fa-solid fa-arrow-left me-2"></i> Kembali</a>
                        <?php if (!empty($donation['campaign_id'])): ?>
                            <a href="<?= base_url('campaign/' . $donation['campaign_id']) ?>" class="btn btn-dk-soft"><i class="fa-solid fa-hand-holding-heart me-2"></i> Lihat Campaign</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?= $this->include('layouts/footer') ?>
