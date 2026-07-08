<?= $this->include('layouts/header') ?>
<?php
helper('text');
$formatRupiah = static fn($value): string => 'Rp ' . number_format((float) $value, 0, ',', '.');
$reportImage = static function (array $report): string {
    if (!empty($report['campaign_gambar'])) {
        return base_url('uploads/campaign/' . $report['campaign_gambar']);
    }
    return 'https://placehold.co/900x560/223149/ffffff?text=Laporan+DonasiKu';
};
?>

<style>
    .report-hero {
        padding: 64px 0 36px;
        background:
            radial-gradient(circle at 12% 8%, rgba(37, 99, 235, .14), transparent 34%),
            radial-gradient(circle at 88% 0%, rgba(79, 70, 229, .12), transparent 32%),
            #f5f8ff;
    }
    .report-title {
        font-size: clamp(34px, 5vw, 64px);
        font-weight: 950;
        letter-spacing: -1.6px;
        line-height: 1.05;
        color: var(--dk-navy);
    }
    .report-title span { color: var(--dk-primary); }
    .report-subtitle {
        max-width: 760px;
        color: var(--dk-muted);
        font-size: 18px;
        line-height: 1.8;
        font-weight: 650;
        margin-top: 16px;
    }
    .report-search-card {
        margin-top: 30px;
        padding: 18px;
        border-radius: 28px;
        background: #ffffff;
        border: 1px solid var(--dk-border);
        box-shadow: 0 18px 46px rgba(15, 23, 42, .07);
    }
    .report-search-card input {
        height: 58px;
        border-radius: 18px;
        border: 1px solid var(--dk-border);
        font-weight: 750;
        padding: 0 18px;
    }
    .reports-section { padding: 34px 0 80px; background: #f5f8ff; }
    .public-report-card {
        height: 100%;
        overflow: hidden;
        border-radius: 30px;
        background: #ffffff;
        border: 1px solid var(--dk-border);
        box-shadow: 0 18px 44px rgba(15, 23, 42, .07);
        transition: .22s ease;
    }
    .public-report-card:hover { transform: translateY(-5px); box-shadow: 0 28px 64px rgba(15, 23, 42, .12); }
    .public-report-img { height: 190px; width: 100%; object-fit: cover; }
    .public-report-body { padding: 22px; }
    .report-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 12px;
        border-radius: 999px;
        background: rgba(34, 197, 94, .14);
        color: #15803d;
        font-weight: 950;
        font-size: 13px;
        margin-bottom: 12px;
    }
    .report-card-title {
        color: var(--dk-navy);
        font-size: 22px;
        font-weight: 950;
        line-height: 1.22;
        margin-bottom: 10px;
    }
    .report-card-meta {
        color: var(--dk-muted);
        font-weight: 800;
        line-height: 1.7;
        margin-bottom: 14px;
    }
    .report-card-total {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 14px 16px;
        border-radius: 20px;
        background: #f5f8ff;
        margin-bottom: 16px;
        color: var(--dk-navy);
        font-weight: 950;
    }
    .empty-report {
        padding: 56px 24px;
        border-radius: 32px;
        background: #ffffff;
        border: 1px solid var(--dk-border);
        text-align: center;
        box-shadow: 0 18px 44px rgba(15, 23, 42, .06);
    }
</style>

<main>
    <section class="report-hero">
        <div class="container">
            <div class="report-pill"><i class="fa-solid fa-file-circle-check"></i> Laporan dana terverifikasi</div>
            <h1 class="report-title">Laporan penggunaan dana <span>terbuka untuk publik.</span></h1>
            

            <form class="report-search-card" method="get" action="<?= base_url('laporan') ?>">
                <div class="row g-3 align-items-center">
                    <div class="col-lg-9">
                        <input type="search" name="q" value="<?= esc($keyword ?? '') ?>" class="form-control" placeholder="Cari judul laporan, campaign, atau nama yayasan...">
                    </div>
                    <div class="col-lg-3">
                        <button type="submit" class="btn btn-dk-primary w-100 h-100"><i class="fa-solid fa-magnifying-glass me-2"></i>Cari Laporan</button>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <section class="reports-section">
        <div class="container">
            <?php if (!empty($reports)): ?>
                <div class="row g-4">
                    <?php foreach ($reports as $report): ?>
                        <div class="col-md-6 col-xl-4">
                            <article class="public-report-card">
                                <img class="public-report-img" src="<?= esc($reportImage($report)) ?>" alt="<?= esc($report['judul_laporan'] ?? 'Laporan Dana') ?>">
                                <div class="public-report-body">
                                    <span class="report-pill"><i class="fa-solid fa-circle-check"></i> Dipublikasikan</span>
                                    <h2 class="report-card-title"><?= esc($report['judul_laporan'] ?? '-') ?></h2>
                                    <div class="report-card-meta">
                                        <div><i class="fa-solid fa-hand-holding-heart me-2 text-primary"></i><?= esc($report['campaign_judul'] ?? '-') ?></div>
                                        <div><i class="fa-solid fa-building-ngo me-2 text-success"></i><?= esc($report['nama_yayasan'] ?? '-') ?></div>
                                        <div><i class="fa-solid fa-calendar me-2 text-warning"></i><?= esc(date('d M Y', strtotime($report['tanggal_laporan'] ?? $report['created_at'] ?? date('Y-m-d')))) ?></div>
                                    </div>
                                    <div class="report-card-total">
                                        <span>Total Pengeluaran</span>
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

                <div class="mt-4">
                    <?= $pager->links('public_reports') ?>
                </div>
            <?php else: ?>
                <div class="empty-report">
                    <i class="fa-solid fa-folder-open fa-3x text-primary mb-3"></i>
                    <h3 class="fw-bold text-dark">Belum ada laporan dipublikasikan</h3>
                    <p class="text-muted mb-0">Laporan akan muncul setelah yayasan mengirim laporan dan admin menyetujuinya.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<?= $this->include('layouts/footer') ?>
