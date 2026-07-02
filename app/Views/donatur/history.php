<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Riwayat Donasi | Donasi Transparan</title>

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
background:linear-gradient(180deg,#2563eb,#1e40af);
color:white;
padding:25px;
}

.logo{
font-size:28px;
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
margin-bottom:12px;
}

.menu a{
display:block;
padding:12px 18px;
color:white;
text-decoration:none;
border-radius:12px;
transition:.3s;
}

.menu a:hover{
background:rgba(255,255,255,.2);
}

.menu a.active{
background:white;
color:#2563eb;
font-weight:bold;
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
padding:25px;
border-radius:20px;
box-shadow:0 5px 20px rgba(0,0,0,.08);
}

.table thead{
background:#2563eb;
color:white;
}

.badge{
padding:8px 15px;
font-size:13px;
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
            <a href="<?= base_url('dashboard') ?>">
                <i class="fa-solid fa-house me-2"></i>
                Dashboard
            </a>
        </li>

        <li>
            <a href="<?= base_url('campaign') ?>">
                <i class="fa-solid fa-bullhorn me-2"></i>
                Campaign
            </a>
        </li>

        <li>
            <a href="<?= base_url('donasi') ?>" class="active">
                <i class="fa-solid fa-hand-holding-heart me-2"></i>
                Riwayat Donasi
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

    <!-- Navbar -->
    <div class="navbar-custom">

        <div>

            <h4 class="fw-bold mb-0">
                Riwayat Donasi
            </h4>

            <small class="text-muted">
                Daftar donasi yang pernah Anda lakukan
            </small>

        </div>

        <div>

            <i class="fa-solid fa-circle-user fa-2x text-primary"></i>

            <span class="ms-2 fw-semibold">
                Halo, <?= session()->get('nama') ?? 'Donatur'; ?>
            </span>

        </div>

    </div>

    <!-- Dashboard -->
    <div class="dashboard">

        <div class="card-box">

            <div class="d-flex justify-content-between mb-4">

                <h4 class="fw-bold">
                    Data Donasi
                </h4>

                <a href="<?= base_url('campaign') ?>" class="btn btn-primary">

                    <i class="fa-solid fa-plus"></i>

                    Donasi Lagi

                </a>

            </div>

            <table class="table table-hover align-middle">

                <thead>

                    <tr>

                        <th>No</th>
                        <th>Campaign</th>
                        <th>Tanggal</th>
                        <th>Nominal</th>
                        <th>Status</th>
                        <th>Aksi</th>

                    </tr>

                </thead>

                <tbody>

                    <tr>

                        <td>1</td>

                        <td>Bantu Korban Banjir Bandung</td>

                        <td>01 Juli 2025</td>

                        <td>Rp500.000</td>

                        <td>

                            <span class="badge bg-success">

                                Berhasil

                            </span>

                        </td>

                        <td>

                            <a href="#" class="btn btn-sm btn-primary">

                                Detail

                            </a>

                        </td>

                    </tr>

                    <tr>

                        <td>2</td>

                        <td>Pembangunan Masjid</td>

                        <td>28 Juni 2025</td>

                        <td>Rp250.000</td>

                        <td>

                            <span class="badge bg-warning text-dark">

                                Menunggu

                            </span>

                        </td>

                        <td>

                            <a href="#" class="btn btn-sm btn-primary">

                                Detail

                            </a>

                        </td>

                    </tr>

                    <tr>

                        <td>3</td>

                        <td>Bantu Anak Yatim</td>

                        <td>20 Juni 2025</td>

                        <td>Rp100.000</td>

                        <td>

                            <span class="badge bg-success">

                                Berhasil

                            </span>

                        </td>

                        <td>

                            <a href="#" class="btn btn-sm btn-primary">

                                Detail

                            </a>

                        </td>

                    </tr>

                </tbody>

            </table>

        </div>
        <!-- Ringkasan Donasi -->
<div class="row mt-4">

    <div class="col-lg-4 mb-3">

        <div class="card-box text-center">

            <i class="fa-solid fa-hand-holding-heart fa-2x text-primary mb-3"></i>

            <h5>Total Donasi</h5>

            <h2 class="fw-bold text-primary">
                Rp850.000
            </h2>

        </div>

    </div>

    <div class="col-lg-4 mb-3">

        <div class="card-box text-center">

            <i class="fa-solid fa-receipt fa-2x text-success mb-3"></i>

            <h5>Total Transaksi</h5>

            <h2 class="fw-bold text-success">
                3
            </h2>

        </div>

    </div>

    <div class="col-lg-4 mb-3">

        <div class="card-box text-center">

            <i class="fa-solid fa-circle-check fa-2x text-warning mb-3"></i>

            <h5>Donasi Berhasil</h5>

            <h2 class="fw-bold text-warning">
                2
            </h2>

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
    <!-- End Dashboard -->

</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>