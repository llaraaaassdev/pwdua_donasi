<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<style>
.admin-campaign-form .form-card {
    background: #ffffff;
    border-radius: 28px;
    padding: 30px;
    box-shadow: 0 14px 34px rgba(15, 23, 42, .08);
    border: 1px solid #eef2f7;
}

.admin-campaign-form .preview-card {
    background: linear-gradient(180deg, #ffffff, #f8fafc);
    border-radius: 28px;
    padding: 24px;
    box-shadow: 0 14px 34px rgba(15, 23, 42, .08);
    border: 1px solid #eef2f7;
    position: sticky;
    top: 116px;
}

.admin-campaign-form label {
    font-weight: 900;
    color: #1e293b;
    margin-bottom: 8px;
}

.admin-campaign-form .form-control,
.admin-campaign-form .form-select {
    border-radius: 18px;
    min-height: 54px;
    border-color: #e2e8f0;
}

.admin-campaign-form textarea.form-control {
    min-height: 150px;
}

.admin-campaign-form .preview-image {
    width: 100%;
    height: 240px;
    object-fit: cover;
    border-radius: 22px;
    background: #e2e8f0;
}

.admin-campaign-form .btn-main {
    border: none;
    border-radius: 18px;
    padding: 14px 22px;
    background: linear-gradient(135deg, #2563eb, #4f46e5);
    color: #ffffff;
    font-weight: 900;
}

.admin-campaign-form .btn-back {
    border: none;
    border-radius: 18px;
    padding: 14px 22px;
    background: #f8fafc;
    color: #0f172a;
    font-weight: 900;
    text-decoration: none;
}
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="admin-campaign-form">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1">Tambah Campaign</h2>
            <p class="text-muted mb-0">Buat campaign dari sisi admin dengan tampilan yang sama rapi seperti dashboard yayasan.</p>
        </div>
    </div>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger rounded-4 mb-4"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <form action="<?= base_url('admin/campaign/store') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="form-card">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label>Yayasan <span class="text-danger">*</span></label>
                            <select name="foundation_id" class="form-select" required>
                                <option value="">Pilih Yayasan</option>
                                <?php foreach (($foundations ?? []) as $foundation): ?>
                                    <option value="<?= $foundation['id'] ?>" <?= old('foundation_id') == $foundation['id'] ? 'selected' : '' ?>>
                                        <?= esc($foundation['nama_yayasan'] ?? '-') ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label>Kategori <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-select" required>
                                <option value="">Pilih Kategori</option>
                                <?php foreach (($categories ?? []) as $category): ?>
                                    <option value="<?= $category['id'] ?>" <?= old('category_id') == $category['id'] ? 'selected' : '' ?>>
                                        <?= esc($category['nama_kategori'] ?? '-') ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-12">
                            <label>Judul Campaign <span class="text-danger">*</span></label>
                            <input type="text" name="judul" id="judulInput" class="form-control" value="<?= esc(old('judul')) ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label>Target Dana <span class="text-danger">*</span></label>
                            <input type="number" name="target_dana" id="targetInput" class="form-control" value="<?= esc(old('target_dana')) ?>" min="1" required>
                        </div>

                        <div class="col-md-6">
                            <label>Lokasi</label>
                            <input type="text" name="lokasi" class="form-control" value="<?= esc(old('lokasi')) ?>" placeholder="Contoh: Jakarta">
                        </div>

                        <div class="col-md-6">
                            <label>Tanggal Mulai <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_mulai" class="form-control" value="<?= esc(old('tanggal_mulai')) ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label>Tanggal Berakhir <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_berakhir" class="form-control" value="<?= esc(old('tanggal_berakhir')) ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label>Status Campaign</label>
                            <select name="status" class="form-select">
                                <option value="aktif" <?= old('status', 'aktif') === 'aktif' ? 'selected' : '' ?>>Aktif</option>
                                <option value="draft" <?= old('status') === 'draft' ? 'selected' : '' ?>>Draft</option>
                                <option value="selesai" <?= old('status') === 'selesai' ? 'selected' : '' ?>>Selesai</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label>Status Verifikasi</label>
                            <select name="status_verifikasi" class="form-select">
                                <option value="approved" <?= old('status_verifikasi', 'approved') === 'approved' ? 'selected' : '' ?>>Disetujui</option>
                                <option value="pending" <?= old('status_verifikasi') === 'pending' ? 'selected' : '' ?>>Menunggu Verifikasi</option>
                                <option value="rejected" <?= old('status_verifikasi') === 'rejected' ? 'selected' : '' ?>>Ditolak</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label>Deskripsi Campaign <span class="text-danger">*</span></label>
                            <textarea name="deskripsi" class="form-control" required><?= esc(old('deskripsi')) ?></textarea>
                        </div>

                        <div class="col-12">
                            <label>Gambar Campaign</label>
                            <input type="file" name="gambar" id="gambarInput" class="form-control" accept="image/*">
                            <small class="text-muted">Opsional. Format JPG, JPEG, PNG, WEBP. Maksimal 5MB.</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="preview-card">
                    <img id="imagePreview" src="<?= base_url('assets/img/default-campaign.jpg') ?>" class="preview-image" alt="Preview Campaign">

                    <h4 class="fw-bold mt-4 mb-2" id="titlePreview">Judul Campaign</h4>
                    <p class="text-muted mb-3">Preview singkat campaign yang akan dibuat.</p>

                    <div class="progress mb-3" style="height:10px;border-radius:999px;">
                        <div class="progress-bar" style="width:0%"></div>
                    </div>

                    <strong class="d-block fs-4">Rp 0</strong>
                    <small class="text-muted" id="targetPreview">dari Rp 0</small>

                    <div class="d-flex gap-2 mt-4">
                        <a href="<?= base_url('admin/campaign') ?>" class="btn-back flex-fill text-center">
                            <i class="fa-solid fa-arrow-left me-2"></i>
                            Kembali
                        </a>
                        <button type="submit" class="btn-main flex-fill">
                            <i class="fa-solid fa-floppy-disk me-2"></i>
                            Simpan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
const judulInput = document.getElementById('judulInput');
const titlePreview = document.getElementById('titlePreview');
const targetInput = document.getElementById('targetInput');
const targetPreview = document.getElementById('targetPreview');
const gambarInput = document.getElementById('gambarInput');
const imagePreview = document.getElementById('imagePreview');

function formatRupiah(value) {
    const number = parseInt(value || 0, 10);
    return 'Rp ' + number.toLocaleString('id-ID');
}

judulInput?.addEventListener('input', function () {
    titlePreview.textContent = this.value || 'Judul Campaign';
});

targetInput?.addEventListener('input', function () {
    targetPreview.textContent = 'dari ' + formatRupiah(this.value);
});

gambarInput?.addEventListener('change', function () {
    const file = this.files && this.files[0];

    if (!file) {
        return;
    }

    const reader = new FileReader();
    reader.onload = e => imagePreview.src = e.target.result;
    reader.readAsDataURL(file);
});
</script>
<?= $this->endSection() ?>
