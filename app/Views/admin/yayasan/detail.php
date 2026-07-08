<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<?php
$status = $foundation['status'] ?? 'pending';
$pendingProfileChange = $pendingProfileChange ?? null;
$hasPendingChange = !empty($pendingProfileChange);
$activeCampaignCount = (int) ($activeCampaignCount ?? 0);
$donationCount = (int) ($donationCount ?? 0);
$canDisableAccount = $activeCampaignCount === 0 && $donationCount === 0;
$canApproveVerification = $status !== 'verified' || $hasPendingChange;
$canRejectVerification = (($status !== 'verified' && $status !== 'rejected') || $hasPendingChange);

$statusClass = 'pending';
$statusIcon = 'fa-clock';
$statusText = 'Pending';

if ($status === 'verified') {
    $statusClass = 'verified';
    $statusIcon = 'fa-circle-check';
    $statusText = 'Verified';
} elseif ($status === 'rejected') {
    $statusClass = 'rejected';
    $statusIcon = 'fa-circle-xmark';
    $statusText = 'Rejected';
}
?>

<style>
    .detail-page {
        animation: fadeUp .6s ease;
    }

    .detail-hero {
        background: linear-gradient(135deg, #2563eb, #4f46e5);
        border-radius: 28px;
        padding: 32px;
        color: #ffffff;
        position: relative;
        overflow: hidden;
        margin-bottom: 28px;
        box-shadow: 0 18px 35px rgba(37, 99, 235, .22);
    }

    .detail-hero::before {
        content: "";
        position: absolute;
        width: 260px;
        height: 260px;
        border-radius: 50%;
        background: rgba(255,255,255,.16);
        right: -80px;
        top: -100px;
        animation: floatBlob 5s ease-in-out infinite;
    }

    .detail-hero-content {
        position: relative;
        z-index: 2;
    }

    .detail-hero h2 {
        font-weight: 800;
        margin-bottom: 8px;
    }

    .detail-hero p {
        margin-bottom: 0;
        color: rgba(255,255,255,.84);
    }

    .detail-grid {
        display: grid;
        grid-template-columns: 360px 1fr;
        gap: 24px;
    }

    .modern-card {
        background: #ffffff;
        border-radius: 28px;
        padding: 28px;
        border: 1px solid #eef2f7;
        box-shadow: 0 14px 34px rgba(15, 23, 42, .08);
    }

    .logo-preview {
        min-height: 280px;
        border-radius: 24px;
        background: #f8fafc;
        border: 1px solid #eef2f7;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        margin-bottom: 22px;
    }

    .logo-preview img {
        max-width: 100%;
        max-height: 240px;
        object-fit: contain;
    }

    .logo-empty {
        text-align: center;
        color: #64748b;
    }

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

    .status-badge.pending {
        background: rgba(245, 158, 11, .14);
        color: #b45309;
    }

    .status-badge.verified {
        background: rgba(22, 163, 74, .14);
        color: #15803d;
    }

    .status-badge.rejected {
        background: rgba(239, 68, 68, .14);
        color: #dc2626;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 18px;
    }

    .info-item {
        background: #f8fafc;
        border: 1px solid #eef2f7;
        border-radius: 20px;
        padding: 18px;
    }

    .info-title {
        color: #64748b;
        font-weight: 700;
        font-size: 13px;
        margin-bottom: 8px;
    }

    .info-value {
        color: #0f172a;
        font-weight: 800;
        word-break: break-word;
    }

    .info-wide {
        grid-column: 1 / -1;
    }

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



    .pending-change-panel {
        margin-top: 24px;
        padding: 22px;
        border-radius: 24px;
        background: rgba(245, 158, 11, .10);
        border: 1px solid rgba(245, 158, 11, .24);
    }

    .pending-change-panel h5 {
        color: #78350f;
        font-weight: 800;
        margin-bottom: 8px;
    }

    .pending-change-panel p {
        color: #92400e;
        margin-bottom: 18px;
    }

    .compare-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 14px;
    }

    .compare-item {
        background: #ffffff;
        border: 1px solid #fde68a;
        border-radius: 18px;
        padding: 15px;
    }

    .compare-title {
        color: #92400e;
        font-size: 12px;
        font-weight: 800;
        margin-bottom: 7px;
        text-transform: uppercase;
        letter-spacing: .03em;
    }

    .compare-value {
        color: #0f172a;
        font-weight: 700;
        word-break: break-word;
    }

    @media(max-width: 992px) {
        .compare-grid {
            grid-template-columns: 1fr;
        }
    }

    .active-campaign-note {
        margin-top: 14px;
        padding: 12px 14px;
        border-radius: 16px;
        background: rgba(239, 68, 68, .10);
        border: 1px solid rgba(239, 68, 68, .18);
        color: #b91c1c;
        font-weight: 700;
        font-size: 13px;
    }

    .action-bar {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: 24px;
    }

    .btn-modern {
        min-height: 46px;
        border-radius: 15px;
        font-weight: 800;
        padding: 10px 16px;
    }

    .btn-gradient {
        background: linear-gradient(to right, #2563eb, #4f46e5);
        color: #ffffff;
        border: none;
    }

    .btn-gradient:hover {
        color: #ffffff;
        opacity: .92;
        transform: translateY(-2px);
    }

    .btn-disabled-modern,
    .btn-disabled-modern:hover {
        background: #f1f5f9;
        color: #94a3b8;
        border: 1px solid #e2e8f0;
        cursor: not-allowed;
        transform: none;
    }

    @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(18px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes floatBlob {
        0%, 100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(22px);
        }
    }

    @media(max-width: 992px) {
        .detail-grid {
            grid-template-columns: 1fr;
        }

        .info-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="detail-page">

    <div class="detail-hero">
        <div class="detail-hero-content">
            <h2>Detail Yayasan</h2>
            <p>Periksa data yayasan, dokumen legalitas, serta pengajuan perubahan profil sebelum mengambil keputusan.</p>
        </div>
    </div>

    <?php if(empty($foundation)): ?>

        <div class="modern-card text-center">
            <h5 class="fw-bold">Data yayasan tidak ditemukan.</h5>
            <a href="<?= base_url('admin/yayasan') ?>" class="btn btn-gradient btn-modern mt-3">
                Kembali
            </a>
        </div>

    <?php else: ?>

        <div class="detail-grid">

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

                <h4 class="fw-bold mb-2">
                    <?= esc($foundation['nama_yayasan']) ?>
                </h4>

                <div class="mb-3 text-muted">
                    <?= esc($foundation['email_yayasan']) ?>
                </div>

                <span class="status-badge <?= $statusClass ?>">
                    <i class="fa-solid <?= $statusIcon ?>"></i>
                    <?= $statusText ?>
                </span>

                <?php if($hasPendingChange): ?>
                    <div class="mt-3">
                        <span class="status-badge pending">
                            <i class="fa-solid fa-clock-rotate-left"></i>
                            Perubahan Profil Pending
                        </span>
                    </div>
                <?php endif; ?>

                <?php if($activeCampaignCount > 0 || $donationCount > 0): ?>
                    <div class="active-campaign-note">
                        <i class="fa-solid fa-lock me-1"></i>
                        Akun tidak bisa di-reject atau dinonaktifkan karena masih memiliki
                        <?= $activeCampaignCount ?> campaign aktif/disetujui dan <?= $donationCount ?> data donasi.
                    </div>
                <?php endif; ?>
            </div>

            <div class="modern-card">
                <div class="section-title">
                    <i class="fa-solid fa-circle-info"></i>
                    <span>Informasi Yayasan</span>
                </div>

                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-title">Nama Yayasan</div>
                        <div class="info-value"><?= esc($foundation['nama_yayasan']) ?></div>
                    </div>

                    <div class="info-item">
                        <div class="info-title">Penanggung Jawab</div>
                        <div class="info-value"><?= esc($foundation['nama'] ?? '-') ?></div>
                    </div>

                    <div class="info-item">
                        <div class="info-title">Email Yayasan</div>
                        <div class="info-value"><?= esc($foundation['email_yayasan']) ?></div>
                    </div>

                    <div class="info-item">
                        <div class="info-title">Nomor Telepon</div>
                        <div class="info-value"><?= esc($foundation['telepon']) ?></div>
                    </div>

                    <div class="info-item">
                        <div class="info-title">Nomor Izin</div>
                        <div class="info-value"><?= esc($foundation['nomor_izin']) ?></div>
                    </div>

                    <div class="info-item">
                        <div class="info-title">Tanggal Daftar</div>
                        <div class="info-value">
                            <?= !empty($foundation['created_at']) ? date('d M Y H:i', strtotime($foundation['created_at'])) : '-' ?>
                        </div>
                    </div>

                    <div class="info-item info-wide">
                        <div class="info-title">Alamat</div>
                        <div class="info-value"><?= esc($foundation['alamat']) ?></div>
                    </div>

                    <div class="info-item info-wide">
                        <div class="info-title">Deskripsi</div>
                        <div class="info-value">
                            <?= !empty($foundation['deskripsi']) ? esc($foundation['deskripsi']) : '-' ?>
                        </div>
                    </div>

                    <div class="info-item info-wide">
                        <div class="info-title">Dokumen Legalitas</div>
                        <div class="info-value">
                            <?php if(!empty($foundation['dokumen_verifikasi'])): ?>
                                <?php
                                $dokumenFile = $foundation['dokumen_verifikasi'];
                                $dokumenUrl = base_url('uploads/dokumen/'.$dokumenFile);

                                if (!file_exists(FCPATH . 'uploads/dokumen/' . $dokumenFile) && file_exists(FCPATH . 'uploads/legalitas/' . $dokumenFile)) {
                                    $dokumenUrl = base_url('uploads/legalitas/'.$dokumenFile);
                                }
                                ?>
                                <a
                                    href="<?= $dokumenUrl ?>"
                                    target="_blank"
                                    class="btn btn-outline-danger btn-modern">
                                    <i class="fa-solid fa-file-pdf me-1"></i>
                                    Lihat Dokumen
                                </a>
                            <?php else: ?>
                                Belum ada dokumen
                            <?php endif; ?>
                        </div>
                    </div>
                </div>


                <?php if($hasPendingChange): ?>
                    <div class="pending-change-panel">
                        <h5><i class="fa-solid fa-clock-rotate-left me-1"></i> Pengajuan Perubahan Profil</h5>
                        <p>Data berikut adalah perubahan yang diajukan yayasan. Jika disetujui, data ini akan menggantikan profil aktif.</p>

                        <div class="compare-grid">
                            <?php foreach([
                                'nama_yayasan' => 'Nama Yayasan',
                                'email_yayasan' => 'Email Yayasan',
                                'telepon' => 'Nomor Telepon',
                                'nomor_izin' => 'Nomor Izin',
                                'alamat' => 'Alamat',
                                'deskripsi' => 'Deskripsi'
                            ] as $field => $label): ?>
                                <div class="compare-item">
                                    <div class="compare-title"><?= esc($label) ?></div>
                                    <div class="compare-value"><?= esc($pendingProfileChange[$field] ?? '-') ?></div>
                                </div>
                            <?php endforeach; ?>

                            <div class="compare-item">
                                <div class="compare-title">Logo Baru</div>
                                <div class="compare-value">
                                    <?php if(!empty($pendingProfileChange['logo'])): ?>
                                        <a href="<?= base_url('uploads/logo/'.$pendingProfileChange['logo']) ?>" target="_blank">Lihat Logo</a>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="compare-item">
                                <div class="compare-title">Dokumen Legalitas Baru</div>
                                <div class="compare-value">
                                    <?php if(!empty($pendingProfileChange['dokumen_verifikasi'])): ?>
                                        <a href="<?= base_url('uploads/dokumen/'.$pendingProfileChange['dokumen_verifikasi']) ?>" target="_blank">Lihat Dokumen</a>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="action-bar">
                    <a href="<?= base_url('admin/yayasan') ?>" class="btn btn-light btn-modern">
                        <i class="fa-solid fa-arrow-left me-1"></i>
                        Kembali
                    </a>

                    <?php if($canApproveVerification): ?>
                        <a
                            href="<?= base_url('admin/yayasan/approve/'.$foundation['id']) ?>"
                            class="btn btn-success btn-modern"
                            onclick="return confirm('Setujui pengajuan ini?')">
                            <i class="fa-solid fa-check me-1"></i>
                            Approve
                        </a>
                    <?php endif; ?>

                    <?php if($canRejectVerification): ?>
                        <a
                            href="<?= base_url('admin/yayasan/reject/'.$foundation['id']) ?>"
                            class="btn btn-warning btn-modern"
                            onclick="return confirm('Tolak pengajuan ini?')">
                            <i class="fa-solid fa-xmark me-1"></i>
                            Reject
                        </a>
                    <?php endif; ?>

                    <?php if($canDisableAccount): ?>
                        <a
                            href="<?= base_url('admin/yayasan/delete/'.$foundation['id']) ?>"
                            class="btn btn-outline-danger btn-modern"
                            onclick="return confirm('Nonaktifkan akun yayasan ini?')">
                            <i class="fa-solid fa-trash me-1"></i>
                            Nonaktifkan
                        </a>
                    <?php else: ?>
                        <button type="button" class="btn btn-disabled-modern btn-modern" disabled title="Masih ada campaign aktif atau data donasi">
                            <i class="fa-solid fa-lock me-1"></i>
                            Tidak Bisa Nonaktifkan
                        </button>
                    <?php endif; ?>
                </div>
            </div>

        </div>

    <?php endif; ?>

</div>

<?= $this->endSection() ?>