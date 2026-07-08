<?= $this->extend('yayasan/layouts/main') ?>

<?= $this->section('content') ?>

<link rel="stylesheet" href="<?= base_url('assets/css/campaign_create.css') ?>">

<div class="campaign-create-page">

    <div class="page-header">
        <div>
            <h2 class="page-title">Pengajuan Kampanye Baru</h2>
            <p class="page-subtitle">
                Lengkapi informasi campaign agar dapat diverifikasi oleh Admin
                dan mulai menerima donasi.
            </p>
        </div>

        <a href="<?= base_url('yayasan/campaign/index') ?>" class="btn btn-light back-btn">
            <i class="fa-solid fa-arrow-left"></i>
            Kembali
        </a>
    </div>

    <div class="create-card">

        <form
            action="<?= base_url('yayasan/campaign/store') ?>"
            method="post"
            enctype="multipart/form-data"
            id="campaignForm">

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
                                class="form-control"
                                placeholder="Contoh : Bantuan Pendidikan Anak Yatim"
                                required>
                        </div>

                        <div class="form-group">
                            <label>Kategori</label>
                            <select name="category_id" class="form-select" required>
                                <option value="">Pilih Kategori</option>

                                <?php foreach($categories as $category): ?>
                                    <option value="<?= $category['id'] ?>">
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
                                required></textarea>
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
                                    id="target_dana"
                                    class="form-control rupiah"
                                    placeholder="Contoh : 50.000.000"
                                    autocomplete="off">

                                <input
                                    type="hidden"
                                    name="target_dana"
                                    id="target_real">
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
    min="<?= date('Y-m-d') ?>"
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
    min="<?= date('Y-m-d') ?>"
    required>
                                </div>
                            </div>

                        </div>

                        <div class="campaign-duration">
                            <i class="fa-regular fa-calendar-days"></i>
                            <span id="durationText">
                                Pilih tanggal mulai dan tanggal selesai.
                            </span>
                        </div>

                    </div>

                </div>

                <div class="col-lg-4">

                    <div class="upload-card">

                        <h5>
                            <i class="fa-solid fa-images"></i>
                            Foto Campaign
                        </h5>

                        <p class="upload-desc">
                            Upload beberapa gambar campaign. Gambar pertama akan digunakan
                            sebagai cover utama.
                        </p>

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

                                <h6>Klik atau Drag Gambar</h6>

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
                            Tips Campaign
                        </h5>

                        <ul>
                            <li>Gunakan judul yang singkat dan jelas.</li>
                            <li>Jelaskan kondisi penerima manfaat.</li>
                            <li>Sertakan foto asli agar lebih dipercaya.</li>
                            <li>Tentukan target donasi yang realistis.</li>
                            <li>Pastikan tanggal campaign sesuai.</li>
                        </ul>

                    </div>

                </div>

            </div>

            <div class="form-footer">

                <a
                    href="<?= base_url('yayasan/campaign/index') ?>"
                    class="btn btn-light btn-lg">

                    <i class="fa-solid fa-arrow-left"></i>
                    Kembali

                </a>

                <button
                    type="submit"
                    class="btn btn-primary btn-lg">

                    <i class="fa-solid fa-floppy-disk"></i>
                    Simpan Campaign

                </button>

            </div>

        </form>

    </div>

</div>

<script src="<?= base_url('assets/js/campaign-create.js') ?>"></script>
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
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('campaignForm');
    const targetDisplay = document.getElementById('target_dana');
    const targetReal = document.getElementById('target_real');
    const mulai = document.getElementById('tanggal_mulai');
    const selesai = document.getElementById('tanggal_berakhir');

    if (targetDisplay && targetReal) {
        targetDisplay.addEventListener('input', function () {
            let angka = this.value.replace(/[^0-9]/g, '');

            targetReal.value = angka;

            this.value = angka.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        });
    }

    if (mulai && selesai) {
        const today = new Date().toISOString().split('T')[0];

        mulai.setAttribute('min', today);
        selesai.setAttribute('min', today);

        mulai.addEventListener('change', function () {
            selesai.min = mulai.value;

            if (selesai.value && selesai.value <= mulai.value) {
                selesai.value = '';
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
</script>
<?= $this->endSection() ?>