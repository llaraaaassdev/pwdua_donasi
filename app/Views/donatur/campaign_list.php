<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Campaign Donasi | Donasi Transparan</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

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
font-weight:bold;
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

.form-control{
height:48px;
border-radius:12px;
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

            <a href="<?= base_url('donatur/dashboard') ?>">

                <i class="fa-solid fa-house me-2"></i>

                Dashboard

            </a>

        </li>

        <li>

            <a href="<?= base_url('donatur/campaign') ?>" class="active">

                <i class="fa-solid fa-bullhorn me-2"></i>

                Campaign

            </a>

        </li>

        <li>

            <a href="<?= base_url('donatur/history') ?>">

                <i class="fa-solid fa-clock-rotate-left me-2"></i>

                Riwayat Donasi

            </a>

        </li>

        <li>

            <a href="<?= base_url('donatur/profile') ?>">

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

                Campaign Donasi

            </h4>

            <small class="text-muted">

                Pilih campaign yang ingin Anda dukung.

            </small>

        </div>

        <div class="d-flex align-items-center">

            <i class="fa-solid fa-circle-user fa-2x text-success"></i>

            <span class="ms-2 fw-semibold">

                <?= esc(session()->get('nama') ?? 'Donatur'); ?>

            </span>

        </div>

    </div>

    <div class="dashboard">
        <div class="card-box">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h4 class="fw-bold mb-0">

            Daftar Campaign

        </h4>

    </div>

    <div class="row mb-4">

        <div class="col-md-9">

            <input
            type="text"
            class="form-control"
            placeholder="Cari campaign...">

        </div>

        <div class="col-md-3">

            <button class="btn btn-success w-100">

                Cari

            </button>

        </div>

    </div>

    <hr>

    <div class="text-center py-5">

        <i class="fa-solid fa-bullhorn fa-4x text-success mb-4"></i>

        <h3 class="fw-bold">

            Belum Ada Campaign

        </h3>

        <p class="text-muted">

            Campaign yang tersedia akan ditampilkan di halaman ini.

        </p>

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