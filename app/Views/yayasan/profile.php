<?= $this->extend('yayasan/layouts/main') ?>

<?= $this->section('content') ?>

<?php
$foundation = $foundation ?? null;
$pendingProfileChange = $pendingProfileChange ?? null;
$isEdit = !empty($foundation);
$status = $foundation['status'] ?? 'pending';
$hasPendingChange = !empty($pendingProfileChange);
$activeCampaignCount = (int) ($activeCampaignCount ?? 0);
$canDisableAccount = $activeCampaignCount === 0;

$statusLabel = [
    'pending'  => 'Pending',
    'verified' => 'Verified',
    'rejected' => 'Rejected',
];

$statusIcon = [
    'pending'  => 'fa-clock',
    'verified' => 'fa-circle-check',
    'rejected' => 'fa-circle-xmark',
];

$displayData = $foundation ?? [];

if ($hasPendingChange) {
    foreach (['nama_yayasan','email_yayasan','telepon','alamat','deskripsi','nomor_izin','logo','dokumen_verifikasi'] as $field) {
        if (array_key_exists($field, $pendingProfileChange)) {
            $displayData[$field] = $pendingProfileChange[$field];
        }
    }
}


$fileExt = static function ($filename) {
    return strtolower(pathinfo((string) $filename, PATHINFO_EXTENSION));
};

$isImageFile = static function ($filename) use ($fileExt) {
    return in_array($fileExt($filename), ['jpg', 'jpeg', 'png', 'webp'], true);
};

$isPdfFile = static function ($filename) use ($fileExt) {
    return $fileExt($filename) === 'pdf';
};

$formatFileName = static function ($filename) {
    return !empty($filename) ? basename((string) $filename) : 'Belum ada file';
};

$logoUrl = static function ($filename) {
    return !empty($filename) ? base_url('uploads/logo/' . $filename) : null;
};

$documentUrl = static function ($filename) {
    return !empty($filename) ? base_url('uploads/dokumen/' . $filename) : null;
};

$currentLogo = $foundation['logo'] ?? null;
$currentDocument = $foundation['dokumen_verifikasi'] ?? null;
$pendingLogo = $pendingProfileChange['logo'] ?? null;
$pendingDocument = $pendingProfileChange['dokumen_verifikasi'] ?? null;
$formLogo = $displayData['logo'] ?? null;
$formDocument = $displayData['dokumen_verifikasi'] ?? null;

$formAction = $isEdit ? base_url('yayasan/profile/update') : base_url('yayasan/profile/store');

if (!$isEdit) {
    $buttonText = 'Kirim Data Verifikasi';
    $buttonIcon = 'fa-floppy-disk';
} elseif (($foundation['status'] ?? '') === 'verified') {
    $buttonText = $hasPendingChange ? 'Perbarui Pengajuan Perubahan' : 'Ajukan Perubahan Profil';
    $buttonIcon = 'fa-paper-plane';
} else {
    $buttonText = 'Kirim Ulang Verifikasi';
    $buttonIcon = 'fa-paper-plane';
}
?>

<style>
    .profile-page { animation: fadeUp .6s ease; }

    .profile-hero {
        background: linear-gradient(135deg, #2563eb, #4f46e5);
        border-radius: 28px;
        padding: 34px;
        color: #ffffff;
        position: relative;
        overflow: hidden;
        margin-bottom: 28px;
        box-shadow: 0 18px 35px rgba(37, 99, 235, .22);
    }

    .profile-hero::before {
        content: "";
        position: absolute;
        width: 260px;
        height: 260px;
        border-radius: 50%;
        background: rgba(255,255,255,.16);
        right: -80px;
        top: -90px;
        animation: floatBlob 5s ease-in-out infinite;
    }

    .profile-hero-content { position: relative; z-index: 2; }
    .profile-hero h2 { font-weight: 800; margin-bottom: 8px; }
    .profile-hero p { margin-bottom: 0; color: rgba(255,255,255,.84); }

    .profile-grid {
        display: grid;
        grid-template-columns: 360px 1fr;
        gap: 24px;
        align-items: start;
    }

    .modern-card {
        background: #ffffff;
        border-radius: 28px;
        padding: 28px;
        border: 1px solid #eef2f7;
        box-shadow: 0 14px 34px rgba(15, 23, 42, .08);
    }

    .logo-preview {
        min-height: 260px;
        border-radius: 24px;
        background: #f8fafc;
        border: 1px solid #eef2f7;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        margin-bottom: 22px;
    }

    .logo-preview img { max-width: 100%; max-height: 220px; object-fit: contain; }
    .logo-empty { text-align: center; color: #64748b; }

    .logo-empty i {
        width: 86px;
        height: 86px;
        border-radius: 26px;
        background: rgba(37, 99, 235, .12);
        color: #2563eb;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 38px;
        margin-bottom: 14px;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 15px;
        border-radius: 999px;
        font-weight: 800;
        font-size: 13px;
    }

    .status-badge.pending { background: rgba(245, 158, 11, .14); color: #b45309; }
    .status-badge.verified { background: rgba(22, 163, 74, .14); color: #15803d; }
    .status-badge.rejected { background: rgba(239, 68, 68, .14); color: #dc2626; }

    .section-title {
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-title i {
        width: 42px;
        height: 42px;
        border-radius: 14px;
        background: rgba(37, 99, 235, .12);
        color: #2563eb;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .form-label { color: #334155; font-weight: 700; margin-bottom: 8px; }
    .required { color: #ef4444; }

    .form-control {
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        min-height: 52px;
    }

    textarea.form-control { min-height: 120px; }
    .form-control:focus { border-color: #2563eb; box-shadow: 0 0 0 .2rem rgba(37, 99, 235, .12); }
    .file-note { display: block; margin-top: 6px; color: #64748b; font-size: 13px; }

    .btn-modern {
        min-height: 52px;
        border-radius: 16px;
        font-weight: 800;
        padding: 13px 22px;
    }

    .btn-gradient {
        background: linear-gradient(to right, #2563eb, #4f46e5);
        color: #ffffff;
        border: none;
        transition: .3s;
    }

    .btn-gradient:hover { color: #ffffff; opacity: .92; transform: translateY(-2px); }
    .alert { border: none; border-radius: 18px; }

    .pending-change-card {
        background: rgba(245, 158, 11, .12);
        border: 1px solid rgba(245, 158, 11, .25);
        color: #92400e;
        border-radius: 20px;
        padding: 18px;
        margin-bottom: 22px;
    }

    .pending-change-card strong { color: #78350f; }

    .danger-zone {
        margin-top: 22px;
        padding: 18px;
        background: rgba(239, 68, 68, .08);
        border: 1px solid rgba(239, 68, 68, .18);
        border-radius: 20px;
    }

    .danger-zone h6 { color: #991b1b; font-weight: 800; }
    .danger-zone p { color: #64748b; margin-bottom: 14px; }

    .file-preview-stack {
        display: grid;
        gap: 14px;
        margin-top: 20px;
    }

    .file-preview-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        padding: 16px;
    }

    .file-preview-card.pending-file {
        background: rgba(245, 158, 11, .10);
        border-color: rgba(245, 158, 11, .28);
    }

    .file-preview-title {
        font-size: 13px;
        font-weight: 800;
        color: #334155;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .file-preview-img {
        width: 100%;
        min-height: 130px;
        max-height: 190px;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        object-fit: contain;
        background: #ffffff;
        padding: 8px;
    }

    .doc-preview-box {
        min-height: 130px;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        background: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .doc-preview-box iframe {
        width: 100%;
        height: 180px;
        border: none;
        background: #ffffff;
    }

    .doc-preview-box img {
        width: 100%;
        max-height: 190px;
        object-fit: contain;
        padding: 8px;
    }

    .file-empty-box {
        min-height: 118px;
        border-radius: 16px;
        border: 1px dashed #cbd5e1;
        color: #64748b;
        background: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 16px;
        font-weight: 700;
    }

    .file-name-line {
        margin-top: 10px;
        color: #64748b;
        font-size: 13px;
        word-break: break-all;
    }

    .file-action-row {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 12px;
    }

    .btn-file-preview {
        border-radius: 12px;
        font-weight: 800;
        font-size: 13px;
        padding: 9px 12px;
    }

    .current-file-note {
        margin-top: 10px;
        padding: 12px 14px;
        border-radius: 14px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        color: #475569;
        font-size: 13px;
    }

    .current-file-note strong { color: #0f172a; }

    .form-preview-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 14px;
        margin-bottom: 22px;
    }

    @media(max-width: 768px) { .form-preview-grid { grid-template-columns: 1fr; } }

    @keyframes fadeUp { from { opacity: 0; transform: translateY(18px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes floatBlob { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(22px); } }

    @media(max-width: 992px) { .profile-grid { grid-template-columns: 1fr; } }
</style>

<div class="profile-page">

    <div class="profile-hero">
        <div class="profile-hero-content">
            <h2>Profil Yayasan</h2>
            <p>
                <?php if(($foundation['status'] ?? '') === 'verified'): ?>
                    Yayasan tetap dapat mengubah profil, tetapi perubahan baru aktif setelah diverifikasi admin.
                <?php else: ?>
                    Lengkapi atau perbaiki data yayasan sebelum diverifikasi oleh administrator.
                <?php endif; ?>
            </p>
        </div>
    </div>

    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
    <?php endif; ?>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <?php if(session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach(session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="profile-grid">

        <div class="modern-card">
            <div class="logo-preview">
                <?php if(!empty($foundation['logo'])): ?>
                    <img src="<?= base_url('uploads/logo/'.$foundation['logo']) ?>" alt="Logo Yayasan">
                <?php else: ?>
                    <div class="logo-empty">
                        <i class="fa-solid fa-building"></i>
                        <h6 class="fw-bold mb-0">Belum Upload Logo</h6>
                    </div>
                <?php endif; ?>
            </div>

            <h4 class="fw-bold mb-2"><?= esc($foundation['nama_yayasan'] ?? 'Data Yayasan') ?></h4>
            <div class="mb-3 text-muted"><?= esc($foundation['email_yayasan'] ?? 'Lengkapi data profil yayasan') ?></div>

            <span class="status-badge <?= esc($status) ?>">
                <i class="fa-solid <?= esc($statusIcon[$status] ?? 'fa-clock') ?>"></i>
                <?= esc($statusLabel[$status] ?? 'Pending') ?>
            </span>

            <?php if($hasPendingChange): ?>
                <div class="pending-change-card mt-3 mb-0">
                    <strong><i class="fa-solid fa-clock me-1"></i> Perubahan menunggu verifikasi</strong>
                    <div class="mt-1">Data yang tampil di form adalah data perubahan yang sedang diajukan.</div>
                </div>
            <?php endif; ?>

            <div class="file-preview-stack">
                <div class="file-preview-card">
                    <div class="file-preview-title">
                        <i class="fa-solid fa-image"></i>
                        Logo saat ini
                    </div>
                    <?php if(!empty($currentLogo)): ?>
                        <img class="file-preview-img" src="<?= esc($logoUrl($currentLogo)) ?>" alt="Logo yayasan saat ini">
                        <div class="file-name-line"><?= esc($formatFileName($currentLogo)) ?></div>
                        <div class="file-action-row">
                            <a href="<?= esc($logoUrl($currentLogo)) ?>" target="_blank" class="btn btn-light btn-file-preview">
                                <i class="fa-solid fa-eye me-1"></i> Lihat Logo
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="file-empty-box">
                            <div><i class="fa-solid fa-image d-block mb-2"></i>Belum ada logo tersimpan</div>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="file-preview-card">
                    <div class="file-preview-title">
                        <i class="fa-solid fa-file-shield"></i>
                        Dokumen legalitas saat ini
                    </div>
                    <?php if(!empty($currentDocument)): ?>
                        <div class="doc-preview-box">
                            <?php if($isImageFile($currentDocument)): ?>
                                <img src="<?= esc($documentUrl($currentDocument)) ?>" alt="Dokumen legalitas saat ini">
                            <?php elseif($isPdfFile($currentDocument)): ?>
                                <iframe src="<?= esc($documentUrl($currentDocument)) ?>#toolbar=0&navpanes=0&scrollbar=0" title="Dokumen legalitas saat ini"></iframe>
                            <?php else: ?>
                                <div class="file-empty-box border-0">
                                    <div><i class="fa-solid fa-file d-block mb-2"></i>Preview tidak tersedia</div>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="file-name-line"><?= esc($formatFileName($currentDocument)) ?></div>
                        <div class="file-action-row">
                            <a href="<?= esc($documentUrl($currentDocument)) ?>" target="_blank" class="btn btn-light btn-file-preview">
                                <i class="fa-solid fa-eye me-1"></i> Lihat Dokumen
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="file-empty-box">
                            <div><i class="fa-solid fa-file-circle-xmark d-block mb-2"></i>Belum ada dokumen tersimpan</div>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if($hasPendingChange): ?>
                    <div class="file-preview-card pending-file">
                        <div class="file-preview-title">
                            <i class="fa-solid fa-clock"></i>
                            File dalam pengajuan perubahan
                        </div>

                        <div class="mb-3">
                            <div class="fw-bold mb-2">Logo yang diajukan</div>
                            <?php if(!empty($pendingLogo)): ?>
                                <img class="file-preview-img" src="<?= esc($logoUrl($pendingLogo)) ?>" alt="Logo yang diajukan">
                                <div class="file-name-line"><?= esc($formatFileName($pendingLogo)) ?></div>
                                <div class="file-action-row">
                                    <a href="<?= esc($logoUrl($pendingLogo)) ?>" target="_blank" class="btn btn-warning btn-file-preview">
                                        <i class="fa-solid fa-eye me-1"></i> Lihat Logo Pengajuan
                                    </a>
                                </div>
                            <?php else: ?>
                                <div class="file-empty-box">Tidak ada perubahan logo</div>
                            <?php endif; ?>
                        </div>

                        <div>
                            <div class="fw-bold mb-2">Dokumen yang diajukan</div>
                            <?php if(!empty($pendingDocument)): ?>
                                <div class="doc-preview-box">
                                    <?php if($isImageFile($pendingDocument)): ?>
                                        <img src="<?= esc($documentUrl($pendingDocument)) ?>" alt="Dokumen yang diajukan">
                                    <?php elseif($isPdfFile($pendingDocument)): ?>
                                        <iframe src="<?= esc($documentUrl($pendingDocument)) ?>#toolbar=0&navpanes=0&scrollbar=0" title="Dokumen yang diajukan"></iframe>
                                    <?php else: ?>
                                        <div class="file-empty-box border-0">Preview tidak tersedia</div>
                                    <?php endif; ?>
                                </div>
                                <div class="file-name-line"><?= esc($formatFileName($pendingDocument)) ?></div>
                                <div class="file-action-row">
                                    <a href="<?= esc($documentUrl($pendingDocument)) ?>" target="_blank" class="btn btn-warning btn-file-preview">
                                        <i class="fa-solid fa-eye me-1"></i> Lihat Dokumen Pengajuan
                                    </a>
                                </div>
                            <?php else: ?>
                                <div class="file-empty-box">Tidak ada perubahan dokumen</div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="modern-card">
            <?php if($hasPendingChange): ?>
                <div class="pending-change-card">
                    <strong>Pengajuan perubahan profil sedang pending.</strong>
                    <div class="mt-1">
                        Anda masih bisa memperbarui pengajuan ini. Data utama yayasan tidak berubah sebelum admin menyetujui.
                    </div>
                </div>
            <?php endif; ?>

            <div class="section-title">
                <i class="fa-solid fa-pen-to-square"></i>
                <span>
                    <?php if(!$isEdit): ?>
                        Lengkapi Data Yayasan
                    <?php elseif(($foundation['status'] ?? '') === 'verified'): ?>
                        Edit Profil Yayasan
                    <?php else: ?>
                        Perbaiki Data Yayasan
                    <?php endif; ?>
                </span>
            </div>

            <?php if($isEdit): ?>
                <div class="form-preview-grid">
                    <div class="file-preview-card">
                        <div class="file-preview-title">
                            <i class="fa-solid fa-image"></i>
                            Logo yang tampil di form
                        </div>
                        <?php if(!empty($formLogo)): ?>
                            <img class="file-preview-img" src="<?= esc($logoUrl($formLogo)) ?>" alt="Logo yang tampil di form">
                            <div class="file-name-line"><?= esc($formatFileName($formLogo)) ?></div>
                            <div class="file-action-row">
                                <a href="<?= esc($logoUrl($formLogo)) ?>" target="_blank" class="btn btn-light btn-file-preview">
                                    <i class="fa-solid fa-up-right-from-square me-1"></i> Buka Logo
                                </a>
                            </div>
                        <?php else: ?>
                            <div class="file-empty-box">Belum ada logo</div>
                        <?php endif; ?>
                    </div>

                    <div class="file-preview-card">
                        <div class="file-preview-title">
                            <i class="fa-solid fa-file-shield"></i>
                            Dokumen yang tampil di form
                        </div>
                        <?php if(!empty($formDocument)): ?>
                            <div class="doc-preview-box">
                                <?php if($isImageFile($formDocument)): ?>
                                    <img src="<?= esc($documentUrl($formDocument)) ?>" alt="Dokumen yang tampil di form">
                                <?php elseif($isPdfFile($formDocument)): ?>
                                    <iframe src="<?= esc($documentUrl($formDocument)) ?>#toolbar=0&navpanes=0&scrollbar=0" title="Dokumen yang tampil di form"></iframe>
                                <?php else: ?>
                                    <div class="file-empty-box border-0">Preview tidak tersedia</div>
                                <?php endif; ?>
                            </div>
                            <div class="file-name-line"><?= esc($formatFileName($formDocument)) ?></div>
                            <div class="file-action-row">
                                <a href="<?= esc($documentUrl($formDocument)) ?>" target="_blank" class="btn btn-light btn-file-preview">
                                    <i class="fa-solid fa-up-right-from-square me-1"></i> Buka Dokumen
                                </a>
                            </div>
                        <?php else: ?>
                            <div class="file-empty-box">Belum ada dokumen</div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

            <form action="<?= $formAction ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama Yayasan <span class="required">*</span></label>
                        <input type="text" name="nama_yayasan" class="form-control" value="<?= old('nama_yayasan', $displayData['nama_yayasan'] ?? '') ?>" placeholder="Nama yayasan" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email Yayasan <span class="required">*</span></label>
                        <input type="email" name="email_yayasan" class="form-control" value="<?= old('email_yayasan', $displayData['email_yayasan'] ?? '') ?>" placeholder="email yayasan" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nomor Telepon <span class="required">*</span></label>
                        <input type="text" name="telepon" class="form-control" value="<?= old('telepon', $displayData['telepon'] ?? '') ?>" placeholder="08xxxxxxxxxx" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nomor Izin Yayasan <span class="required">*</span></label>
                        <input type="text" name="nomor_izin" class="form-control" value="<?= old('nomor_izin', $displayData['nomor_izin'] ?? '') ?>" placeholder="Nomor legalitas" required>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">Alamat Yayasan <span class="required">*</span></label>
                        <input type="text" name="alamat" class="form-control" value="<?= old('alamat', $displayData['alamat'] ?? '') ?>" placeholder="Alamat lengkap" required>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">Deskripsi Yayasan <span class="required">*</span></label>
                        <textarea name="deskripsi" class="form-control" placeholder="Ceritakan tentang yayasan" required><?= old('deskripsi', $displayData['deskripsi'] ?? '') ?></textarea>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Logo Yayasan</label>
                        <input type="file" name="logo" class="form-control" accept="image/png,image/jpg,image/jpeg,image/webp">
                        <small class="file-note">Opsional. JPG, JPEG, PNG, WEBP. Maksimal 2MB.</small>
                        <?php if(!empty($formLogo)): ?>
                            <div class="current-file-note">
                                <strong>Logo sebelumnya:</strong><br>
                                <?= esc($formatFileName($formLogo)) ?><br>
                                <a href="<?= esc($logoUrl($formLogo)) ?>" target="_blank">Lihat logo sebelumnya</a>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Dokumen Legalitas <?= $isEdit ? '' : '<span class="required">*</span>' ?></label>
                        <input type="file" name="dokumen_verifikasi" class="form-control" accept=".pdf,image/png,image/jpg,image/jpeg" <?= $isEdit ? '' : 'required' ?>>
                        <small class="file-note"><?= $isEdit ? 'Kosongkan jika dokumen lama masih benar.' : 'Wajib. PDF, JPG, JPEG, PNG. Maksimal 4MB.' ?></small>
                        <?php if(!empty($formDocument)): ?>
                            <div class="current-file-note">
                                <strong>Dokumen sebelumnya:</strong><br>
                                <?= esc($formatFileName($formDocument)) ?><br>
                                <a href="<?= esc($documentUrl($formDocument)) ?>" target="_blank">Lihat dokumen sebelumnya</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="d-flex flex-wrap gap-2 justify-content-between mt-3">
                    <a href="<?= base_url('yayasan/status') ?>" class="btn btn-light btn-modern">
                        <i class="fa-solid fa-arrow-left me-1"></i>
                        Kembali
                    </a>

                    <button type="submit" class="btn btn-gradient btn-modern">
                        <i class="fa-solid <?= $buttonIcon ?> me-1"></i>
                        <?= esc($buttonText) ?>
                    </button>
                </div>
            </form>

            <?php if($isEdit): ?>
                <div class="danger-zone">
                    <h6><i class="fa-solid fa-triangle-exclamation me-1"></i> Hapus / Nonaktifkan Akun</h6>

                    <?php if(!$canDisableAccount): ?>
                        <p class="mb-2">
                            Akun yayasan tidak dapat dihapus atau dinonaktifkan karena masih memiliki
                            <strong><?= $activeCampaignCount ?></strong> campaign aktif.
                        </p>
                        <button type="button" class="btn btn-outline-danger btn-modern" disabled title="Masih ada campaign aktif">
                            <i class="fa-solid fa-lock me-1"></i>
                            Tidak Bisa Dihapus
                        </button>
                    <?php else: ?>
                        <p>Akun yayasan dapat dinonaktifkan karena tidak ada campaign aktif.</p>
                        <form action="<?= base_url('yayasan/profile/delete') ?>" method="post" onsubmit="return confirm('Yakin ingin menghapus/menonaktifkan akun yayasan ini?')">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn btn-outline-danger btn-modern">
                                <i class="fa-solid fa-trash me-1"></i>
                                Hapus / Nonaktifkan Akun
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>

    </div>

</div>

<?= $this->endSection() ?>
