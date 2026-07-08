<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<style>
    .donation-detail-final{max-width:100%;overflow:hidden}.donation-detail-final .detail-card,.donation-detail-final .side-card,.donation-detail-final .privacy-card{background:#fff;border:1px solid #edf2f7;border-radius:26px;box-shadow:0 16px 42px rgba(15,23,42,.07)}.donation-detail-final .detail-card,.donation-detail-final .side-card{padding:26px}.donation-detail-final .privacy-card{padding:16px 18px;color:#475569;background:#f8fafc}.donation-detail-final .hero-icon{width:68px;height:68px;border-radius:24px;background:#dbeafe;color:#2563eb;display:flex;align-items:center;justify-content:center;font-size:28px;flex:0 0 68px}.donation-detail-final .info-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:14px}.donation-detail-final .info-item{background:#f8fafc;border:1px solid #edf2f7;border-radius:18px;padding:15px;min-width:0}.donation-detail-final .info-item small{display:block;color:#64748b;font-weight:900;margin-bottom:7px}.donation-detail-final .info-item strong{display:block;color:#0f172a;word-break:break-word}.donation-detail-final .badge-soft{display:inline-flex;align-items:center;gap:7px;padding:8px 12px;border-radius:999px;font-weight:950;font-size:12px;white-space:nowrap}.donation-detail-final .badge-soft.success{background:#dcfce7;color:#15803d}.donation-detail-final .badge-soft.warning{background:#fef3c7;color:#92400e}.donation-detail-final .badge-soft.danger{background:#fee2e2;color:#b91c1c}.donation-detail-final .badge-soft.dark{background:#e2e8f0;color:#334155}.donation-detail-final .badge-soft.info{background:#e0f2fe;color:#0369a1}.donation-detail-final .icon-btn{width:44px;height:44px;border:0;border-radius:14px;text-decoration:none;display:inline-flex;align-items:center;justify-content:center;font-size:16px;background:#f1f5f9;color:#0f172a}.donation-detail-final .icon-btn:hover{background:#e0f2fe;color:#0369a1}.donation-detail-final .proof-img{width:100%;border-radius:18px;border:1px solid #e2e8f0}@media(max-width:768px){.donation-detail-final .info-grid{grid-template-columns:1fr}.donation-detail-final .detail-card,.donation-detail-final .side-card{padding:20px}}
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php
$status = strtolower((string)($donation['status'] ?? 'pending'));
$transactionStatus = strtolower((string)($donation['transaction_status'] ?? ''));
$hidden = (int)($donation['anonim'] ?? 0) === 1;

if (in_array($status, ['berhasil', 'verified'], true) || in_array($transactionStatus, ['settlement', 'capture'], true)) {
    $statusClass='success'; $statusText='Berhasil'; $statusIcon='fa-circle-check';
} elseif (in_array($status, ['ditolak', 'rejected'], true) || $transactionStatus === 'deny') {
    $statusClass='danger'; $statusText='Ditolak'; $statusIcon='fa-circle-xmark';
} elseif (in_array($status, ['expired'], true) || in_array($transactionStatus, ['expire', 'expired'], true)) {
    $statusClass='dark'; $statusText='Expired'; $statusIcon='fa-clock-rotate-left';
} elseif (in_array($status, ['dibatalkan', 'cancel', 'cancelled'], true) || $transactionStatus === 'cancel') {
    $statusClass='dark'; $statusText='Dibatalkan'; $statusIcon='fa-ban';
} else {
    $statusClass='warning'; $statusText='Pending'; $statusIcon='fa-clock';
}

$maskName = function ($name, $hidden = false) {
    if ($hidden) return '********';
    $name = trim((string) $name);
    if ($name === '' || $name === '-') return '********';
    $parts = preg_split('/\s+/', $name);
    return implode(' ', array_map(function($part){ return mb_substr($part,0,1) . str_repeat('*', max(3, mb_strlen($part)-1)); }, $parts));
};

$maskEmail = function ($email, $hidden = false) {
    if ($hidden) return '***@***';
    $email = trim((string) $email);
    if ($email === '' || !str_contains($email, '@')) return '***@***';
    [$local, $domain] = explode('@', $email, 2);
    $domainParts = explode('.', $domain);
    $main = $domainParts[0] ?? 'mail';
    $tld = count($domainParts) > 1 ? '.' . end($domainParts) : '';
    return mb_substr($local,0,1) . str_repeat('*', max(3, mb_strlen($local)-1)) . '@' . mb_substr($main,0,1) . str_repeat('*', max(3, mb_strlen($main)-1)) . $tld;
};

$maskPhone = function ($phone) {
    $phone = preg_replace('/\D+/', '', (string) $phone);
    if ($phone === '') return '********';
    return mb_substr($phone,0,2) . str_repeat('*', max(6, mb_strlen($phone)-4)) . mb_substr($phone,-2);
};

$donorName = $maskName($donation['donor_nama'] ?? '', $hidden);
$donorEmail = $maskEmail($donation['donor_email'] ?? '', $hidden);
$donorPhone = $hidden ? '********' : $maskPhone($donation['donor_no_hp'] ?? '');
$proof = $donation['bukti_pembayaran'] ?? null;
$proofUrl = null;
if (!empty($proof)) {
    $paths = ['uploads/bukti/' . $proof, 'uploads/bukti_pembayaran/' . $proof, 'uploads/donasi/' . $proof];
    foreach ($paths as $path) {
        if (defined('FCPATH') && file_exists(FCPATH . $path)) { $proofUrl = base_url($path); break; }
    }
    $proofUrl = $proofUrl ?: base_url('uploads/bukti/' . $proof);
}
?>

<div class="donation-detail-final">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1">Detail Donasi</h2>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge-soft <?= $statusClass ?>"><i class="fa-solid <?= $statusIcon ?>"></i> <?= esc($statusText) ?></span>
            <a href="<?= base_url('admin/donation') ?>" class="icon-btn" title="Kembali"><i class="fa-solid fa-arrow-left"></i></a>
        </div>
    </div>

    <div class="privacy-card mb-4"><i class="fa-solid fa-shield-halved me-2 text-primary"></i>Nama, email, dan nomor HP donatur tidak pernah tampil terbuka di halaman admin. Semua identitas dimasking dengan bintang.</div>

    <div class="row g-4">
        <div class="col-xl-8">
            <div class="detail-card">
                <div class="d-flex flex-wrap align-items-center gap-3 mb-4">
                    <div class="hero-icon"><i class="fa-solid fa-hand-holding-dollar"></i></div>
                    <div>
                        <h3 class="fw-bold mb-1">Rp <?= number_format((float)($donation['nominal'] ?? 0),0,',','.') ?></h3>
                        <p class="text-muted mb-2">Invoice: <?= esc($donation['invoice'] ?? '-') ?></p>
                        <?php if($hidden): ?><span class="badge-soft dark"><i class="fa-solid fa-user-secret"></i> Donatur Anonim</span><?php endif; ?>
                    </div>
                </div>

                <div class="info-grid">
                    <div class="info-item"><small>Nama Donatur</small><strong><?= esc($donorName) ?></strong></div>
                    <div class="info-item"><small>Email Donatur</small><strong><?= esc($donorEmail) ?></strong></div>
                    <div class="info-item"><small>No HP Donatur</small><strong><?= esc($donorPhone) ?></strong></div>
                    <div class="info-item"><small>Campaign</small><strong><?= esc($donation['judul'] ?? '-') ?></strong></div>
                    <div class="info-item"><small>Yayasan</small><strong><?= esc($donation['nama_yayasan'] ?? '-') ?></strong></div>
                    <div class="info-item"><small>Status Sistem</small><span class="badge-soft <?= $statusClass ?>"><i class="fa-solid <?= $statusIcon ?>"></i> <?= esc($statusText) ?></span></div>
                    <div class="info-item"><small>Tanggal Donasi</small><strong><?= esc($donation['tanggal_donasi'] ?? $donation['created_at'] ?? '-') ?></strong></div>
                    <div class="info-item"><small>Waktu Dibayar</small><strong><?= esc($donation['paid_at'] ?? '-') ?></strong></div>
                    <div class="info-item"><small>Metode Pembayaran</small><strong><?= esc(strtoupper(str_replace('_',' ', $donation['payment_type'] ?? $donation['metode_pembayaran'] ?? '-'))) ?></strong></div>
                    <div class="info-item"><small>Bank / VA</small><strong><?= esc(strtoupper($donation['bank'] ?? '-')) ?> <?= !empty($donation['va_number']) ? ' - ' . esc($donation['va_number']) : '' ?></strong></div>
                    <div class="info-item"><small>Transaction ID</small><strong><?= esc($donation['transaction_id'] ?? '-') ?></strong></div>
                    <div class="info-item"><small>Status Midtrans</small><strong><?= esc($donation['transaction_status'] ?? '-') ?></strong></div>
                    <div class="info-item"><small>Fraud Status</small><strong><?= esc($donation['fraud_status'] ?? '-') ?></strong></div>
                    <div class="info-item"><small>Gross Amount</small><strong>Rp <?= number_format((float)($donation['gross_amount'] ?? $donation['nominal'] ?? 0),0,',','.') ?></strong></div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="side-card mb-4">
                <h5 class="fw-bold mb-3">Catatan Sistem</h5>
                <div class="info-item"><small>Konfirmasi Pembayaran</small><strong>Otomatis oleh Midtrans</strong></div>
                <div class="info-item mt-3"><small>Snap Token</small><strong style="word-break:break-all"><?= esc($donation['snap_token'] ?? '-') ?></strong></div>
            </div>
            
        </div>
    </div>
</div>
<?= $this->endSection() ?>
