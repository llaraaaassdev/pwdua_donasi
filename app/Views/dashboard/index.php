<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard | Donasi Transparan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Segoe UI", sans-serif;
        }

        body {
            background: #f4f7fb;
        }

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 250px;
            height: 100vh;
            background: linear-gradient(180deg, #2563eb, #1e40af);
            color: white;
            padding: 25px;
        }

        .logo {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 40px;
        }

        .logo i {
            margin-right: 10px;
        }

        .menu {
            list-style: none;
            padding: 0;
        }

        .menu li {
            margin-bottom: 12px;
        }

        .menu a {
            display: block;
            padding: 12px 18px;
            color: white;
            text-decoration: none;
            border-radius: 12px;
            transition: .3s;
        }

        .menu a:hover {
            background: rgba(255,255,255,.18);
        }

        .content {
            margin-left: 250px;
        }

        .navbar-custom {
            background: white;
            height: 75px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 35px;
            box-shadow: 0 5px 20px rgba(0,0,0,.08);
        }

        .profile {
            font-weight: 600;
        }

        .dashboard {
            padding: 30px;
        }

        .card-stat {
            border: none;
            border-radius: 20px;
            box-shadow: 0 5px 20px rgba(0,0,0,.08);
            transition: .3s;
        }

        .card-stat:hover {
            transform: translateY(-5px);
        }

        .icon-box {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            font-size: 25px;
        }

        .blue {
            background: #2563eb;
        }

        .green {
            background: #10b981;
        }

        .orange {
            background: #f59e0b;
        }

        .red {
            background: #ef4444;
        }

        .table-box {
            margin-top: 35px;
            background: white;
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0,0,0,.08);
        }

        .table thead {
            background: #2563eb;
            color: white;
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
            <a href="#">
                <i class="fa-solid fa-house me-2"></i>
                Dashboard
            </a>
        </li>

        <li>
            <a href="#">
                <i class="fa-solid fa-users me-2"></i>
                Kelola User
            </a>
        </li>

        <li>
            <a href="#">
                <i class="fa-solid fa-building me-2"></i>
                Kelola Yayasan
            </a>
        </li>

        <li>
            <a href="#">
                <i class="fa-solid fa-hand-holding-heart me-2"></i>
                Kelola Donasi
            </a>
        </li>

        <li>
            <a href="#">
                <i class="fa-solid fa-bullhorn me-2"></i>
                Kelola Campaign
            </a>
        </li>

        <li>
            <a href="#">
                <i class="fa-solid fa-chart-column me-2"></i>
                Laporan
            </a>
        </li>

        <li>
            <a href="#">
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

    <!-- Navbar -->
    <div class="navbar-custom">

        <div>
            <h4 class="mb-0 fw-bold">
                Dashboard
            </h4>

            <small class="text-muted">
                Selamat datang di Sistem Donasi Transparan
            </small>
        </div>

        <div class="profile">

            <i class="fa-solid fa-circle-user fa-lg"></i>

            <span class="ms-2">
                Halo, Admin
            </span>

        </div>

    </div>

    <!-- Dashboard -->
    <div class="dashboard">

        <div class="row">
            <!-- Card Total User -->
<div class="col-lg-3 col-md-6 mb-4">

    <div class="card card-stat p-4">

        <div class="d-flex justify-content-between align-items-center">

            <div>

                <small class="text-muted">
                    Total User
                </small>

                <h2 class="fw-bold mt-2">
                    120
                </h2>

            </div>

            <div class="icon-box blue">

                <i class="fa-solid fa-users"></i>

            </div>

        </div>

    </div>

</div>

<!-- Card Yayasan -->
<div class="col-lg-3 col-md-6 mb-4">

    <div class="card card-stat p-4">

        <div class="d-flex justify-content-between align-items-center">

            <div>

                <small class="text-muted">
                    Total Yayasan
                </small>

                <h2 class="fw-bold mt-2">
                    15
                </h2>

            </div>

            <div class="icon-box green">

                <i class="fa-solid fa-building"></i>

            </div>

        </div>

    </div>

</div>

<!-- Card Campaign -->
<div class="col-lg-3 col-md-6 mb-4">

    <div class="card card-stat p-4">

        <div class="d-flex justify-content-between align-items-center">

            <div>

                <small class="text-muted">
                    Campaign Aktif
                </small>

                <h2 class="fw-bold mt-2">
                    25
                </h2>

            </div>

            <div class="icon-box orange">

                <i class="fa-solid fa-bullhorn"></i>

            </div>

        </div>

    </div>

</div>

<!-- Card Donasi -->
<div class="col-lg-3 col-md-6 mb-4">

    <div class="card card-stat p-4">

        <div class="d-flex justify-content-between align-items-center">

            <div>

                <small class="text-muted">
                    Total Donasi
                </small>

                <h2 class="fw-bold mt-2">
                    Rp25 Jt
                </h2>

            </div>

            <div class="icon-box red">

                <i class="fa-solid fa-wallet"></i>

            </div>

        </div>

    </div>

</div>

</div>

<!-- Tabel Campaign -->
<div class="table-box">

    <div class="d-flex justify-content-between mb-3">

        <h4 class="fw-bold">
            Campaign Terbaru
        </h4>

        <button class="btn btn-primary">
            <i class="fa-solid fa-plus"></i>
            Tambah Campaign
        </button>

    </div>

    <table class="table table-hover align-middle">

        <thead>

            <tr>

                <th>No</th>
                <th>Campaign</th>
                <th>Target</th>
                <th>Terkumpul</th>
                <th>Status</th>

            </tr>

        </thead>

        <tbody>

            <tr>

                <td>1</td>

                <td>Bantu Korban Banjir</td>

                <td>Rp50.000.000</td>

                <td>Rp22.500.000</td>

                <td>

                    <span class="badge bg-success">
                        Aktif
                    </span>

                </td>

            </tr>

            <tr>

                <td>2</td>

                <td>Pembangunan Masjid</td>

                <td>Rp150.000.000</td>

                <td>Rp75.000.000</td>

                <td>

                    <span class="badge bg-warning text-dark">
                        Berjalan
                    </span>

                </td>

            </tr>

            <tr>

                <td>3</td>

                <td>Bantu Anak Yatim</td>

                <td>Rp35.000.000</td>

                <td>Rp31.000.000</td>

                <td>

                    <span class="badge bg-primary">
                        Hampir Selesai
                    </span>

                </td>

            </tr>

        </tbody>

    </table>

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
    <!-- End Dashboard -->

</div>
<!-- End Content -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>