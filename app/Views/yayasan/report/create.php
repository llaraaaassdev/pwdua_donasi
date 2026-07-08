<?= $this->extend('layouts/main') ?>
<?= $this->section('styles') ?>
<style>
    .rc-card{background:#fff;border:1px solid #edf2f7;border-radius:28px;box-shadow:0 18px 46px rgba(15,23,42,.07);padding:28px}.rc-title{font-weight:950;color:#0f172a}.rc-subtitle{color:#64748b;line-height:1.7}.form-control,.form-select{border-radius:16px;min-height:50px;border:1px solid #e5edf6}.detail-row{border:1px solid #edf2f7;border-radius:22px;background:#f8fafc;padding:18px;margin-bottom:14px}.remove-row{border:0;width:40px;height:40px;border-radius:14px;background:#fee2e2;color:#b91c1c}.add-row{border:0;border-radius:16px;background:#eff6ff;color:#2563eb;padding:12px 16px;font-weight:900}.alert{border-radius:18px;border:0}.btn{border-radius:16px;font-weight:900}
</style>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="rc-card">
    <div class="d-flex justify-content-between align-items-start gap-3 mb-4 flex-wrap"><div><h2 class="rc-title mb-1">Buat Laporan Penggunaan Dana</h2><p class="rc-subtitle mb-0">Isi ringkasan penggunaan dana dan tambahkan rincian pengeluaran beserta dokumentasi.</p></div><a href="<?= base_url('yayasan/report') ?>" class="btn btn-light px-4 py-3"><i class="fa-solid fa-arrow-left me-2"></i> Kembali</a></div>
    <?php if(session()->getFlashdata('error')): ?><div class="alert alert-danger fw-bold"><?= session()->getFlashdata('error') ?></div><?php endif; ?>
    <?php if(session()->getFlashdata('errors')): ?><div class="alert alert-danger"><?php foreach(session()->getFlashdata('errors') as $error): ?><div><?= esc($error) ?></div><?php endforeach; ?></div><?php endif; ?>

    <form method="post" action="<?= base_url('yayasan/report/store') ?>" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <div class="row g-3 mb-3">
            <div class="col-lg-6"><label class="fw-bold mb-2">Campaign yang Dilaporkan *</label><select name="campaign_id" class="form-select" required><option value="">Pilih campaign aktif</option><?php foreach($campaigns as $campaign): ?><option value="<?= $campaign['id'] ?>" <?= old('campaign_id') == $campaign['id'] ? 'selected' : '' ?>><?= esc($campaign['judul']) ?> - Terkumpul Rp <?= number_format((float)($campaign['dana_terkumpul'] ?? 0),0,',','.') ?></option><?php endforeach; ?></select></div>
            <div class="col-lg-6"><label class="fw-bold mb-2">Tanggal Laporan *</label><input type="date" name="tanggal_laporan" class="form-control" value="<?= old('tanggal_laporan') ?: date('Y-m-d') ?>" required></div>
            <div class="col-12"><label class="fw-bold mb-2">Judul Laporan *</label><input type="text" name="judul_laporan" class="form-control" value="<?= esc(old('judul_laporan')) ?>" placeholder="Contoh: Laporan Penggunaan Dana Tahap 1" required></div>
            <div class="col-12"><label class="fw-bold mb-2">Deskripsi Laporan *</label><textarea name="deskripsi" class="form-control" rows="5" placeholder="Jelaskan kegiatan, penerima manfaat, dan ringkasan penggunaan dana." required><?= esc(old('deskripsi')) ?></textarea></div>
        </div>

        <div class="d-flex justify-content-between align-items-center gap-3 mb-3 flex-wrap"><h4 class="rc-title fs-4 mb-0">Rincian Pengeluaran</h4><button type="button" class="add-row" id="addDetail"><i class="fa-solid fa-plus me-2"></i> Tambah Rincian</button></div>
        <div id="detailWrap">
            <div class="detail-row">
                <div class="row g-3 align-items-end">
                    <div class="col-lg-4"><label class="fw-bold mb-2">Nama Pengeluaran *</label><input type="text" name="nama_pengeluaran[]" class="form-control" placeholder="Contoh: Pembelian sembako" required></div>
                    <div class="col-lg-3"><label class="fw-bold mb-2">Nominal *</label><input type="number" min="1" step="1" name="nominal[]" class="form-control" placeholder="500000" required></div>
                    <div class="col-lg-3"><label class="fw-bold mb-2">Dokumentasi</label><input type="file" name="foto[]" class="form-control" accept="image/*,.pdf"></div>
                    <div class="col-lg-2 text-lg-end"><button type="button" class="remove-row" title="Hapus rincian"><i class="fa-solid fa-trash"></i></button></div>
                    <div class="col-12"><label class="fw-bold mb-2">Keterangan</label><textarea name="keterangan[]" class="form-control" rows="2" placeholder="Keterangan tambahan"></textarea></div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-end gap-2 mt-4 flex-wrap"><a href="<?= base_url('yayasan/report') ?>" class="btn btn-light px-4 py-3">Batal</a><button type="submit" class="btn btn-primary px-4 py-3"><i class="fa-solid fa-paper-plane me-2"></i> Kirim ke Admin</button></div>
    </form>
</div>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function(){
    const wrap=document.getElementById('detailWrap');
    const add=document.getElementById('addDetail');
    add.addEventListener('click', function(){
        const first=wrap.querySelector('.detail-row');
        const clone=first.cloneNode(true);
        clone.querySelectorAll('input, textarea').forEach(el=>{ if(el.type==='file') el.value=''; else el.value=''; });
        wrap.appendChild(clone);
    });
    wrap.addEventListener('click', function(e){
        const btn=e.target.closest('.remove-row');
        if(!btn) return;
        if(wrap.querySelectorAll('.detail-row').length<=1) return;
        btn.closest('.detail-row').remove();
    });
});
</script>
<?= $this->endSection() ?>
