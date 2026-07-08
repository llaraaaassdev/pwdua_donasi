<?= $this->include('layouts/header') ?>
<?php
$formatRupiah = static fn($value): string => 'Rp ' . number_format((float) $value, 0, ',', '.');
$target = (float) ($campaign['target_dana'] ?? 0);
$collected = (float) ($campaign['dana_terkumpul'] ?? 0);
$progress = $target > 0 ? min(100, round(($collected / $target) * 100)) : 0;
$image = !empty($campaign['gambar']) ? base_url('uploads/campaign/' . $campaign['gambar']) : 'https://placehold.co/900x600/223149/ffffff?text=DonasiKu';
?>

<style>
    .donation-page { padding: 54px 0 70px; background: #f5f8ff; }
    .donation-shell { display: grid; grid-template-columns: 1fr 1.08fr; gap: 26px; align-items: start; }
    .campaign-summary, .donation-form-card {
        background: #ffffff;
        border: 1px solid var(--dk-border);
        border-radius: 34px;
        box-shadow: var(--dk-shadow);
        overflow: hidden;
    }
    .campaign-summary img { width: 100%; height: 310px; object-fit: cover; }
    .campaign-summary-body { padding: 26px; }
    .summary-badge {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 9px 13px; border-radius: 999px;
        background: rgba(34, 197, 94, .14); color: #15803d;
        font-weight: 950; margin-bottom: 14px;
    }
    .summary-title { font-size: 30px; font-weight: 950; color: var(--dk-navy); line-height: 1.16; margin-bottom: 14px; }
    .summary-meta { display: grid; gap: 10px; color: var(--dk-muted); font-weight: 800; }
    .summary-meta span { display: flex; gap: 10px; align-items: center; }
    .progress-track { height: 12px; border-radius: 999px; background: #edf2f8; overflow: hidden; margin: 20px 0 12px; }
    .progress-fill { width: <?= esc($progress) ?>%; height: 100%; background: linear-gradient(135deg, var(--dk-primary), var(--dk-secondary)); border-radius: 999px; }
    .amount-row { display: flex; justify-content: space-between; gap: 16px; color: var(--dk-muted); font-weight: 800; }
    .amount-row strong { display: block; color: var(--dk-navy); font-size: 22px; font-weight: 950; }

    .donation-form-card { padding: 34px; }
    .form-eyebrow { display: inline-flex; align-items: center; gap: 8px; color: var(--dk-primary); font-weight: 950; background: rgba(37,99,235,.08); padding: 9px 13px; border-radius: 999px; }
    .form-title { margin: 18px 0 10px; font-size: 38px; font-weight: 950; letter-spacing: -1px; color: var(--dk-navy); }
    .form-subtitle { color: var(--dk-muted); font-weight: 750; margin-bottom: 26px; }
    .nominal-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; margin-bottom: 16px; }
    .nominal-btn {
        border: 1px solid rgba(37,99,235,.18);
        background: #f8fbff;
        color: var(--dk-navy);
        border-radius: 18px;
        padding: 14px 12px;
        font-weight: 950;
        text-align: center;
        transition: .2s ease;
    }
    .nominal-btn:hover, .nominal-btn.active { background: linear-gradient(135deg, var(--dk-primary), var(--dk-secondary)); color: #fff; transform: translateY(-2px); }
    .form-control, .form-select {
        border-radius: 18px;
        border: 1px solid var(--dk-border);
        padding: 14px 16px;
        font-weight: 800;
        color: var(--dk-navy);
        background: #fbfdff;
    }
    .form-control:focus, .form-select:focus { border-color: rgba(37,99,235,.42); box-shadow: 0 0 0 .22rem rgba(37,99,235,.10); }
    .privacy-card {
        display: flex; gap: 12px;
        padding: 16px;
        background: #f8fbff;
        border: 1px solid var(--dk-border);
        border-radius: 20px;
        color: var(--dk-muted);
        font-weight: 750;
    }
    .privacy-card i { color: var(--dk-primary); margin-top: 4px; }
    .form-check-input { width: 1.15em; height: 1.15em; }
    @media(max-width: 991px) { .donation-shell { grid-template-columns: 1fr; } .nominal-grid { grid-template-columns: repeat(2, 1fr); } }
</style>

<main class="donation-page">
    <div class="container">
        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger rounded-4 fw-bold mb-4"><?= esc(session()->getFlashdata('error')) ?></div>
        <?php endif; ?>

        <div class="donation-shell">
            <aside class="campaign-summary">
                <img src="<?= esc($image) ?>" alt="<?= esc($campaign['judul'] ?? 'Campaign') ?>">
                <div class="campaign-summary-body">
                    <span class="summary-badge"><i class="fa-solid fa-circle-check"></i> Campaign Aktif</span>
                    <h1 class="summary-title"><?= esc($campaign['judul'] ?? '-') ?></h1>
                    <div class="summary-meta">
                        <span><i class="fa-solid fa-building-ngo text-primary"></i> <?= esc($campaign['nama_yayasan'] ?? 'Yayasan') ?></span>
                        <span><i class="fa-solid fa-tag text-success"></i> <?= esc($campaign['nama_kategori'] ?? 'Umum') ?></span>
                        <?php if (!empty($campaign['tanggal_berakhir'])): ?>
                            <span><i class="fa-solid fa-calendar-days text-warning"></i> Sampai <?= date('d M Y', strtotime($campaign['tanggal_berakhir'])) ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="progress-track"><div class="progress-fill"></div></div>
                    <div class="amount-row">
                        <span><strong><?= esc($formatRupiah($collected)) ?></strong>terkumpul</span>
                        <span class="text-end"><strong><?= esc($formatRupiah($target)) ?></strong>target</span>
                    </div>
                </div>
            </aside>

            <section class="donation-form-card">
                <span class="form-eyebrow"><i class="fa-solid fa-hand-holding-heart"></i> Form Donasi</span>
                <h2 class="form-title">Salurkan bantuan Anda</h2>
                <p class="form-subtitle">Pembayaran diproses otomatis melalui Midtrans. Admin tidak melakukan verifikasi manual.</p>

                <form action="<?= base_url('donatur/donation/store') ?>" method="post" id="donationForm">
                    <?= csrf_field() ?>
                    <input type="hidden" name="campaign_id" value="<?= esc($campaign['id']) ?>">

                    <label class="form-label fw-black mb-2">Pilih Nominal</label>
                    <div class="nominal-grid">
                        <?php foreach ([10000, 25000, 50000, 100000, 250000, 500000] as $nominal): ?>
                            <button type="button" class="nominal-btn" data-nominal="<?= esc($nominal) ?>"><?= esc($formatRupiah($nominal)) ?></button>
                        <?php endforeach; ?>
                    </div>

                    <div class="mb-3">
                        <label for="nominal" class="form-label fw-black">Nominal Lain</label>
                        <input type="number" min="1000" step="1000" class="form-control" name="nominal" id="nominal" placeholder="Contoh: 75000" value="<?= old('nominal') ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="pesan" class="form-label fw-black">Pesan Dukungan</label>
                        <textarea class="form-control" name="pesan" id="pesan" rows="4" placeholder="Tulis doa atau pesan singkat..."><?= old('pesan') ?></textarea>
                    </div>

                    <div class="privacy-card mb-3">
                        <i class="fa-solid fa-user-shield"></i>
                        <div>
                            <div class="form-check mb-1">
                                <input class="form-check-input" type="checkbox" name="anonim" value="1" id="anonim" <?= old('anonim') ? 'checked' : '' ?>>
                                <label class="form-check-label fw-black text-dark" for="anonim">Sembunyikan nama saya dari publik</label>
                            </div>
                            <small>Nama dan email donatur tetap dilindungi. Di halaman publik, nama tampil dalam bentuk bintang.</small>
                        </div>
                    </div>

                    <input type="hidden" name="metode_pembayaran" value="midtrans">

                    <button type="submit" class="btn btn-dk-primary btn-lg w-100 mt-2">
                        <i class="fa-solid fa-wallet me-2"></i> Lanjut Pembayaran Midtrans
                    </button>
                    <a href="<?= base_url('/campaign/' . $campaign['id']) ?>" class="btn btn-dk-outline w-100 mt-3">
                        <i class="fa-solid fa-arrow-left me-2"></i> Kembali ke Detail Campaign
                    </a>
                </form>
            </section>
        </div>
    </div>
</main>

<script>
    document.querySelectorAll('.nominal-btn').forEach((button) => {
        button.addEventListener('click', () => {
            document.querySelectorAll('.nominal-btn').forEach((item) => item.classList.remove('active'));
            button.classList.add('active');
            document.getElementById('nominal').value = button.dataset.nominal;
        });
    });
</script>

<?= $this->include('layouts/footer') ?>
