<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<style>
    .admin-user-detail-final{max-width:100%;overflow:hidden}.admin-user-detail-final .detail-card{background:#fff;border:1px solid #edf2f7;border-radius:26px;padding:26px;box-shadow:0 16px 42px rgba(15,23,42,.07)}.admin-user-detail-final .hero-avatar{width:78px;height:78px;border-radius:28px;background:linear-gradient(135deg,#2563eb,#4f46e5);color:#fff;display:flex;align-items:center;justify-content:center;font-size:32px;font-weight:950;flex:0 0 78px}.admin-user-detail-final .info-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:14px}.admin-user-detail-final .info-item{background:#f8fafc;border:1px solid #edf2f7;border-radius:18px;padding:16px;min-width:0}.admin-user-detail-final .info-item small{display:block;color:#64748b;font-weight:900;margin-bottom:7px}.admin-user-detail-final .info-item strong{display:block;color:#0f172a;word-break:break-word}.admin-user-detail-final .badge-soft{display:inline-flex;align-items:center;gap:7px;padding:8px 12px;border-radius:999px;font-weight:950;font-size:12px}.admin-user-detail-final .badge-soft.success{background:#dcfce7;color:#15803d}.admin-user-detail-final .badge-soft.danger{background:#fee2e2;color:#b91c1c}.admin-user-detail-final .badge-soft.dark{background:#e2e8f0;color:#334155}.admin-user-detail-final .icon-btn{width:44px;height:44px;border:0;border-radius:14px;text-decoration:none;display:inline-flex;align-items:center;justify-content:center;font-size:16px;transition:.2s}.admin-user-detail-final .icon-btn:hover{transform:translateY(-2px)}.admin-user-detail-final .icon-back{background:#f1f5f9;color:#0f172a}.admin-user-detail-final .icon-edit{background:#fef3c7;color:#92400e}@media(max-width:768px){.admin-user-detail-final .detail-card{padding:20px}.admin-user-detail-final .info-grid{grid-template-columns:1fr}}
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php
$role = strtolower((string)($user['role'] ?? '-'));
$isDonatur = $role === 'donatur';
$maskEmail = function ($email) {
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
    if ($phone === '') return '-';
    return mb_substr($phone,0,2) . str_repeat('*', max(5, mb_strlen($phone)-4)) . mb_substr($phone,-2);
};
$emailDisplay = $isDonatur ? $maskEmail($user['email'] ?? '') : ($user['email'] ?? '-');
$phoneDisplay = $isDonatur ? $maskPhone($user['no_hp'] ?? '') : ($user['no_hp'] ?? '-');
$isActive = (int)($user['is_active'] ?? 0) === 1;
?>
<div class="admin-user-detail-final">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1">Detail User</h2>
            <p class="text-muted mb-0">Informasi akun pengguna. Data donatur dimasking untuk menjaga privasi.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="<?= base_url('admin/users') ?>" class="icon-btn icon-back" title="Kembali"><i class="fa-solid fa-arrow-left"></i></a>
            <a href="<?= base_url('admin/users/edit/'.$user['id']) ?>" class="icon-btn icon-edit" title="Edit"><i class="fa-solid fa-pen"></i></a>
        </div>
    </div>

    <div class="detail-card">
        <div class="d-flex flex-wrap align-items-center gap-3 mb-4">
            <div class="hero-avatar"><?= strtoupper(substr($user['nama'] ?? 'U', 0, 1)) ?></div>
            <div>
                <h3 class="fw-bold mb-1"><?= esc($user['nama'] ?? '-') ?></h3>
                <p class="text-muted mb-2"><?= esc($emailDisplay) ?></p>
                <span class="badge-soft dark"><i class="fa-solid fa-user-tag"></i> <?= esc(ucfirst($role)) ?></span>
                <span class="badge-soft <?= $isActive ? 'success' : 'danger' ?>"><i class="fa-solid <?= $isActive ? 'fa-circle-check' : 'fa-circle-xmark' ?>"></i> <?= $isActive ? 'Aktif' : 'Nonaktif' ?></span>
            </div>
        </div>
        <div class="info-grid">
            <div class="info-item"><small>ID User</small><strong><?= esc($user['id'] ?? '-') ?></strong></div>
            <div class="info-item"><small>No HP</small><strong><?= esc($phoneDisplay) ?></strong></div>
            <div class="info-item"><small>Status Verifikasi</small><strong><?= esc(ucfirst($user['status_verifikasi'] ?? '-')) ?></strong></div>
            <div class="info-item"><small>Tanggal Dibuat</small><strong><?= esc($user['created_at'] ?? '-') ?></strong></div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
