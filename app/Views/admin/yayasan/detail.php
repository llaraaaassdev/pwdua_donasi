<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Detail Yayasan | Donasi Transparan</title>

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
text-decoration:none;
color:white;
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
margin-bottom:25px;
}

.info-title{
font-weight:600;
color:#6b7280;
margin-bottom:5px;
}

.info-value{
font-size:16px;
font-weight:500;
}

.btn-success{
background:#16a34a;
border:none;
}

.btn-secondary{
border:none;
}

</style>

</head>
<body>

<!-- Sidebar -->
<div class="sidebar">

    <div class="logo">

        <?php if(!empty($foundation['logo'])): ?>
            <img
            src="<?= base_url('uploads/logo/'.$foundation['logo']) ?>"
            class="img-fluid rounded"
            style="max-height:180px;">

            <?php else: ?>
            <i class="fa-solid fa-building fa-5x text-success"></i>
            <h5 class="mt-3">  Belum Upload Logo   </h5>

        <?php endif; ?>
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

                Detail Yayasan

            </h4>

            <small class="text-muted">

                Informasi lengkap yayasan

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

    <div class="row">

        <div class="col-md-3 text-center">

            <div class="border rounded-4 p-4">

                <i class="fa-solid fa-building fa-5x text-success"></i>

                <h5 class="mt-3">

                    Logo Yayasan

                </h5>

            </div>

        </div>

        <div class="col-md-9">

            <div class="row">

                <div class="col-md-6 mb-4">

                    <div class="info-title">

                        Nama Yayasan

                    </div>

                    <div class="info-value">

                        <?= esc($foundation['nama_yayasan']) ?>

                    </div>

                </div>

                <div class="col-md-6 mb-4">

                    <div class="info-title">

                        Penanggung Jawab

                    </div>

                    <div class="info-value">

                        <?= esc($foundation['nama']) ?>

                    </div>

                </div>

                <div class="col-md-6 mb-4">

                    <div class="info-title">

                        Email

                    </div>

                    <div class="info-value">
                        <?= esc($foundation['email_yayasan']) ?>
                    </div>

                </div>

                <div class="col-md-6 mb-4">

                    <div class="info-title">

                        Nomor Telepon

                    </div>

                    <div class="info-value">

                        <?= esc($foundation['telepon']) ?>

                    </div>

                </div>

                <div class="col-md-12">

                    <div class="info-title">

                        Alamat

                    </div>

                    <div class="info-value">

                        <?= esc($foundation['alamat']) ?>

                    </div>

                    <div class="col-md-6 mt-4">

                        <div class="info-title">  Status </div>
                        <div class="info-value">

                        <?php
                            if($foundation['status']=="pending")
                            echo "<span class='badge bg-warning'>Pending</span>";
                            elseif($foundation['status']=="verified")
                            echo "<span class='badge bg-success'>Verified</span>";
                            else
                            echo "<span class='badge bg-danger'>Rejected</span>";
                        ?>

                        </div>
                        </div>
                </div>
                <div class="col-md-6 mt-4">

                    <div class="info-title"> Dokumen Legalitas </div>
                    <div class="info-value">

                    <?php if(!empty($foundation['dokumen_verifikasi'])): ?>

                    <a
                    href="<?= base_url('uploads/dokumen/'.$foundation['dokumen_verifikasi']) ?>"
                    target="_blank"
                    class="btn btn-secondary">

                    <i class="fa-solid fa-file-pdf"></i>  Lihat Dokumen </a>

                    <?php else: ?> 
                    Belum ada dokumen 
                    <?php endif; ?>

                    </div>

                    </div>
                        <div class="mt-4 d-flex gap-2">

                        <form action="<?= base_url('admin/yayasan/approve/'.$foundation['id']) ?>" method="post">

                        <?= csrf_field(); ?>

                        <button class="btn btn-success">

                        <i class="fa-solid fa-check"></i>

                        Approve

                        </button>

                        </form>

                        <form action="<?= base_url('admin/yayasan/reject/'.$foundation['id']) ?>" method="post">

                        <?= csrf_field(); ?>

                        <button class="btn btn-danger">

                        <i class="fa-solid fa-xmark"></i>

                        Reject

                        </button>

                        </form>

                        <a href="<?= base_url('admin/yayasan') ?>"
                        class="btn btn-secondary">

                        Kembali

                        </a>
                        <a href="<?= base_url('admin/yayasan/delete/'.$foundation['id']) ?>"
                        class="btn btn-outline-danger"
                        onclick="return confirm('Yakin ingin menghapus yayasan ini?')">

                            Delete

                        </a>

                        </div>
            </div>

        </div>

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