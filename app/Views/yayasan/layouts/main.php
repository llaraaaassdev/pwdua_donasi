<!DOCTYPE html> 
<html lang="id"> 
    <head> 
        <meta charset="UTF-8"> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <title><?= esc($title ?? 'Donasi Transparan') ?></title> 
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> 
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"> 
        <style> 
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', sans-serif; } 
        body { background: #f4f7fb; color: #0f172a; } 
        .app-wrapper { min-height: 100vh; display: flex; } 
        .main-wrapper { width: 100%; margin-left: 280px; min-height: 100vh; 
            display: flex; flex-direction: column; transition: .3s; } 
        .content-wrapper { flex: 1; padding: 28px 34px; } 
        .card { border: none; border-radius: 26px; padding: 28px; 
            box-shadow: 0 12px 30px rgba(15, 23, 42, .07); } 
        .btn { border-radius: 14px; font-weight: 700; } 
        .form-control, .form-select { border-radius: 14px; min-height: 48px; } 
        @media(max-width: 992px) { .main-wrapper { margin-left: 0; } 
        .content-wrapper { padding: 22px 18px; } } 
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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
        </script> 
        <?= $this->renderSection('scripts') ?> 
    </body> 
</html>