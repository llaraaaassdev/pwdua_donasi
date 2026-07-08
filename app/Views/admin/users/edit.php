<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<style>
    .admin-user-edit-final{max-width:100%;overflow:hidden}.admin-user-edit-final .form-card,.admin-user-edit-final .help-card{background:#fff;border:1px solid #edf2f7;border-radius:26px;box-shadow:0 16px 42px rgba(15,23,42,.07)}.admin-user-edit-final .form-card{padding:26px}.admin-user-edit-final .form-label{font-weight:900;color:#0f172a}.admin-user-edit-final .help-card{padding:16px 18px;background:#f8fafc;color:#64748b;box-shadow:none}.admin-user-edit-final .icon-btn{width:44px;height:44px;border:0;border-radius:14px;text-decoration:none;display:inline-flex;align-items:center;justify-content:center;font-size:16px;transition:.2s}.admin-user-edit-final .icon-btn:hover{transform:translateY(-2px)}.admin-user-edit-final .icon-back{background:#f1f5f9;color:#0f172a}.admin-user-edit-final .save-btn{border:0;border-radius:16px;background:linear-gradient(135deg,#2563eb,#4f46e5);color:#fff;font-weight:950;padding:12px 20px;display:inline-flex;align-items:center;gap:8px}@media(max-width:768px){.admin-user-edit-final .form-card{padding:20px}}
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php
$protectionInfo = $protectionInfo ?? [];
$isRoleLocked = !empty($protectionInfo['protected']) && strtolower((string)($user['role'] ?? '')) === 'yayasan';
?>
<div class="admin-user-edit-final">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1">Edit User</h2>
            <p class="text-muted mb-0">Perbarui data dasar user tanpa mengubah alur verifikasi yayasan.</p>
        </div>
        <a href="<?= base_url('admin/users') ?>" class="icon-btn icon-back" title="Kembali"><i class="fa-solid fa-arrow-left"></i></a>
    </div>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger rounded-4">
            <?= esc(session()->getFlashdata('error')) ?>
        </div>
    <?php endif; ?>

    <?php if(session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger rounded-4">
            <?php foreach(session()->getFlashdata('errors') as $error): ?><div><?= esc($error) ?></div><?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="form-card">
        <form action="<?= base_url('admin/users/update/'.$user['id']) ?>" method="post">
            <?= csrf_field(); ?>
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label">Nama</label><input type="text" name="nama" class="form-control" value="<?= old('nama', $user['nama'] ?? '') ?>" required></div>
                <div class="col-md-6"><label class="form-label">Email</label><input type="email" name="email" class="form-control" value="<?= old('email', $user['email'] ?? '') ?>" required></div>
                <div class="col-md-6"><label class="form-label">No HP</label><input type="text" name="no_hp" class="form-control" value="<?= old('no_hp', $user['no_hp'] ?? '') ?>"></div>
                <div class="col-md-3"><label class="form-label">Role</label><?php if($isRoleLocked): ?><input type="hidden" name="role" value="yayasan"><select class="form-select" disabled><option selected>Yayasan</option></select><small class="text-muted d-block mt-2"><i class="fa-solid fa-lock me-1"></i>Role dikunci karena yayasan masih memiliki campaign aktif atau data donasi.</small><?php else: ?><select name="role" class="form-select" required><option value="admin" <?= old('role', $user['role'] ?? '') === 'admin' ? 'selected' : '' ?>>Admin</option><option value="yayasan" <?= old('role', $user['role'] ?? '') === 'yayasan' ? 'selected' : '' ?>>Yayasan</option><option value="donatur" <?= old('role', $user['role'] ?? '') === 'donatur' ? 'selected' : '' ?>>Donatur</option></select><?php endif; ?></div>
                <div class="col-md-3"><label class="form-label">Status Akun</label><select name="is_active" class="form-select" required><option value="1" <?= (string) old('is_active', $user['is_active'] ?? '') === '1' ? 'selected' : '' ?>>Aktif</option><option value="0" <?= (string) old('is_active', $user['is_active'] ?? '') === '0' ? 'selected' : '' ?>>Nonaktif</option></select></div>
                <div class="col-12"><div class="help-card"><i class="fa-solid fa-circle-info me-1"></i>Untuk yayasan, profil resmi tetap dikelola melalui menu Kelola Yayasan dan perubahan profil mengikuti verifikasi admin.</div></div>
            </div>
            <div class="mt-4"><button type="submit" class="save-btn"><i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan</button></div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
