<?= $this->include('layouts/header') ?>
<?php
helper('text');
$formatRupiah = static fn($value): string => 'Rp ' . number_format((float) $value, 0, ',', '.');
$maskName = static function ($name): string {
    $name = trim((string) $name);
    if ($name === '') return 'P********';
    $parts = preg_split('/\s+/', $name);
    $masked = [];
    foreach ($parts as $part) {
        $first = mb_substr($part, 0, 1);
        $masked[] = $first . str_repeat('*', max(4, mb_strlen($part) - 1));
    }
    return implode(' ', $masked);
};
$reportImage = !empty($report['campaign_gambar'])
    ? base_url('uploads/campaign/' . $report['campaign_gambar'])
    : 'https://placehold.co/1100x720/223149/ffffff?text=Laporan+DonasiKu';
$isLoggedIn = (bool) session()->get('logged_in');
?>

<style>
    .report-detail-hero {
        padding: 58px 0 78px;
        background:
            radial-gradient(circle at 12% 12%, rgba(37, 99, 235, .14), transparent 34%),
            radial-gradient(circle at 84% 0%, rgba(79, 70, 229, .12), transparent 32%),
            #f5f8ff;
    }
    .report-detail-card,
    .report-side-card,
    .expense-card,
    .comment-card,
    .comment-form-card {
        border-radius: 32px;
        background: #ffffff;
        border: 1px solid var(--dk-border);
        box-shadow: 0 20px 54px rgba(15, 23, 42, .08);
    }
    .report-detail-card { overflow: hidden; }
    .report-detail-img { width: 100%; max-height: 420px; object-fit: cover; }
    .report-detail-body { padding: 30px; }
    .report-status-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 14px;
        border-radius: 999px;
        background: rgba(34, 197, 94, .14);
        color: #15803d;
        font-weight: 950;
        margin-bottom: 16px;
    }
    .report-detail-title {
        color: var(--dk-navy);
        font-size: clamp(32px, 4vw, 54px);
        line-height: 1.08;
        font-weight: 950;
        letter-spacing: -1.2px;
        margin-bottom: 18px;
    }
    .report-detail-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        color: var(--dk-muted);
        font-weight: 850;
        margin-bottom: 22px;
    }
    .report-detail-meta span {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 13px;
        border-radius: 16px;
        background: #f5f8ff;
    }
    .report-description {
        color: #52637c;
        font-weight: 650;
        font-size: 16px;
        line-height: 1.9;
    }
    .report-side-card { padding: 26px; position: sticky; top: 110px; }
    .side-total {
        font-size: 32px;
        font-weight: 950;
        color: var(--dk-navy);
        letter-spacing: -.8px;
    }
    .side-label { color: var(--dk-muted); font-weight: 800; }
    .section-title-mini {
        color: var(--dk-navy);
        font-size: 28px;
        font-weight: 950;
        letter-spacing: -.7px;
        margin-bottom: 18px;
    }
    .expense-card { padding: 20px; height: 100%; box-shadow: 0 14px 34px rgba(15, 23, 42, .06); }
    .expense-card h4 { font-size: 19px; font-weight: 950; color: var(--dk-navy); }
    .expense-card .nominal { font-size: 22px; font-weight: 950; color: var(--dk-primary); }
    .proof-link { font-weight: 900; text-decoration: none; }
    .comment-form-card { padding: 24px; }
    .comment-form-card input,
    .comment-form-card textarea {
        border-radius: 18px;
        border: 1px solid var(--dk-border);
        padding: 14px 16px;
        font-weight: 700;
    }
    .comment-card { padding: 18px 20px; box-shadow: 0 12px 30px rgba(15, 23, 42, .05); }
    .comment-head { display: flex; align-items: center; gap: 12px; margin-bottom: 10px; }
    .comment-avatar {
        width: 42px; height: 42px; border-radius: 15px;
        background: linear-gradient(135deg, var(--dk-primary), var(--dk-secondary));
        color: #fff; display: inline-flex; align-items: center; justify-content: center;
        font-weight: 950;
    }
    .comment-name { font-weight: 950; color: var(--dk-navy); }
    .comment-date { color: var(--dk-muted); font-size: 13px; font-weight: 750; }
    .comment-body { color: #52637c; line-height: 1.8; font-weight: 650; }
</style>

<main class="report-detail-hero">
    <div class="container">
        <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success border-0 rounded-4 fw-bold mb-4"><i class="fa-solid fa-circle-check me-2"></i><?= esc(session()->getFlashdata('success')) ?></div>
        <?php endif; ?>
        <?php if(session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger border-0 rounded-4 fw-bold mb-4">
                <?php foreach(session()->getFlashdata('errors') as $error): ?>
                    <div><?= esc($error) ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="row g-4 align-items-start">
            <div class="col-lg-8">
                <article class="report-detail-card">
                    <img src="<?= esc($reportImage) ?>" class="report-detail-img" alt="<?= esc($report['campaign_judul'] ?? 'Campaign') ?>">
                    <div class="report-detail-body">
                        <span class="report-status-pill"><i class="fa-solid fa-circle-check"></i> Laporan terverifikasi admin</span>
                        <h1 class="report-detail-title"><?= esc($report['judul_laporan'] ?? '-') ?></h1>
                        <div class="report-detail-meta">
                            <span><i class="fa-solid fa-hand-holding-heart text-primary"></i><?= esc($report['campaign_judul'] ?? '-') ?></span>
                            <span><i class="fa-solid fa-building-ngo text-success"></i><?= esc($report['nama_yayasan'] ?? '-') ?></span>
                            <span><i class="fa-solid fa-calendar text-warning"></i><?= esc(date('d M Y', strtotime($report['tanggal_laporan'] ?? $report['created_at'] ?? date('Y-m-d')))) ?></span>
                        </div>
                        <div class="report-description"><?= nl2br(esc($report['deskripsi'] ?? '-')) ?></div>
                    </div>
                </article>

                <section class="mt-4">
                    <h2 class="section-title-mini">Rincian Penggunaan Dana</h2>
                    <?php if(!empty($details)): ?>
                        <div class="row g-3">
                            <?php foreach($details as $detail): ?>
                                <div class="col-md-6">
                                    <div class="expense-card">
                                        <h4><?= esc($detail['nama_pengeluaran'] ?? '-') ?></h4>
                                        <div class="nominal mb-2"><?= esc($formatRupiah($detail['nominal'] ?? 0)) ?></div>
                                        <p class="text-muted fw-semibold mb-2"><?= esc($detail['keterangan'] ?? 'Tidak ada keterangan tambahan.') ?></p>
                                        <?php if(!empty($detail['foto'])): ?>
                                            <a class="proof-link" href="<?= base_url('uploads/laporan/' . $detail['foto']) ?>" target="_blank">
                                                <i class="fa-solid fa-paperclip me-1"></i>Lihat bukti
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="expense-card text-center text-muted fw-bold">Belum ada rincian pengeluaran.</div>
                    <?php endif; ?>
                </section>

                <section class="mt-5" id="komentar">
                    <h2 class="section-title-mini">Komentar Publik</h2>
                    <div class="comment-form-card mb-4">
                        <form action="<?= base_url('laporan/' . $report['id'] . '/komentar') ?>" method="post">
                            <?php if(!$isLoggedIn): ?>
                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label class="fw-bold mb-2">Nama</label>
                                        <input type="text" name="nama_pengomentar" class="form-control" value="<?= old('nama_pengomentar') ?>" placeholder="Nama Anda" required>
                                        <small class="text-muted fw-semibold">Nama akan ditampilkan dengan sensor.</small>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="fw-bold mb-2">Email opsional</label>
                                        <input type="email" name="email_pengomentar" class="form-control" value="<?= old('email_pengomentar') ?>" placeholder="Email tidak akan ditampilkan">
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="alert alert-info border-0 rounded-4 fw-bold">Komentar menggunakan akun <?= esc($maskName(session()->get('nama') ?: 'Pengguna')) ?>.</div>
                            <?php endif; ?>
                            <label class="fw-bold mb-2">Komentar</label>
                            <textarea name="komentar" rows="4" class="form-control mb-3" placeholder="Tulis komentar atau pertanyaan tentang laporan ini..." required><?= old('komentar') ?></textarea>
                            <button class="btn btn-dk-primary" type="submit"><i class="fa-solid fa-paper-plane me-2"></i>Kirim Komentar</button>
                        </form>
                    </div>

                    <?php if(!empty($comments)): ?>
                        <div class="d-grid gap-3">
                            <?php foreach($comments as $comment): ?>
                                <?php $displayName = $maskName($comment['nama_pengomentar'] ?? 'Pengguna'); ?>
                                <div class="comment-card">
                                    <div class="comment-head">
                                        <div class="comment-avatar"><?= esc(strtoupper(substr($displayName, 0, 1))) ?></div>
                                        <div>
                                            <div class="comment-name"><?= esc($displayName) ?></div>
                                            <div class="comment-date"><?= esc(date('d M Y H:i', strtotime($comment['created_at'] ?? date('Y-m-d H:i:s')))) ?></div>
                                        </div>
                                    </div>
                                    <div class="comment-body"><?= nl2br(esc($comment['komentar'] ?? '-')) ?></div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="comment-card text-center text-muted fw-bold">Belum ada komentar. Jadilah yang pertama memberi tanggapan.</div>
                    <?php endif; ?>
                </section>
            </div>

            <div class="col-lg-4">
                <aside class="report-side-card">
                    <div class="side-label">Total Pengeluaran Dilaporkan</div>
                    <div class="side-total"><?= esc($formatRupiah($report['total_pengeluaran'] ?? 0)) ?></div>
                    <hr>
                    <div class="side-label mb-1">Campaign</div>
                    <h4 class="fw-bold text-dark mb-3"><?= esc($report['campaign_judul'] ?? '-') ?></h4>
                    <a href="<?= base_url('campaign/' . $report['campaign_id']) ?>" class="btn btn-dk-outline w-100 mb-2">
                        <i class="fa-solid fa-circle-info me-2"></i>Lihat Campaign
                    </a>
                    <a href="<?= base_url('laporan') ?>" class="btn btn-dk-primary w-100">
                        <i class="fa-solid fa-arrow-left me-2"></i>Daftar Laporan
                    </a>
                </aside>
            </div>
        </div>
    </div>
</main>

<?= $this->include('layouts/footer') ?>
