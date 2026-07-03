<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Dashboard Yayasan | Donasi Transparan</title>

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


.card,
.card-box{
background:white;
border:none;
border-radius:20px;
padding:30px;
box-shadow:0 5px 20px rgba(0,0,0,.08);
}


.card-stat{
background:white;
border:none;
border-radius:20px;
padding:25px;
box-shadow:0 5px 20px rgba(0,0,0,.08);
}


.icon-box{
width:60px;
height:60px;
display:flex;
justify-content:center;
align-items:center;
border-radius:15px;
font-size:24px;
color:white;
}


.green{background:#16a34a;}
.blue{background:#2563eb;}
.orange{background:#f59e0b;}
.red{background:#ef4444;}


.btn-success{
background:#16a34a;
border:none;
}


.table thead th{
background:#16a34a;
color:white;
}

</style>

</head>


<body>


<!-- SIDEBAR -->

<div class="sidebar">


<div class="logo">

<i class="fa-solid fa-hand-holding-heart"></i>

Donasi Transparan

</div>



<ul class="menu">


<li>
<a href="<?= base_url('yayasan/dashboard') ?>">
<i class="fa-solid fa-house me-2"></i>
Dashboard
</a>
</li>


<li>
<a href="<?= base_url('yayasan/campaign/index') ?>">
<i class="fa-solid fa-bullhorn me-2"></i>
Campaign Saya
</a>
</li>


<li>
<a href="<?= base_url('yayasan/campaign/create') ?>">
<i class="fa-solid fa-circle-plus me-2"></i>
Buat Campaign
</a>
</li>


<li>
<a href="<?= base_url('yayasan/reports') ?>">
<i class="fa-solid fa-chart-column me-2"></i>
Laporan
</a>
</li>


<li>
<a href="<?= base_url('yayasan/status') ?>">
<i class="fa-solid fa-circle-check me-2"></i>
Status Verifikasi
</a>
</li>


<li>
<a href="<?= base_url('yayasan/profile') ?>">
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



<!-- CONTENT -->


<div class="content">


<div class="navbar-custom">


<div>


<h4 class="fw-bold mb-0">

Dashboard Yayasan

</h4>


<small class="text-muted">

Kelola campaign dan pantau perkembangan donasi.

</small>


</div>



<div class="d-flex align-items-center">


<i class="fa-solid fa-circle-user fa-2x text-success"></i>


<span class="ms-2 fw-semibold">

<?= esc(session()->get('nama') ?? 'Yayasan') ?>

</span>


</div>


</div>



<div class="dashboard">


<?= $this->renderSection('content') ?>


</div>


</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>