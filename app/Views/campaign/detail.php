<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Detail Campaign | Donasi Transparan</title>

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

.card-box{

background:white;

border-radius:20px;

padding:25px;

box-shadow:0 5px 20px rgba(0,0,0,.08);

margin-bottom:25px;

}

.progress{

height:20px;

border-radius:20px;

}

.progress-bar{

background:#2563eb;

}

img{

border-radius:20px;

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
                Detail Campaign
            </h4>

            <small class="text-muted">
                Informasi lengkap campaign donasi
            </small>

        </div>

        <div>

            <i class="fa-solid fa-circle-user fa-2x text-primary"></i>

            <span class="ms-2 fw-semibold">
                Halo, <?= session()->get('nama') ?? 'User'; ?>
            </span>

        </div>

    </div>

    <!-- Dashboard -->
    <div class="dashboard">

        <div class="card-box">

            <img
                src="https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?w=1200"
                class="img-fluid w-100"
                style="height:350px; object-fit:cover;">

            <h2 class="mt-4 fw-bold">

                Bantu Korban Banjir Bandung

            </h2>

            <p class="text-muted">

                Yayasan Peduli Sesama

            </p>

            <div class="progress mb-3">

                <div
                    class="progress-bar"
                    style="width:45%;">

                    45%

                </div>

            </div>

            <div class="row text-center">

                <div class="col-md-4">

                    <h5 class="text-primary">

                        Rp22.500.000

                    </h5>

                    <small class="text-muted">
                        Dana Terkumpul
                    </small>

                </div>

                <div class="col-md-4">

                    <h5 class="text-success">

                        Rp50.000.000

                    </h5>

                    <small class="text-muted">
                        Target Donasi
                    </small>

                </div>

                <div class="col-md-4">

                    <h5 class="text-danger">

                        20 Hari

                    </h5>

                    <small class="text-muted">
                        Sisa Waktu
                    </small>

                </div>

            </div>

        </div>
        <!-- Deskripsi Campaign -->
<div class="card-box">

    <h4 class="fw-bold mb-3">

        Deskripsi Campaign

    </h4>

    <p class="text-muted" style="line-height:30px;">

        Campaign ini dibuat untuk membantu masyarakat yang terdampak
        banjir di wilayah Bandung. Donasi yang terkumpul akan digunakan
        untuk memenuhi kebutuhan pokok, obat-obatan, selimut, pakaian,
        serta membantu proses pemulihan pasca bencana.

        <br><br>

        Kami mengajak seluruh masyarakat untuk bersama-sama
        berbagi dan membantu saudara kita yang membutuhkan.
        Setiap donasi yang diberikan akan disalurkan secara
        transparan dan dapat dipantau perkembangannya.

    </p>

</div>

<!-- Informasi Yayasan -->
<div class="card-box">

    <h4 class="fw-bold mb-4">

        Informasi Yayasan

    </h4>

    <div class="row">

        <div class="col-md-6">

            <p>

                <strong>Nama Yayasan</strong>

                <br>

                Yayasan Peduli Sesama

            </p>

        </div>

        <div class="col-md-6">

            <p>

                <strong>Email</strong>

                <br>

                yayasan@gmail.com

            </p>

        </div>

        <div class="col-md-6">

            <p>

                <strong>No. HP</strong>

                <br>

                081234567890

            </p>

        </div>

        <div class="col-md-6">

            <p>

                <strong>Alamat</strong>

                <br>

                Jl. Merdeka No. 12 Bandung

            </p>

        </div>

    </div>

</div>

<!-- Aksi -->
<div class="card-box">

    <div class="d-flex justify-content-between align-items-center">

        <a
            href="<?= base_url('campaign') ?>"
            class="btn btn-secondary">

            <i class="fa-solid fa-arrow-left"></i>

            Kembali

        </a>

        <a
            href="<?= base_url('donasi/create') ?>"
            class="btn btn-primary">

            <i class="fa-solid fa-hand-holding-heart"></i>

            Donasi Sekarang

        </a>

    </div>

</div>
<!-- Riwayat Donasi -->
<div class="card-box">

    <h4 class="fw-bold mb-4">
        Riwayat Donasi Terbaru
    </h4>

    <table class="table table-hover align-middle">

        <thead class="table-primary">

            <tr>

                <th>No</th>

                <th>Nama Donatur</th>

                <th>Nominal</th>

                <th>Tanggal</th>

            </tr>

        </thead>

        <tbody>

            <tr>

                <td>1</td>

                <td>Ahmad Fauzi</td>

                <td>Rp500.000</td>

                <td>12 Juni 2025</td>

            </tr>

            <tr>

                <td>2</td>

                <td>Siti Rahma</td>

                <td>Rp250.000</td>

                <td>11 Juni 2025</td>

            </tr>

            <tr>

                <td>3</td>

                <td>Budi Santoso</td>

                <td>Rp1.000.000</td>

                <td>10 Juni 2025</td>

            </tr>

            <tr>

                <td>4</td>

                <td>Dewi Lestari</td>

                <td>Rp150.000</td>

                <td>09 Juni 2025</td>

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