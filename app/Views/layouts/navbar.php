<?php
$nama = session()->get('nama') ?? 'Pengguna';
$role = session()->get('role') ?? 'guest';

$roleLabel = [
    'admin'   => 'Administrator',
    'yayasan' => 'Yayasan',
    'donatur' => 'Donatur',
];

$displayRole = $roleLabel[$role] ?? 'Pengguna';

$dashboardSubtitle = [
    'admin'   => 'Kelola yayasan, campaign, donasi, dan pengguna.',
    'yayasan' => 'Kelola campaign dan pantau donasi dengan mudah.',
    'donatur' => 'Temukan campaign dan pantau riwayat donasi Anda.',
];

$dashboardTitle = [
    'admin'   => 'Dashboard Admin',
    'yayasan' => 'Dashboard Yayasan',
    'donatur' => 'Dashboard Donatur',
];

$profileUrl = base_url('/');
if ($role === 'admin') {
    $profileUrl = base_url('admin/dashboard');
} elseif ($role === 'yayasan') {
    $profileUrl = base_url('yayasan/profile');
} elseif ($role === 'donatur') {
    $profileUrl = base_url('donatur/profile');
}

$notificationCount = 0;
if (session()->get('logged_in') && session()->get('id')) {
    try {
        if (class_exists('App\\Models\\NotificationModel')) {
            $notificationModel = new \App\Models\NotificationModel();
            if (method_exists($notificationModel, 'countUnreadByUser')) {
                $notificationCount = (int) $notificationModel->countUnreadByUser((int) session()->get('id'));
            }
        }
    } catch (\Throwable $e) {
        $notificationCount = 0;
    }
}
?>

<style>
    .dk-dashboard-topbar {
        min-height: 92px;
        background: #ffffff;
        border-bottom: 1px solid #e2e8f0;
        padding: 18px 34px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        position: sticky;
        top: 0;
        z-index: 5000;
        isolation: isolate;
        box-shadow: 0 8px 20px rgba(15, 23, 42, .035);
        pointer-events: auto;
    }

    .dk-dashboard-topbar * {
        pointer-events: auto;
    }

    .dk-topbar-left,
    .dk-topbar-right {
        display: flex;
        align-items: center;
    }

    .dk-topbar-left {
        gap: 18px;
        min-width: 0;
    }

    .dk-topbar-right {
        gap: 14px;
        flex-shrink: 0;
    }

    .dk-sidebar-toggle {
        width: 48px;
        height: 48px;
        border: none;
        border-radius: 16px;
        background: #f1f5f9;
        color: #1e293b;
        display: none;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        transition: .25s;
    }

    .dk-sidebar-toggle:hover {
        background: #e2e8f0;
        transform: translateY(-2px);
    }

    .dk-topbar-title {
        min-width: 0;
    }

    .dk-topbar-title h4 {
        margin: 0;
        font-weight: 900;
        color: #0f172a;
        font-size: 24px;
        letter-spacing: -.3px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .dk-topbar-title p {
        margin: 3px 0 0;
        color: #64748b;
        font-size: 14px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .dk-time-box {
        text-align: right;
        min-width: 130px;
    }

    .dk-time-box strong {
        display: block;
        color: #0f172a;
        font-size: 18px;
        line-height: 1.2;
        font-weight: 900;
    }

    .dk-time-box span {
        color: #64748b;
        font-size: 14px;
    }

    .dk-header-icon-btn,
    .dk-header-logout-btn {
        width: 52px;
        height: 52px;
        border: none;
        border-radius: 18px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        position: relative;
        transition: .25s;
    }

    .dk-header-icon-btn {
        background: #f8fafc;
        color: #1e293b;
        font-size: 20px;
    }

    .dk-header-icon-btn:hover {
        background: #edf6ff;
        color: #2563eb;
        transform: translateY(-2px);
    }

    .dk-header-logout-btn {
        background: #fff1f2;
        color: #e11d48;
        font-size: 19px;
    }

    .dk-header-logout-btn:hover {
        background: #ffe4e6;
        color: #be123c;
        transform: translateY(-2px);
    }

    .dk-notification-dot {
        min-width: 18px;
        height: 18px;
        padding: 0 5px;
        border-radius: 999px;
        background: #ef4444;
        color: #ffffff;
        position: absolute;
        top: 7px;
        right: 7px;
        border: 2px solid #ffffff;
        font-size: 10px;
        font-weight: 900;
        line-height: 14px;
        text-align: center;
    }

    .dk-profile-link {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 6px 8px 6px 6px;
        border-radius: 22px;
        color: inherit;
        text-decoration: none;
        transition: .25s;
        max-width: 280px;
    }

    .dk-profile-link:hover {
        background: #f8fafc;
        color: inherit;
        transform: translateY(-1px);
    }

    .dk-profile-avatar {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: linear-gradient(135deg, #2563eb, #4f46e5);
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 900;
        font-size: 22px;
        box-shadow: 0 12px 24px rgba(37, 99, 235, .22);
        flex: 0 0 56px;
    }

    .dk-profile-info {
        min-width: 0;
    }

    .dk-profile-info strong,
    .dk-profile-info span {
        display: block;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .dk-profile-info strong {
        color: #0f172a;
        line-height: 1.2;
        font-weight: 900;
    }

    .dk-profile-info span {
        color: #64748b;
        font-size: 14px;
    }

    @media(max-width: 992px) {
        .dk-dashboard-topbar {
            padding: 16px 18px;
            min-height: 78px;
        }

        .dk-sidebar-toggle {
            display: flex;
        }

        .dk-topbar-title h4 {
            font-size: 20px;
        }

        .dk-time-box {
            display: none;
        }
    }

    @media(max-width: 720px) {
        .dk-profile-info {
            display: none;
        }

        .dk-profile-link {
            padding: 0;
        }

        .dk-topbar-title p {
            display: none;
        }
    }

    @media(max-width: 520px) {
        .dk-dashboard-topbar {
            gap: 10px;
        }

        .dk-topbar-right {
            gap: 8px;
        }

        .dk-header-icon-btn,
        .dk-header-logout-btn {
            width: 46px;
            height: 46px;
            border-radius: 16px;
        }

        .dk-profile-avatar {
            width: 46px;
            height: 46px;
            flex-basis: 46px;
            font-size: 19px;
        }
    }
</style>

<header class="dk-dashboard-topbar">
    <div class="dk-topbar-left">
        <button type="button" class="dk-sidebar-toggle" id="sidebarToggle" aria-label="Buka menu">
            <i class="fa-solid fa-bars"></i>
        </button>

        <div class="dk-topbar-title">
            <h4><?= esc($dashboardTitle[$role] ?? 'Donasi Transparan') ?></h4>
            <p><?= esc($dashboardSubtitle[$role] ?? 'Sistem informasi donasi berbasis web.') ?></p>
        </div>
    </div>

    <div class="dk-topbar-right">
        <div class="dk-time-box">
            <strong id="navbarClock">00.00.00</strong>
            <span><?= date('l, d F Y') ?></span>
        </div>

        <a href="<?= base_url('notifications') ?>" class="dk-header-icon-btn" title="Notifikasi" aria-label="Buka notifikasi">
            <i class="fa-regular fa-bell"></i>
            <?php if ($notificationCount > 0): ?>
                <span class="dk-notification-dot"><?= $notificationCount > 9 ? '9+' : $notificationCount ?></span>
            <?php endif; ?>
        </a>

        <a href="<?= esc($profileUrl) ?>" class="dk-profile-link" title="Profil akun" aria-label="Buka profil akun">
            <div class="dk-profile-avatar">
                <?= esc(strtoupper(substr((string) $nama, 0, 1))) ?>
            </div>
            <div class="dk-profile-info">
                <strong><?= esc($nama) ?></strong>
                <span><?= esc($displayRole) ?></span>
            </div>
        </a>

        <a href="<?= base_url('logout') ?>" class="dk-header-logout-btn" title="Logout" aria-label="Logout">
            <i class="fa-solid fa-right-from-bracket"></i>
        </a>
    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const clock = document.getElementById('navbarClock');
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarBackdrop = document.getElementById('sidebarBackdrop');

        function updateClock() {
            if (!clock) return;

            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');

            clock.textContent = hours + '.' + minutes + '.' + seconds;
        }

        updateClock();
        setInterval(updateClock, 1000);

        function openSidebar() {
            if (sidebar) sidebar.classList.add('show');
            if (sidebarBackdrop) sidebarBackdrop.classList.add('show');
        }

        function closeSidebar() {
            if (sidebar) sidebar.classList.remove('show');
            if (sidebarBackdrop) sidebarBackdrop.classList.remove('show');
        }

        if (sidebarToggle) sidebarToggle.addEventListener('click', openSidebar);
        if (sidebarBackdrop) sidebarBackdrop.addEventListener('click', closeSidebar);
    });
</script>
