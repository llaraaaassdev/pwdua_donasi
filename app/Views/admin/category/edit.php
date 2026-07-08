<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<style>
.admin-category-form .form-card,
.admin-category-form .info-card {
    background: #ffffff;
    border-radius: 26px;
    padding: 30px;
    box-shadow: 0 14px 34px rgba(15, 23, 42, .08);
    border: 1px solid #eef2f7;
}
.admin-category-form .preview-icon {
    width: 76px;
    height: 76px;
    border-radius: 24px;
    background: #eef2ff;
    color: #2563eb;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 34px;
}
.admin-category-form .btn-save {
    background: linear-gradient(135deg, #2563eb, #4f46e5);
    color: #ffffff;
    border: none;
    border-radius: 16px;
    padding: 12px 18px;
    font-weight: 900;
}
.admin-category-form .btn-back {
    background: #f8fafc;
    color: #0f172a;
    border-radius: 16px;
    padding: 12px 18px;
    font-weight: 900;
    text-decoration: none;
}
.admin-category-form .badge-soft {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 8px 12px;
    border-radius: 999px;
    font-weight: 900;
    font-size: 12px;
    background: #dcfce7;
    color: #15803d;
}
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php
    $category = $category ?? [];
    $iconValue = old('icon') ?: ($category['icon'] ?? 'fa-solid fa-tag');
?>

<div class="admin-category-form">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1">Edit Kategori Donasi</h2>
            <p class="text-muted mb-0">Perbarui data kategori donasi tanpa merusak data campaign.</p>
        </div>
        <span class="badge-soft">
            <i class="fa-solid fa-bullhorn"></i>
            <?= number_format((int) ($campaignCount ?? 0), 0, ',', '.') ?> Campaign memakai kategori ini
        </span>
    </div>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger rounded-4">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <div class="form-card">
        <form action="<?= base_url('admin/category/update/' . ($category['id'] ?? 0)) ?>" method="post">
            <?= csrf_field() ?>

            <div class="text-center mb-4">
                <div class="preview-icon">
                    <i id="iconPreview" class="<?= esc($iconValue ?: 'fa-solid fa-tag') ?>"></i>
                </div>
                <p class="text-muted mt-3 mb-0">Preview icon kategori</p>
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Nama Kategori <span class="text-danger">*</span></label>
                    <input type="text" name="nama_kategori" class="form-control" value="<?= esc(old('nama_kategori') ?: ($category['nama_kategori'] ?? '')) ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Icon Font Awesome</label>
                    <input type="text" name="icon" id="iconInput" class="form-control" value="<?= esc($iconValue ?: 'fa-solid fa-tag') ?>">
                    <small class="text-muted">Gunakan class Font Awesome, misalnya <b>fa-solid fa-graduation-cap</b>.</small>
                </div>
                <div class="col-12">
                    <label class="form-label fw-bold">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="5"><?= esc(old('deskripsi') ?: ($category['deskripsi'] ?? '')) ?></textarea>
                </div>
            </div>

            <div class="d-flex flex-wrap gap-2 mt-4">
                <a href="<?= base_url('admin/category') ?>" class="btn-back">
                    <i class="fa-solid fa-arrow-left me-1"></i> Kembali
                </a>
                <button type="submit" class="btn-save">
                    <i class="fa-solid fa-floppy-disk me-1"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('iconInput');
    const preview = document.getElementById('iconPreview');

    if (input && preview) {
        input.addEventListener('input', function () {
            preview.className = input.value.trim() || 'fa-solid fa-tag';
        });
    }
});
</script>
<?= $this->endSection() ?>
