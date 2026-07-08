<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'DonasiKu | Donasi Transparan') ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        :root {
            --dk-primary: #2563eb;
            --dk-primary-dark: #1d4ed8;
            --dk-secondary: #4f46e5;
            --dk-accent: #22c55e;
            --dk-danger: #ef4444;
            --dk-warning: #f59e0b;
            --dk-navy: #172339;
            --dk-navy-2: #223149;
            --dk-text: #0f172a;
            --dk-muted: #64748b;
            --dk-soft: #f3f7ff;
            --dk-border: #e6edf7;
            --dk-card: #ffffff;
            --dk-shadow: 0 24px 60px rgba(15, 23, 42, .10);
            --dk-cursor: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='34' height='34' viewBox='0 0 34 34'%3E%3Cdefs%3E%3ClinearGradient id='g' x1='0' x2='1' y1='0' y2='1'%3E%3Cstop stop-color='%232563eb'/%3E%3Cstop offset='1' stop-color='%234f46e5'/%3E%3C/linearGradient%3E%3C/defs%3E%3Ccircle cx='17' cy='17' r='15' fill='url(%23g)'/%3E%3Cpath d='M9 20.4h3.4c.7 0 1.5.2 2.1.6l1.2.7c.5.3 1.1.4 1.7.4h5.1c.9 0 1.6.7 1.6 1.6v.2c0 .7-.5 1.3-1.2 1.4l-7.4.9c-1 .1-2-.1-2.9-.6l-3.6-2v-3.2Z' fill='white'/%3E%3Cpath d='M18.2 9.7c1.4-1.7 4.3-.8 4.3 1.9 0 2.7-4.3 5.2-5.4 5.8-.2.1-.4.1-.6 0-1.1-.6-5.4-3.1-5.4-5.8 0-2.7 2.9-3.6 4.3-1.9l1.4 1.6 1.4-1.6Z' fill='white'/%3E%3Ccircle cx='24.5' cy='8.5' r='3.5' fill='%2322c55e'/%3E%3C/svg%3E") 8 8, auto;
        }

        * { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            margin: 0;
            min-height: 100vh;
            background: radial-gradient(circle at top left, rgba(37, 99, 235, .10), transparent 36%), #f5f8ff;
            color: var(--dk-text);
            font-family: 'Segoe UI', system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
            cursor: var(--dk-cursor);
        }
        a, button, .btn, .nav-link, .navbar-brand, .dropdown-item, .campaign-card, .category-chip, .action-card { cursor: var(--dk-cursor) !important; }
        input, textarea, select { cursor: text; }

        .public-navbar {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: rgba(255, 255, 255, .90);
            border-bottom: 1px solid rgba(230, 237, 247, .92);
            backdrop-filter: blur(18px);
            box-shadow: 0 12px 34px rgba(15, 23, 42, .06);
        }
        .navbar-brand {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            color: var(--dk-navy) !important;
            font-size: 22px;
            font-weight: 950;
            letter-spacing: -.4px;
            flex-shrink: 0;
        }
        .brand-icon, .donatur-avatar {
            width: 44px;
            height: 44px;
            border-radius: 15px;
            background: linear-gradient(135deg, var(--dk-primary), var(--dk-secondary));
            color: #ffffff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 14px 28px rgba(37, 99, 235, .24);
        }
        .brand-text small {
            display: block;
            margin-top: -3px;
            color: var(--dk-muted);
            font-size: 12px;
            font-weight: 800;
            letter-spacing: .3px;
        }
        .nav-link {
            color: #4b5f7b !important;
            font-weight: 850;
            padding: 10px 12px !important;
            border-radius: 14px;
            transition: .22s ease;
            white-space: nowrap;
        }
        .nav-link:hover, .nav-link.active {
            color: var(--dk-primary) !important;
            background: rgba(37, 99, 235, .08);
        }
        .btn {
            border: 0;
            border-radius: 16px;
            font-weight: 900;
            padding: 11px 18px;
            transition: .22s ease;
            white-space: nowrap;
        }
        .btn:hover { transform: translateY(-2px); }
        .btn-dk-primary {
            color: #ffffff !important;
            background: linear-gradient(135deg, var(--dk-primary), var(--dk-secondary));
            box-shadow: 0 16px 30px rgba(37, 99, 235, .26);
        }
        .btn-dk-outline {
            color: var(--dk-primary) !important;
            background: #ffffff;
            border: 1px solid rgba(37, 99, 235, .18);
            box-shadow: 0 10px 24px rgba(15, 23, 42, .05);
        }
        .btn-dk-soft { color: var(--dk-navy) !important; background: #f2f6ff; }

        .donatur-menu-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 8px 10px 8px 8px;
            border: 1px solid var(--dk-border);
            border-radius: 18px;
            background: #ffffff;
            color: var(--dk-navy);
            box-shadow: 0 10px 24px rgba(15, 23, 42, .06);
            font-weight: 950;
            max-width: 240px;
        }
        .donatur-menu-btn::after { margin-left: 4px; }
        .donatur-avatar {
            width: 38px;
            height: 38px;
            border-radius: 14px;
            box-shadow: none;
            font-size: 15px;
        }
        .donatur-name {
            min-width: 0;
            text-align: left;
            line-height: 1.1;
        }
        .donatur-name span {
            display: block;
            max-width: 126px;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }
        .donatur-name small {
            display: block;
            color: var(--dk-muted);
            font-size: 11px;
            font-weight: 800;
            margin-top: 2px;
        }
        .donatur-dropdown {
            min-width: 260px;
            border: 1px solid var(--dk-border);
            border-radius: 22px;
            padding: 10px;
            box-shadow: 0 26px 58px rgba(15, 23, 42, .16);
        }
        .donatur-dropdown .dropdown-header {
            color: var(--dk-navy);
            font-weight: 950;
            padding: 10px 12px 8px;
        }
        .donatur-dropdown .dropdown-item {
            border-radius: 14px;
            padding: 11px 12px;
            color: #334155;
            font-weight: 850;
        }
        .donatur-dropdown .dropdown-item:hover { background: #f2f6ff; color: var(--dk-primary); }
        .donatur-dropdown i { width: 22px; }

        .public-dropdown {
            min-width: 230px;
            border: 1px solid var(--dk-border);
            border-radius: 20px;
            padding: 10px;
            box-shadow: 0 24px 54px rgba(15, 23, 42, .14);
        }
        .public-dropdown .dropdown-item {
            border-radius: 14px;
            padding: 11px 12px;
            color: #334155;
            font-weight: 850;
        }
        .public-dropdown .dropdown-item:hover {
            background: #f2f6ff;
            color: var(--dk-primary);
        }
        .public-dropdown i { width: 22px; }
        .public-navbar .navbar-nav { flex-wrap: nowrap; }

        @media(max-width: 1199px) {
            .navbar-brand { font-size: 20px; }
            .brand-icon { width: 42px; height: 42px; }
            .nav-link { padding-left: 10px !important; padding-right: 10px !important; }
            .btn { padding-left: 16px; padding-right: 16px; }
        }

        @media(max-width: 991px) {
            .public-navbar .navbar-collapse {
                margin-top: 14px;
                padding: 14px;
                border-radius: 22px;
                background: #ffffff;
                border: 1px solid var(--dk-border);
            }
            .public-navbar .btn, .donatur-menu-btn { width: 100%; justify-content: center; margin-top: 8px; }
            .donatur-name span { max-width: 180px; }
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg public-navbar">
    <div class="container">
        <a class="navbar-brand" href="<?= base_url('/') ?>" aria-label="DonasiKu Beranda">
            <span class="brand-icon"><i class="fa-solid fa-hand-holding-heart"></i></span>
            <span class="brand-text">DonasiKu<small>Donasi Transparan</small></span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#publicNavbar" aria-controls="publicNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="publicNavbar">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center gap-lg-1">
                <li class="nav-item"><a class="nav-link" href="<?= base_url('/') ?>"><i class="fa-solid fa-house me-1 d-lg-none"></i> Beranda</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('/#campaign') ?>"><i class="fa-solid fa-bullhorn me-1 d-lg-none"></i> Campaign</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="publicInfoDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Informasi
                    </a>
                    <ul class="dropdown-menu public-dropdown" aria-labelledby="publicInfoDropdown">
                        <li><a class="dropdown-item" href="<?= base_url('/berita-donasi') ?>"><i class="fa-solid fa-bolt text-warning"></i> Berita Donasi</a></li>
                        <li><a class="dropdown-item" href="<?= base_url('/laporan') ?>"><i class="fa-solid fa-file-circle-check text-primary"></i> Laporan Dana</a></li>
                        <li><a class="dropdown-item" href="<?= base_url('/#alur') ?>"><i class="fa-solid fa-route text-success"></i> Alur Donasi</a></li>
                        <li><a class="dropdown-item" href="<?= base_url('/#kategori') ?>"><i class="fa-solid fa-tags text-info"></i> Kategori</a></li>
                    </ul>
                </li>

                <?php if(session()->get('logged_in')): ?>
                    <?php if(session()->get('role') === 'admin'): ?>
                        <li class="nav-item ms-lg-2"><a class="btn btn-dk-primary" href="<?= base_url('admin/dashboard') ?>"><i class="fa-solid fa-table-columns me-1"></i> Dashboard</a></li>
                        <li class="nav-item ms-lg-2"><a class="btn btn-dk-outline" href="<?= base_url('logout') ?>"><i class="fa-solid fa-right-from-bracket me-1"></i> Logout</a></li>
                    <?php elseif(session()->get('role') === 'yayasan'): ?>
                        <li class="nav-item ms-lg-2"><a class="btn btn-dk-primary" href="<?= base_url('yayasan/dashboard') ?>"><i class="fa-solid fa-table-columns me-1"></i> Dashboard</a></li>
                        <li class="nav-item ms-lg-2"><a class="btn btn-dk-outline" href="<?= base_url('logout') ?>"><i class="fa-solid fa-right-from-bracket me-1"></i> Logout</a></li>
                    <?php elseif(session()->get('role') === 'donatur'): ?>
                        <?php $donaturName = session()->get('nama') ?: 'Donatur'; ?>
                        <li class="nav-item dropdown ms-lg-2">
                            <button class="btn dropdown-toggle donatur-menu-btn" type="button" id="donaturDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="donatur-avatar"><?= esc(strtoupper(substr($donaturName, 0, 1))) ?></span>
                                <span class="donatur-name">
                                    <span>Halo, <?= esc($donaturName) ?></span>
                                    <small>Akses Donatur</small>
                                </span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end donatur-dropdown" aria-labelledby="donaturDropdown">
                                <li><h6 class="dropdown-header">Menu Donatur</h6></li>
                                <li><a class="dropdown-item" href="<?= base_url('/#campaign') ?>"><i class="fa-solid fa-hand-holding-heart text-primary"></i> Mulai Donasi</a></li>
                                <li><a class="dropdown-item" href="<?= base_url('donatur/history') ?>"><i class="fa-solid fa-clock-rotate-left text-success"></i> Riwayat Donasi</a></li>
                                <li><a class="dropdown-item" href="<?= base_url('/berita-donasi') ?>"><i class="fa-solid fa-bolt text-warning"></i> Berita Donasi</a></li>
                                <li><a class="dropdown-item" href="<?= base_url('/laporan') ?>"><i class="fa-solid fa-file-circle-check text-info"></i> Laporan Dana</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="<?= base_url('logout') ?>"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
                            </ul>
                        </li>
                    <?php endif; ?>
                <?php else: ?>
                    <li class="nav-item ms-lg-2"><a class="btn btn-dk-outline" href="<?= base_url('login') ?>">Login</a></li>
                    <li class="nav-item ms-lg-2"><a class="btn btn-dk-primary" href="<?= base_url('register') ?>">Daftar Donatur</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
