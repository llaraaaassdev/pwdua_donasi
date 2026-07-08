<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<style>
    .notification-page {
        animation: fadeUp .6s ease;
    }

    .notification-hero {
        background: linear-gradient(135deg, #2563eb, #4f46e5);
        border-radius: 28px;
        padding: 34px;
        color: #ffffff;
        position: relative;
        overflow: hidden;
        margin-bottom: 28px;
        box-shadow: 0 18px 35px rgba(37, 99, 235, .22);
    }

    .notification-hero::before {
        content: "";
        position: absolute;
        width: 260px;
        height: 260px;
        border-radius: 50%;
        background: rgba(255,255,255,.16);
        right: -80px;
        top: -90px;
    }

    .notification-hero-content {
        position: relative;
        z-index: 2;
    }

    .notification-hero h2 {
        font-weight: 800;
        margin-bottom: 8px;
    }

    .notification-hero p {
        margin-bottom: 0;
        color: rgba(255,255,255,.84);
    }

    .modern-card {
        background: #ffffff;
        border-radius: 28px;
        padding: 28px;
        border: 1px solid #eef2f7;
        box-shadow: 0 14px 34px rgba(15, 23, 42, .08);
    }

    .notification-item {
        display: flex;
        gap: 16px;
        padding: 18px;
        border-radius: 20px;
        background: #f8fafc;
        border: 1px solid #eef2f7;
        margin-bottom: 14px;
        text-decoration: none;
        color: inherit;
        transition: .25s;
    }

    .notification-item:hover {
        transform: translateY(-2px);
        background: #ffffff;
        color: inherit;
    }

    .notification-icon {
        width: 48px;
        height: 48px;
        border-radius: 16px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 48px;
    }

    .notification-icon.info { background: rgba(37, 99, 235, .12); color: #2563eb; }
    .notification-icon.success { background: rgba(22, 163, 74, .14); color: #16a34a; }
    .notification-icon.warning { background: rgba(245, 158, 11, .14); color: #d97706; }
    .notification-icon.danger { background: rgba(239, 68, 68, .14); color: #ef4444; }

    .notification-title {
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 5px;
    }

    .notification-message {
        color: #64748b;
        margin-bottom: 8px;
        line-height: 1.6;
    }

    .notification-time {
        color: #94a3b8;
        font-size: 13px;
        font-weight: 700;
    }

    .empty-state {
        text-align: center;
        color: #64748b;
        padding: 70px 20px;
    }

    .empty-state i {
        width: 78px;
        height: 78px;
        border-radius: 24px;
        background: #f1f5f9;
        color: #2563eb;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 34px;
        margin-bottom: 18px;
    }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(18px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="notification-page">
    <div class="notification-hero">
        <div class="notification-hero-content">
            <h2>Notifikasi</h2>
            <p>Semua proses verifikasi, approval, dan penolakan akan muncul di halaman ini.</p>
        </div>
    </div>

    <div class="modern-card">
        <?php if(empty($notifications)): ?>
            <div class="empty-state">
                <i class="fa-regular fa-bell"></i>
                <h5 class="fw-bold">Belum ada notifikasi</h5>
                <p class="mb-0">Notifikasi akan muncul setelah ada proses verifikasi atau perubahan data.</p>
            </div>
        <?php else: ?>
            <?php foreach($notifications as $notification): ?>
                <?php
                $type = $notification['type'] ?? 'info';
                $icon = [
                    'info' => 'fa-circle-info',
                    'success' => 'fa-circle-check',
                    'warning' => 'fa-clock',
                    'danger' => 'fa-circle-xmark',
                ][$type] ?? 'fa-circle-info';
                $url = !empty($notification['link']) ? $notification['link'] : '#';
                ?>
                <a href="<?= esc($url) ?>" class="notification-item">
                    <div class="notification-icon <?= esc($type) ?>">
                        <i class="fa-solid <?= esc($icon) ?>"></i>
                    </div>
                    <div>
                        <div class="notification-title">
                            <?= esc($notification['title']) ?>
                        </div>
                        <div class="notification-message">
                            <?= esc($notification['message']) ?>
                        </div>
                        <div class="notification-time">
                            <?= !empty($notification['created_at']) ? date('d M Y H:i', strtotime($notification['created_at'])) : '-' ?>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
