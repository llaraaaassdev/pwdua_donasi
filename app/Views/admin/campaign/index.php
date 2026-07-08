<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<style>
.admin-campaign-page { max-width: 100%; overflow-x: hidden; }
.admin-campaign-page .page-title{font-weight:900;color:#0f172a;margin-bottom:4px}.admin-campaign-page .page-subtitle{color:#64748b;margin-bottom:0}.admin-campaign-page .stat-card,.admin-campaign-page .toolbar-card,.admin-campaign-page .campaign-card{background:#fff;border:1px solid #eef2f7;box-shadow:0 14px 34px rgba(15,23,42,.07)}.admin-campaign-page .stat-card{border-radius:24px;padding:22px;min-height:118px}.admin-campaign-page .stat-card small{color:#64748b;font-weight:800}.admin-campaign-page .stat-card h2{margin:8px 0 0;font-weight:900;color:#0f172a;font-size:28px}.admin-campaign-page .toolbar-card{border-radius:24px;padding:20px}.admin-campaign-page .campaign-card{border-radius:26px;overflow:hidden;height:100%;transition:.25s}.admin-campaign-page .campaign-card:hover{transform:translateY(-4px)}.admin-campaign-page .campaign-image{width:100%;height:210px;object-fit:cover;background:#e2e8f0}.admin-campaign-page .campaign-body{padding:22px}.admin-campaign-page .campaign-title{margin:14px 0 8px;font-weight:900;color:#0f172a;line-height:1.25;font-size:21px}.admin-campaign-page .campaign-meta{color:#64748b;font-size:14px;line-height:1.7}.admin-campaign-page .badge-soft{display:inline-flex;align-items:center;gap:7px;padding:8px 12px;border-radius:999px;font-weight:900;font-size:12px}.admin-campaign-page .badge-soft.success{background:#dcfce7;color:#15803d}.admin-campaign-page .badge-soft.warning{background:#fef3c7;color:#92400e}.admin-campaign-page .badge-soft.danger{background:#fee2e2;color:#b91c1c}.admin-campaign-page .badge-soft.dark{background:#e2e8f0;color:#334155}.admin-campaign-page .progress{height:10px;border-radius:999px;background:#edf2f7;overflow:hidden}.admin-campaign-page .progress-bar{background:linear-gradient(135deg,#2563eb,#4f46e5)}.admin-campaign-page .campaign-money strong{display:block;font-size:22px;color:#0f172a;font-weight:900}.admin-campaign-page .campaign-money small{color:#64748b}.admin-campaign-page .campaign-action{display:flex;flex-wrap:wrap;gap:10px}.admin-campaign-page .campaign-action form{display:inline-flex;margin:0}.admin-campaign-page .icon-btn{width:48px;height:48px;border:0;border-radius:16px;font-weight:900;text-decoration:none;display:inline-flex;align-items:center;justify-content:center;font-size:18px;transition:.2s}.admin-campaign-page .icon-btn:hover{transform:translateY(-2px);filter:brightness(.98)}.admin-campaign-page .btn-detail{background:#e0f2fe;color:#0369a1}.admin-campaign-page .btn-edit{background:#fef3c7;color:#92400e}.admin-campaign-page .btn-approve{background:#16a34a;color:#fff}.admin-campaign-page .btn-reject{background:#64748b;color:#fff}.admin-campaign-page .btn-delete{background:#ffe4e6;color:#be123c}.admin-campaign-page .btn-locked{background:#e2e8f0;color:#64748b;cursor:not-allowed}.admin-campaign-page .empty-state{background:#fff;border-radius:26px;padding:54px 20px;text-align:center;color:#64748b;box-shadow:0 14px 34px rgba(15,23,42,.08)}.admin-campaign-page .empty-state i{font-size:54px;color:#94a3b8;margin-bottom:14px}
.donasiku-confirm{position:fixed;inset:0;background:rgba(15,23,42,.55);z-index:2147483000;display:none;align-items:center;justify-content:center;padding:22px}.donasiku-confirm.show{display:flex}.donasiku-confirm-card{width:410px;max-width:100%;background:#fff;border-radius:28px;padding:30px;text-align:center;box-shadow:0 28px 80px rgba(15,23,42,.25);animation:donasikuPop .18s ease-out}.donasiku-confirm-icon{width:72px;height:72px;margin:0 auto 16px;border-radius:22px;background:#eef2ff;color:#2563eb;font-size:30px;display:flex;align-items:center;justify-content:center}.donasiku-confirm-title{font-weight:900;color:#0f172a;margin-bottom:8px}.donasiku-confirm-message{color:#64748b;margin-bottom:24px;line-height:1.6}.donasiku-confirm-actions{display:flex;justify-content:center;gap:10px;flex-wrap:wrap}.donasiku-btn{border:0;border-radius:16px;padding:12px 22px;font-weight:900}.donasiku-btn-cancel{background:#f1f5f9;color:#334155}.donasiku-btn-primary{background:#2563eb;color:#fff}.donasiku-btn-success{background:#16a34a;color:#fff}.donasiku-btn-danger{background:#e11d48;color:#fff}.donasiku-btn-secondary{background:#64748b;color:#fff}@keyframes donasikuPop{from{transform:scale(.94);opacity:.6}to{transform:scale(1);opacity:1}}
.donasiku-toast{position:fixed;right:24px;top:94px;z-index:2147482999;max-width:360px;background:#fff;border:1px solid #e2e8f0;border-radius:20px;padding:16px 18px;box-shadow:0 18px 50px rgba(15,23,42,.15);display:flex;gap:12px;align-items:flex-start}.donasiku-toast.success{border-left:6px solid #16a34a}.donasiku-toast.error{border-left:6px solid #e11d48}.donasiku-toast i{margin-top:3px}.donasiku-toast.success i{color:#16a34a}.donasiku-toast.error i{color:#e11d48}
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php
$campaigns = $campaigns ?? [];
$totalCampaign = count($campaigns);
$totalPending = count(array_filter($campaigns, fn($c) => ($c['status_verifikasi'] ?? 'pending') === 'pending'));
$totalAktif = count(array_filter($campaigns, fn($c) => ($c['status_verifikasi'] ?? '') === 'approved' && ($c['status'] ?? '') === 'aktif'));
$totalDana = array_sum(array_map(fn($c) => (float)($c['dana_terkumpul'] ?? 0), $campaigns));
$imageUrl = function ($file) {
    if (empty($file)) return base_url('assets/img/default-campaign.jpg');
    foreach (['uploads/campaign/'.$file, 'uploads/campaigns/'.$file] as $path) {
        if (defined('FCPATH') && file_exists(FCPATH.$path)) return base_url($path);
    }
    return base_url('uploads/campaign/'.$file);
};
?>

<div class="admin-campaign-page">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="page-title">Kelola Campaign</h2>
            <p class="page-subtitle">Verifikasi campaign yayasan, kelola data, dan lindungi histori donasi.</p>
        </div>
        <a href="<?= base_url('admin/campaign/create') ?>" class="btn btn-primary px-4 py-3 rounded-4 fw-bold"><i class="fa-solid fa-plus me-2"></i>Tambah Campaign</a>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-3 col-md-6"><div class="stat-card"><small>Total Campaign</small><h2><?= $totalCampaign ?></h2></div></div>
        <div class="col-lg-3 col-md-6"><div class="stat-card"><small>Menunggu Verifikasi</small><h2><?= $totalPending ?></h2></div></div>
        <div class="col-lg-3 col-md-6"><div class="stat-card"><small>Campaign Aktif</small><h2><?= $totalAktif ?></h2></div></div>
        <div class="col-lg-3 col-md-6"><div class="stat-card"><small>Dana Masuk</small><h2>Rp <?= number_format($totalDana,0,',','.') ?></h2></div></div>
    </div>

    <div class="toolbar-card mb-4">
        <form method="get" action="<?= base_url('admin/campaign') ?>">
            <div class="row g-3 align-items-center">
                <div class="col-lg-6"><input type="text" name="keyword" class="form-control" placeholder="Cari campaign, yayasan, atau kategori..." value="<?= esc($keyword ?? '') ?>"></div>
                <div class="col-lg-3"><select name="status" class="form-select"><option value="" <?= empty($status)?'selected':'' ?>>Semua Status</option><option value="pending" <?= (($status ?? '') === 'pending')?'selected':'' ?>>Menunggu Verifikasi</option><option value="approved" <?= (($status ?? '') === 'approved')?'selected':'' ?>>Disetujui</option><option value="rejected" <?= (($status ?? '') === 'rejected')?'selected':'' ?>>Ditolak</option><option value="aktif" <?= (($status ?? '') === 'aktif')?'selected':'' ?>>Aktif</option><option value="selesai" <?= (($status ?? '') === 'selesai')?'selected':'' ?>>Selesai</option><option value="draft" <?= (($status ?? '') === 'draft')?'selected':'' ?>>Draft</option></select></div>
                <div class="col-lg-3 d-flex gap-2"><button class="btn btn-primary flex-fill fw-bold" type="submit"><i class="fa-solid fa-filter me-2"></i>Filter</button><a href="<?= base_url('admin/campaign') ?>" class="btn btn-light fw-bold">Reset</a></div>
            </div>
        </form>
    </div>

    <div class="row g-4">
        <?php if (empty($campaigns)): ?>
            <div class="col-12"><div class="empty-state"><i class="fa-solid fa-box-open"></i><h4 class="fw-bold">Belum ada campaign</h4><p class="mb-0">Campaign baru akan tampil di sini untuk diverifikasi admin.</p></div></div>
        <?php endif; ?>

        <?php foreach ($campaigns as $campaign): ?>
            <?php
            $id = (int)($campaign['id'] ?? 0);
            $targetDana = (float)($campaign['target_dana'] ?? $campaign['target'] ?? 0);
            $danaTerkumpul = (float)($campaign['dana_terkumpul'] ?? 0);
            $jumlahDonatur = (int)($campaign['jumlah_donatur'] ?? 0);
            $persen = $targetDana > 0 ? min(($danaTerkumpul / $targetDana) * 100, 100) : 0;
            $statusCampaign = $campaign['status'] ?? 'draft';
            $statusVerifikasi = $campaign['status_verifikasi'] ?? 'pending';
            $hasDonation = $danaTerkumpul > 0 || $jumlahDonatur > 0;
            $img = $imageUrl($campaign['gambar'] ?? null);
            ?>
            <div class="col-xl-4 col-lg-6">
                <div class="campaign-card">
                    <img src="<?= $img ?>" class="campaign-image" alt="<?= esc($campaign['judul'] ?? 'Campaign') ?>">
                    <div class="campaign-body">
                        <div class="d-flex flex-wrap gap-2 mb-2">
                            <?php if ($statusVerifikasi === 'approved'): ?>
                                <span class="badge-soft <?= $statusCampaign === 'aktif' ? 'success' : 'dark' ?>"><i class="fa-solid fa-circle"></i><?= $statusCampaign === 'aktif' ? 'Aktif' : esc(ucfirst($statusCampaign)) ?></span>
                                <span class="badge-soft success"><i class="fa-solid fa-shield-halved"></i>Disetujui</span>
                            <?php elseif ($statusVerifikasi === 'rejected'): ?>
                                <span class="badge-soft danger"><i class="fa-solid fa-xmark"></i>Ditolak</span>
                            <?php else: ?>
                                <span class="badge-soft warning"><i class="fa-solid fa-clock"></i>Menunggu Verifikasi</span>
                            <?php endif; ?>
                        </div>
                        <h4 class="campaign-title"><?= esc($campaign['judul'] ?? '-') ?></h4>
                        <div class="campaign-meta">
                            <div><i class="fa-solid fa-building-user me-2"></i><?= esc($campaign['nama_yayasan'] ?? '-') ?></div>
                            <div><i class="fa-solid fa-tag me-2"></i><?= esc($campaign['nama_kategori'] ?? $campaign['kategori'] ?? '-') ?></div>
                            <div><i class="fa-solid fa-calendar-days me-2"></i><?= esc($campaign['tanggal_mulai'] ?? '-') ?> s.d <?= esc($campaign['tanggal_berakhir'] ?? '-') ?></div>
                        </div>
                        <div class="progress mt-3"><div class="progress-bar" style="width:<?= $persen ?>%"></div></div>
                        <div class="campaign-money mt-3"><strong>Rp <?= number_format($danaTerkumpul,0,',','.') ?></strong><small>dari Rp <?= number_format($targetDana,0,',','.') ?> · <?= $jumlahDonatur ?> donatur</small></div>
                        <?php if ($hasDonation): ?><div class="alert alert-warning py-2 px-3 mt-3 mb-0 rounded-4 small"><i class="fa-solid fa-lock me-1"></i>Sudah ada donasi, tidak boleh ditolak atau dihapus.</div><?php endif; ?>
                        <div class="campaign-action mt-4">
                            <a href="<?= base_url('admin/campaign/detail/'.$id) ?>" class="icon-btn btn-detail" title="Detail"><i class="fa-solid fa-eye"></i></a>
                            <a href="<?= base_url('admin/campaign/edit/'.$id) ?>" class="icon-btn btn-edit" title="Edit"><i class="fa-solid fa-pen"></i></a>
                            <?php if ($statusVerifikasi !== 'approved'): ?>
                                <form action="<?= base_url('admin/campaign/approve/'.$id) ?>" method="post" class="js-donasiku-confirm" data-title="Setujui Campaign" data-message="Campaign akan aktif dan bisa menerima donasi." data-confirm-text="Ya, Setujui" data-confirm-class="donasiku-btn-success"><?= csrf_field() ?><button type="submit" class="icon-btn btn-approve" title="Approve"><i class="fa-solid fa-check"></i></button></form>
                            <?php endif; ?>
                            <?php if ($statusVerifikasi !== 'rejected'): ?>
                                <?php if ($hasDonation): ?><button type="button" class="icon-btn btn-locked" disabled title="Sudah ada donasi"><i class="fa-solid fa-lock"></i></button><?php else: ?><form action="<?= base_url('admin/campaign/reject/'.$id) ?>" method="post" class="js-donasiku-confirm" data-title="Tolak Campaign" data-message="Campaign akan ditolak dan yayasan perlu memperbaiki pengajuan." data-confirm-text="Ya, Tolak" data-confirm-class="donasiku-btn-secondary"><?= csrf_field() ?><button type="submit" class="icon-btn btn-reject" title="Reject"><i class="fa-solid fa-xmark"></i></button></form><?php endif; ?>
                            <?php endif; ?>
                            <?php if ($hasDonation): ?><button type="button" class="icon-btn btn-locked" disabled title="Sudah ada donasi"><i class="fa-solid fa-lock"></i></button><?php else: ?><form action="<?= base_url('admin/campaign/delete/'.$id) ?>" method="post" class="js-donasiku-confirm" data-title="Hapus Campaign" data-message="Campaign akan dihapus permanen. Lanjutkan?" data-confirm-text="Ya, Hapus" data-confirm-class="donasiku-btn-danger"><?= csrf_field() ?><button type="submit" class="icon-btn btn-delete" title="Hapus"><i class="fa-solid fa-trash"></i></button></form><?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<div class="donasiku-confirm" id="donasikuConfirm" aria-hidden="true">
    <div class="donasiku-confirm-card">
        <div class="donasiku-confirm-icon"><i class="fa-solid fa-circle-question"></i></div>
        <h4 class="donasiku-confirm-title" data-title>Konfirmasi</h4>
        <p class="donasiku-confirm-message" data-message>Apakah Anda yakin?</p>
        <div class="donasiku-confirm-actions">
            <button type="button" class="donasiku-btn donasiku-btn-cancel" data-cancel>Batal</button>
            <button type="button" class="donasiku-btn donasiku-btn-primary" data-confirm>Ya, Lanjutkan</button>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
(function(){
    let activeForm = null;
    const modal = document.getElementById('donasikuConfirm');
    if (!modal) return;
    const title = modal.querySelector('[data-title]');
    const message = modal.querySelector('[data-message]');
    const btnConfirm = modal.querySelector('[data-confirm]');
    const btnCancel = modal.querySelector('[data-cancel]');
    document.querySelectorAll('.js-donasiku-confirm').forEach(function(form){
        form.addEventListener('submit', function(e){
            e.preventDefault();
            activeForm = form;
            title.textContent = form.dataset.title || 'Konfirmasi';
            message.textContent = form.dataset.message || 'Apakah Anda yakin ingin melanjutkan?';
            btnConfirm.textContent = form.dataset.confirmText || 'Ya, Lanjutkan';
            btnConfirm.className = 'donasiku-btn ' + (form.dataset.confirmClass || 'donasiku-btn-primary');
            modal.classList.add('show');
            modal.setAttribute('aria-hidden', 'false');
        });
    });
    function closeModal(){ modal.classList.remove('show'); modal.setAttribute('aria-hidden','true'); activeForm = null; }
    btnCancel.addEventListener('click', closeModal);
    modal.addEventListener('click', function(e){ if(e.target === modal) closeModal(); });
    document.addEventListener('keydown', function(e){ if(e.key === 'Escape' && modal.classList.contains('show')) closeModal(); });
    btnConfirm.addEventListener('click', function(){
        if (!activeForm) return;
        btnConfirm.disabled = true;
        btnConfirm.textContent = 'Memproses...';
        HTMLFormElement.prototype.submit.call(activeForm);
    });
})();
</script>
<?php if (session()->getFlashdata('success')): ?><div class="donasiku-toast success"><i class="fa-solid fa-check-circle"></i><div><strong>Berhasil</strong><br><?= esc(session()->getFlashdata('success')) ?></div></div><script>setTimeout(()=>document.querySelector('.donasiku-toast')?.remove(),4000);</script><?php endif; ?>
<?php if (session()->getFlashdata('error')): ?><div class="donasiku-toast error"><i class="fa-solid fa-triangle-exclamation"></i><div><strong>Gagal</strong><br><?= esc(session()->getFlashdata('error')) ?></div></div><script>setTimeout(()=>document.querySelector('.donasiku-toast')?.remove(),5000);</script><?php endif; ?>
<?= $this->endSection() ?>
