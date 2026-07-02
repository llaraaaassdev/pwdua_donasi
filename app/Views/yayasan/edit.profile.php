<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Edit Profil Yayasan | Donasi Transparan</title>

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
}

.form-control,
textarea{
border-radius:12px;
}

textarea{
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

<i class="fa-solid fa-hand-holding-heart"></i>

Donasi Transparan

</div>

<ul class="menu">

<li><a href="<?= base_url('yayasan/dashboard') ?>">
<i class="fa-solid fa-house me-2"></i>Dashboard
</a></li>

<li><a href="<?= base_url('yayasan/campaign') ?>">
<i class="fa-solid fa-bullhorn me-2"></i>Campaign Saya
</a></li>

<li><a href="<?= base_url('yayasan/campaign/create') ?>">
<i class="fa-solid fa-circle-plus me-2"></i>Buat Campaign
</a></li>

<li><a href="<?= base_url('yayasan/reports') ?>">
<i class="fa-solid fa-chart-column me-2"></i>Laporan
</a></li>

<li><a href="<?= base_url('yayasan/status') ?>">
<i class="fa-solid fa-circle-check me-2"></i>Status Verifikasi
</a></li>

<li><a href="<?= base_url('yayasan/profile') ?>" class="active">
<i class="fa-solid fa-user me-2"></i>Profil
</a></li>

<li><a href="<?= base_url('logout') ?>">
<i class="fa-solid fa-right-from-bracket me-2"></i>Logout
</a></li>

</ul>

</div>

<div class="content">

<div class="navbar-custom">

<div>

<h4 class="fw-bold mb-0">

Edit Profil Yayasan

</h4>

<small class="text-muted">

Perbarui informasi yayasan

</small>

</div>

<div>

<i class="fa-solid fa-circle-user fa-2x text-success"></i>

<span class="ms-2 fw-semibold">

<?= esc(session()->get('nama') ?? 'Yayasan'); ?>

</span>

</div>

</div>

<div class="dashboard">

<div class="card-box">

<h4 class="fw-bold mb-4">

Form Profil Yayasan

</h4>

<form>
    <div class="mb-3">

<label class="form-label">

Nama Yayasan

</label>

<input
type="text"
class="form-control"
placeholder="Nama Yayasan">

</div>

<div class="mb-3">

<label class="form-label">

Nama Penanggung Jawab

</label>

<input
type="text"
class="form-control"
placeholder="Nama Penanggung Jawab">

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
placeholder="Alamat Yayasan"></textarea>

</div>

<div class="mb-3">

<label class="form-label">

Logo Yayasan

</label>

<input
type="file"
class="form-control">

</div>

<div class="d-flex justify-content-end">

<a href="<?= base_url('yayasan/dashboard') ?>" class="btn btn-secondary me-2">

Batal

</a>

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