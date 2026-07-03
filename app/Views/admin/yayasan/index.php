<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Kelola Yayasan | Donasi Transparan</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Segoe UI',sans-serif;
}

body{
background:#f4f7fb;
}

.sidebar{
position:fixed;
left:0;
top:0;
width:250px;
height:100vh;
background:linear-gradient(180deg,#16a34a,#15803d);
padding:25px;
color:white;
overflow-y:auto;
}

.logo{
font-size:26px;
font-weight:700;
margin-bottom:40px;
}

.logo i{
margin-right:10px;
}

.menu{
list-style:none;
padding:0;
}

.menu li{
margin-bottom:10px;
}

.menu a{
display:block;
padding:13px 18px;
color:white;
text-decoration:none;
border-radius:12px;
transition:.3s;
}

.menu a:hover{
background:rgba(255,255,255,.15);
}

.menu a.active{
background:white;
color:#15803d;
font-weight:600;
}

.content{
margin-left:250px;
}

.navbar-custom{
height:75px;
background:white;
display:flex;
justify-content:space-between;
align-items:center;
padding:0 35px;
box-shadow:0 5px 20px rgba(0,0,0,.08);
}

.dashboard{
padding:30px;
}

.card-box{
background:white;
padding:30px;
border-radius:20px;
box-shadow:0 5px 20px rgba(0,0,0,.08);
}

.table thead{
background:#16a34a;
color:white;
}

.btn-success{
background:#16a34a;
border:none;
}

</style>

</head>
<body>

<!-- Sidebar -->
<div class="sidebar">

    <div class="logo">

        <i class="fa-solid fa-hand-holding-heart"></i>

        Donasi Transparan

    </div>

    <ul class="menu">

        <li>

            <a href="<?= base_url('admin/dashboard') ?>">

                <i class="fa-solid fa-house me-2"></i>

                Dashboard

            </a>

        </li>

        <li>

            <a href="<?= base_url('admin/users') ?>">

                <i class="fa-solid fa-users me-2"></i>

                Kelola User

            </a>

        </li>

        <li>

            <a href="<?= base_url('admin/yayasan') ?>" class="active">

                <i class="fa-solid fa-building me-2"></i>

                Kelola Yayasan

            </a>

        </li>

        <li>

            <a href="<?= base_url('admin/campaign') ?>">

                <i class="fa-solid fa-bullhorn me-2"></i>

                Kelola Campaign

            </a>

        </li>

        <li>

            <a href="<?= base_url('admin/donations') ?>">

                <i class="fa-solid fa-hand-holding-heart me-2"></i>

                Kelola Donasi

            </a>

        </li>

        <li>

            <a href="<?= base_url('admin/reports') ?>">

                <i class="fa-solid fa-chart-column me-2"></i>

                Laporan

            </a>

        </li>

        <li>

            <a href="<?= base_url('profile') ?>">

                <i class="fa-solid fa-user me-2"></i>

                Profil

            </a>

        </li>

        <li>

            <a href="<?= base_url('logout') ?>">

                <i class="fa-solid fa-right-from-bracket me-2"></i>

                Logout

            </a>

        </li>

    </ul>

</div>

<!-- Content -->
<div class="content">

    <div class="navbar-custom">

        <div>

            <h4 class="fw-bold mb-0">

                Kelola Yayasan

            </h4>

            <small class="text-muted">

                Data seluruh yayasan yang terdaftar

            </small>

        </div>

        <div class="d-flex align-items-center">

            <i class="fa-solid fa-circle-user fa-2x text-success"></i>

            <span class="ms-2 fw-semibold">

                <?= esc(session()->get('nama') ?? 'Administrator'); ?>

            </span>

        </div>

    </div>

    <div class="dashboard">

        <div class="card-box">

            <div class="d-flex justify-content-between align-items-center mb-4">

                <h4 class="fw-bold mb-0">

                    Daftar Yayasan

                </h4>

                <button class="btn btn-success">

                    <i class="fa-solid fa-plus"></i>

                    Tambah Yayasan

                </button>

            </div>

            <div class="row mb-4">

                <div class="col-md-6">

                    <form method="get">

<div class="row mb-4">

    <div class="col-md-5">

        <input
            type="text"
            name="keyword"
            class="form-control"
            placeholder="Cari nama yayasan..."
            value="<?= esc($keyword ?? '') ?>">

    </div>

    <div class="col-md-4">

        <select
            name="status"
            class="form-select">

            <option value="">Semua Status</option>

            <option value="pending"
            <?= ($status=='pending')?'selected':'' ?>>
                Pending
            </option>

            <option value="verified"
            <?= ($status=='verified')?'selected':'' ?>>
                Verified
            </option>

            <option value="rejected"
            <?= ($status=='rejected')?'selected':'' ?>>
                Rejected
            </option>

        </select>

    </div>

    <div class="col-md-3">

        <button
            class="btn btn-success w-100">

            Filter

        </button>

    </div>

</div>

</form>
                </div>

                <div class="col-md-3">

                    <select class="form-select">

                        <option>Semua Status</option>
                        <option>Aktif</option>
                        <option>Menunggu Verifikasi</option>
                        <option>Nonaktif</option>

                    </select>

                </div>

                <div class="col-md-3">

                    <button class="btn btn-success w-100">

                        Filter

                    </button>

                </div>

            </div>
            <?php if(session()->getFlashdata('success')): ?>

<div class="alert alert-success">

<?= session()->getFlashdata('success'); ?>

</div>

<?php endif; ?>
            <!-- Tabel Yayasan -->
<div class="table-responsive">

    <table class="table table-bordered table-hover align-middle">

        <thead>

            <tr>

                <th width="60">No</th>

                <th>Nama Yayasan</th>

                <th>Penanggung Jawab</th>

                <th>Email</th>

                <th>Status</th>

                <th width="180">Aksi</th>

            </tr>

        </thead>

        
<tbody>

<?php $no = 1; ?>

<?php if(empty($foundations)): ?>

<tr>
    <td colspan="6" class="text-center">
        Belum ada data yayasan.
    </td>
</tr>

<?php else: ?>

<?php foreach($foundations as $f): ?>

<tr>

<td><?= $no++ ?></td>

<td><?= esc($f['nama_yayasan']) ?></td>

<td><?= esc($f['nama']) ?></td>

<td><?= esc($f['email_yayasan']) ?></td>

<td>

<?php if($f['status']=='pending'): ?>

<span class="badge bg-warning">Pending</span>

<?php elseif($f['status']=='verified'): ?>

<span class="badge bg-success">Verified</span>

<?php else: ?>

<span class="badge bg-danger">Rejected</span>

<?php endif; ?>

</td>

<td>

<a href="<?= base_url('admin/yayasan/detail/'.$f['id']) ?>"
class="btn btn-info btn-sm">

<i class="fa-solid fa-eye"></i>

</a>

<a href="<?= base_url('admin/yayasan/approve/'.$f['id']) ?>"
class="btn btn-success btn-sm"
onclick="return confirm('Approve yayasan ini?')">

<i class="fa-solid fa-check"></i>

</a>

<a href="<?= base_url('admin/yayasan/delete/'.$f['id']) ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Hapus yayasan ini?')">

<i class="fa-solid fa-trash"></i>

</a>

</td>

</tr>

<?php endforeach; ?>

<?php endif; ?>

</tbody>
    </table>

</div>

</div>

<!-- Footer -->
<div class="mt-5 text-center text-muted">

    <hr>

    <p class="mb-0">

        © <?= date('Y'); ?> Donasi Transparan |
        Sistem Informasi Donasi Berbasis Web

    </p>

</div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>