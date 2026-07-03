<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title><?= $title ?? 'Dashboard Admin' ?> | Donasi Transparan</title>

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


/* SIDEBAR */

.sidebar{
    position:fixed;
    left:0;
    top:0;

    width:250px;
    height:100vh;

    background:linear-gradient(180deg,#16a34a,#15803d);

    color:white;

    padding:25px;

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

    color:white;

    text-decoration:none;

    padding:13px 18px;

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


/* CONTENT */


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



.card-stat{

    background:white;

    border:none;

    border-left:5px solid #16a34a;

    border-radius:20px;

    padding:25px;


    box-shadow:0 5px 20px rgba(0,0,0,.08);

}



.content-card,

.card{

    background:white;

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

    color:white;

    font-size:24px;

}



.green{background:#16a34a;}
.blue{background:#2563eb;}
.orange{background:#f59e0b;}
.red{background:#ef4444;}


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

<a href="<?= base_url('admin/campaign') ?>">

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




<!-- CONTENT -->


<div class="content">


<!-- NAVBAR -->


<div class="navbar-custom">


<div>


<h4 class="fw-bold mb-0">

Dashboard Admin

</h4>


<small class="text-muted">

Selamat datang di Sistem Donasi Transparan

</small>


</div>




<div class="d-flex align-items-center">


<i class="fa-solid fa-circle-user fa-2x text-success"></i>


<div class="ms-3">


<div class="fw-bold">

<?= esc(session()->get('nama') ?? 'Administrator'); ?>

</div>


<small class="text-muted">

Administrator

</small>


</div>


</div>


</div>




<!-- ISI HALAMAN -->


<div class="dashboard">


<?= $this->renderSection('content') ?>


</div>



</div>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>