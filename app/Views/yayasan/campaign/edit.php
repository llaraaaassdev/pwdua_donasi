<?= $this->extend('yayasan/layouts/main') ?>

<?= $this->section('content') ?>

<link rel="stylesheet" href="<?= base_url('assets/css/campaign_create.css') ?>">

<div class="campaign-create-page">

    <div class="page-header">

        <div>
            <h2 class="page-title">Edit Kampanye</h2>
            <p class="page-subtitle">
                Perbarui informasi Kampanye dan kelola gambar Kampanye.
            </p>
        </div>

        <a href="<?= base_url('yayasan/campaign/index') ?>" class="btn btn-light back-btn">
            <i class="fa-solid fa-arrow-left"></i>
            Kembali
        </a>

    </div>

    <div class="create-card">

        <form
            action="<?= base_url('yayasan/campaign/update/' . $campaign['id']) ?>"
            method="post"
            enctype="multipart/form-data"
            id="campaignEditForm">

            <?= csrf_field(); ?>

            <div class="row">

                <div class="col-lg-8">

                    <div class="form-section">

                        <h5>
                            <i class="fa-solid fa-circle-info"></i>
                            Informasi Campaign
                        </h5>

                        <div class="form-group">
                            <label>Judul Campaign</label>
                            <input
                                type="text"
                                name="judul"
                                value="<?= old('judul', $campaign['judul']) ?>"
                                class="form-control"
                                placeholder="Contoh : Bantuan Pendidikan Anak Yatim"
                                required>
                        </div>

                        <div class="form-group">
                            <label>Kategori</label>
                            <select name="category_id" class="form-select" required>
                                <option value="">Pilih Kategori</option>

                                <?php foreach ($categories as $category): ?>
                                    <option
                                        value="<?= $category['id'] ?>"
                                        <?= old('category_id', $campaign['category_id']) == $category['id'] ? 'selected' : '' ?>>
                                        <?= esc($category['nama_kategori']) ?>
                                    </option>
                                <?php endforeach; ?>

                            </select>
                        </div>

                        <div class="form-group">
                            <label>Deskripsi Campaign</label>
                            <textarea
                                name="deskripsi"
                                rows="8"
                                class="form-control"
                                placeholder="Ceritakan tujuan campaign secara lengkap..."
                                required><?= old('deskripsi', $campaign['deskripsi']) ?></textarea>
                        </div>

                    </div>

                    <div class="form-section mt-4">

                        <h5>
                            <i class="fa-solid fa-hand-holding-dollar"></i>
                            Target Penggalangan Dana
                        </h5>

                        <div class="form-group">
                            <label>Target Donasi</label>

                            <div class="input-group">
                                <span class="input-group-text">Rp</span>

                                <input
                                    type="text"
                                    id="target_dana_display"
                                    class="form-control rupiah"
                                    value="<?= number_format((float) old('target_dana', $campaign['target_dana']), 0, ',', '.') ?>"
                                    placeholder="Contoh : 50.000.000"
                                    autocomplete="off">

                                <input
                                    type="hidden"
                                    name="target_dana"
                                    id="target_real"
                                    value="<?= old('target_dana', $campaign['target_dana']) ?>">
                            </div>

                            <small class="text-muted">
                                Masukkan target dana yang ingin dicapai.
                            </small>
                        </div>

                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tanggal Mulai</label>
                                    <input
                                        type="date"
                                        name="tanggal_mulai"
                                        class="form-control"
                                        id="tanggal_mulai"
                                        value="<?= old('tanggal_mulai', $campaign['tanggal_mulai']) ?>"
                                        required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tanggal Berakhir</label>
                                    <input
                                        type="date"
                                        name="tanggal_berakhir"
                                        class="form-control"
                                        id="tanggal_berakhir"
                                        value="<?= old('tanggal_berakhir', $campaign['tanggal_berakhir']) ?>"
                                        required>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

                <div class="col-lg-4">

                    <div class="upload-card">

                        <h5>
                            <i class="fa-solid fa-images"></i>
                            Gambar Campaign
                        </h5>

                        <p class="upload-desc">
                            Tambahkan gambar baru untuk melengkapi gallery campaign.
                            Gambar lama tetap tersimpan selama tidak dihapus.
                        </p>

                        <?php if (!empty($campaignImages)): ?>

                            <div class="current-gallery">

                                <label class="mb-2 d-block">
                                    Gambar Saat Ini
                                </label>

                                <div class="preview-gallery" style="display:grid; grid-template-columns:repeat(auto-fill,minmax(90px,1fr)); gap:10px;">

                                    <?php foreach ($campaignImages as $image): ?>

                                        <div style="position:relative; border-radius:12px; overflow:hidden; border:1px solid #e5e7eb; background:#f8fafc;">

                                            <img
                                                src="<?= base_url('uploads/campaign/' . $image['image']) ?>"
                                                alt="Gambar Campaign"
                                                style="width:100%; height:90px; object-fit:cover; display:block;">

                                            <?php if ((int) $image['is_cover'] === 1): ?>
                                                <span style="position:absolute; top:6px; left:6px; font-size:11px; padding:3px 7px; border-radius:999px; background:#0d6efd; color:#fff; font-weight:600;">
                                                    Cover
                                                </span>
                                            <?php endif; ?>

                                            <label style="position:absolute; right:6px; bottom:6px; background:#ef4444; color:white; padding:4px 7px; border-radius:8px; font-size:11px; cursor:pointer;">
                                                <input
                                                    type="checkbox"
                                                    name="hapus_gambar[]"
                                                    value="<?= $image['id'] ?>"
                                                    style="margin-right:3px;">
                                                Hapus
                                            </label>

                                        </div>

                                    <?php endforeach; ?>

                                </div>

                            </div>

                            <hr>

                        <?php elseif (!empty($campaign['gambar'])): ?>

                            <div class="current-gallery">

                                <label class="mb-2 d-block">
                                    Gambar Saat Ini
                                </label>

                                <div style="position:relative; border-radius:16px; overflow:hidden; border:1px solid #e5e7eb;">
                                    <img
                                        src="<?= base_url('uploads/campaign/' . $campaign['gambar']) ?>"
                                        alt="Gambar Campaign"
                                        style="width:100%; height:180px; object-fit:cover; display:block;">

                                    <span style="position:absolute; top:10px; left:10px; font-size:12px; padding:4px 9px; border-radius:999px; background:#0d6efd; color:#fff; font-weight:600;">
                                        Cover
                                    </span>
                                </div>

                            </div>

                            <hr>

                        <?php endif; ?>

                        <label class="upload-box" id="uploadBox">

                            <input
                                type="file"
                                name="gambar[]"
                                id="gambar"
                                accept="image/*"
                                multiple
                                hidden>

                            <div class="upload-content" id="uploadContent">
                                <i class="fa-solid fa-cloud-arrow-up upload-icon"></i>

                                <h6>Pilih Gambar Baru</h6>

                                <small>
                                    JPG, JPEG, PNG
                                    <br>
                                    Maksimal 2 MB per gambar
                                </small>
                            </div>

                        </label>

                        <div
                            id="previewGallery"
                            class="preview-gallery"
                            style="display:none; margin-top:15px;">
                        </div>

                        <small class="text-muted d-block mt-2">
                            Anda dapat memilih lebih dari satu gambar sekaligus.
                        </small>

                    </div>

                    <div class="tips-card">

                        <h5>
                            <i class="fa-solid fa-lightbulb"></i>
                            Catatan Edit
                        </h5>

                        <ul>
                            <li>Gambar pertama akan menjadi cover jika belum ada cover.</li>
                            <li>Campaign yang sudah disetujui tidak boleh dihapus.</li>
                            <li>Pastikan tanggal selesai lebih besar dari tanggal mulai.</li>
                            <li>Perubahan campaign dapat diperiksa kembali oleh Admin.</li>
                        </ul>

                    </div>

                </div>

            </div>

            <div class="form-footer">

                <a
                    href="<?= base_url('yayasan/campaign/index') ?>"
                    class="btn btn-light btn-lg">
                    <i class="fa-solid fa-arrow-left"></i>
                    Batal
                </a>

                <button
                    type="submit"
                    class="btn btn-primary btn-lg">
                    <i class="fa-solid fa-floppy-disk"></i>
                    Simpan Perubahan
                </button>

            </div>

        </form>

    </div>

</div>

<style>
.campaign-popup-overlay {
    position: fixed;
    inset: 0;
    background: rgba(15, 23, 42, 0.45);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 99999;
}

.campaign-popup-box {
    width: 360px;
    max-width: 90%;
    background: #fff;
    border-radius: 22px;
    padding: 28px;
    text-align: center;
    box-shadow: 0 20px 60px rgba(0,0,0,.18);
}

.campaign-popup-icon {
    width: 64px;
    height: 64px;
    margin: 0 auto 16px;
    border-radius: 50%;
    color: #fff;
    font-size: 34px;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
}

.campaign-popup-icon.success {
    background: #22c55e;
}

.campaign-popup-icon.error {
    background: #ef4444;
}

.campaign-popup-box h4 {
    margin-bottom: 8px;
    font-weight: 700;
}

.campaign-popup-box p {
    color: #64748b;
    margin-bottom: 20px;
}

.campaign-popup-box button {
    border: none;
    background: #2563eb;
    color: white;
    padding: 10px 28px;
    border-radius: 12px;
    font-weight: 600;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('campaignEditForm');
    const targetDisplay = document.getElementById('target_dana_display');
    const targetReal = document.getElementById('target_real');
    const mulai = document.getElementById('tanggal_mulai');
    const selesai = document.getElementById('tanggal_berakhir');
    const gambarInput = document.getElementById('gambar');
    const previewGallery = document.getElementById('previewGallery');
    const uploadBox = document.getElementById('uploadBox');

    if (targetDisplay && targetReal) {
        targetDisplay.addEventListener('input', function () {
            let angka = this.value.replace(/[^0-9]/g, '');

            targetReal.value = angka;
            this.value = angka.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        });
    }

    if (mulai && selesai) {
        selesai.min = mulai.value;

        mulai.addEventListener('change', function () {
            selesai.min = mulai.value;

            if (selesai.value && selesai.value <= mulai.value) {
                selesai.value = '';
            }
        });
    }

    if (gambarInput && previewGallery) {
        gambarInput.addEventListener('change', function () {
            previewGallery.innerHTML = '';

            const files = Array.from(this.files);

            if (files.length === 0) {
                previewGallery.style.display = 'none';
                return;
            }

            previewGallery.style.display = 'grid';
            previewGallery.style.gridTemplateColumns = 'repeat(auto-fill, minmax(90px, 1fr))';
            previewGallery.style.gap = '10px';

            files.forEach(function (file, index) {
                if (!file.type.startsWith('image/')) {
                    return;
                }

                const reader = new FileReader();

                reader.onload = function (event) {
                    const item = document.createElement('div');
                    item.style.position = 'relative';
                    item.style.borderRadius = '12px';
                    item.style.overflow = 'hidden';
                    item.style.border = '1px solid #e5e7eb';
                    item.style.background = '#f8fafc';

                    const img = document.createElement('img');
                    img.src = event.target.result;
                    img.alt = 'Preview Gambar Campaign';
                    img.style.width = '100%';
                    img.style.height = '90px';
                    img.style.objectFit = 'cover';
                    img.style.display = 'block';

                    item.appendChild(img);

                    const badge = document.createElement('span');
                    badge.innerText = 'Baru';
                    badge.style.position = 'absolute';
                    badge.style.top = '6px';
                    badge.style.left = '6px';
                    badge.style.fontSize = '11px';
                    badge.style.padding = '3px 7px';
                    badge.style.borderRadius = '999px';
                    badge.style.background = '#22c55e';
                    badge.style.color = '#fff';
                    badge.style.fontWeight = '600';

                    item.appendChild(badge);

                    previewGallery.appendChild(item);
                };

                reader.readAsDataURL(file);
            });
        });
    }

    if (uploadBox && gambarInput) {
        uploadBox.addEventListener('dragover', function (event) {
            event.preventDefault();
            uploadBox.classList.add('drag-over');
        });

        uploadBox.addEventListener('dragleave', function () {
            uploadBox.classList.remove('drag-over');
        });

        uploadBox.addEventListener('drop', function (event) {
            event.preventDefault();
            uploadBox.classList.remove('drag-over');

            if (event.dataTransfer.files.length > 0) {
                gambarInput.files = event.dataTransfer.files;

                const changeEvent = new Event('change');
                gambarInput.dispatchEvent(changeEvent);
            }
        });
    }

    if (form) {
        form.addEventListener('submit', function (e) {
            if (targetReal && targetReal.value === '') {
                e.preventDefault();
                showCampaignPopup('error', 'Target donasi wajib diisi.');
                return;
            }

            if (mulai.value && selesai.value && selesai.value <= mulai.value) {
                e.preventDefault();
                showCampaignPopup('error', 'Tanggal berakhir harus lebih besar dari tanggal mulai.');
                return;
            }
        });
    }
});

function showCampaignPopup(type, message) {
    const oldPopup = document.querySelector('.campaign-popup-overlay');

    if (oldPopup) {
        oldPopup.remove();
    }

    const overlay = document.createElement('div');
    overlay.className = 'campaign-popup-overlay';

    overlay.innerHTML = `
        <div class="campaign-popup-box">
            <div class="campaign-popup-icon ${type}">
                ${type === 'success' ? '✓' : '!' }
            </div>
            <h4>${type === 'success' ? 'Berhasil' : 'Gagal'}</h4>
            <p>${message}</p>
            <button type="button" onclick="this.closest('.campaign-popup-overlay').remove()">
                Oke
            </button>
        </div>
    `;

    document.body.appendChild(overlay);
}
</script>

<?php if (session()->getFlashdata('success')): ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    showCampaignPopup('success', '<?= esc(session()->getFlashdata('success')) ?>');
});
</script>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    showCampaignPopup('error', '<?= esc(session()->getFlashdata('error')) ?>');
});
</script>
<?php endif; ?>

<?= $this->endSection() ?>