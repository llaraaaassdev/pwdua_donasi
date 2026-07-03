<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Kelola Campaign | Donasi Transparan</title>

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

<li>
<a href="<?= base_url('admin/dashboard') ?>">
<i class="fa-solid fa-house me-2"></i>
Dashboard
</a>
</li>

<li>
<a href="<?= base_url('admin/users') ?>">
<i class="fa-solid fa-users me-2"></i>
Kelola User
</a>
</li>

<li>
<a href="<?= base_url('admin/yayasan') ?>">
<i class="fa-solid fa-building me-2"></i>
Kelola Yayasan
</a>
</li>

<li>
<a href="<?= base_url('admin/campaigns') ?>" class="active">
<i class="fa-solid fa-bullhorn me-2"></i>
Kelola Campaign
</a>
</li>

<li>
<a href="<?= base_url('admin/donations') ?>">
<i class="fa-solid fa-hand-holding-heart me-2"></i>
Kelola Donasi
</a>
</li>

<li>
<a href="<?= base_url('admin/reports') ?>">
<i class="fa-solid fa-chart-column me-2"></i>
Laporan
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

<div class="content">

<div class="navbar-custom">

<div>

<h4 class="fw-bold mb-0">

Kelola Campaign

</h4>

<small class="text-muted">

Data seluruh campaign donasi

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

<div class="d-flex justify-content-between align-items-center mb-4">

<h4 class="fw-bold">

Daftar Campaign

</h4>

<button class="btn btn-success">

<i class="fa-solid fa-plus"></i>

Tambah Campaign

</button>

</div>

<div class="row mb-4">

<div class="col-md-6">

<input
type="text"
class="form-control"
placeholder="Cari campaign...">

</div>

<div class="col-md-3">

<select class="form-select">

<option>Semua Status</option>

<option>Aktif</option>

<option>Selesai</option>

<option>Nonaktif</option>

</select>

</div>

<div class="col-md-3">

<button class="btn btn-success w-100">

Filter

</button>

</div>

</div>
<div class="table-responsive">

<table class="table table-bordered table-hover align-middle">

<thead>

<tr>

<th width="60">No</th>

<th>Judul Campaign</th>

<th>Yayasan</th>

<th>Target</th>

<th>Status</th>

<th width="180">Aksi</th>

</tr>

</thead>

<tbody>

<tr>

<td colspan="6" class="text-center py-5">

<i class="fa-solid fa-bullhorn fa-3x text-success mb-3"></i>

<h5 class="mt-3">

Belum Ada Campaign

</h5>

<p class="text-muted mb-0">

Data campaign akan ditampilkan setelah sistem terhubung dengan database.

</p>

</td>

</tr>

</tbody>

</table>

</div>

</div>

<div class="mt-5 text-center text-muted">

<hr>

<p class="mb-0">

© <?= date('Y'); ?> Donasi Transparan |
Sistem Informasi Donasi Berbasis Web

</p>

</div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>