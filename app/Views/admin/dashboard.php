<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard Admin | Donasi Transparan</title>

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
            color:white;
            padding:25px;
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
            color:white;
            text-decoration:none;
            padding:13px 18px;
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
            border-left:5px solid #16a34a;
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
            color:white;
            font-size:24px;
        }

        .green{background:#16a34a;}
        .blue{background:#2563eb;}
        .orange{background:#f59e0b;}
        .red{background:#ef4444;}

        .content-card{
            background:white;
            border-radius:20px;
            padding:30px;
            margin-top:30px;
            box-shadow:0 5px 20px rgba(0,0,0,.08);
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
            <a href="<?= base_url('admin/dashboard') ?>" class="active">
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
            <a href="<?= base_url('admin/yayasan') ?>">
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
            <h4 class="fw-bold mb-0">Dashboard Admin</h4>
            <small class="text-muted">
                Selamat datang di Sistem Donasi Transparan
            </small>
        </div>

        <div class="d-flex align-items-center">

            <i class="fa-solid fa-circle-user fa-2x text-success"></i>

            <div class="ms-3">

                <div class="fw-bold">
                    <?= esc(session()->get('nama') ?? 'Administrator'); ?>
                </div>

                <small class="text-muted">
                    Administrator
                </small>

            </div>

        </div>

    </div>

    <div class="dashboard">

        <div class="mb-4">

            <h3 class="fw-bold">
                Ringkasan Dashboard
            </h3>

            <p class="text-muted mb-0">
                Informasi sistem secara keseluruhan.
            </p>

        </div>

        <div class="row">

            <!-- Total User -->
            <div class="col-lg-3 col-md-6 mb-4">

                <div class="card card-stat">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <small class="text-muted">
                                Total User
                            </small>

                            <h2 class="fw-bold mt-2">
                                <?= $totalUser ?>
                            </h2>

                        </div>

                        <div class="icon-box blue">

                            <i class="fa-solid fa-users"></i>

                        </div>

                    </div>

                </div>

            </div>

            <!-- Total Yayasan -->
            <div class="col-lg-3 col-md-6 mb-4">

                <div class="card card-stat">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <small class="text-muted">
                                Total Yayasan
                            </small>

                            <h2 class="fw-bold mt-2">
                                <?= $totalFoundation ?>
                            </h2>

                        </div>

                        <div class="icon-box green">

                            <i class="fa-solid fa-building"></i>

                        </div>

                    </div>

                </div>

            </div>

            <!-- Total Campaign -->
            <div class="col-lg-3 col-md-6 mb-4">

                <div class="card card-stat">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <small class="text-muted">
                                Total Campaign
                            </small>

                            <h2 class="fw-bold mt-2">
                                <?= $totalCampaign ?>
                            </h2>

                        </div>

                        <div class="icon-box orange">

                            <i class="fa-solid fa-bullhorn"></i>

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
                                Rp <?= number_format($totalDonation,0,',','.') ?>
                            </h2>

                        </div>

                        <div class="icon-box red">

                            <i class="fa-solid fa-wallet"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- Card tambahan -->
        <div class="row">

            <div class="col-lg-6">

                <div class="content-card">

                    <h5 class="fw-bold mb-3">
                        Yayasan Menunggu Verifikasi
                    </h5>

                    <h1 class="text-warning">
                        <?= $waitingFoundation ?>
                    </h1>

                    <p class="text-muted mb-0">
                        Yayasan yang belum diverifikasi admin.
                    </p>

                </div>

            </div>

            <div class="col-lg-6">

                <div class="content-card">

                    <h5 class="fw-bold mb-3">
                        Campaign Terbaru
                    </h5>

                    <?php if(!empty($latestCampaign)): ?>

                        <ul class="list-group">

                            <?php foreach($latestCampaign as $campaign): ?>

                                <li class="list-group-item">

                                    <?= esc($campaign['judul']) ?>

                                </li>

                            <?php endforeach; ?>

                        </ul>

                    <?php else: ?>

                        <p class="text-muted">
                            Belum ada campaign.
                        </p>

                    <?php endif; ?>

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