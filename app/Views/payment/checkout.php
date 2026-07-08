<?php $config = config('Midtrans'); ?>
<?= $this->include('layouts/header') ?>
<?php
$formatRupiah = static fn($value): string => 'Rp ' . number_format((float) $value, 0, ',', '.');
?>
<script src="https://app<?= $config->isProduction ? '' : '.sandbox' ?>.midtrans.com/snap/snap.js" data-client-key="<?= esc($config->clientKey) ?>"></script>

<style>
    .checkout-page { padding: 54px 0 70px; background: #f5f8ff; min-height: 70vh; }
    .checkout-card { max-width: 760px; margin: 0 auto; background: #fff; border: 1px solid var(--dk-border); border-radius: 36px; box-shadow: var(--dk-shadow); overflow: hidden; }
    .checkout-head { padding: 34px; background: linear-gradient(135deg, var(--dk-navy), #28426c); color: #fff; text-align: center; }
    .checkout-icon { width: 84px; height: 84px; margin: 0 auto 18px; border-radius: 28px; background: rgba(255,255,255,.14); display: flex; align-items: center; justify-content: center; font-size: 34px; }
    .checkout-head h1 { font-size: 36px; font-weight: 950; margin: 0; }
    .checkout-head p { margin: 10px 0 0; color: rgba(255,255,255,.74); font-weight: 750; }
    .checkout-body { padding: 32px; }
    .summary-row { display: flex; justify-content: space-between; gap: 18px; padding: 16px 0; border-bottom: 1px solid #edf2f8; }
    .summary-row span { color: var(--dk-muted); font-weight: 850; }
    .summary-row strong { color: var(--dk-navy); font-weight: 950; text-align: right; }
    .pay-status { display: none; margin-top: 18px; padding: 16px; border-radius: 20px; background: #f8fbff; border: 1px solid var(--dk-border); color: var(--dk-muted); font-weight: 800; }
</style>

<main class="checkout-page">
    <div class="container">
        <div class="checkout-card">
            <div class="checkout-head">
                <div class="checkout-icon"><i class="fa-solid fa-wallet"></i></div>
                <h1>Pembayaran Donasi</h1>
                <p>Transaksi diproses langsung oleh Midtrans. Jangan tutup halaman ini sebelum memilih metode pembayaran.</p>
            </div>
            <div class="checkout-body">
                <div class="summary-row"><span>Campaign</span><strong><?= esc($campaign['judul'] ?? '-') ?></strong></div>
                <div class="summary-row"><span>Invoice</span><strong><?= esc($donation['invoice'] ?? '-') ?></strong></div>
                <div class="summary-row"><span>Nominal</span><strong><?= esc($formatRupiah($donation['nominal'] ?? 0)) ?></strong></div>

                <button id="pay-button" class="btn btn-dk-primary btn-lg w-100 mt-4"><i class="fa-solid fa-credit-card me-2"></i> Bayar Sekarang</button>
                <a href="<?= base_url('donatur/history') ?>" class="btn btn-dk-outline w-100 mt-3">Lihat Riwayat Donasi</a>

                <div id="pay-status" class="pay-status"></div>
            </div>
        </div>
    </div>
</main>

<script>
    const payButton = document.getElementById('pay-button');
    const statusBox = document.getElementById('pay-status');

    function showStatus(message) {
        statusBox.style.display = 'block';
        statusBox.textContent = message;
    }

    payButton.addEventListener('click', function () {
        payButton.disabled = true;
        payButton.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i> Membuka Midtrans...';

        snap.pay("<?= esc($snapToken) ?>", {
            onSuccess: function(result) {
                window.location.href = "<?= base_url('donatur/history') ?>";
            },
            onPending: function(result) {
                window.location.href = "<?= base_url('donatur/history') ?>";
            },
            onError: function(result) {
                payButton.disabled = false;
                payButton.innerHTML = '<i class="fa-solid fa-credit-card me-2"></i> Coba Bayar Lagi';
                showStatus('Pembayaran belum berhasil. Silakan coba lagi atau pilih metode pembayaran lain.');
            },
            onClose: function() {
                payButton.disabled = false;
                payButton.innerHTML = '<i class="fa-solid fa-credit-card me-2"></i> Bayar Sekarang';
                showStatus('Popup pembayaran ditutup. Transaksi masih tersimpan di riwayat donasi Anda.');
            }
        });
    });
</script>

<?= $this->include('layouts/footer') ?>
