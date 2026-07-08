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
            linear-gradient(rgba(255,255,255,0.7), rgba(255,255,255,0.7)),
            url('https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?q=80&w=1470&auto=format&fit=crop');
            background-size:cover;
            background-position:center;
            display:flex;
            flex-direction:column;
            align-items:center;
            justify-content:flex-start;
            padding:28px 20px;
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
            animation:fadeUp .7s ease;
        }

        .left-side{
            position:relative;
            padding:60px;
            background:rgba(255,255,255,0.5);
            overflow:hidden;
        }

        .left-side::before{
            content:"";
            position:absolute;
            width:320px;
            height:320px;
            border-radius:50%;
            background:linear-gradient(135deg,rgba(37,99,235,.18),rgba(22,163,74,.22));
            right:-120px;
            top:90px;
            animation:floatBlob 5s ease-in-out infinite;
        }

        .logo{
            position:relative;
            font-size:42px;
            color:#2563eb;
            margin-bottom:20px;
        }

        .title{
            position:relative;
            font-size:40px;
            font-weight:700;
            color:#1e293b;
            line-height:1.2;
        }

        .title span{
            color:#2563eb;
        }

        .desc{
            position:relative;
            margin-top:20px;
            color:#475569;
            line-height:1.8;
        }

        .feature{
            position:relative;
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

        .feature p{
            color:#475569;
            margin-bottom:0;
        }

        .right-side{
            display:flex;
            align-items:center;
            justify-content:center;
            padding:40px;
        }

        .register-card{
            width:100%;
            max-width:470px;
            background:rgba(255,255,255,0.4);
            backdrop-filter:blur(15px);
            padding:42px;
            border-radius:30px;
            box-shadow:0 10px 30px rgba(0,0,0,0.1);
            animation:softPop .7s ease;
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
            margin-bottom:25px;
        }

        .role-options{
            display:grid;
            grid-template-columns:1fr 1fr;
            gap:12px;
            margin-bottom:25px;
        }

        .role-card{
            min-height:96px;
            border-radius:18px;
            background:rgba(255,255,255,0.72);
            color:#334155;
            text-decoration:none;
            display:flex;
            flex-direction:column;
            align-items:center;
            justify-content:center;
            gap:8px;
            transition:.3s;
            border:2px solid transparent;
        }

        .role-card i{
            font-size:25px;
            color:#2563eb;
        }

        .role-card span{
            font-weight:700;
            font-size:14px;
        }

        .role-card.active{
            background:linear-gradient(to right,#2563eb,#4f46e5);
            color:white;
            box-shadow:0 10px 24px rgba(37,99,235,.22);
        }

        .role-card.active i{
            color:white;
        }

        .role-card:hover{
            transform:translateY(-3px);
            border-color:rgba(37,99,235,.3);
        }

        label{
            font-weight:600;
            color:#334155;
            margin-bottom:7px;
        }

        .form-control{
            height:55px;
            border-radius:15px;
            border:none;
            background:rgba(255,255,255,0.8);
        }

        .form-control:focus{
            box-shadow:0 0 0 .2rem rgba(37,99,235,.16);
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
            color:white;
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

        .alert{
            border:none;
            border-radius:15px;
        }

        @keyframes fadeUp{
            from{
                opacity:0;
                transform:translateY(22px);
            }
            to{
                opacity:1;
                transform:translateY(0);
            }
        }

        @keyframes softPop{
            from{
                opacity:0;
                transform:scale(.96);
            }
            to{
                opacity:1;
                transform:scale(1);
            }
        }

        @keyframes floatBlob{
            0%,100%{
                transform:translateY(0);
            }
            50%{
                transform:translateY(24px);
            }
        }



        :root{
            --donasiku-primary:#3157f6;
            --donasiku-secondary:#5b3df5;
            --donasiku-navy:#1d2b44;
            --donasiku-soft:#f6f8ff;
        }

        html, body, button, a, input, textarea, select{
            cursor:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='34' height='34' viewBox='0 0 64 64'%3E%3Crect width='64' height='64' rx='18' fill='%233157f6'/%3E%3Cpath d='M32 47s-17-9.6-17-22.2C15 17.7 20.7 14 25.8 14c3 0 5.2 1.5 6.2 3.2C33 15.5 35.2 14 38.2 14 43.3 14 49 17.7 49 24.8 49 37.4 32 47 32 47z' fill='white'/%3E%3Cpath d='M20 51h24' stroke='white' stroke-width='5' stroke-linecap='round'/%3E%3C/svg%3E") 5 5, auto;
        }

        .auth-topbar{
            width:100%;
            max-width:1200px;
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:16px;
            padding:14px 18px;
            margin-bottom:20px;
            border-radius:24px;
            background:rgba(255,255,255,.78);
            border:1px solid rgba(255,255,255,.78);
            box-shadow:0 14px 35px rgba(15,23,42,.10);
            backdrop-filter:blur(14px);
        }

        .auth-brand-home{
            display:inline-flex;
            align-items:center;
            gap:12px;
            text-decoration:none;
            color:var(--donasiku-navy);
            min-width:0;
        }

        .auth-brand-home .brand-icon{
            width:46px;
            height:46px;
            flex:0 0 46px;
            display:flex;
            align-items:center;
            justify-content:center;
            border-radius:16px;
            color:white;
            background:linear-gradient(135deg,var(--donasiku-primary),var(--donasiku-secondary));
            box-shadow:0 10px 24px rgba(49,87,246,.24);
            font-size:22px;
        }

        .auth-brand-home strong{
            display:block;
            font-size:20px;
            font-weight:900;
            line-height:1.1;
        }

        .auth-brand-home small{
            display:block;
            color:#64748b;
            font-weight:700;
            margin-top:3px;
        }

        .auth-top-actions{
            display:flex;
            align-items:center;
            gap:10px;
        }

        .auth-link-home,
        .auth-link-secondary{
            display:inline-flex;
            align-items:center;
            gap:9px;
            padding:11px 16px;
            border-radius:999px;
            text-decoration:none;
            font-weight:900;
            transition:.25s ease;
            white-space:nowrap;
        }

        .auth-link-home{
            background:linear-gradient(135deg,var(--donasiku-primary),var(--donasiku-secondary));
            color:white;
            box-shadow:0 12px 28px rgba(49,87,246,.22);
        }

        .auth-link-secondary{
            background:white;
            color:var(--donasiku-primary);
            border:1px solid rgba(49,87,246,.16);
        }

        .auth-link-home:hover,
        .auth-link-secondary:hover{
            transform:translateY(-2px);
            color:white;
            background:linear-gradient(135deg,var(--donasiku-primary),var(--donasiku-secondary));
        }

        .auth-home-inline{
            margin-top:14px;
            text-align:center;
        }

        .auth-home-inline a{
            display:inline-flex;
            align-items:center;
            gap:8px;
            padding:10px 14px;
            border-radius:999px;
            background:rgba(49,87,246,.10);
            color:var(--donasiku-primary);
            text-decoration:none;
            font-weight:800;
        }

        .auth-home-inline a:hover{
            background:linear-gradient(135deg,var(--donasiku-primary),var(--donasiku-secondary));
            color:white;
        }

        @media(max-width:992px){

            .auth-topbar{
                padding:12px;
                border-radius:20px;
                margin-bottom:14px;
            }

            .auth-brand-home .brand-icon{
                width:40px;
                height:40px;
                flex-basis:40px;
                border-radius:14px;
            }

            .auth-brand-home strong{
                font-size:17px;
            }

            .auth-brand-home small{
                font-size:12px;
            }

            .auth-top-actions{
                gap:8px;
            }

            .auth-link-home,
            .auth-link-secondary{
                padding:10px 12px;
                font-size:13px;
            }
            .container-register{
                grid-template-columns:1fr;
            }

            .left-side{
                display:none;
            }

            .right-side{
                padding:24px;
            }

            .register-card{
                padding:30px 24px;
            }
        }

        @media(max-width:576px){
            .auth-topbar{
                align-items:flex-start;
                flex-direction:column;
            }

            .auth-top-actions{
                width:100%;
            }

            .auth-link-home,
            .auth-link-secondary{
                flex:1;
                justify-content:center;
            }
        }
    </style>
</head>
<body>

<header class="auth-topbar">
    <a href="<?= base_url('/') ?>" class="auth-brand-home">
        <span class="brand-icon"><i class="fa-solid fa-hand-holding-heart"></i></span>
        <span>
            <strong>DonasiKu</strong>
            <small>Kembali ke halaman utama</small>
        </span>
    </a>
    <div class="auth-top-actions">
        <a href="<?= base_url('/') ?>" class="auth-link-home"><i class="fa-solid fa-house"></i> Beranda</a>
        <a href="<?= base_url('login') ?>" class="auth-link-secondary"><i class="fa-solid fa-right-to-bracket"></i> Login</a>
    </div>
</header>


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
            Pilih jenis akun sesuai kebutuhan Anda. Donatur dapat berdonasi,
            sedangkan yayasan dapat mengajukan campaign setelah diverifikasi.
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
                <p>Data dilindungi dengan sistem yang tertata.</p>
            </div>
        </div>

        <div class="feature">
            <div class="feature-icon">
                <i class="fa-solid fa-circle-check"></i>
            </div>

            <div>
                <h5>Terverifikasi</h5>
                <p>Yayasan melewati validasi admin sebelum aktif.</p>
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
                Pilih jenis pendaftaran terlebih dahulu
            </p>

            <div class="role-options">
                <a href="<?= base_url('register') ?>" class="role-card active">
                    <i class="fa-solid fa-user"></i>
                    <span>Donatur</span>
                </a>

                <a href="<?= base_url('register-yayasan') ?>" class="role-card">
                    <i class="fa-solid fa-building-user"></i>
                    <span>Yayasan</span>
                </a>
            </div>

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
                        value="<?= old('nama') ?>"
                        placeholder="Masukkan nama lengkap"
                        required>
                </div>

                <div class="mb-3">
                    <label>Email</label>
                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        value="<?= old('email') ?>"
                        placeholder="Masukkan email"
                        required>
                </div>

                <div class="mb-4">
                    <label>Password</label>
                    <input
                        type="password"
                        name="password"
                        class="form-control"
                        placeholder="Minimal 6 karakter"
                        required>
                </div>

                <button class="btn btn-register w-100">
                    Daftar Sebagai Donatur
                </button>

            </form>

            <div class="bottom-text">
                Sudah punya akun?
                <a href="<?= base_url('login') ?>">Login</a>
            </div>

        </div>

    </div>

</div>

</body>
</html>