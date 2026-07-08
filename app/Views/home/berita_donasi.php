<?= $this->include('layouts/header') ?>
<?php
$formatRupiah = static fn($value): string => 'Rp ' . number_format((float) $value, 0, ',', '.');
$maskName = static function ($name, $anonim = false): string {
    $name = trim((string) $name);
    if ($name === '') {
        return '********';
    }
    $parts = preg_split('/\s+/', $name);
    $masked = [];
    foreach ($parts as $part) {
        $len = mb_strlen($part);
        if ($len <= 2) {
            $masked[] = mb_substr($part, 0, 1) . '*';
        } else {
            $masked[] = mb_substr($part, 0, 1) . str_repeat('*', min(6, $len - 1));
        }
    }
    return implode(' ', $masked);
};
$timeAgo = static function ($datetime): string {
    if (empty($datetime)) return '-';
    $diff = time() - strtotime($datetime);
    if ($diff < 60) return 'baru saja';
    if ($diff < 3600) return floor($diff / 60) . ' menit lalu';
    if ($diff < 86400) return floor($diff / 3600) . ' jam lalu';
    return date('d M Y H:i', strtotime($datetime));
};
?>

<style>
    .news-page { padding: 70px 0; background: #f5f8ff; }
    .news-hero {
        padding: 42px;
        border-radius: 38px;
        background: radial-gradient(circle at 92% 0%, rgba(37,99,235,.20), transparent 34%), linear-gradient(135deg, var(--dk-navy), #27416b);
        color: #fff;
        box-shadow: var(--dk-shadow);
        margin-bottom: 26px;
    }
    .news-hero span { display: inline-flex; gap: 8px; align-items: center; padding: 10px 14px; border-radius: 999px; background: rgba(255,255,255,.12); font-weight: 950; }
    .news-hero h1 { margin: 18px 0 12px; font-size: clamp(38px, 5vw, 64px); font-weight: 950; letter-spacing: -1.5px; }
    .news-hero p { margin: 0; max-width: 760px; color: rgba(255,255,255,.75); font-weight: 750; font-size: 18px; }
    .ticker-card { background: #fff; border: 1px solid var(--dk-border); border-radius: 32px; box-shadow: var(--dk-shadow); padding: 22px; }
    .ticker-row { display: grid; grid-template-columns: auto 1.1fr 1.2fr auto; gap: 18px; align-items: center; padding: 18px; border-radius: 24px; border: 1px solid #edf2f8; margin-bottom: 12px; background: #fff; }
    .ticker-row:last-child { margin-bottom: 0; }
    .donor-icon { width: 54px; height: 54px; border-radius: 18px; background: linear-gradient(135deg, var(--dk-primary), var(--dk-secondary)); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 22px; }
    .donor-name { font-weight: 950; color: var(--dk-navy); font-size: 18px; }
    .donor-sub { color: var(--dk-muted); font-weight: 780; font-size: 14px; }
    .campaign-title { color: var(--dk-navy); font-weight: 950; }
    .amount-pill { display: inline-flex; align-items: center; gap: 8px; padding: 11px 14px; border-radius: 999px; background: rgba(34,197,94,.16); color: #15803d; font-weight: 950; white-space: nowrap; }
    .empty-state { text-align: center; padding: 70px 20px; color: var(--dk-muted); font-weight: 800; }
    .empty-state i { width: 82px; height: 82px; display: inline-flex; align-items: center; justify-content: center; border-radius: 28px; background: #f2f6ff; color: var(--dk-primary); font-size: 32px; margin-bottom: 18px; }
    @media(max-width: 991px) { .ticker-row { grid-template-columns: 1fr; } .donor-icon { width: 48px; height: 48px; } .news-hero { padding: 30px; } }
</style>

<main class="news-page">
    <div class="container">
        <section class="news-hero">
            <span><i class="fa-solid fa-bolt"></i> Berita Donasi Real-time</span>
            <h1>Kabar terbaru dari donatur.</h1>
            <p>Mereka Menunggu Kabar Baik ini </p>
        </section>

        <section class="ticker-card">
            <?php if (empty($news)): ?>
                <div class="empty-state">
                    <i class="fa-solid fa-hand-holding-heart"></i>
                    <h3 class="fw-black text-dark">Belum ada donasi berhasil</h3>
                    <p>Donasi yang sudah berhasil melalui Midtrans akan tampil di sini.</p>
                </div>
            <?php else: ?>
                <?php foreach ($news as $item): ?>
                    <?php $donor = $maskName($item['donor_nama'] ?? '', !empty($item['anonim'])); ?>
                    <article class="ticker-row">
                        <div class="donor-icon"><i class="fa-solid fa-user-shield"></i></div>
                        <div>
                            <div class="donor-name"><?= esc($donor) ?></div>
                            <div class="donor-sub">telah berdonasi · <?= esc($timeAgo($item['paid_at'] ?: ($item['created_at'] ?? null))) ?></div>
                        </div>
                        <div>
                            <div class="campaign-title"><?= esc($item['judul'] ?? 'Campaign Donasi') ?></div>
                            <div class="donor-sub"><?= esc($item['nama_yayasan'] ?? 'Yayasan') ?></div>
                        </div>
                        <div><span class="amount-pill"><i class="fa-solid fa-circle-check"></i><?= esc($formatRupiah($item['nominal'] ?? 0)) ?></span></div>
                    </article>
                <?php endforeach; ?>

                <div class="mt-4">
                    <?= $pager ? $pager->links('donation_news', 'default_full') : '' ?>
                </div>
            <?php endif; ?>
        </section>
    </div>
</main>

<script>
    setTimeout(() => {
        if (!document.hidden) {
            window.location.reload();
        }
    }, 60000);
</script>

<?= $this->include('layouts/footer') ?>
