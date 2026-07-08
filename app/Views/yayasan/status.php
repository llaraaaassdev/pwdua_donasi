<?= $this->extend('yayasan/layouts/main') ?>

<?= $this->section('content') ?>

<?php
$foundation = $foundation ?? null;
$pendingProfileChange = $pendingProfileChange ?? null;
$status = empty($foundation) ? 'need_profile' : ($foundation['status'] ?? 'pending');

if (!empty($foundation) && ($foundation['status'] ?? '') === 'verified' && !empty($pendingProfileChange)) {
    $status = 'profile_change_pending';
}

$statusConfig = [
    'need_profile' => [
        'title' => 'Profil Yayasan Belum Lengkap',
        'subtitle' => 'Silakan lengkapi data profil yayasan terlebih dahulu.',
        'description' => 'Data profil dan dokumen legalitas wajib dilengkapi sebelum administrator dapat melakukan verifikasi. Setelah data dikirim, status pengajuan akan berubah menjadi pending.',
        'icon' => 'fa-pen-to-square',
        'class' => 'pending',
        'label' => 'Perlu Lengkapi Data',
        'button_text' => 'Lengkapi Data',
        'button_icon' => 'fa-pen-to-square',
        'button_url' => base_url('yayasan/profile'),
        'button_class' => 'btn-warning-modern'
    ],
    'pending' => [
        'title' => 'Menunggu Verifikasi Admin',
        'subtitle' => 'Data yayasan Anda sedang diperiksa oleh administrator.',
        'description' => 'Registrasi yayasan sudah lengkap. Silakan tunggu admin memeriksa data profil dan dokumen legalitas sebelum akun dapat digunakan untuk membuat campaign.',
        'icon' => 'fa-clock',
        'class' => 'pending',
        'label' => 'Pending',
        'button_text' => 'Lihat Profil',
        'button_icon' => 'fa-user-pen',
        'button_url' => base_url('yayasan/profile'),
        'button_class' => 'btn-secondary-modern'
    ],
    'verified' => [
        'title' => 'Akun Yayasan Terverifikasi',
        'subtitle' => 'Selamat, akun yayasan Anda sudah disetujui.',
        'description' => 'Anda dapat membuat campaign, mengelola pengajuan donasi, dan memantau perkembangan dana melalui dashboard yayasan. Perubahan profil berikutnya tetap harus diverifikasi admin.',
        'icon' => 'fa-circle-check',
        'class' => 'verified',
        'label' => 'Verified',
        'button_text' => 'Masuk Dashboard',
        'button_icon' => 'fa-table-columns',
        'button_url' => base_url('yayasan/dashboard'),
        'button_class' => 'btn-primary-modern'
    ],
    'rejected' => [
        'title' => 'Pengajuan Ditolak',
        'subtitle' => 'Maaf, data yayasan belum dapat disetujui.',
        'description' => 'Silakan periksa kembali data yayasan dan dokumen legalitas yang sudah dikirim, lalu perbaiki data profil dan kirim ulang untuk diverifikasi admin.',
        'icon' => 'fa-circle-xmark',
        'class' => 'rejected',
        'label' => 'Rejected',
        'button_text' => 'Perbaiki Data',
        'button_icon' => 'fa-pen-to-square',
        'button_url' => base_url('yayasan/profile'),
        'button_class' => 'btn-warning-modern'
    ],
    'profile_change_pending' => [
        'title' => 'Perubahan Profil Menunggu Verifikasi',
        'subtitle' => 'Akun yayasan tetap aktif, tetapi perubahan profil belum diterapkan.',
        'description' => 'Data utama yayasan masih menggunakan data lama yang sudah disetujui. Perubahan baru akan aktif setelah admin menyetujui pengajuan perubahan profil.',
        'icon' => 'fa-clock-rotate-left',
        'class' => 'pending',
        'label' => 'Perubahan Pending',
        'button_text' => 'Lihat/Edit Pengajuan',
        'button_icon' => 'fa-user-pen',
        'button_url' => base_url('yayasan/profile'),
        'button_class' => 'btn-warning-modern'
    ]
];

$current = $statusConfig[$status] ?? $statusConfig['pending'];
?>

<style>
    .status-page {
        animation: fadeUp .6s ease;
    }

    .status-hero {
        background: linear-gradient(135deg, #2563eb, #4f46e5);
        border-radius: 28px;
        padding: 34px;
        color: #ffffff;
        position: relative;
        overflow: hidden;
        margin-bottom: 28px;
        box-shadow: 0 18px 35px rgba(37, 99, 235, .22);
    }

    .status-hero::before {
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

    .status-hero-content {
        position: relative;
        z-index: 2;
    }

    .status-hero h2 {
        font-weight: 800;
        margin-bottom: 8px;
    }

    .status-hero p {
        margin-bottom: 0;
        color: rgba(255,255,255,.84);
    }

    .status-grid {
        display: grid;
        grid-template-columns: 1fr 380px;
        gap: 24px;
        align-items: stretch;
    }

    .modern-card {
        background: #ffffff;
        border-radius: 28px;
        padding: 32px;
        border: 1px solid #eef2f7;
        box-shadow: 0 14px 34px rgba(15, 23, 42, .08);
    }

    .status-main {
        min-height: 430px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        text-align: center;
    }

    .status-icon {
        width: 118px;
        height: 118px;
        border-radius: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 26px;
        font-size: 54px;
    }

    .status-icon.pending {
        background: rgba(245, 158, 11, .14);
        color: #f59e0b;
    }

    .status-icon.verified {
        background: rgba(22, 163, 74, .14);
        color: #16a34a;
    }

    .status-icon.rejected {
        background: rgba(239, 68, 68, .14);
        color: #ef4444;
    }

    .status-title {
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 10px;
    }

    .status-subtitle {
        color: #64748b;
        font-size: 17px;
        margin-bottom: 16px;
    }

    .status-description {
        max-width: 680px;
        margin: 0 auto;
        color: #64748b;
        line-height: 1.8;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 11px 16px;
        border-radius: 999px;
        font-weight: 800;
        font-size: 13px;
        margin-top: 24px;
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

    .btn-modern {
        min-height: 52px;
        border: none;
        border-radius: 16px;
        padding: 13px 22px;
        font-weight: 800;
        transition: .3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        margin-top: 26px;
    }

    .btn-modern:hover {
        transform: translateY(-2px);
    }

    .btn-primary-modern {
        background: linear-gradient(to right, #2563eb, #4f46e5);
        color: #ffffff;
    }

    .btn-primary-modern:hover {
        color: #ffffff;
        opacity: .92;
    }

    .btn-secondary-modern {
        background: #f1f5f9;
        color: #0f172a;
    }

    .btn-warning-modern {
        background: #f59e0b;
        color: #ffffff;
    }

    .btn-warning-modern:hover {
        color: #ffffff;
        opacity: .92;
    }

    .side-card-title {
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 20px;
    }

    .info-list {
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .info-item {
        background: #f8fafc;
        border: 1px solid #eef2f7;
        border-radius: 18px;
        padding: 16px;
    }

    .info-label {
        color: #64748b;
        font-size: 13px;
        font-weight: 700;
        margin-bottom: 6px;
    }

    .info-value {
        color: #0f172a;
        font-weight: 800;
        word-break: break-word;
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
        .status-grid {
            grid-template-columns: 1fr;
        }

        .modern-card {
            padding: 24px;
        }
    }
</style>

<div class="status-page">

    <div class="status-hero">
        <div class="status-hero-content">
            <h2>Status Verifikasi Yayasan</h2>
            <p>Pantau status registrasi dan perubahan profil yayasan.</p>
        </div>
    </div>

    <div class="status-grid">

        <div class="modern-card status-main">
            <div class="status-icon <?= $current['class'] ?>">
                <i class="fa-solid <?= $current['icon'] ?>"></i>
            </div>

            <h2 class="status-title">
                <?= esc($current['title']) ?>
            </h2>

            <div class="status-subtitle">
                <?= esc($current['subtitle']) ?>
            </div>

            <p class="status-description">
                <?= esc($current['description']) ?>
            </p>

            <div>
                <span class="status-badge <?= $current['class'] ?>">
                    <i class="fa-solid <?= $current['icon'] ?>"></i>
                    Status: <?= esc($current['label']) ?>
                </span>
            </div>

            <div>
                <a href="<?= $current['button_url'] ?>" class="btn-modern <?= $current['button_class'] ?>">
                    <i class="fa-solid <?= $current['button_icon'] ?>"></i>
                    <?= esc($current['button_text']) ?>
                </a>
            </div>
        </div>

        <div class="modern-card">
            <h4 class="side-card-title">
                Ringkasan Yayasan
            </h4>

            <div class="info-list">
                <div class="info-item">
                    <div class="info-label">Nama Yayasan</div>
                    <div class="info-value">
                        <?= esc($foundation['nama_yayasan'] ?? '-') ?>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-label">Email Yayasan</div>
                    <div class="info-value">
                        <?= esc($foundation['email_yayasan'] ?? '-') ?>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-label">Nomor Telepon</div>
                    <div class="info-value">
                        <?= esc($foundation['telepon'] ?? '-') ?>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-label">Nomor Izin</div>
                    <div class="info-value">
                        <?= esc($foundation['nomor_izin'] ?? '-') ?>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-label">Tanggal Registrasi</div>
                    <div class="info-value">
                        <?= !empty($foundation['created_at']) ? date('d M Y H:i', strtotime($foundation['created_at'])) : '-' ?>
                    </div>
                </div>

                <?php if(!empty($pendingProfileChange)): ?>
                    <div class="info-item">
                        <div class="info-label">Pengajuan Perubahan</div>
                        <div class="info-value">
                            Menunggu verifikasi admin
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Tanggal Pengajuan</div>
                        <div class="info-value">
                            <?= !empty($pendingProfileChange['created_at']) ? date('d M Y H:i', strtotime($pendingProfileChange['created_at'])) : '-' ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>

</div>

<?= $this->endSection() ?>