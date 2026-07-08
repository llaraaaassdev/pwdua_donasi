<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<style>
    .re-card{background:#fff;border:1px solid #edf2f7;border-radius:28px;box-shadow:0 18px 46px rgba(15,23,42,.07);padding:28px}.re-title{font-weight:950;color:#0f172a}.re-subtitle{color:#64748b;line-height:1.7}.form-control,.form-select{border-radius:16px;min-height:50px;border:1px solid #e5edf6}.detail-row{border:1px solid #edf2f7;border-radius:22px;background:#f8fafc;padding:18px;margin-bottom:14px}.remove-row{border:0;width:40px;height:40px;border-radius:14px;background:#fee2e2;color:#b91c1c}.add-row{border:0;border-radius:16px;background:#eff6ff;color:#2563eb;padding:12px 16px;font-weight:900}.file-note{font-size:13px;color:#64748b;margin-top:6px}.file-note a{font-weight:900;text-decoration:none}.alert{border-radius:18px;border:0}.btn{border-radius:16px;font-weight:900}
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php
$reportStatus = strtolower((string)($report['status_verifikasi'] ?? 'pending'));
?>
<div class="re-card">
    <div class="d-flex justify-content-between align-items-start gap-3 mb-4 flex-wrap">
        <div>
            <h2 class="re-title mb-1">Edit / Perbaiki Laporan Dana</h2>
            <p class="re-subtitle mb-0">Perbaikan dilakukan pada laporan yang sama. Setelah disimpan, status laporan kembali menjadi menunggu verifikasi admin.</p>
        </div>
        <a href="<?= base_url('yayasan/report/detail/' . $report['id']) ?>" class="btn btn-light px-4 py-3"><i class="fa-solid fa-arrow-left me-2"></i> Kembali</a>
    </div>

    <?php if($reportStatus === 'rejected'): ?><div class="alert alert-danger fw-bold"><i class="fa-solid fa-triangle-exclamation me-2"></i> Laporan ini perlu perbaikan. Silakan revisi data, rincian, atau dokumentasi lalu kirim ulang.</div><?php endif; ?>
    <?php if(session()->getFlashdata('error')): ?><div class="alert alert-danger fw-bold"><?= session()->getFlashdata('error') ?></div><?php endif; ?>
    <?php if(session()->getFlashdata('errors')): ?><div class="alert alert-danger"><?php foreach(session()->getFlashdata('errors') as $error): ?><div><?= esc($error) ?></div><?php endforeach; ?></div><?php endif; ?>

    <form method="post" action="<?= base_url('yayasan/report/update/' . $report['id']) ?>" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <div class="row g-3 mb-3">
            <div class="col-lg-6">
                <label class="fw-bold mb-2">Campaign yang Dilaporkan *</label>
                <select name="campaign_id" class="form-select" required>
                    <option value="">Pilih campaign</option>
                    <?php foreach($campaigns as $campaign): ?>
                        <option value="<?= $campaign['id'] ?>" <?= (string)old('campaign_id', $report['campaign_id'] ?? '') === (string)$campaign['id'] ? 'selected' : '' ?>><?= esc($campaign['judul']) ?> - Terkumpul Rp <?= number_format((float)($campaign['dana_terkumpul'] ?? 0),0,',','.') ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-lg-6">
                <label class="fw-bold mb-2">Tanggal Laporan *</label>
                <input type="date" name="tanggal_laporan" class="form-control" value="<?= esc(old('tanggal_laporan', $report['tanggal_laporan'] ?? date('Y-m-d'))) ?>" required>
            </div>
            <div class="col-12">
                <label class="fw-bold mb-2">Judul Laporan *</label>
                <input type="text" name="judul_laporan" class="form-control" value="<?= esc(old('judul_laporan', $report['judul_laporan'] ?? '')) ?>" required>
            </div>
            <div class="col-12">
                <label class="fw-bold mb-2">Deskripsi Laporan *</label>
                <textarea name="deskripsi" class="form-control" rows="5" required><?= esc(old('deskripsi', $report['deskripsi'] ?? '')) ?></textarea>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center gap-3 mb-3 flex-wrap">
            <h4 class="re-title fs-4 mb-0">Rincian Pengeluaran</h4>
            <button type="button" class="add-row" id="addDetail"><i class="fa-solid fa-plus me-2"></i> Tambah Rincian</button>
        </div>

        <div id="detailWrap">
            <?php if(empty($details)): $details = [['nama_pengeluaran'=>'','nominal'=>'','keterangan'=>'','foto'=>'']]; endif; ?>
            <?php foreach($details as $detail): ?>
            <div class="detail-row">
                <input type="hidden" name="old_foto[]" value="<?= esc($detail['foto'] ?? '') ?>">
                <div class="row g-3 align-items-end">
                    <div class="col-lg-4">
                        <label class="fw-bold mb-2">Nama Pengeluaran *</label>
                        <input type="text" name="nama_pengeluaran[]" class="form-control" value="<?= esc($detail['nama_pengeluaran'] ?? '') ?>" required>
                    </div>
                    <div class="col-lg-3">
                        <label class="fw-bold mb-2">Nominal *</label>
                        <input type="number" min="1" step="1" name="nominal[]" class="form-control" value="<?= esc($detail['nominal'] ?? '') ?>" required>
                    </div>
                    <div class="col-lg-3">
                        <label class="fw-bold mb-2">Dokumentasi</label>
                        <input type="file" name="foto[]" class="form-control" accept="image/*,.pdf">
                        <?php if(!empty($detail['foto'])): ?><div class="file-note">File lama: <a href="<?= base_url('uploads/laporan/' . $detail['foto']) ?>" target="_blank">lihat dokumen</a></div><?php else: ?><div class="file-note">Belum ada dokumentasi.</div><?php endif; ?>
                    </div>
                    <div class="col-lg-2 text-lg-end"><button type="button" class="remove-row" title="Hapus rincian"><i class="fa-solid fa-trash"></i></button></div>
                    <div class="col-12">
                        <label class="fw-bold mb-2">Keterangan</label>
                        <textarea name="keterangan[]" class="form-control" rows="2"><?= esc($detail['keterangan'] ?? '') ?></textarea>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="d-flex justify-content-end gap-2 mt-4 flex-wrap">
            <a href="<?= base_url('yayasan/report/detail/' . $report['id']) ?>" class="btn btn-light px-4 py-3">Batal</a>
            <button type="submit" class="btn btn-primary px-4 py-3"><i class="fa-solid fa-paper-plane me-2"></i> Kirim Ulang ke Admin</button>
        </div>
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
        clone.querySelectorAll('input, textarea').forEach(el=>{
            if(el.name === 'old_foto[]') el.value='';
            else if(el.type === 'file') el.value='';
            else el.value='';
        });
        const note=clone.querySelector('.file-note');
        if(note) note.innerHTML='Belum ada dokumentasi.';
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
