<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Laporan | Donasi Transparan</title>

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

.table thead{
background:#16a34a;
color:white;
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

<li><a href="<?= base_url('admin/dashboard') ?>"><i class="fa-solid fa-house me-2"></i>Dashboard</a></li>

<li><a href="<?= base_url('admin/users') ?>"><i class="fa-solid fa-users me-2"></i>Kelola User</a></li>

<li><a href="<?= base_url('admin/yayasan') ?>"><i class="fa-solid fa-building me-2"></i>Kelola Yayasan</a></li>

<li><a href="<?= base_url('admin/campaigns') ?>"><i class="fa-solid fa-bullhorn me-2"></i>Kelola Campaign</a></li>

<li><a href="<?= base_url('admin/donations') ?>"><i class="fa-solid fa-hand-holding-heart me-2"></i>Kelola Donasi</a></li>

<li><a href="<?= base_url('admin/reports') ?>" class="active"><i class="fa-solid fa-chart-column me-2"></i>Laporan</a></li>

<li><a href="<?= base_url('profile') ?>"><i class="fa-solid fa-user me-2"></i>Profil</a></li>

<li><a href="<?= base_url('logout') ?>"><i class="fa-solid fa-right-from-bracket me-2"></i>Logout</a></li>

</ul>

</div>

<div class="content">

<div class="navbar-custom">

<div>

<h4 class="fw-bold mb-0">

Laporan

</h4>

<small class="text-muted">

Laporan data donasi dan campaign

</small>

</div>

<div>

<i class="fa-solid fa-circle-user fa-2x text-success"></i>

<span class="ms-2 fw-semibold">

<?= esc(session()->get('nama') ?? 'Administrator'); ?>

</span>

</div>

</div>

<div class="dashboard">

<div class="card-box">

<div class="row">

<div class="col-md-4">

<label class="form-label">

Tanggal Awal

</label>

<input type="date" class="form-control">

</div>

<div class="col-md-4">

<label class="form-label">

Tanggal Akhir

</label>

<input type="date" class="form-control">

</div>

<div class="col-md-4 d-flex align-items-end">

<button class="btn btn-success w-100">

Tampilkan Laporan

</button>

</div>

</div>

</div>
<div class="card-box">

<h4 class="fw-bold mb-4">

Hasil Laporan

</h4>

<div class="table-responsive">

<table class="table table-bordered table-hover">

<thead>

<tr>

<th>No</th>

<th>Tanggal</th>

<th>Campaign</th>

<th>Donatur</th>

<th>Nominal</th>

<th>Status</th>

</tr>

</thead>

<tbody>

<tr>

<td colspan="6" class="text-center py-5">

<i class="fa-solid fa-file-lines fa-3x text-success mb-3"></i>

<h5>

Belum Ada Laporan

</h5>

<p class="text-muted mb-0">

Laporan akan ditampilkan setelah sistem terhubung dengan database.

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