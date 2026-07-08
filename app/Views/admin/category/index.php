<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<style>
.admin-category-page .page-title { font-weight: 900; color: #0f172a; margin-bottom: 4px; }
.admin-category-page .page-subtitle { color: #64748b; margin-bottom: 0; }
.admin-category-page .toolbar-card,
.admin-category-page .category-card {
    background: #ffffff;
    border-radius: 24px;
    box-shadow: 0 12px 30px rgba(15, 23, 42, .07);
    border: 1px solid #eef2f7;
}
.admin-category-page .toolbar-card { padding: 20px; }
.admin-category-page .category-card { padding: 24px; height: 100%; transition: .25s; }
.admin-category-page .category-card:hover { transform: translateY(-4px); }
.admin-category-page .category-icon {
    width: 62px;
    height: 62px;
    border-radius: 20px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: #eef2ff;
    color: #2563eb;
    font-size: 26px;
}
.admin-category-page .category-title { color: #0f172a; font-weight: 900; margin: 18px 0 8px; }
.admin-category-page .category-desc { color: #64748b; line-height: 1.7; min-height: 52px; }
.admin-category-page .badge-soft {
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
.admin-category-page .category-action { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 20px; }
.admin-category-page .category-action form { display: inline-flex; margin: 0; }
.admin-category-page .btn-action {
    border: none;
    border-radius: 14px;
    padding: 10px 14px;
    font-weight: 900;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
}
.admin-category-page .btn-create { background: linear-gradient(135deg, #2563eb, #4f46e5); color: #ffffff; border-radius: 16px; padding: 12px 18px; font-weight: 900; text-decoration: none; }
.admin-category-page .btn-edit { background: #facc15; color: #111827; }
.admin-category-page .btn-delete { background: #e11d48; color: #ffffff; }
.admin-category-page .btn-locked { background: #e2e8f0; color: #64748b; cursor: not-allowed; }
.admin-category-page .empty-state {
    background: #ffffff;
    border-radius: 26px;
    padding: 54px 20px;
    text-align: center;
    color: #64748b;
    box-shadow: 0 14px 34px rgba(15, 23, 42, .08);
}
.admin-category-popup-overlay {
    position: fixed;
    inset: 0;
    background: rgba(15, 23, 42, .45);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 99999;
}
.admin-category-popup-box {
    width: 380px;
    max-width: 90%;
    background: #ffffff;
    border-radius: 24px;
    padding: 28px;
    text-align: center;
    box-shadow: 0 24px 70px rgba(0,0,0,.20);
}
.admin-category-popup-icon {
    width: 66px;
    height: 66px;
    margin: 0 auto 16px;
    border-radius: 50%;
    color: #ffffff;
    font-size: 34px;
    font-weight: 900;
    display: flex;
    align-items: center;
    justify-content: center;
}
.admin-category-popup-icon.success { background: #22c55e; }
.admin-category-popup-icon.error { background: #ef4444; }
.admin-category-popup-box h4 { margin-bottom: 8px; font-weight: 900; }
.admin-category-popup-box p { color: #64748b; margin-bottom: 20px; }
.admin-category-popup-box button { border: none; background: #2563eb; color: #ffffff; padding: 10px 30px; border-radius: 14px; font-weight: 800; }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php
    $categories = $categories ?? [];
    $campaignCount = $campaignCount ?? [];
?>

<div class="admin-category-page">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="page-title">Kategori Donasi</h2>
            <p class="page-subtitle">Kelola kategori yang digunakan pada pengajuan campaign donasi.</p>
        </div>
        <a href="<?= base_url('admin/category/create') ?>" class="btn-create">
            <i class="fa-solid fa-plus me-1"></i> Tambah Kategori
        </a>
    </div>

    <form method="get" class="toolbar-card mb-4">
        <div class="row g-3 align-items-end">
            <div class="col-lg-9">
                <label class="form-label fw-bold">Cari Kategori</label>
                <input type="text" name="keyword" class="form-control" placeholder="Cari nama kategori atau deskripsi..." value="<?= esc($keyword ?? '') ?>">
            </div>
            <div class="col-lg-3 d-flex gap-2">
                <button class="btn btn-primary flex-fill" type="submit">
                    <i class="fa-solid fa-magnifying-glass me-1"></i> Filter
                </button>
                <a href="<?= base_url('admin/category') ?>" class="btn btn-light">Reset</a>
            </div>
        </div>
    </form>

    <?php if (empty($categories)): ?>
        <div class="empty-state">
            <i class="fa-solid fa-tags fa-3x mb-3"></i>
            <h4 class="fw-bold">Belum ada kategori</h4>
            <p class="mb-0">Tambahkan kategori donasi agar yayasan dapat memilih kategori campaign.</p>
        </div>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach ($categories as $category): ?>
                <?php
                    $usedCount = (int) ($campaignCount[$category['id']] ?? 0);
                    $icon = trim((string) ($category['icon'] ?? '')) ?: 'fa-solid fa-tag';
                    if (!str_contains($icon, 'fa-')) {
                        $icon = 'fa-solid fa-tag';
                    }
                ?>
                <div class="col-xl-4 col-lg-6">
                    <div class="category-card">
                        <div class="category-icon">
                            <i class="<?= esc($icon) ?>"></i>
                        </div>
                        <h4 class="category-title"><?= esc($category['nama_kategori'] ?? '-') ?></h4>
                        <p class="category-desc"><?= esc($category['deskripsi'] ?? 'Belum ada deskripsi kategori.') ?></p>

                        <span class="badge-soft">
                            <i class="fa-solid fa-bullhorn"></i>
                            <?= number_format($usedCount, 0, ',', '.') ?> Campaign
                        </span>

                        <div class="category-action">
                            <a href="<?= base_url('admin/category/edit/' . $category['id']) ?>" class="btn-action btn-edit">
                                <i class="fa-solid fa-pen"></i> Edit
                            </a>

                            <?php if ($usedCount > 0): ?>
                                <button type="button" class="btn-action btn-locked" disabled title="Kategori sudah digunakan campaign, tidak boleh dihapus.">
                                    <i class="fa-solid fa-lock"></i> Hapus
                                </button>
                            <?php else: ?>
                                <form action="<?= base_url('admin/category/delete/' . $category['id']) ?>" method="post" class="js-confirm-form" data-title="Hapus Kategori" data-message="Kategori akan dihapus dan tidak dapat dikembalikan." data-confirm-text="Ya, Hapus" data-confirm-class="btn-danger">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn-action btn-delete">
                                        <i class="fa-solid fa-trash"></i> Hapus
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<div class="modal fade" id="adminCategoryConfirmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-5 overflow-hidden">
            <div class="modal-body p-4 text-center">
                <div class="mx-auto mb-3 rounded-circle d-inline-flex align-items-center justify-content-center" style="width:64px;height:64px;background:#eef2ff;color:#2563eb;font-size:28px;">
                    <i class="fa-solid fa-circle-question"></i>
                </div>
                <h4 class="mb-2" data-confirm-title style="font-weight:900;color:#0f172a;">Konfirmasi Aksi</h4>
                <p class="text-muted mb-4" data-confirm-message>Apakah Anda yakin ingin melanjutkan proses ini?</p>
                <div class="d-flex justify-content-center gap-2 flex-wrap">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary px-4" data-confirm-submit>Ya, Lanjutkan</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
let pendingAdminCategoryForm = null;

function showAdminCategoryPopup(type, message) {
    const oldPopup = document.querySelector('.admin-category-popup-overlay');
    if (oldPopup) oldPopup.remove();

    const overlay = document.createElement('div');
    overlay.className = 'admin-category-popup-overlay';
    overlay.innerHTML = `
        <div class="admin-category-popup-box">
            <div class="admin-category-popup-icon ${type}">${type === 'success' ? '✓' : '!'}</div>
            <h4>${type === 'success' ? 'Berhasil' : 'Gagal'}</h4>
            <p>${message}</p>
            <button type="button" onclick="this.closest('.admin-category-popup-overlay').remove()">Oke</button>
        </div>
    `;
    document.body.appendChild(overlay);
}

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.js-confirm-form').forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (form.dataset.confirmed === '1') return;
            event.preventDefault();
            pendingAdminCategoryForm = form;

            const modal = document.getElementById('adminCategoryConfirmModal');
            modal.querySelector('[data-confirm-title]').textContent = form.dataset.title || 'Konfirmasi Aksi';
            modal.querySelector('[data-confirm-message]').textContent = form.dataset.message || 'Apakah Anda yakin ingin melanjutkan proses ini?';
            const submit = modal.querySelector('[data-confirm-submit]');
            submit.textContent = form.dataset.confirmText || 'Ya, Lanjutkan';
            submit.className = 'btn px-4 ' + (form.dataset.confirmClass || 'btn-primary');

            bootstrap.Modal.getOrCreateInstance(modal).show();
        });
    });

    const submit = document.querySelector('#adminCategoryConfirmModal [data-confirm-submit]');
    if (submit) {
        submit.addEventListener('click', function () {
            if (!pendingAdminCategoryForm) return;
            pendingAdminCategoryForm.dataset.confirmed = '1';
            bootstrap.Modal.getOrCreateInstance(document.getElementById('adminCategoryConfirmModal')).hide();
            pendingAdminCategoryForm.submit();
        });
    }
});
</script>

<?php if (session()->getFlashdata('success')): ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    showAdminCategoryPopup('success', '<?= esc(session()->getFlashdata('success')) ?>');
});
</script>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    showAdminCategoryPopup('error', '<?= esc(session()->getFlashdata('error')) ?>');
});
</script>
<?php endif; ?>
<?= $this->endSection() ?>
