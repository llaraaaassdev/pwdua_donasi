<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Profil Donatur | Donasi Transparan</title>

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
}

.logo{
font-size:26px;
font-weight:bold;
margin-bottom:40px;
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

.card-box{
background:white;
padding:30px;
border-radius:20px;
box-shadow:0 5px 20px rgba(0,0,0,.08);
margin-bottom:25px;
}

.form-control{
border-radius:12px;
height:48px;
}

textarea.form-control{
height:120px;
}

.btn-success{
background:#16a34a;
border:none;
}

</style>

</head>
<body>

<div class="sidebar">

<div class="logo">

<i class="fa-solid fa-hand-holding-heart me-2"></i>

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

<a href="<?= base_url('donatur/campaign') ?>">

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

<a href="<?= base_url('donatur/profile') ?>" class="active">

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

<div class="content">

<div class="navbar-custom">

<div>

<h4 class="fw-bold mb-0">

Profil Donatur

</h4>

<small class="text-muted">

Kelola informasi akun Anda.

</small>

</div>

<div>

<i class="fa-solid fa-circle-user fa-2x text-success"></i>

<span class="ms-2 fw-semibold">

<?= esc(session()->get('nama') ?? 'Donatur'); ?>

</span>

</div>

</div>

<div class="dashboard">

<div class="card-box">

<h4 class="fw-bold mb-4">

Informasi Profil

</h4>

<form>
    <div class="mb-3">

<label class="form-label">

Nama Lengkap

</label>

<input
type="text"
class="form-control"
placeholder="Nama Lengkap">

</div>

<div class="mb-3">

<label class="form-label">

Email

</label>

<input
type="email"
class="form-control"
placeholder="Email">

</div>

<div class="mb-3">

<label class="form-label">

Nomor Telepon

</label>

<input
type="text"
class="form-control"
placeholder="Nomor Telepon">

</div>

<div class="mb-3">

<label class="form-label">

Alamat

</label>

<textarea
class="form-control"
placeholder="Alamat"></textarea>

</div>

<div class="mb-3">

<label class="form-label">

Foto Profil

</label>

<input
type="file"
class="form-control">

</div>

<div class="d-flex justify-content-end">

<button class="btn btn-success">

Simpan Perubahan

</button>

</div>

</form>

</div>
<div class="text-center mt-5 text-muted">

<hr>

<p>

© <?= date('Y'); ?> Donasi Transparan |
Sistem Informasi Donasi Berbasis Web

</p>

</div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>