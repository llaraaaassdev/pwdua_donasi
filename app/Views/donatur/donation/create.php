<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Pembayaran Donasi | Donasi Transparan</title>

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

.btn-success{
background:#16a34a;
border:none;
}

.form-control,
.form-select{
height:50px;
border-radius:12px;
}

textarea.form-control{
height:120px;
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

<li><a href="<?= base_url('donatur/dashboard') ?>">
<i class="fa-solid fa-house me-2"></i>Dashboard
</a></li>

<li><a href="<?= base_url('donatur/campaign') ?>" class="active">
<i class="fa-solid fa-bullhorn me-2"></i>Campaign
</a></li>

<li><a href="<?= base_url('donatur/history') ?>">
<i class="fa-solid fa-clock-rotate-left me-2"></i>Riwayat Donasi
</a></li>

<li><a href="<?= base_url('donatur/profile') ?>">
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

Pembayaran Donasi

</h4>

<small class="text-muted">

Lengkapi data donasi Anda.

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

Form Donasi<?= esc($campaign['judul']) ?>

</h4>

<form
method="post"

action="<?= base_url('donatur/donation/store') ?>"

enctype="multipart/form-data">

<div class="mb-3">
<input

type="hidden"

name="campaign_id"

value="<?= $campaign['id'] ?>">

<div class="mb-3">

<label class="form-label">

Nominal Donasi

</label>

<input
type="number"
name="nominal"
class="form-control"
placeholder="Masukkan nominal">

</div>

<div class="mb-3">

<label class="form-label">

Metode Pembayaran

</label>

<select class="form-select" name="metode_pembayaran">

<option>Pilih Metode</option>

<option>Transfer Bank</option>

<option>E-Wallet</option>

<option>QRIS</option>

</select>

</div>
<div class="mb-3">

<label>Bukti Pembayaran</label>

<input
type="file"
name="bukti_pembayaran"
class="form-control"
accept="image/*,.pdf">

<small class="text-muted">

Format JPG, PNG atau PDF.

</small>

</div>
<div class="mb-4">

<label class="form-label">

Pesan / Doa

</label>

<textarea name="pesan"
class="form-control"
placeholder="Tulis pesan..."></textarea>

</div>
<div class="form-check mb-3">

<input

type="checkbox"

name="anonim"

value="1"

class="form-check-input">

<label class="form-check-label">

Sembunyikan Nama Saya

</label>

</div>

<div class="d-flex justify-content-end">

<a href="<?= base_url('donatur/campaign/index') ?>" class="btn btn-secondary me-2">

Kembali

</a>

<button type="submit" class="btn btn-success">

Lanjut Pembayaran

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