<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<?php
$totalYayasan = count($foundations ?? []);
$totalPending = 0;
$totalVerified = 0;
$totalRejected = 0;
$totalProfileChangePending = 0;

foreach (($foundations ?? []) as $item) {
    if (!empty($item['pending_profile_change'])) {
        $totalProfileChangePending++;
    }

    if (($item['status'] ?? '') === 'pending') {
        $totalPending++;
    } elseif (($item['status'] ?? '') === 'verified') {
        $totalVerified++;
    } elseif (($item['status'] ?? '') === 'rejected') {
        $totalRejected++;
    }
}
?>

<style>
    .page-yayasan {
        animation: fadeUp .6s ease;
    }

    .modern-hero {
        background: linear-gradient(135deg, #2563eb, #4f46e5);
        border-radius: 28px;
        padding: 34px;
        color: #ffffff;
        position: relative;
        overflow: hidden;
        box-shadow: 0 18px 35px rgba(37, 99, 235, .22);
        margin-bottom: 28px;
    }

    .modern-hero::before {
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

    .modern-hero::after {
        content: "";
        position: absolute;
        width: 160px;
        height: 160px;
        border-radius: 50%;
        background: rgba(255,255,255,.12);
        right: 170px;
        bottom: -80px;
        animation: floatBlob 6s ease-in-out infinite;
    }

    .modern-hero-content {
        position: relative;
        z-index: 2;
    }

    .modern-hero h2 {
        font-weight: 800;
        margin-bottom: 8px;
    }

    .modern-hero p {
        margin-bottom: 0;
        color: rgba(255,255,255,.82);
        font-size: 16px;
    }

    .stat-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 18px;
        margin-bottom: 28px;
    }

    .stat-card {
        background: #ffffff;
        border-radius: 24px;
        padding: 24px;
        box-shadow: 0 12px 30px rgba(15, 23, 42, .07);
        transition: .3s;
        border: 1px solid #eef2f7;
    }

    .stat-card:hover {
        transform: translateY(-4px);
    }

    .stat-icon {
        width: 58px;
        height: 58px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 23px;
        margin-bottom: 18px;
    }

    .stat-icon.blue {
        background: rgba(37, 99, 235, .12);
        color: #2563eb;
    }

    .stat-icon.yellow {
        background: rgba(245, 158, 11, .14);
        color: #f59e0b;
    }

    .stat-icon.green {
        background: rgba(22, 163, 74, .14);
        color: #16a34a;
    }

    .stat-icon.red {
        background: rgba(239, 68, 68, .14);
        color: #ef4444;
    }

    .stat-label {
        color: #64748b;
        margin-bottom: 6px;
        font-weight: 600;
    }

    .stat-value {
        font-size: 34px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1;
    }

    .modern-card {
        background: #ffffff;
        border-radius: 28px;
        padding: 28px;
        box-shadow: 0 14px 34px rgba(15, 23, 42, .08);
        border: 1px solid #eef2f7;
    }

    .card-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        margin-bottom: 22px;
    }

    .card-head h4 {
        margin-bottom: 4px;
        font-weight: 800;
        color: #0f172a;
    }

    .card-head p {
        margin-bottom: 0;
        color: #64748b;
    }

    .filter-box {
        background: #f8fafc;
        border-radius: 22px;
        padding: 18px;
        margin-bottom: 24px;
        border: 1px solid #eef2f7;
    }

    .form-control,
    .form-select {
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        min-height: 50px;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 .2rem rgba(37, 99, 235, .12);
    }

    .btn-modern {
        min-height: 50px;
        border-radius: 16px;
        font-weight: 700;
        border: none;
        background: linear-gradient(to right, #2563eb, #4f46e5);
        color: #ffffff;
        transition: .3s;
    }

    .btn-modern:hover {
        transform: translateY(-2px);
        color: #ffffff;
        opacity: .92;
    }

    .modern-table {
        border-collapse: separate;
        border-spacing: 0 12px;
        margin-bottom: 0;
    }

    .modern-table thead th {
        border: none;
        color: #64748b;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: .04em;
        padding: 0 16px 10px;
    }

    .modern-table tbody tr {
        box-shadow: 0 8px 22px rgba(15, 23, 42, .05);
    }

    .modern-table tbody td {
        background: #ffffff;
        border-top: 1px solid #eef2f7;
        border-bottom: 1px solid #eef2f7;
        padding: 18px 16px;
        vertical-align: middle;
    }

    .modern-table tbody td:first-child {
        border-left: 1px solid #eef2f7;
        border-radius: 18px 0 0 18px;
    }

    .modern-table tbody td:last-child {
        border-right: 1px solid #eef2f7;
        border-radius: 0 18px 18px 0;
    }

    .foundation-name {
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 4px;
    }

    .foundation-email {
        color: #64748b;
        font-size: 13px;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 9px 13px;
        border-radius: 999px;
        font-weight: 800;
        font-size: 12px;
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



    .change-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 10px;
        border-radius: 999px;
        font-weight: 800;
        font-size: 11px;
        background: rgba(245, 158, 11, .14);
        color: #b45309;
        margin-top: 8px;
    }

    .active-campaign-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 10px;
        border-radius: 999px;
        font-weight: 800;
        font-size: 11px;
        background: rgba(239, 68, 68, .12);
        color: #dc2626;
        margin-top: 8px;
    }

    .action-group {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .btn-action {
        width: 38px;
        height: 38px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        transition: .25s;
    }

    .btn-action:hover {
        transform: translateY(-2px);
    }

    .btn-view {
        background: rgba(14, 165, 233, .14);
        color: #0284c7;
    }

    .btn-approve {
        background: rgba(22, 163, 74, .14);
        color: #16a34a;
    }

    .btn-reject {
        background: rgba(245, 158, 11, .14);
        color: #d97706;
    }

    .btn-delete {
        background: rgba(239, 68, 68, .14);
        color: #ef4444;
    }

    .btn-disabled {
        background: #f1f5f9;
        color: #94a3b8;
        cursor: not-allowed;
    }

    .btn-disabled:hover {
        transform: none;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #64748b;
    }

    .empty-state i {
        width: 76px;
        height: 76px;
        border-radius: 24px;
        background: #f1f5f9;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        color: #2563eb;
        margin-bottom: 18px;
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
        .stat-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .card-head {
            align-items: flex-start;
            flex-direction: column;
        }
    }

    @media(max-width: 576px) {
        .modern-hero {
            padding: 26px;
            border-radius: 22px;
        }

        .stat-grid {
            grid-template-columns: 1fr;
        }

        .modern-card {
            padding: 20px;
            border-radius: 22px;
        }
    }
</style>

<div class="page-yayasan">

    <div class="modern-hero">
        <div class="modern-hero-content">
            <h2>Kelola Verifikasi Yayasan</h2>
            <p>Periksa registrasi yayasan dan perubahan profil, lalu setujui atau tolak pengajuan.</p>
        </div>
    </div>

    <div class="stat-grid">
        <div class="stat-card">
            <div class="stat-icon blue">
                <i class="fa-solid fa-building-user"></i>
            </div>
            <div class="stat-label">Total Yayasan</div>
            <div class="stat-value"><?= $totalYayasan ?></div>
        </div>

        <div class="stat-card">
            <div class="stat-icon yellow">
                <i class="fa-solid fa-clock"></i>
            </div>
            <div class="stat-label">Menunggu</div>
            <div class="stat-value"><?= $totalPending + $totalProfileChangePending ?></div>
        </div>

        <div class="stat-card">
            <div class="stat-icon green">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div class="stat-label">Verified</div>
            <div class="stat-value"><?= $totalVerified ?></div>
        </div>

        <div class="stat-card">
            <div class="stat-icon red">
                <i class="fa-solid fa-circle-xmark"></i>
            </div>
            <div class="stat-label">Rejected</div>
            <div class="stat-value"><?= $totalRejected ?></div>
        </div>
    </div>

    <div class="modern-card">

        <div class="card-head">
            <div>
                <h4>Daftar Yayasan</h4>
                <p>Data registrasi yayasan yang masuk ke sistem.</p>
            </div>
        </div>

        <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <?= esc(session()->getFlashdata('success')) ?>
            </div>
        <?php endif; ?>

        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <?= esc(session()->getFlashdata('error')) ?>
            </div>
        <?php endif; ?>

        <form method="get" class="filter-box">
            <div class="row g-3">
                <div class="col-md-5">
                    <input
                        type="text"
                        name="keyword"
                        class="form-control"
                        placeholder="Cari nama yayasan..."
                        value="<?= esc($keyword ?? '') ?>">
                </div>

                <div class="col-md-4">
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>

                        <option value="pending" <?= ($status ?? '') === 'pending' ? 'selected' : '' ?>>
                            Pending
                        </option>

                        <option value="verified" <?= ($status ?? '') === 'verified' ? 'selected' : '' ?>>
                            Verified
                        </option>

                        <option value="rejected" <?= ($status ?? '') === 'rejected' ? 'selected' : '' ?>>
                            Rejected
                        </option>
                    </select>
                </div>

                <div class="col-md-3">
                    <button class="btn btn-modern w-100">
                        <i class="fa-solid fa-filter me-1"></i>
                        Filter
                    </button>
                </div>
            </div>
        </form>

        <?php if(empty($foundations)): ?>

            <div class="empty-state">
                <i class="fa-solid fa-folder-open"></i>
                <h5 class="fw-bold">Belum ada data yayasan</h5>
                <p class="mb-0">Data registrasi yayasan akan muncul setelah pengguna mendaftar.</p>
            </div>

        <?php else: ?>

            <div class="table-responsive">
                <table class="table modern-table align-middle">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Yayasan</th>
                            <th>Penanggung Jawab</th>
                            <th>Status</th>
                            <th>Tanggal Daftar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach($foundations as $f): ?>
                            <?php
                                $statusYayasan = $f['status'] ?? 'pending';
                                $hasPendingProfileChange = !empty($f['pending_profile_change']);
                                $activeCampaignCount = (int) ($f['active_campaign_count'] ?? 0);
                                $donationCount = (int) ($f['donation_count'] ?? 0);
                                $canDisableAccount = $activeCampaignCount === 0 && $donationCount === 0;
                                $canApproveVerification = $statusYayasan !== 'verified' || $hasPendingProfileChange;
                                $canRejectVerification = (($statusYayasan !== 'verified' && $statusYayasan !== 'rejected') || $hasPendingProfileChange);
                            ?>
                            <tr>
                                <td>
                                    <strong><?= $no++ ?></strong>
                                </td>

                                <td>
                                    <div class="foundation-name">
                                        <?= esc($f['nama_yayasan']) ?>
                                    </div>
                                    <div class="foundation-email">
                                        <?= esc($f['email_yayasan']) ?>
                                    </div>
                                </td>

                                <td>
                                    <?= esc($f['nama'] ?? '-') ?>
                                </td>

                                <td>
                                    <?php if($statusYayasan === 'pending'): ?>
                                        <span class="status-badge pending">
                                            <i class="fa-solid fa-clock"></i>
                                            Pending
                                        </span>
                                    <?php elseif($statusYayasan === 'verified'): ?>
                                        <span class="status-badge verified">
                                            <i class="fa-solid fa-circle-check"></i>
                                            Verified
                                        </span>
                                    <?php else: ?>
                                        <span class="status-badge rejected">
                                            <i class="fa-solid fa-circle-xmark"></i>
                                            Rejected
                                        </span>
                                    <?php endif; ?>

                                    <?php if($hasPendingProfileChange): ?>
                                        <div>
                                            <span class="change-badge">
                                                <i class="fa-solid fa-clock-rotate-left"></i>
                                                Perubahan pending
                                            </span>
                                        </div>
                                    <?php endif; ?>

                                    <?php if($activeCampaignCount > 0): ?>
                                        <div>
                                            <span class="active-campaign-badge">
                                                <i class="fa-solid fa-bullhorn"></i>
                                                <?= $activeCampaignCount ?> Campaign aktif
                                            </span>
                                        </div>
                                    <?php endif; ?>

                                    <?php if($donationCount > 0): ?>
                                        <div>
                                            <span class="active-campaign-badge" title="Yayasan sudah memiliki histori donasi">
                                                <i class="fa-solid fa-hand-holding-dollar"></i>
                                                <?= $donationCount ?> Donasi
                                            </span>
                                        </div>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <?= !empty($f['created_at']) ? date('d M Y', strtotime($f['created_at'])) : '-' ?>
                                </td>

                                <td>
                                    <div class="action-group">
                                        <a
                                            href="<?= base_url('admin/yayasan/detail/'.$f['id']) ?>"
                                            class="btn-action btn-view"
                                            title="Detail">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>

                                        <?php if($canApproveVerification): ?>
                                            <a
                                                href="<?= base_url('admin/yayasan/approve/'.$f['id']) ?>"
                                                class="btn-action btn-approve"
                                                title="Approve"
                                                onclick="return confirm('Setujui pengajuan ini?')">
                                                <i class="fa-solid fa-check"></i>
                                            </a>
                                        <?php endif; ?>

                                        <?php if($canRejectVerification): ?>
                                            <a
                                                href="<?= base_url('admin/yayasan/reject/'.$f['id']) ?>"
                                                class="btn-action btn-reject"
                                                title="Reject"
                                                onclick="return confirm('Tolak pengajuan ini?')">
                                                <i class="fa-solid fa-xmark"></i>
                                            </a>
                                        <?php endif; ?>

                                        <?php if($canDisableAccount): ?>
                                            <a
                                                href="<?= base_url('admin/yayasan/delete/'.$f['id']) ?>"
                                                class="btn-action btn-delete"
                                                title="Nonaktifkan"
                                                onclick="return confirm('Nonaktifkan akun yayasan ini?')">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>
                                        <?php else: ?>
                                            <span
                                                class="btn-action btn-disabled"
                                                title="Tidak bisa dinonaktifkan karena masih ada campaign aktif atau data donasi">
                                                <i class="fa-solid fa-lock"></i>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        <?php endif; ?>

    </div>

    <div class="mt-5 text-center text-muted">
        <hr>
        <p>
            © <?= date('Y') ?> Donasi Transparan | Sistem Informasi Donasi Berbasis Web
        </p>
    </div>

</div>

<?= $this->endSection() ?>