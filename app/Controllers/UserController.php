<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<style>
    .admin-users-final{max-width:100%;overflow:hidden}.admin-users-final .page-title{font-weight:950;color:#0f172a;margin:0}.admin-users-final .page-subtitle{color:#64748b;margin:.35rem 0 0}.admin-users-final .stat-card,.admin-users-final .filter-card,.admin-users-final .list-card{background:#fff;border:1px solid #edf2f7;border-radius:26px;box-shadow:0 16px 42px rgba(15,23,42,.07)}.admin-users-final .stat-card{padding:18px;display:flex;align-items:center;justify-content:space-between;gap:12px;min-height:106px}.admin-users-final .stat-card small{display:block;color:#64748b;font-weight:900}.admin-users-final .stat-card h3{font-weight:950;color:#0f172a;margin:8px 0 0}.admin-users-final .stat-icon{width:52px;height:52px;border-radius:18px;display:flex;align-items:center;justify-content:center;font-size:21px}.admin-users-final .stat-icon.blue{background:#dbeafe;color:#2563eb}.admin-users-final .stat-icon.green{background:#dcfce7;color:#16a34a}.admin-users-final .stat-icon.orange{background:#ffedd5;color:#f97316}.admin-users-final .stat-icon.red{background:#fee2e2;color:#ef4444}.admin-users-final .filter-card{padding:20px}.admin-users-final .list-card{padding:24px}.admin-users-final .user-head,.admin-users-final .user-row{display:grid;grid-template-columns:54px minmax(220px,1.5fr) 118px 118px 104px;gap:14px;align-items:center}.admin-users-final .user-head{padding:0 16px 12px;color:#64748b;font-size:12px;text-transform:uppercase;letter-spacing:.08em;font-weight:950}.admin-users-final .user-row{padding:16px;border:1px solid #edf2f7;border-radius:22px;background:#fff;margin-bottom:12px;box-shadow:0 8px 20px rgba(15,23,42,.045)}.admin-users-final .user-identity{display:flex;align-items:center;gap:12px;min-width:0}.admin-users-final .user-avatar{width:44px;height:44px;border-radius:50%;background:linear-gradient(135deg,#2563eb,#4f46e5);color:#fff;display:flex;align-items:center;justify-content:center;font-weight:950;flex:0 0 44px}.admin-users-final .user-identity strong{display:block;color:#0f172a;font-weight:950;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}.admin-users-final .user-identity small{display:block;color:#64748b;margin-top:2px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}.admin-users-final .badge-soft{display:inline-flex;align-items:center;justify-content:center;gap:6px;padding:8px 11px;border-radius:999px;font-weight:950;font-size:12px;white-space:nowrap}.admin-users-final .badge-soft.success{background:#dcfce7;color:#15803d}.admin-users-final .badge-soft.danger{background:#fee2e2;color:#b91c1c}.admin-users-final .badge-soft.dark{background:#e2e8f0;color:#334155}.admin-users-final .actions{display:flex;gap:8px;justify-content:flex-start;flex-wrap:nowrap}.admin-users-final .icon-btn{width:42px;height:42px;border:0;border-radius:14px;text-decoration:none;display:inline-flex;align-items:center;justify-content:center;font-size:16px;font-weight:950;transition:.2s}.admin-users-final .icon-btn:hover{transform:translateY(-2px)}.admin-users-final .icon-detail{background:#e0f2fe;color:#0369a1}.admin-users-final .icon-edit{background:#fef3c7;color:#92400e}.admin-users-final .empty-state{border:1px dashed #dbe3ef;border-radius:22px;background:#f8fafc;text-align:center;color:#64748b;padding:42px}.admin-users-final .notice-card{border:1px solid #dbeafe;background:#eff6ff;color:#1e40af;border-radius:18px;padding:14px 16px;font-weight:800;display:flex;gap:10px;align-items:flex-start}@media(max-width:1100px){.admin-users-final .user-head{display:none}.admin-users-final .user-row{grid-template-columns:1fr auto;gap:12px}.admin-users-final .user-row>div:nth-child(1){display:none}.admin-users-final .role-cell,.admin-users-final .status-cell{display:inline-flex}.admin-users-final .actions{justify-content:flex-end}.admin-users-final .user-meta-mobile{display:flex!important;gap:8px;flex-wrap:wrap;margin-top:8px}}@media(min-width:1101px){.admin-users-final .user-meta-mobile{display:none!important}}@media(max-width:576px){.admin-users-final .list-card,.admin-users-final .filter-card{padding:18px}.admin-users-final .user-row{grid-template-columns:1fr}.admin-users-final .actions{justify-content:flex-start}.admin-users-final .user-identity{align-items:flex-start}.admin-users-final .icon-btn{width:40px;height:40px}}
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php
$users = $users ?? [];
$stats = $stats ?? [];
$page = (int) (service('request')->getGet('page_users') ?? 1);
$perPage = (int) ($perPage ?? 25);
$startNo = (($page - 1) * $perPage) + 1;
$maskEmail = function ($email) {
    $email = trim((string) $email);
    if ($email === '' || !str_contains($email, '@')) return '***@***';
    [$local, $domain] = explode('@', $email, 2);
    $localMasked = mb_substr($local, 0, 1) . str_repeat('*', max(3, mb_strlen($local) - 1));
    $domainParts = explode('.', $domain);
    $main = $domainParts[0] ?? 'mail';
    $tld = count($domainParts) > 1 ? '.' . end($domainParts) : '';
    return $localMasked . '@' . mb_substr($main, 0, 1) . str_repeat('*', max(3, mb_strlen($main) - 1)) . $tld;
};
?>
<div class="admin-users-final">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="page-title">Kelola User</h2>
            <p class="page-subtitle">User hanya dapat dilihat atau diedit. Fitur hapus user dinonaktifkan agar histori donasi, campaign, dan invoice tetap aman.</p>
        </div>
    </div>

    <div class="notice-card mb-4">
        <i class="fa-solid fa-shield-halved mt-1"></i>
        <div>Keamanan data aktif: tombol hapus user dihilangkan. Untuk menonaktifkan akun, gunakan tombol edit lalu ubah status akun menjadi Nonaktif.</div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6"><div class="stat-card"><div><small>Total User</small><h3><?= number_format((int)($stats['total'] ?? 0),0,',','.') ?></h3></div><div class="stat-icon blue"><i class="fa-solid fa-users"></i></div></div></div>
        <div class="col-xl-3 col-md-6"><div class="stat-card"><div><small>Yayasan</small><h3><?= number_format((int)($stats['yayasan'] ?? 0),0,',','.') ?></h3></div><div class="stat-icon green"><i class="fa-solid fa-building-user"></i></div></div></div>
        <div class="col-xl-3 col-md-6"><div class="stat-card"><div><small>Donatur</small><h3><?= number_format((int)($stats['donatur'] ?? 0),0,',','.') ?></h3></div><div class="stat-icon orange"><i class="fa-solid fa-hand-holding-heart"></i></div></div></div>
        <div class="col-xl-3 col-md-6"><div class="stat-card"><div><small>Nonaktif</small><h3><?= number_format((int)($stats['nonaktif'] ?? 0),0,',','.') ?></h3></div><div class="stat-icon red"><i class="fa-solid fa-user-slash"></i></div></div></div>
    </div>

    <?php if(session()->getFlashdata('success')): ?><div class="alert alert-success rounded-4"><?= esc(session()->getFlashdata('success')) ?></div><?php endif; ?>
    <?php if(session()->getFlashdata('error')): ?><div class="alert alert-danger rounded-4"><?= esc(session()->getFlashdata('error')) ?></div><?php endif; ?>

    <form method="get" class="filter-card mb-4">
        <div class="row g-3 align-items-end">
            <div class="col-lg-5"><label class="form-label fw-bold">Cari User</label><input type="text" name="keyword" class="form-control" placeholder="Nama, email, atau nomor HP..." value="<?= esc($keyword ?? '') ?>"></div>
            <div class="col-lg-2"><label class="form-label fw-bold">Role</label><select name="role" class="form-select"><option value="">Semua</option><option value="admin" <?= ($role ?? '') === 'admin' ? 'selected' : '' ?>>Admin</option><option value="yayasan" <?= ($role ?? '') === 'yayasan' ? 'selected' : '' ?>>Yayasan</option><option value="donatur" <?= ($role ?? '') === 'donatur' ? 'selected' : '' ?>>Donatur</option></select></div>
            <div class="col-lg-2"><label class="form-label fw-bold">Status</label><select name="status" class="form-select"><option value="">Semua</option><option value="1" <?= (string)($status ?? '') === '1' ? 'selected' : '' ?>>Aktif</option><option value="0" <?= (string)($status ?? '') === '0' ? 'selected' : '' ?>>Nonaktif</option></select></div>
            <div class="col-lg-3 d-flex gap-2"><button type="submit" class="btn btn-primary flex-fill" title="Filter"><i class="fa-solid fa-magnifying-glass"></i></button><a href="<?= base_url('admin/users') ?>" class="btn btn-light px-4" title="Reset"><i class="fa-solid fa-rotate-left"></i></a></div>
        </div>
    </form>

    <div class="list-card">
        <div class="d-flex justify-content-between align-items-center gap-3 mb-3">
            <h4 class="fw-bold mb-0">Daftar User</h4>
            <span class="text-muted small"><?= (int)$perPage ?> data per halaman</span>
        </div>
        <div class="user-head"><div>No</div><div>User</div><div>Role</div><div>Status</div><div>Aksi</div></div>
        <?php if(!empty($users)): ?>
            <?php $no = $startNo; foreach($users as $user): ?>
                <?php
                    $userRole = strtolower((string)($user['role'] ?? '-'));
                    $emailText = $userRole === 'donatur' ? $maskEmail($user['email'] ?? '') : ($user['email'] ?? '-');
                    $isActive = (int)($user['is_active'] ?? 0) === 1;
                ?>
                <div class="user-row">
                    <div><?= $no++ ?></div>
                    <div class="user-identity">
                        <div class="user-avatar"><?= strtoupper(substr($user['nama'] ?? 'U', 0, 1)) ?></div>
                        <div class="min-w-0">
                            <strong><?= esc($user['nama'] ?? '-') ?></strong>
                            <small><?= esc($emailText) ?></small>
                            <div class="user-meta-mobile">
                                <span class="badge-soft dark"><?= esc(ucfirst($userRole)) ?></span>
                                <span class="badge-soft <?= $isActive ? 'success' : 'danger' ?>"><i class="fa-solid <?= $isActive ? 'fa-circle-check' : 'fa-circle-xmark' ?>"></i> <?= $isActive ? 'Aktif' : 'Nonaktif' ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="role-cell"><span class="badge-soft dark"><?= esc(ucfirst($userRole)) ?></span></div>
                    <div class="status-cell"><span class="badge-soft <?= $isActive ? 'success' : 'danger' ?>"><i class="fa-solid <?= $isActive ? 'fa-circle-check' : 'fa-circle-xmark' ?>"></i> <?= $isActive ? 'Aktif' : 'Nonaktif' ?></span></div>
                    <div class="actions">
                        <a href="<?= base_url('admin/users/detail/'.$user['id']) ?>" class="icon-btn icon-detail" title="Detail" aria-label="Detail"><i class="fa-solid fa-eye"></i></a>
                        <a href="<?= base_url('admin/users/edit/'.$user['id']) ?>" class="icon-btn icon-edit" title="Edit" aria-label="Edit"><i class="fa-solid fa-pen"></i></a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="empty-state"><i class="fa-solid fa-user-group fa-2x mb-3"></i><h5 class="fw-bold">Tidak ada data user</h5><p class="mb-0">Coba ubah filter pencarian.</p></div>
        <?php endif; ?>
        <?php if(isset($pager)): ?><div class="mt-3"><?= $pager->links('users', 'default_full') ?></div><?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>
