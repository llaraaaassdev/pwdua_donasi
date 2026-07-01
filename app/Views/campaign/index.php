<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Kelola Campaign | Donasi Transparan</title>

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

background:linear-gradient(180deg,#2563eb,#1e40af);

color:white;

padding:25px;

overflow-y:auto;

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

.card-stat{

border:none;

border-radius:20px;

box-shadow:0 5px 20px rgba(0,0,0,.08);

}

.table-box{

margin-top:30px;

background:white;

padding:25px;

border-radius:20px;

box-shadow:0 5px 20px rgba(0,0,0,.08);

}

.table thead{

background:#2563eb;
color:white;

}

.btn-primary{

background:#2563eb;
border:none;

}

.btn-primary:hover{

background:#1e40af;

}

.form-control,
.form-select{

border-radius:12px;

}

.badge{

padding:8px 12px;

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
            <a href="<?= base_url('campaign') ?>" class="active">
                <i class="fa-solid fa-bullhorn me-2"></i>
                Campaign
            </a>
        </li>

        <li>
            <a href="<?= base_url('donasi') ?>">
                <i class="fa-solid fa-hand-holding-heart me-2"></i>
                Donasi
            </a>
        </li>

        <li>
            <a href="<?= base_url('profile') ?>">
                <i class="fa-solid fa-user me-2"></i>
                Profil
            </a>
        </li>

        <li>
            <a href="#">
                <i class="fa-solid fa-chart-column me-2"></i>
                Laporan
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
                Kelola Campaign
            </h4>

            <small class="text-muted">
                Daftar seluruh campaign donasi
            </small>

        </div>

        <div class="d-flex align-items-center">

            <i class="fa-solid fa-circle-user fa-2x text-primary"></i>

            <span class="ms-2 fw-semibold">
                Halo, <?= session()->get('nama') ?? 'User'; ?>
            </span>

        </div>

    </div>

    <!-- Dashboard -->
    <div class="dashboard">

        <!-- Statistik -->
        <div class="row">

            <div class="col-lg-4 mb-4">

                <div class="card card-stat p-4">

                    <h6 class="text-muted">
                        Total Campaign
                    </h6>

                    <h2 class="fw-bold">
                        25
                    </h2>

                </div>

            </div>

            <div class="col-lg-4 mb-4">

                <div class="card card-stat p-4">

                    <h6 class="text-muted">
                        Campaign Aktif
                    </h6>

                    <h2 class="fw-bold text-success">
                        18
                    </h2>

                </div>

            </div>

            <div class="col-lg-4 mb-4">

                <div class="card card-stat p-4">

                    <h6 class="text-muted">
                        Campaign Selesai
                    </h6>

                    <h2 class="fw-bold text-primary">
                        7
                    </h2>

                </div>

            </div>

        </div>
        <!-- Table Campaign -->
<div class="table-box">

    <div class="row mb-4">

        <div class="col-md-4">

            <input
                type="text"
                class="form-control"
                placeholder="Cari Campaign...">

        </div>

        <div class="col-md-3">

            <select class="form-select">

                <option>Semua Status</option>
                <option>Aktif</option>
                <option>Berjalan</option>
                <option>Selesai</option>

            </select>

        </div>

        <div class="col-md-5 text-end">

            <a href="<?= base_url('campaign/create') ?>"
                class="btn btn-primary">

                <i class="fa-solid fa-plus"></i>

                Tambah Campaign

            </a>

        </div>

    </div>

    <table class="table table-hover align-middle">

        <thead>

            <tr>

                <th>No</th>

                <th>Gambar</th>

                <th>Judul Campaign</th>

                <th>Target</th>

                <th>Terkumpul</th>

                <th>Status</th>

                <th>Aksi</th>

            </tr>

        </thead>

        <tbody>

            <tr>

                <td>1</td>

                <td>

                    <img
                        src="https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?w=120"
                        width="70"
                        class="rounded">

                </td>

                <td>

                    Bantu Korban Banjir Bandung

                </td>

                <td>

                    Rp50.000.000

                </td>

                <td>

                    Rp20.000.000

                </td>

                <td>

                    <span class="badge bg-success">

                        Aktif

                    </span>

                </td>

                <td>

                    <a href="<?= base_url('campaign/detail') ?>"
                        class="btn btn-sm btn-primary">

                        <i class="fa-solid fa-eye"></i>

                    </a>

                    <a href="#"
                        class="btn btn-sm btn-warning">

                        <i class="fa-solid fa-pen"></i>

                    </a>

                    <a href="#"
                        class="btn btn-sm btn-danger">

                        <i class="fa-solid fa-trash"></i>

                    </a>

                </td>

            </tr>

            <tr>

                <td>2</td>

                <td>

                    <img
                        src="https://images.unsplash.com/photo-1469571486292-b53601020f1c?w=120"
                        width="70"
                        class="rounded">

                </td>

                <td>

                    Donasi Anak Yatim

                </td>

                <td>

                    Rp30.000.000

                </td>

                <td>

                    Rp15.500.000

                </td>

                <td>

                    <span class="badge bg-warning text-dark">

                        Berjalan

                    </span>

                </td>

                <td>

                    <a href="<?= base_url('campaign/detail') ?>"
                        class="btn btn-sm btn-primary">

                        <i class="fa-solid fa-eye"></i>

                    </a>

                    <a href="#"
                        class="btn btn-sm btn-warning">

                        <i class="fa-solid fa-pen"></i>

                    </a>

                    <a href="#"
                        class="btn btn-sm btn-danger">

                        <i class="fa-solid fa-trash"></i>

                    </a>

                </td>

            </tr>

            <tr>

                <td>3</td>

                <td>

                    <img
                        src="https://images.unsplash.com/photo-1517486808906-6ca8b3f04846?w=120"
                        width="70"
                        class="rounded">

                </td>

                <td>

                    Renovasi Panti Asuhan

                </td>

                <td>

                    Rp75.000.000

                </td>

                <td>

                    Rp75.000.000

                </td>

                <td>

                    <span class="badge bg-primary">

                        Selesai

                    </span>

                </td>

                <td>

                    <a href="<?= base_url('campaign/detail') ?>"
                        class="btn btn-sm btn-primary">

                        <i class="fa-solid fa-eye"></i>

                    </a>

                    <a href="#"
                        class="btn btn-sm btn-warning">

                        <i class="fa-solid fa-pen"></i>

                    </a>

                    <a href="#"
                        class="btn btn-sm btn-danger">

                        <i class="fa-solid fa-trash"></i>

                    </a>

                </td>

            </tr>

        </tbody>

    </table>
        <!-- Pagination -->
    <nav class="mt-4">

        <ul class="pagination justify-content-end">

            <li class="page-item disabled">

                <a class="page-link" href="#">
                    Previous
                </a>

            </li>

            <li class="page-item active">

                <a class="page-link" href="#">
                    1
                </a>

            </li>

            <li class="page-item">

                <a class="page-link" href="#">
                    2
                </a>

            </li>

            <li class="page-item">

                <a class="page-link" href="#">
                    3
                </a>

            </li>

            <li class="page-item">

                <a class="page-link" href="#">
                    Next
                </a>

            </li>

        </ul>

    </nav>

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