<?= $this->include('layouts/header') ?>
<?php
helper('text');

$stats = $stats ?? [
    'total_campaign' => count($campaigns ?? []),
    'total_dana' => 0,
    'total_donatur' => 0,
    'total_yayasan' => 0,
];

$isLoggedIn = (bool) session()->get('logged_in');
$userRole   = session()->get('role');
$isDonatur  = $isLoggedIn && $userRole === 'donatur';
$namaUser   = session()->get('nama') ?: 'Donatur';
$donorStats = $donorStats ?? null;
$publicReports = $publicReports ?? [];
$totalReports = $totalReports ?? count($publicReports);

$formatRupiah = static function ($value): string {
    return 'Rp ' . number_format((float) $value, 0, ',', '.');
};

$formatCompact = static function ($value): string {
    $value = (float) $value;
    if ($value >= 1000000000) {
        return 'Rp ' . rtrim(rtrim(number_format($value / 1000000000, 1, ',', '.'), '0'), ',') . ' M';
    }
    if ($value >= 1000000) {
        return 'Rp ' . rtrim(rtrim(number_format($value / 1000000, 1, ',', '.'), '0'), ',') . ' Jt';
    }
    return 'Rp ' . number_format($value, 0, ',', '.');
};

$campaignProgress = static function (array $campaign): int {
    $target = (float) ($campaign['target_dana'] ?? 0);
    $collected = (float) ($campaign['dana_terkumpul'] ?? 0);

    if ($target <= 0) {
        return 0;
    }

    return (int) min(100, round(($collected / $target) * 100));
};

$campaignImage = static function (array $campaign): string {
    if (!empty($campaign['gambar'])) {
        return base_url('uploads/campaign/' . $campaign['gambar']);
    }

    return 'https://placehold.co/900x600/223149/ffffff?text=DonasiKu';
};

$featuredCampaigns = $featuredCampaigns ?? array_slice($campaigns ?? [], 0, 3);
?>

<style>
    .home-page {
        overflow: hidden;
    }

    .hero-section {
        position: relative;
        padding: 86px 0 64px;
        background:
            radial-gradient(circle at 10% 12%, rgba(37, 99, 235, .16), transparent 34%),
            radial-gradient(circle at 80% 10%, rgba(79, 70, 229, .13), transparent 32%),
            linear-gradient(180deg, #ffffff 0%, #f5f8ff 100%);
    }

    .hero-section::before,
    .hero-section::after {
        content: '';
        position: absolute;
        border-radius: 999px;
        filter: blur(2px);
        opacity: .75;
        pointer-events: none;
        animation: floatShape 7s ease-in-out infinite;
    }

    .hero-section::before {
        width: 220px;
        height: 220px;
        right: 7%;
        top: 120px;
        background: rgba(37, 99, 235, .10);
    }

    .hero-section::after {
        width: 160px;
        height: 160px;
        left: 7%;
        bottom: 80px;
        background: rgba(34, 197, 94, .12);
        animation-delay: -2s;
    }

    .eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        padding: 10px 14px;
        border-radius: 999px;
        background: rgba(37, 99, 235, .08);
        color: var(--dk-primary);
        font-weight: 900;
        border: 1px solid rgba(37, 99, 235, .12);
    }

    .hero-title {
        margin: 22px 0 18px;
        font-size: clamp(42px, 6vw, 78px);
        line-height: 1.04;
        letter-spacing: -2px;
        font-weight: 950;
        color: var(--dk-navy);
    }

    .hero-title span {
        display: inline-block;
        color: transparent;
        background: linear-gradient(135deg, var(--dk-primary), var(--dk-secondary));
        -webkit-background-clip: text;
        background-clip: text;
    }

    .hero-desc {
        max-width: 630px;
        color: #5f718d;
        font-size: 18px;
        line-height: 1.85;
        font-weight: 500;
    }

    .hero-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 14px;
        margin-top: 28px;
    }

    .trust-row {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-top: 28px;
    }

    .trust-pill {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        padding: 12px 15px;
        border-radius: 18px;
        background: #ffffff;
        color: var(--dk-navy);
        border: 1px solid var(--dk-border);
        box-shadow: 0 12px 28px rgba(15, 23, 42, .05);
        font-weight: 800;
    }

    .hero-visual {
        position: relative;
        min-height: 520px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .visual-shell {
        position: relative;
        width: min(440px, 100%);
        padding: 18px;
        border-radius: 40px;
        background: rgba(255,255,255,.66);
        border: 1px solid rgba(255,255,255,.9);
        box-shadow: var(--dk-shadow);
        backdrop-filter: blur(18px);
        animation: floatCard 5.5s ease-in-out infinite;
    }

    .visual-card {
        position: relative;
        overflow: hidden;
        min-height: 430px;
        border-radius: 32px;
        background: linear-gradient(145deg, var(--dk-navy), #26375c 58%, var(--dk-primary));
        color: #ffffff;
        padding: 28px;
    }

    .visual-card::before {
        content: '';
        position: absolute;
        inset: -90px -80px auto auto;
        width: 260px;
        height: 260px;
        border-radius: 50%;
        background: rgba(255,255,255,.13);
    }

    .visual-card::after {
        content: '';
        position: absolute;
        left: -70px;
        bottom: -70px;
        width: 210px;
        height: 210px;
        border-radius: 50%;
        background: rgba(34, 197, 94, .24);
    }

    .visual-logo {
        position: relative;
        z-index: 1;
        width: 78px;
        height: 78px;
        border-radius: 26px;
        background: rgba(255, 255, 255, .16);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 34px;
        box-shadow: inset 0 0 0 1px rgba(255,255,255,.20);
    }

    .visual-title {
        position: relative;
        z-index: 1;
        margin-top: 28px;
        font-size: 36px;
        line-height: 1.16;
        font-weight: 950;
        letter-spacing: -1px;
    }

    .visual-mini {
        position: relative;
        z-index: 1;
        margin-top: 26px;
        display: grid;
        gap: 14px;
    }

    .mini-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        padding: 14px;
        border-radius: 20px;
        background: rgba(255,255,255,.13);
        border: 1px solid rgba(255,255,255,.14);
        backdrop-filter: blur(8px);
    }

    .mini-row strong {
        display: block;
        font-size: 14px;
    }

    .mini-row span {
        color: rgba(255,255,255,.74);
        font-size: 12px;
        font-weight: 700;
    }

    .mini-icon {
        width: 42px;
        height: 42px;
        border-radius: 15px;
        background: #ffffff;
        color: var(--dk-primary);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .floating-badge {
        position: absolute;
        z-index: 2;
        display: inline-flex;
        align-items: center;
        gap: 9px;
        padding: 13px 16px;
        border-radius: 20px;
        background: #ffffff;
        border: 1px solid var(--dk-border);
        box-shadow: var(--dk-shadow);
        color: var(--dk-navy);
        font-weight: 900;
    }

    .floating-badge.top {
        top: 46px;
        right: 0;
    }

    .floating-badge.bottom {
        bottom: 52px;
        left: 0;
    }

    .stats-section {
        position: relative;
        z-index: 3;
        margin-top: -28px;
    }

    .stat-card {
        height: 100%;
        padding: 24px;
        border-radius: 28px;
        background: #ffffff;
        border: 1px solid var(--dk-border);
        box-shadow: var(--dk-shadow);
        transition: .24s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
    }

    .stat-icon {
        width: 56px;
        height: 56px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        background: linear-gradient(135deg, var(--dk-primary), var(--dk-secondary));
        font-size: 22px;
        margin-bottom: 18px;
    }

    .stat-card:nth-child(2) .stat-icon,
    .stat-card:nth-child(4) .stat-icon {
        background: linear-gradient(135deg, #16a34a, #22c55e);
    }

    .stat-value {
        color: var(--dk-navy);
        font-size: 32px;
        font-weight: 950;
        letter-spacing: -1px;
    }

    .stat-label {
        margin-top: 2px;
        color: var(--dk-muted);
        font-weight: 700;
    }

    .section-block {
        padding: 86px 0;
    }

    .section-head {
        display: flex;
        align-items: end;
        justify-content: space-between;
        gap: 18px;
        margin-bottom: 28px;
    }

    .section-title {
        color: var(--dk-navy);
        font-size: clamp(30px, 4vw, 46px);
        font-weight: 950;
        letter-spacing: -1.2px;
        margin: 0;
    }

    .section-subtitle {
        color: var(--dk-muted);
        margin: 10px 0 0;
        line-height: 1.7;
        font-weight: 600;
    }

    .action-card {
        position: relative;
        overflow: hidden;
        height: 100%;
        padding: 30px;
        border-radius: 32px;
        background: #ffffff;
        border: 1px solid var(--dk-border);
        box-shadow: var(--dk-shadow);
        transition: .24s ease;
    }

    .action-card:hover {
        transform: translateY(-6px);
    }

    .action-card::after {
        content: '';
        position: absolute;
        width: 190px;
        height: 190px;
        border-radius: 50%;
        right: -90px;
        top: -90px;
        background: rgba(37, 99, 235, .08);
    }

    .action-icon {
        width: 70px;
        height: 70px;
        border-radius: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, var(--dk-primary), var(--dk-secondary));
        color: #ffffff;
        font-size: 28px;
        margin-bottom: 22px;
    }

    .action-card.green .action-icon {
        background: linear-gradient(135deg, #16a34a, #22c55e);
    }

    .action-card h3 {
        color: var(--dk-navy);
        font-size: 28px;
        font-weight: 950;
        letter-spacing: -.6px;
    }

    .action-card p {
        color: var(--dk-muted);
        line-height: 1.75;
        font-weight: 600;
    }

    .category-scroller {
        display: flex;
        gap: 12px;
        overflow-x: auto;
        padding-bottom: 8px;
        scrollbar-width: thin;
    }

    .category-chip {
        flex: 0 0 auto;
        display: inline-flex;
        align-items: center;
        gap: 9px;
        border: 0;
        padding: 13px 17px;
        border-radius: 999px;
        background: #ffffff;
        color: var(--dk-navy);
        font-weight: 900;
        box-shadow: 0 10px 26px rgba(15, 23, 42, .06);
        border: 1px solid var(--dk-border);
        transition: .2s ease;
    }

    .category-chip.active,
    .category-chip:hover {
        color: #ffffff;
        background: linear-gradient(135deg, var(--dk-primary), var(--dk-secondary));
        transform: translateY(-2px);
    }

    .campaign-tools {
        display: grid;
        grid-template-columns: 1fr auto;
        gap: 14px;
        margin: 24px 0 28px;
    }

    .search-box {
        position: relative;
    }

    .search-box i {
        position: absolute;
        left: 18px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--dk-primary);
    }

    .search-box input {
        width: 100%;
        min-height: 56px;
        border: 1px solid var(--dk-border);
        background: #ffffff;
        border-radius: 20px;
        padding: 14px 18px 14px 50px;
        box-shadow: 0 10px 24px rgba(15, 23, 42, .04);
        outline: 0;
        color: var(--dk-navy);
        font-weight: 700;
    }

    .campaign-count-pill {
        min-height: 56px;
        display: inline-flex;
        align-items: center;
        padding: 12px 18px;
        border-radius: 20px;
        background: var(--dk-navy);
        color: #ffffff;
        font-weight: 900;
        white-space: nowrap;
    }

    .campaign-card {
        height: 100%;
        overflow: hidden;
        border-radius: 32px;
        background: #ffffff;
        border: 1px solid var(--dk-border);
        box-shadow: var(--dk-shadow);
        transition: .24s ease;
    }

    .campaign-card:hover {
        transform: translateY(-7px);
    }

    .campaign-image-wrap {
        position: relative;
        height: 235px;
        overflow: hidden;
        background: var(--dk-navy);
    }

    .campaign-image-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: .42s ease;
    }

    .campaign-card:hover img {
        transform: scale(1.06);
    }

    .campaign-badge {
        position: absolute;
        left: 18px;
        top: 18px;
        padding: 9px 13px;
        border-radius: 999px;
        background: rgba(255,255,255,.92);
        color: var(--dk-primary);
        font-weight: 900;
        font-size: 13px;
        backdrop-filter: blur(8px);
    }

    .campaign-body {
        padding: 24px;
    }

    .campaign-title {
        color: var(--dk-navy);
        font-size: 23px;
        font-weight: 950;
        line-height: 1.25;
        min-height: 58px;
        margin-bottom: 10px;
    }

    .campaign-meta {
        display: flex;
        align-items: center;
        gap: 8px;
        color: var(--dk-muted);
        font-weight: 700;
        margin-bottom: 12px;
    }

    .campaign-desc {
        color: #62738d;
        line-height: 1.65;
        min-height: 54px;
        margin-bottom: 18px;
    }

    .progress-track {
        height: 11px;
        border-radius: 999px;
        background: #edf2f8;
        overflow: hidden;
        margin-bottom: 13px;
    }

    .progress-fill {
        width: 0;
        height: 100%;
        border-radius: 999px;
        background: linear-gradient(135deg, var(--dk-primary), var(--dk-secondary));
        transition: width 1s ease;
    }

    .donation-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        color: var(--dk-muted);
        font-weight: 800;
        margin-bottom: 18px;
    }

    .donation-row strong {
        display: block;
        color: var(--dk-navy);
        font-size: 19px;
        font-weight: 950;
    }

    .steps-wrap {
        position: relative;
    }

    .step-card {
        height: 100%;
        padding: 26px;
        border-radius: 28px;
        background: #ffffff;
        border: 1px solid var(--dk-border);
        box-shadow: 0 16px 42px rgba(15, 23, 42, .06);
    }

    .step-number {
        width: 52px;
        height: 52px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 18px;
        color: #ffffff;
        background: linear-gradient(135deg, var(--dk-primary), var(--dk-secondary));
        font-weight: 950;
        margin-bottom: 18px;
    }

    .step-card h4 {
        color: var(--dk-navy);
        font-weight: 950;
    }

    .step-card p {
        color: var(--dk-muted);
        line-height: 1.7;
        margin: 0;
        font-weight: 600;
    }

    .cta-section {
        padding: 0 0 86px;
    }

    .cta-card {
        position: relative;
        overflow: hidden;
        border-radius: 40px;
        padding: 52px;
        background: linear-gradient(135deg, var(--dk-navy), #22365d 56%, var(--dk-primary));
        color: #ffffff;
        box-shadow: var(--dk-shadow);
    }

    .cta-card::before {
        content: '';
        position: absolute;
        width: 340px;
        height: 340px;
        border-radius: 50%;
        right: -120px;
        top: -120px;
        background: rgba(255,255,255,.12);
    }

    .cta-card h2 {
        font-size: clamp(32px, 4vw, 50px);
        font-weight: 950;
        letter-spacing: -1.2px;
    }

    .cta-card p {
        color: rgba(255,255,255,.78);
        font-size: 17px;
        line-height: 1.75;
        max-width: 680px;
    }

    .empty-state {
        padding: 54px 24px;
        border-radius: 32px;
        background: #ffffff;
        border: 1px dashed #cbd5e1;
        text-align: center;
        color: var(--dk-muted);
    }

    .reveal {
        opacity: 0;
        transform: translateY(26px);
        transition: .6s ease;
    }

    .reveal.show {
        opacity: 1;
        transform: translateY(0);
    }

    @keyframes floatShape {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(24px); }
    }

    @keyframes floatCard {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-13px); }
    }

    @media(max-width: 991px) {
        .hero-section {
            padding-top: 58px;
        }

        .hero-visual {
            min-height: 420px;
            margin-top: 30px;
        }

        .floating-badge.top {
            right: 14px;
        }

        .floating-badge.bottom {
            left: 14px;
        }

        .section-head,
        .campaign-tools {
            grid-template-columns: 1fr;
            flex-direction: column;
            align-items: flex-start;
        }
    }


    .flash-home-alert {
        position: relative;
        z-index: 5;
        margin: 0;
        border: 0;
        border-radius: 0;
        padding: 16px 0;
        background: #dcfce7;
        color: #166534;
        font-weight: 800;
    }

    .donor-welcome-card {
        margin-top: 26px;
        max-width: 650px;
        padding: 20px;
        border-radius: 26px;
        background: rgba(255, 255, 255, .88);
        border: 1px solid rgba(37, 99, 235, .14);
        box-shadow: 0 18px 42px rgba(15, 23, 42, .08);
        display: grid;
        grid-template-columns: auto 1fr;
        gap: 16px;
        align-items: center;
    }

    .donor-welcome-icon {
        width: 58px;
        height: 58px;
        border-radius: 20px;
        color: #ffffff;
        background: linear-gradient(135deg, var(--dk-primary), var(--dk-secondary));
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }

    .donor-welcome-card h3 {
        margin: 0 0 4px;
        font-size: 22px;
        font-weight: 950;
        color: var(--dk-navy);
    }

    .donor-welcome-card p {
        margin: 0;
        color: #5f718d;
        font-weight: 650;
        line-height: 1.6;
    }

    .donor-mini-stats {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 12px;
    }

    .donor-mini-stats span {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 9px 12px;
        border-radius: 999px;
        background: #f2f6ff;
        color: var(--dk-navy);
        font-size: 13px;
        font-weight: 900;
    }

    .campaign-actions-inline {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
    }

    @media(max-width: 576px) {
        .donor-welcome-card {
            grid-template-columns: 1fr;
        }

        .campaign-actions-inline {
            grid-template-columns: 1fr;
        }
    }

    @media(max-width: 576px) {
        .hero-actions .btn,
        .campaign-tools .campaign-count-pill {
            width: 100%;
            justify-content: center;
        }

        .visual-card {
            min-height: 360px;
        }

        .cta-card {
            padding: 34px 24px;
        }
    }

    .report-preview-card {
        height: 100%;
        border-radius: 30px;
        background: #ffffff;
        border: 1px solid var(--dk-border);
        overflow: hidden;
        box-shadow: 0 18px 44px rgba(15, 23, 42, .07);
        transition: .22s ease;
    }
    .report-preview-card:hover { transform: translateY(-5px); box-shadow: 0 28px 64px rgba(15, 23, 42, .12); }
    .report-preview-top {
        min-height: 138px;
        padding: 22px;
        background:
            radial-gradient(circle at 84% 20%, rgba(34, 197, 94, .18), transparent 34%),
            linear-gradient(135deg, #172339, #2563eb);
        color: #ffffff;
    }
    .report-preview-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 12px;
        border-radius: 999px;
        background: rgba(255,255,255,.15);
        font-weight: 950;
        font-size: 13px;
        margin-bottom: 14px;
    }
    .report-preview-title {
        font-size: 22px;
        font-weight: 950;
        line-height: 1.25;
        margin: 0;
    }
    .report-preview-body { padding: 22px; }
    .report-preview-meta {
        color: var(--dk-muted);
        font-weight: 800;
        line-height: 1.7;
        margin-bottom: 14px;
    }
    .report-preview-total {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        padding: 14px 16px;
        border-radius: 20px;
        background: #f5f8ff;
        color: var(--dk-navy);
        font-weight: 950;
        margin-bottom: 16px;
    }

</style>

<main class="home-page">
    <?php if (session()->getFlashdata('success')): ?>
        <div class="flash-home-alert">
            <div class="container">
                <i class="fa-solid fa-circle-check me-2"></i><?= esc(session()->getFlashdata('success')) ?>
            </div>
        </div>
    <?php endif; ?>

    <section class="hero-section">
        <div class="container position-relative">
            <div class="row align-items-center">
                <div class="col-lg-6 reveal show">
                    <span class="eyebrow">
                        <i class="fa-solid fa-shield-heart"></i>
                        Platform Donasi Aman & Transparan
                    </span>

                    <h1 class="hero-title">
                        Bantu sesama lewat <span>DonasiKu.</span>
                    </h1>

                    <p class="hero-desc">
                        Temukan campaign resmi dari yayasan terverifikasi, salurkan bantuan dengan mudah, dan pantau perkembangan dana secara transparan dalam satu sistem.
                    </p>

                    <div class="hero-actions">
                        <a href="#campaign" class="btn btn-dk-primary btn-lg">
                            <i class="fa-solid fa-hand-holding-heart me-2"></i><?= $isDonatur ? 'Mulai Donasi' : 'Lihat Campaign' ?>
                        </a>
                        <?php if ($isDonatur): ?>
                            <a href="<?= base_url('donatur/history') ?>" class="btn btn-dk-outline btn-lg">
                                <i class="fa-solid fa-clock-rotate-left me-2"></i>Riwayat Donasi
                            </a>
                        <?php else: ?>
                            <a href="<?= base_url('register-yayasan') ?>" class="btn btn-dk-outline btn-lg">
                                <i class="fa-solid fa-building-ngo me-2"></i>Daftar Yayasan
                            </a>
                        <?php endif; ?>
                    </div>

                    <?php if ($isDonatur): ?>
                        <div class="donor-welcome-card">
                            <div class="donor-welcome-icon"><i class="fa-solid fa-user-heart"></i></div>
                            <div>
                                <h3>Halo, <?= esc($namaUser) ?></h3>
                                <p>Anda sudah masuk sebagai donatur. Pilih campaign aktif, lalu lanjutkan donasi dengan pembayaran yang tersedia.</p>
                                <div class="donor-mini-stats">
                                    <span><i class="fa-solid fa-receipt text-primary"></i><?= esc((int) ($donorStats['total_transaksi'] ?? 0)) ?> transaksi</span>
                                    <span><i class="fa-solid fa-wallet text-success"></i><?= esc($formatRupiah($donorStats['total_berhasil'] ?? 0)) ?> berhasil</span>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="trust-row">
                        <span class="trust-pill"><i class="fa-solid fa-circle-check text-success"></i>Yayasan Terverifikasi</span>
                        <span class="trust-pill"><i class="fa-solid fa-lock text-primary"></i>Pembayaran Aman</span>
                        <span class="trust-pill"><i class="fa-solid fa-chart-line text-warning"></i>Dana Terpantau</span>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="hero-visual reveal">
                        <div class="floating-badge top">
                            <i class="fa-solid fa-bell text-primary"></i>
                            Notifikasi Real-time
                        </div>

                        <div class="visual-shell">
                            <div class="visual-card">
                                <div class="visual-logo">
                                    <i class="fa-solid fa-hand-holding-heart"></i>
                                </div>
                                <div class="visual-title">
                                    Satu klik untuk memberi dampak nyata.
                                </div>
                                <div class="visual-mini">
                                    <div class="mini-row">
                                        <div>
                                            <strong>Campaign aktif</strong>
                                            <span>Donasi bisa langsung disalurkan</span>
                                        </div>
                                        <div class="mini-icon"><i class="fa-solid fa-bullhorn"></i></div>
                                    </div>
                                    <div class="mini-row">
                                        <div>
                                            <strong>Transparansi dana</strong>
                                            <span>Nominal terkumpul selalu tercatat</span>
                                        </div>
                                        <div class="mini-icon"><i class="fa-solid fa-receipt"></i></div>
                                    </div>
                                    <div class="mini-row">
                                        <div>
                                            <strong>Donatur terlindungi</strong>
                                            <span>Nama bisa ditampilkan atau disembunyikan</span>
                                        </div>
                                        <div class="mini-icon"><i class="fa-solid fa-user-shield"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="floating-badge bottom">
                            <i class="fa-solid fa-wallet text-success"></i>
                            <?= esc($formatCompact($stats['total_dana'] ?? 0)) ?> Terkumpul
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="stats-section">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-6 col-xl-3 reveal">
                    <div class="stat-card">
                        <div class="stat-icon"><i class="fa-solid fa-bullhorn"></i></div>
                        <div class="stat-value js-counter" data-target="<?= esc((int) ($stats['total_campaign'] ?? 0)) ?>">0</div>
                        <div class="stat-label">Campaign Aktif</div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3 reveal">
                    <div class="stat-card">
                        <div class="stat-icon"><i class="fa-solid fa-building-ngo"></i></div>
                        <div class="stat-value js-counter" data-target="<?= esc((int) ($stats['total_yayasan'] ?? 0)) ?>">0</div>
                        <div class="stat-label">Yayasan Terverifikasi</div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3 reveal">
                    <div class="stat-card">
                        <div class="stat-icon"><i class="fa-solid fa-users"></i></div>
                        <div class="stat-value js-counter" data-target="<?= esc((int) ($stats['total_donatur'] ?? 0)) ?>">0</div>
                        <div class="stat-label">Donatur Berpartisipasi</div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3 reveal">
                    <div class="stat-card">
                        <div class="stat-icon"><i class="fa-solid fa-sack-dollar"></i></div>
                        <div class="stat-value"><?= esc($formatCompact($stats['total_dana'] ?? 0)) ?></div>
                        <div class="stat-label">Dana Terkumpul</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-block" id="kategori">
        <div class="container">
            <div class="section-head reveal">
                <div>
                    <h2 class="section-title">Mulai dari kebutuhan yang paling dekat.</h2>
                    <p class="section-subtitle">Pilih kategori donasi dan temukan campaign yang sesuai dengan niat baik Anda.</p>
                </div>
            </div>

            <div class="category-scroller reveal" id="categoryFilter">
                <button class="category-chip active" type="button" data-filter="all">
                    <i class="fa-solid fa-layer-group"></i> Semua Campaign
                </button>
                <?php foreach (($categories ?? []) as $category): ?>
                    <button class="category-chip" type="button" data-filter="<?= esc(strtolower($category['nama_kategori'] ?? 'umum')) ?>">
                        <i class="fa-solid <?= esc($category['icon'] ?: 'fa-hand-holding-heart') ?>"></i>
                        <?= esc($category['nama_kategori'] ?? 'Umum') ?>
                        <small>(<?= esc((int) ($category['total_campaign'] ?? 0)) ?>)</small>
                    </button>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="section-block pt-0" id="campaign">
        <div class="container">
            <div class="section-head reveal">
                <div>
                    <h2 class="section-title">Campaign donasi terbaru.</h2>
                    <p class="section-subtitle">Seluruh campaign yang tampil sudah melewati verifikasi admin dan siap menerima donasi.</p>
                </div>
                <?php if ($isDonatur): ?>
                    <a href="<?= base_url('donatur/history') ?>" class="btn btn-dk-soft">
                        <i class="fa-solid fa-clock-rotate-left me-2"></i>Riwayat Donasi
                    </a>
                <?php elseif (!$isLoggedIn): ?>
                    <a href="<?= base_url('login') ?>" class="btn btn-dk-soft">
                        <i class="fa-solid fa-arrow-right-to-bracket me-2"></i>Masuk untuk Donasi
                    </a>
                <?php endif; ?>
            </div>

            <div class="campaign-tools reveal">
                <div class="search-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="search" id="campaignSearch" placeholder="Cari judul campaign, kategori, atau nama yayasan...">
                </div>
                <div class="campaign-count-pill" id="campaignCounter">
                    <?= count($campaigns ?? []) ?> campaign tampil
                </div>
            </div>

            <?php if (!empty($campaigns)): ?>
                <div class="row g-4" id="campaignGrid">
                    <?php foreach ($campaigns as $campaign): ?>
                        <?php
                            $progress = $campaignProgress($campaign);
                            $categoryName = $campaign['nama_kategori'] ?? 'Umum';
                            $searchText = strtolower(trim(($campaign['judul'] ?? '') . ' ' . $categoryName . ' ' . ($campaign['nama_yayasan'] ?? '')));
                        ?>
                        <div class="col-md-6 col-xl-4 campaign-item reveal" data-category="<?= esc(strtolower($categoryName)) ?>" data-search="<?= esc($searchText) ?>">
                            <article class="campaign-card">
                                <div class="campaign-image-wrap">
                                    <img src="<?= esc($campaignImage($campaign)) ?>" alt="<?= esc($campaign['judul'] ?? 'Campaign Donasi') ?>">
                                    <span class="campaign-badge"><i class="fa-solid fa-tag me-1"></i><?= esc($categoryName) ?></span>
                                </div>
                                <div class="campaign-body">
                                    <div class="campaign-meta">
                                        <i class="fa-solid fa-building-ngo"></i>
                                        <span><?= esc($campaign['nama_yayasan'] ?? 'Yayasan') ?></span>
                                    </div>
                                    <h3 class="campaign-title"><?= esc($campaign['judul'] ?? '-') ?></h3>
                                    <p class="campaign-desc">
                                        <?= esc(character_limiter(strip_tags($campaign['deskripsi'] ?? ''), 105)) ?>
                                    </p>

                                    <div class="progress-track" aria-label="Progress donasi">
                                        <div class="progress-fill" data-progress="<?= esc($progress) ?>"></div>
                                    </div>

                                    <div class="donation-row">
                                        <span>
                                            <strong><?= esc($formatRupiah($campaign['dana_terkumpul'] ?? 0)) ?></strong>
                                            terkumpul
                                        </span>
                                        <span><?= esc($progress) ?>%</span>
                                    </div>

                                    <?php if ($isDonatur): ?>
                                        <div class="campaign-actions-inline">
                                            <a href="<?= base_url('campaign/' . $campaign['id']) ?>" class="btn btn-dk-outline w-100">
                                                <i class="fa-solid fa-circle-info me-2"></i>Detail
                                            </a>
                                            <a href="<?= base_url('donatur/donation/create/' . $campaign['id']) ?>" class="btn btn-dk-primary w-100">
                                                <i class="fa-solid fa-heart me-2"></i>Donasi
                                            </a>
                                        </div>
                                    <?php else: ?>
                                        <a href="<?= base_url('campaign/' . $campaign['id']) ?>" class="btn btn-dk-primary w-100">
                                            <i class="fa-solid fa-circle-info me-2"></i>Lihat Detail
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </article>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="empty-state d-none" id="emptyCampaign">
                    <i class="fa-solid fa-magnifying-glass fa-2x mb-3 text-primary"></i>
                    <h4 class="fw-bold text-dark">Campaign tidak ditemukan</h4>
                    <p class="mb-0">Coba gunakan kata kunci lain atau pilih kategori semua campaign.</p>
                </div>
            <?php else: ?>
                <div class="empty-state reveal">
                    <i class="fa-solid fa-box-open fa-3x mb-3 text-primary"></i>
                    <h4 class="fw-bold text-dark">Belum ada campaign aktif</h4>
                    <p class="mb-0">Campaign yang sudah disetujui admin akan tampil di halaman ini.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>


    <section class="section-block pt-0" id="laporan">
        <div class="container">
            <div class="section-head reveal">
                <div>
                    <h2 class="section-title">Laporan dana yang bisa dilihat publik.</h2>
                    <p class="section-subtitle">Laporan penggunaan dana yang sudah disetujui admin dapat dibaca dan dikomentari oleh semua orang.</p>
                </div>
                <a href="<?= base_url('laporan') ?>" class="btn btn-dk-soft">
                    <i class="fa-solid fa-file-circle-check me-2"></i>Lihat Semua Laporan
                </a>
            </div>

            <?php if(!empty($publicReports)): ?>
                <div class="row g-4">
                    <?php foreach($publicReports as $report): ?>
                        <div class="col-md-6 col-xl-4 reveal">
                            <article class="report-preview-card">
                                <div class="report-preview-top">
                                    <span class="report-preview-pill"><i class="fa-solid fa-circle-check"></i> Dipublikasikan</span>
                                    <h3 class="report-preview-title"><?= esc($report['judul_laporan'] ?? '-') ?></h3>
                                </div>
                                <div class="report-preview-body">
                                    <div class="report-preview-meta">
                                        <div><i class="fa-solid fa-hand-holding-heart me-2 text-primary"></i><?= esc($report['campaign_judul'] ?? '-') ?></div>
                                        <div><i class="fa-solid fa-building-ngo me-2 text-success"></i><?= esc($report['nama_yayasan'] ?? '-') ?></div>
                                        <div><i class="fa-solid fa-comments me-2 text-warning"></i><?= esc((int)($report['total_komentar'] ?? 0)) ?> komentar</div>
                                    </div>
                                    <div class="report-preview-total">
                                        <span>Pengeluaran</span>
                                        <span><?= esc($formatRupiah($report['total_pengeluaran'] ?? 0)) ?></span>
                                    </div>
                                    <a href="<?= base_url('laporan/' . $report['id']) ?>" class="btn btn-dk-primary w-100">
                                        <i class="fa-solid fa-comments me-2"></i>Lihat & Komentari
                                    </a>
                                </div>
                            </article>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="empty-state reveal">
                    <i class="fa-solid fa-file-circle-exclamation fa-3x mb-3 text-primary"></i>
                    <h4 class="fw-bold text-dark">Belum ada laporan publik</h4>
                    <p class="mb-0">Laporan akan tampil setelah yayasan mengirim laporan dan admin menyetujuinya.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <section class="section-block pt-0" id="alur">
        <div class="container">
            <div class="section-head reveal">
                <div>
                    <h2 class="section-title">Alur donasi dibuat sederhana.</h2>
                    <p class="section-subtitle">Donatur dapat berdonasi dengan mudah, sedangkan yayasan tetap melalui proses verifikasi agar data lebih aman.</p>
                </div>
            </div>

            <div class="row g-4 steps-wrap">
                <div class="col-md-4 reveal">
                    <div class="step-card">
                        <div class="step-number">01</div>
                        <h4>Pilih Campaign</h4>
                        <p>Lihat daftar campaign aktif, baca detail kebutuhan, target dana, dan yayasan pengelolanya.</p>
                    </div>
                </div>
                <div class="col-md-4 reveal">
                    <div class="step-card">
                        <div class="step-number">02</div>
                        <h4>Lakukan Donasi</h4>
                        <p>Masuk sebagai donatur, pilih nominal, lalu lanjutkan pembayaran melalui sistem pembayaran yang tersedia.</p>
                    </div>
                </div>
                <div class="col-md-4 reveal">
                    <div class="step-card">
                        <div class="step-number">03</div>
                        <h4>Pantau Perkembangan</h4>
                        <p>Nominal donasi dan status campaign tercatat sehingga proses donasi lebih rapi dan transparan.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-block pt-0">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-6 reveal">
                    <div class="action-card">
                        <div class="action-icon"><i class="fa-solid fa-user-heart"></i></div>
                        <h3><?= $isDonatur ? 'Akses Donatur' : 'Untuk Donatur' ?></h3>
                        <p><?= $isDonatur ? 'Anda sudah masuk sebagai donatur. Gunakan halaman utama ini untuk memilih campaign dan memantau riwayat donasi.' : 'Temukan campaign terpercaya, pilih apakah nama ingin ditampilkan atau disembunyikan, lalu donasi dengan proses yang lebih cepat.' ?></p>
                        <?php if ($isDonatur): ?>
                            <a href="<?= base_url('donatur/history') ?>" class="btn btn-dk-primary">Lihat Riwayat Donasi</a>
                        <?php else: ?>
                            <a href="<?= base_url('register') ?>" class="btn btn-dk-primary">Daftar sebagai Donatur</a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-lg-6 reveal">
                    <div class="action-card green">
                        <div class="action-icon"><i class="fa-solid fa-building-ngo"></i></div>
                        <h3>Untuk Yayasan</h3>
                        <p>Daftarkan profil yayasan lengkap, tunggu verifikasi admin, lalu ajukan campaign donasi yang bisa dipantau dari dashboard yayasan.</p>
                        <a href="<?= base_url('register-yayasan') ?>" class="btn btn-dk-primary">Daftar sebagai Yayasan</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="cta-section">
        <div class="container">
            <div class="cta-card reveal">
                <h2>Gerakkan kebaikan dengan sistem yang lebih transparan.</h2>
                <p>DonasiKu membantu donatur, yayasan, dan admin berada dalam satu alur yang jelas: pendaftaran, verifikasi, campaign, donasi, hingga laporan penggunaan dana.</p>
                <div class="hero-actions">
                    <a href="#campaign" class="btn btn-light btn-lg fw-bold"><i class="fa-solid fa-heart me-2 text-danger"></i>Mulai Donasi</a>
                    <?php if ($isDonatur): ?>
                        <a href="<?= base_url('donatur/history') ?>" class="btn btn-dk-outline btn-lg">Riwayat Saya</a>
                    <?php else: ?>
                        <a href="<?= base_url('login') ?>" class="btn btn-dk-outline btn-lg">Masuk Akun</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const revealItems = document.querySelectorAll('.reveal');
        const progressBars = document.querySelectorAll('.progress-fill');
        const counters = document.querySelectorAll('.js-counter');
        const campaignSearch = document.getElementById('campaignSearch');
        const campaignItems = document.querySelectorAll('.campaign-item');
        const categoryButtons = document.querySelectorAll('.category-chip');
        const campaignCounter = document.getElementById('campaignCounter');
        const emptyCampaign = document.getElementById('emptyCampaign');
        let activeCategory = 'all';

        const revealObserver = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('show');
                    revealObserver.unobserve(entry.target);
                }
            });
        }, { threshold: .12 });

        revealItems.forEach(function (item) {
            revealObserver.observe(item);
        });

        const progressObserver = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    const value = entry.target.getAttribute('data-progress') || 0;
                    entry.target.style.width = value + '%';
                    progressObserver.unobserve(entry.target);
                }
            });
        }, { threshold: .35 });

        progressBars.forEach(function (bar) {
            progressObserver.observe(bar);
        });

        counters.forEach(function (counter) {
            const target = parseInt(counter.getAttribute('data-target') || '0', 10);
            const duration = 900;
            const startTime = performance.now();

            function animateCounter(now) {
                const progress = Math.min((now - startTime) / duration, 1);
                counter.textContent = Math.floor(progress * target).toLocaleString('id-ID');

                if (progress < 1) {
                    requestAnimationFrame(animateCounter);
                }
            }

            requestAnimationFrame(animateCounter);
        });

        function filterCampaigns() {
            const keyword = (campaignSearch ? campaignSearch.value : '').toLowerCase().trim();
            let visible = 0;

            campaignItems.forEach(function (item) {
                const category = item.getAttribute('data-category') || '';
                const search = item.getAttribute('data-search') || '';
                const matchCategory = activeCategory === 'all' || category === activeCategory;
                const matchKeyword = keyword === '' || search.includes(keyword);

                if (matchCategory && matchKeyword) {
                    item.classList.remove('d-none');
                    visible++;
                } else {
                    item.classList.add('d-none');
                }
            });

            if (campaignCounter) {
                campaignCounter.textContent = visible + ' campaign tampil';
            }

            if (emptyCampaign) {
                emptyCampaign.classList.toggle('d-none', visible !== 0);
            }
        }

        categoryButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                categoryButtons.forEach(function (item) { item.classList.remove('active'); });
                button.classList.add('active');
                activeCategory = button.getAttribute('data-filter') || 'all';
                filterCampaigns();
            });
        });

        if (campaignSearch) {
            campaignSearch.addEventListener('input', filterCampaigns);
        }
    });
</script>

<?= $this->include('layouts/footer') ?>
