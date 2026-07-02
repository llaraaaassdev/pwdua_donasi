<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Dashboard Yayasan | Donasi Transparan</title>

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

.card-stat{
background:white;
border:none;
border-radius:20px;
padding:25px;
box-shadow:0 5px 20px rgba(0,0,0,.08);
transition:.3s;
}

.card-stat:hover{
transform:translateY(-5px);
}

.icon-box{
width:60px;
height:60px;
display:flex;
justify-content:center;
align-items:center;
border-radius:15px;
font-size:24px;
color:white;
}

.green{
background:#16a34a;
}

.blue{
background:#2563eb;
}

.orange{
background:#f59e0b;
}

.red{
background:#ef4444;
}

.card-box{
background:white;
padding:30px;
border-radius:20px;
margin-top:30px;
box-shadow:0 5px 20px rgba(0,0,0,.08);
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

            <a href="<?= base_url('yayasan/dashboard') ?>" class="active">

                <i class="fa-solid fa-house me-2"></i>

                Dashboard

            </a>

        </li>

        <li>

            <a href="<?= base_url('yayasan/campaign') ?>">

                <i class="fa-solid fa-bullhorn me-2"></i>

                Campaign Saya

            </a>

        </li>

        <li>

            <a href="<?= base_url('yayasan/campaign/create') ?>">

                <i class="fa-solid fa-circle-plus me-2"></i>

                Buat Campaign

            </a>

        </li>

        <li>

            <a href="<?= base_url('yayasan/reports') ?>">

                <i class="fa-solid fa-chart-column me-2"></i>

                Laporan

            </a>

        </li>

        <li>

            <a href="<?= base_url('yayasan/status') ?>">

                <i class="fa-solid fa-circle-check me-2"></i>

                Status Verifikasi

            </a>

        </li>

        <li>

            <a href="<?= base_url('yayasan/profile') ?>">

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

                Dashboard Yayasan

            </h4>

            <small class="text-muted">

                Kelola campaign dan pantau perkembangan donasi.

            </small>

        </div>

        <div class="d-flex align-items-center">

            <i class="fa-solid fa-circle-user fa-2x text-success"></i>

            <span class="ms-2 fw-semibold">

                <?= esc(session()->get('nama') ?? 'Yayasan'); ?>

            </span>

        </div>

    </div>

    <div class="dashboard">
        <div class="row">

    <!-- Total Campaign -->
    <div class="col-lg-3 col-md-6 mb-4">

        <div class="card card-stat">

            <div class="d-flex justify-content-between align-items-center">

                <div>

                    <small class="text-muted">

                        Total Campaign

                    </small>

                    <h2 class="fw-bold mt-2">

                        0

                    </h2>

                </div>

                <div class="icon-box green">

                    <i class="fa-solid fa-bullhorn"></i>

                </div>

            </div>

        </div>

    </div>

    <!-- Campaign Aktif -->
    <div class="col-lg-3 col-md-6 mb-4">

        <div class="card card-stat">

            <div class="d-flex justify-content-between align-items-center">

                <div>

                    <small class="text-muted">

                        Campaign Aktif

                    </small>

                    <h2 class="fw-bold mt-2">

                        0

                    </h2>

                </div>

                <div class="icon-box blue">

                    <i class="fa-solid fa-circle-check"></i>

                </div>

            </div>

        </div>

    </div>

    <!-- Total Donasi -->
    <div class="col-lg-3 col-md-6 mb-4">

        <div class="card card-stat">

            <div class="d-flex justify-content-between align-items-center">

                <div>

                    <small class="text-muted">

                        Total Donasi

                    </small>

                    <h2 class="fw-bold mt-2">

                        Rp0

                    </h2>

                </div>

                <div class="icon-box orange">

                    <i class="fa-solid fa-wallet"></i>

                </div>

            </div>

        </div>

    </div>

    <!-- Total Donatur -->
    <div class="col-lg-3 col-md-6 mb-4">

        <div class="card card-stat">

            <div class="d-flex justify-content-between align-items-center">

                <div>

                    <small class="text-muted">

                        Total Donatur

                    </small>

                    <h2 class="fw-bold mt-2">

                        0

                    </h2>

                </div>

                <div class="icon-box red">

                    <i class="fa-solid fa-users"></i>

                </div>

            </div>

        </div>

    </div>

</div>
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