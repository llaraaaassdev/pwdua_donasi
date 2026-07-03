<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">

<title>Detail Campaign</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-5">

    <a href="<?= base_url('donatur/campaign') ?>" class="btn btn-secondary mb-4">
        ← Kembali
    </a>

    <div class="card">

        <?php if(!empty($campaign['gambar'])): ?>

            <img
                src="<?= base_url('uploads/campaign/'.$campaign['gambar']) ?>"
                class="card-img-top"
                style="height:350px;object-fit:cover;">

        <?php endif; ?>

        <div class="card-body">

            <h2><?= esc($campaign['judul']) ?></h2>

            <hr>

            <h5>Target Dana</h5>

            <h3 class="text-success">

                Rp <?= number_format($campaign['target_dana'],0,',','.') ?>

            </h3>

            <hr>

            <h5>Dana Terkumpul</h5>

            <h4>

                Rp <?= number_format($campaign['dana_terkumpul'],0,',','.') ?>

            </h4>

            <hr>

            <h5>Deskripsi</h5>

            <p>

                <?= nl2br(esc($campaign['deskripsi'])) ?>

            </p>

            <hr>

            <a
                href="<?= base_url('donatur/donation/create/'.$campaign['id']) ?>"
                class="btn btn-success btn-lg">

                Donasi Sekarang

            </a>

        </div>

    </div>

</div>

</body>
</html>