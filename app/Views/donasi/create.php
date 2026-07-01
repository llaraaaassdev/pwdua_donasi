<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Donasi | Donasi Transparan</title>

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

padding:30px;

border-radius:20px;

box-shadow:0 5px 20px rgba(0,0,0,.08);

}

.form-control,
.form-select{

height:50px;

border-radius:12px;

}

textarea.form-control{

height:120px;

}

.btn-primary{

background:#2563eb;
border:none;

border-radius:12px;

padding:12px 30px;

}

.btn-secondary{

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
            <a href="<?= base_url('donasi') ?>" class="active">
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
                Form Donasi
            </h4>

            <small class="text-muted">
                Lengkapi data donasi Anda
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

            <h3 class="fw-bold mb-3">
                Bantu Korban Banjir Bandung
            </h3>

            <p class="text-muted">
                Campaign ini bertujuan membantu masyarakat yang terdampak
                banjir melalui penyaluran kebutuhan pokok, obat-obatan,
                dan bantuan lainnya.
            </p>

            <hr>

            <form>

                <div class="mb-3">

                    <label class="form-label">
                        Nama Donatur
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        placeholder="Masukkan nama lengkap">

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Email
                    </label>

                    <input
                        type="email"
                        class="form-control"
                        placeholder="Masukkan email">

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Nominal Donasi
                    </label>

                    <input
                        type="number"
                        class="form-control"
                        placeholder="Contoh: 100000">

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Metode Pembayaran
                    </label>

                    <select class="form-select">

                        <option>Transfer Bank</option>
                        <option>QRIS</option>
                        <option>E-Wallet</option>

                    </select>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Pesan / Doa
                    </label>

                    <textarea
                        class="form-control"
                        placeholder="Tulis doa atau pesan..."></textarea>

                </div>

                <div class="mb-4">

                    <label class="form-label">
                        Upload Bukti Transfer
                    </label>

                    <input
                        type="file"
                        class="form-control">

                </div>
                                <hr>

                <div class="row mb-4">

                    <div class="col-md-6">

                        <div class="card border-0 bg-light p-3">

                            <h5 class="fw-bold mb-3">
                                Ringkasan Donasi
                            </h5>

                            <p class="mb-2">
                                <strong>Campaign :</strong><br>
                                Bantu Korban Banjir Bandung
                            </p>

                            <p class="mb-2">
                                <strong>Target :</strong><br>
                                Rp50.000.000
                            </p>

                            <p class="mb-2">
                                <strong>Terkumpul :</strong><br>
                                Rp22.500.000
                            </p>

                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="card border-0 bg-light p-3">

                            <h5 class="fw-bold mb-3">
                                Informasi Pembayaran
                            </h5>

                            <p class="mb-2">
                                <strong>Bank BCA</strong><br>
                                1234567890
                            </p>

                            <p class="mb-2">
                                <strong>a.n.</strong><br>
                                Yayasan Peduli Sesama
                            </p>

                            <small class="text-muted">
                                Silakan transfer sesuai nominal donasi,
                                kemudian upload bukti transfer.
                            </small>

                        </div>

                    </div>

                </div>

                <div class="d-flex justify-content-between">

                    <a href="<?= base_url('campaign/detail') ?>"
                        class="btn btn-secondary">

                        <i class="fa-solid fa-arrow-left"></i>

                        Kembali

                    </a>

                    <button
                        type="submit"
                        class="btn btn-primary">

                        <i class="fa-solid fa-paper-plane"></i>

                        Kirim Donasi

                    </button>

                </div>

            </form>

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