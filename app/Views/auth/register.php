<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Donasi Transparan</title>

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
            min-height:100vh;
            background:
            linear-gradient(rgba(255,255,255,0.7),
            rgba(255,255,255,0.7)),
            url('https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?q=80&w=1470&auto=format&fit=crop');
            background-size:cover;
            background-position:center;
            display:flex;
            align-items:center;
            justify-content:center;
            padding:20px;
        }

        .container-register{
            width:100%;
            max-width:1200px;
            display:grid;
            grid-template-columns:1fr 1fr;
            background:rgba(255,255,255,0.15);
            backdrop-filter:blur(15px);
            border-radius:30px;
            overflow:hidden;
            box-shadow:0 10px 40px rgba(0,0,0,0.1);
        }

        .left-side{
            padding:60px;
            background:rgba(255,255,255,0.5);
        }

        .logo{
            font-size:42px;
            color:#2563eb;
            margin-bottom:20px;
        }

        .title{
            font-size:40px;
            font-weight:700;
            color:#1e293b;
            line-height:1.2;
        }

        .title span{
            color:#2563eb;
        }

        .desc{
            margin-top:20px;
            color:#475569;
            line-height:1.8;
        }

        .feature{
            display:flex;
            gap:15px;
            margin-top:30px;
            align-items:flex-start;
        }

        .feature-icon{
            width:60px;
            height:60px;
            background:white;
            border-radius:20px;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:24px;
            color:#2563eb;
            box-shadow:0 5px 20px rgba(0,0,0,0.08);
        }

        .feature h5{
            margin-bottom:5px;
            font-weight:700;
        }

        .right-side{
            display:flex;
            align-items:center;
            justify-content:center;
            padding:40px;
        }

        .register-card{
            width:100%;
            max-width:450px;
            background:rgba(255,255,255,0.4);
            backdrop-filter:blur(15px);
            padding:45px;
            border-radius:30px;
            box-shadow:0 10px 30px rgba(0,0,0,0.1);
        }

        .register-icon{
            width:90px;
            height:90px;
            background:white;
            border-radius:50%;
            display:flex;
            align-items:center;
            justify-content:center;
            margin:auto;
            font-size:40px;
            color:#2563eb;
            margin-bottom:25px;
        }

        .register-title{
            text-align:center;
            font-weight:700;
            color:#1e293b;
            margin-bottom:10px;
        }

        .register-sub{
            text-align:center;
            color:#64748b;
            margin-bottom:35px;
        }

        .form-control{
            height:55px;
            border-radius:15px;
            border:none;
            background:rgba(255,255,255,0.8);
        }

        .btn-register{
            height:55px;
            border:none;
            border-radius:15px;
            background:linear-gradient(to right,#2563eb,#4f46e5);
            color:white;
            font-weight:600;
            transition:0.3s;
        }

        .btn-register:hover{
            transform:translateY(-2px);
            opacity:0.9;
        }

        .bottom-text{
            text-align:center;
            margin-top:25px;
            color:#64748b;
        }

        .bottom-text a{
            text-decoration:none;
            font-weight:600;
            color:#2563eb;
        }

        @media(max-width:992px){

            .container-register{
                grid-template-columns:1fr;
            }

            .left-side{
                display:none;
            }

        }

    </style>
</head>
<body>

<div class="container-register">

    <div class="left-side">

        <div class="logo">
            <i class="fa-solid fa-hand-holding-heart"></i>
        </div>

        <div class="title">
            Bergabung Dengan <br>
            <span>Donasi Transparan</span>
        </div>

        <div class="desc">
            Daftarkan akun Anda untuk ikut membangun sistem donasi
            yang aman, transparan, dan terpercaya.
        </div>

        <div class="feature">
            <div class="feature-icon">
                <i class="fa-solid fa-shield-heart"></i>
            </div>

            <div>
                <h5>Transparan</h5>
                <p>Semua transaksi dapat diaudit publik.</p>
            </div>
        </div>

        <div class="feature">
            <div class="feature-icon">
                <i class="fa-solid fa-lock"></i>
            </div>

            <div>
                <h5>Aman</h5>
                <p>Data terenkripsi dengan SHA-256.</p>
            </div>
        </div>

        <div class="feature">
            <div class="feature-icon">
                <i class="fa-solid fa-circle-check"></i>
            </div>

            <div>
                <h5>Terverifikasi</h5>
                <p>Data terjamin keasliannya.</p>
            </div>
        </div>

    </div>

    <div class="right-side">

        <div class="register-card">

            <div class="register-icon">
                <i class="fa-solid fa-user-plus"></i>
            </div>

            <h2 class="register-title">Buat Akun</h2>

            <p class="register-sub">
                Silakan daftar untuk melanjutkan
            </p>
<?php if(session()->getFlashdata('errors')) : ?>

<div class="alert alert-danger">

<ul class="mb-0">

<?php foreach(session()->getFlashdata('errors') as $error): ?>

<li><?= esc($error) ?></li>

<?php endforeach; ?>

</ul>

</div>

<?php endif; ?>
            <form action="<?= base_url('register') ?>" method="post">

                <?= csrf_field() ?>

                <div class="mb-3">
                    <label>Nama</label>
                    <input
                        type="text"
                        name="nama"
                        class="form-control"
                        required>
                </div>

                <div class="mb-3">
                    <label>Email</label>
                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        required>
                </div>

                <div class="mb-4">
                    <label>Password</label>
                    <input
                        type="password"
                        name="password"
                        class="form-control"
                        required>
                </div>

                <button class="btn btn-register w-100">
                    Daftar Sekarang
                </button>

            </form>

            <div class="bottom-text">
                Sudah punya akun?
                <a href="<?= base_url('/') ?>">Login</a>
            </div>

        </div>

    </div>

</div>

</body>
</html>