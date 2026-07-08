<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Donasi Transparan') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', system-ui, -apple-system, BlinkMacSystemFont, sans-serif; }
        html, body { max-width: 100%; overflow-x: hidden; }
        body { background: #f4f7fb; color: #0f172a; }
        a, button { cursor: pointer; }
        .app-wrapper {
            min-height: 100vh;
            display: flex;
            width: 100%;
            max-width: 100%;
            overflow-x: hidden;
            position: relative;
        }
        .main-wrapper {
            width: calc(100% - 280px);
            max-width: calc(100% - 280px);
            margin-left: 280px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: .3s;
            min-width: 0;
            position: relative;
            z-index: 1;
        }
        .content-wrapper {
            flex: 1;
            padding: 28px 34px;
            min-width: 0;
            max-width: 100%;
            position: relative;
            z-index: 1;
        }
        .card { border: none; border-radius: 26px; padding: 28px; box-shadow: 0 12px 30px rgba(15, 23, 42, .07); }
        .btn { border-radius: 14px; font-weight: 700; }
        .form-control, .form-select { border-radius: 14px; min-height: 48px; }
        img, video, canvas, svg, table { max-width: 100%; }
        @media(max-width: 992px) {
            .main-wrapper { width: 100%; max-width: 100%; margin-left: 0; }
            .content-wrapper { padding: 22px 18px; }
        }
    </style>
    <?= $this->renderSection('styles') ?>
</head>
<body>
    <div class="app-wrapper">
        <?= $this->include('layouts/sidebar') ?>
        <div class="main-wrapper">
            <?= $this->include('layouts/navbar') ?>
            <main class="content-wrapper">
                <?= $this->renderSection('content') ?>
            </main>
            <?= $this->include('layouts/footer') ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <?= $this->renderSection('scripts') ?>
</body>
</html>
