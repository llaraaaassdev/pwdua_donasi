<?php
$role = session()->get('role');
$nama = session()->get('nama') ?? 'Pengguna';

$currentPath = trim(parse_url(current_url(), PHP_URL_PATH), '/');

$isActive = function ($path) use ($currentPath) {
    $path = trim($path, '/');

    return str_contains($currentPath, $path) ? 'active' : '';
};
?>

<style>
    .sidebar {
        width: 280px;
        height: 100vh;
        position: fixed;
        left: 0;
        top: 0;
        background: #1e293b;
        color: #ffffff;
        padding: 28px 22px;
        overflow-y: auto;
        z-index: 1000;
        transition: .3s;
    }

    .sidebar-brand {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 36px;
    }

    .sidebar-logo {
        width: 46px;
        height: 46px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #2563eb, #4f46e5);
        font-size: 22px;
        box-shadow: 0 12px 26px rgba(37, 99, 235, .28);
    }

    .sidebar-brand h4 {
        margin: 0;
        font-weight: 800;
        font-size: 24px;
    }

    .sidebar-brand small {
        color: #bfdbfe;
        font-weight: 500;
    }

    .sidebar-user {
        background: rgba(255,255,255,.08);
        border: 1px solid rgba(255,255,255,.08);
        border-radius: 22px;
        padding: 16px;
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 30px;
    }

    .sidebar-avatar {
        width: 46px;
        height: 46px;
        border-radius: 50%;
        background: linear-gradient(135deg, #6366f1, #2563eb);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 18px;
    }

    .sidebar-user strong {
        display: block;
        line-height: 1.2;
    }

    .sidebar-user span {
        color: #cbd5e1;
        font-size: 13px;
        text-transform: capitalize;
    }

    .sidebar-label {
        color: #93c5fd;
        font-size: 12px;
        letter-spacing: .12em;
        text-transform: uppercase;
        margin: 22px 12px 12px;
        font-weight: 800;
    }

    .sidebar-menu {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .sidebar-link {
        min-height: 52px;
        padding: 13px 16px;
        display: flex;
        align-items: center;
        gap: 14px;
        border-radius: 16px;
        text-decoration: none;
        color: #dbeafe;
        font-weight: 700;
        transition: .25s;
    }

    .sidebar-link i {
        width: 22px;
        text-align: center;
        font-size: 18px;
    }

    .sidebar-link:hover,
    .sidebar-link.active {
        background: rgba(255,255,255,.12);
        color: #ffffff;
        transform: translateX(4px);
    }

    .sidebar-link.active {
        box-shadow: inset 4px 0 0 #60a5fa;
    }

    .sidebar-logout {
        margin-top: 28px;
        display: block;
        width: 100%;
        text-align: center;
        padding: 15px;
        border-radius: 18px;
        background: #ef4444;
        color: #ffffff;
        text-decoration: none;
        font-weight: 800;
        transition: .25s;
    }

    .sidebar-logout:hover {
        background: #dc2626;
        color: #ffffff;
        transform: translateY(-2px);
    }

    .sidebar-backdrop {
        display: none;
    }

    @media(max-width: 992px) {
        .sidebar {
            transform: translateX(-100%);
        }

        .sidebar.show {
            transform: translateX(0);
        }

        .sidebar-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15,23,42,.45);
            z-index: 999;
        }

        .sidebar-backdrop.show {
            display: block;
        }
    }
</style>

<div class="sidebar-backdrop" id="sidebarBackdrop"></div>

<aside class="sidebar" id="sidebar">

    <div class="sidebar-brand">
        <div class="sidebar-logo">
            <i class="fa-solid fa-hand-holding-heart"></i>
        </div>

        <div>
            <h4>DonasiKu</h4>
            <small>
                <?php if ($role === 'admin'): ?>
                    Admin Dashboard
                <?php elseif ($role === 'yayasan'): ?>
                    Foundation Dashboard
                <?php else: ?>
                    Donatur Dashboard
                <?php endif; ?>
            </small>
        </div>
    </div>

    <div class="sidebar-user">
        <div class="sidebar-avatar">
            <?= strtoupper(substr($nama, 0, 1)) ?>
        </div>

        <div>
            <strong><?= esc($nama) ?></strong>
            <span><?= esc($role ?? 'guest') ?></span>
        </div>
    </div>

    <div class="sidebar-label">Main Menu</div>

    <nav class="sidebar-menu">

        <?php if ($role === 'admin'): ?>

            <a href="<?= base_url('admin/dashboard') ?>" class="sidebar-link <?= $isActive('admin/dashboard') ?>">
                <i class="fa-solid fa-chart-line"></i>
                <span>Dashboard</span>
            </a>

            <a href="<?= base_url('admin/yayasan') ?>" class="sidebar-link <?= $isActive('admin/yayasan') ?>">
                <i class="fa-solid fa-building-user"></i>
                <span>Kelola Yayasan</span>
            </a>

            <a href="<?= base_url('admin/campaign') ?>" class="sidebar-link <?= $isActive('admin/campaign') ?>">
                <i class="fa-solid fa-bullhorn"></i>
                <span>Kelola Campaign</span>
            </a>

            <a href="<?= base_url('admin/category') ?>" class="sidebar-link <?= $isActive('admin/category') ?>">
                <i class="fa-solid fa-tags"></i>
                <span>Kategori Donasi</span>
            </a>

            <a href="<?= base_url('admin/users') ?>" class="sidebar-link <?= $isActive('admin/users') ?>">
                <i class="fa-solid fa-users"></i>
                <span>Kelola User</span>
            </a>

            <a href="<?= base_url('admin/donation') ?>" class="sidebar-link <?= $isActive('admin/donation') ?>">
                <i class="fa-solid fa-money-bill-wave"></i>
                <span>Kelola Donasi</span>
            </a>

        <?php elseif ($role === 'yayasan'): ?>

            <a href="<?= base_url('yayasan/dashboard') ?>" class="sidebar-link <?= $isActive('yayasan/dashboard') ?>">
                <i class="fa-solid fa-table-columns"></i>
                <span>Dashboard</span>
            </a>

            <a href="<?= base_url('yayasan/campaign/index') ?>" class="sidebar-link <?= $isActive('yayasan/campaign/index') ?>">
                <i class="fa-solid fa-bullhorn"></i>
                <span>Daftar Campaign</span>
            </a>

            <a href="<?= base_url('yayasan/campaign/create') ?>" class="sidebar-link <?= $isActive('yayasan/campaign/create') ?>">
                <i class="fa-solid fa-circle-plus"></i>
                <span>Pengajuan Campaign</span>
            </a>

            <a href="<?= base_url('yayasan/donation/index') ?>" class="sidebar-link <?= $isActive('yayasan/donation/index') ?>">
                <i class="fa-solid fa-money-bill-wave"></i>
                <span>Donasi</span>
            </a>

            <a href="<?= base_url('yayasan/profile') ?>" class="sidebar-link <?= $isActive('yayasan/profile') ?>">
                <i class="fa-solid fa-user-pen"></i>
                <span>Profil Yayasan</span>
            </a>

            <a href="<?= base_url('yayasan/status') ?>" class="sidebar-link <?= $isActive('yayasan/status') ?>">
                <i class="fa-solid fa-circle-check"></i>
                <span>Status Verifikasi</span>
            </a>

        <?php elseif ($role === 'donatur'): ?>

            <a href="<?= base_url('donatur/dashboard') ?>" class="sidebar-link <?= $isActive('donatur/dashboard') ?>">
                <i class="fa-solid fa-table-columns"></i>
                <span>Dashboard</span>
            </a>

            <a href="<?= base_url('donatur/campaign/index') ?>" class="sidebar-link <?= $isActive('donatur/campaign/index') ?>">
                <i class="fa-solid fa-hand-holding-heart"></i>
                <span>Campaign Donasi</span>
            </a>

            <a href="<?= base_url('donatur/history') ?>" class="sidebar-link <?= $isActive('donatur/history') ?>">
                <i class="fa-solid fa-clock-rotate-left"></i>
                <span>Riwayat Donasi</span>
            </a>

        <?php endif; ?>

    </nav>

    <a href="<?= base_url('logout') ?>" class="sidebar-logout">
        <i class="fa-solid fa-arrow-right-from-bracket me-2"></i>
        Logout
    </a>

</aside>