<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Laporan Donasi | Donasi Transparan</title>

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
margin-bottom:25px;
}

.table thead{
background:#16a34a;
color:white;
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

<li><a href="<?= base_url('yayasan/reports') ?>" class="active">
<i class="fa-solid fa-chart-column me-2"></i>Laporan
</a></li>

<li><a href="<?= base_url('yayasan/status') ?>">
<i class="fa-solid fa-circle-check me-2"></i>Status Verifikasi
</a></li>

<li><a href="<?= base_url('yayasan/profile') ?>">
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

Laporan Donasi

</h4>

<small class="text-muted">

Laporan seluruh donasi campaign.

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

<div class="row mb-4">

<div class="col-md-5">

<input
type="text"
class="form-control"
placeholder="Cari campaign...">

</div>

<div class="col-md-3">

<input
type="date"
class="form-control">

</div>

<div class="col-md-2">

<button class="btn btn-success w-100">

Filter

</button>

</div>

<div class="col-md-2">

<a href="<?= base_url('yayasan/report/create') ?>" class="btn btn-success w-100">

Buat Laporan

</a>

</div>

</div>
<div class="table-responsive">

<table class="table table-bordered table-hover align-middle">

<thead>

<tr>

<th>No</th>

<th>Campaign</th>

<th>Total Donasi</th>

<th>Donatur</th>

<th>Tanggal</th>

<th>Aksi</th>

</tr>

</thead>

<tbody>

<tr>

<td colspan="6" class="text-center py-5">

<i class="fa-solid fa-file-lines fa-3x text-success mb-3"></i>

<h5>

Belum Ada Laporan

</h5>

<p class="text-muted">

Laporan donasi akan ditampilkan setelah data tersedia.

</p>

</td>

</tr>

</tbody>

</table>

</div>

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