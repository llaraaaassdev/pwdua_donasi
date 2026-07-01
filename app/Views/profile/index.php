<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Profil | Donasi Transparan</title>

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
padding:25px;
color:white;
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
background:rgba(255,255,255,.18);
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
padding:30px;
border-radius:20px;
box-shadow:0 5px 20px rgba(0,0,0,.08);
margin-bottom:25px;
}

.profile-img{

width:130px;
height:130px;

border-radius:50%;

background:#2563eb;

display:flex;

align-items:center;
justify-content:center;

font-size:60px;

color:white;

margin:auto;

}

.form-control{

height:50px;
border-radius:12px;

}

.btn-primary{

background:#2563eb;
border:none;

border-radius:12px;

padding:12px 30px;

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
            <a href="<?= base_url('donasi') ?>">
                <i class="fa-solid fa-hand-holding-heart me-2"></i>
                Donasi
            </a>
        </li>

        <li>
            <a href="<?= base_url('profile') ?>" class="active">
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
                Profil Saya
            </h4>

            <small class="text-muted">
                Kelola informasi akun Anda
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

            <div class="text-center mb-4">

                <div class="profile-img">

                    <i class="fa-solid fa-user"></i>

                </div>

                <h3 class="fw-bold mt-3">
                    <?= session()->get('nama') ?? 'Nama Pengguna'; ?>
                </h3>

                <span class="badge bg-primary">
                    <?= ucfirst(session()->get('role') ?? 'Donatur'); ?>
                </span>

            </div>

            <form>

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Nama Lengkap
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            value="<?= session()->get('nama') ?? ''; ?>">

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Email
                        </label>

                        <input
                            type="email"
                            class="form-control"
                            value="user@gmail.com">

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Nomor HP
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            value="081234567890">

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Role
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            value="<?= ucfirst(session()->get('role') ?? 'Donatur'); ?>"
                            readonly>

                    </div>

                    <div class="col-12 mb-3">

                        <label class="form-label">
                            Alamat
                        </label>

                        <textarea
                            class="form-control"
                            rows="4">Bandung, Jawa Barat</textarea>

                    </div>

                </div>
                                    <div class="col-12 mt-4">

                        <div class="d-flex justify-content-between">

                            <a href="<?= base_url('dashboard') ?>"
                                class="btn btn-secondary">

                                <i class="fa-solid fa-arrow-left"></i>

                                Kembali

                            </a>

                            <div>

                                <button
                                    type="button"
                                    class="btn btn-warning me-2">

                                    <i class="fa-solid fa-key"></i>

                                    Ubah Password

                                </button>

                                <button
                                    type="submit"
                                    class="btn btn-primary">

                                    <i class="fa-solid fa-floppy-disk"></i>

                                    Simpan Perubahan

                                </button>

                            </div>

                        </div>

                    </div>

                </div>

            </form>

        </div>

        <!-- Informasi Akun -->
        <div class="card-box">

            <h4 class="fw-bold mb-4">

                Informasi Akun

            </h4>

            <div class="row">

                <div class="col-md-4 text-center">

                    <i class="fa-solid fa-user-check fa-3x text-primary mb-3"></i>

                    <h5>Status Akun</h5>

                    <span class="badge bg-success">

                        Aktif

                    </span>

                </div>

                <div class="col-md-4 text-center">

                    <i class="fa-solid fa-calendar-days fa-3x text-success mb-3"></i>

                    <h5>Bergabung</h5>

                    <p>01 Juli 2025</p>

                </div>

                <div class="col-md-4 text-center">

                    <i class="fa-solid fa-hand-holding-heart fa-3x text-danger mb-3"></i>

                    <h5>Total Donasi</h5>

                    <p>3 Transaksi</p>

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
<!-- End Content -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>