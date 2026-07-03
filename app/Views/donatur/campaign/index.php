<!DOCTYPE html>
<html>
<head>
    <title>Daftar Campaign</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

    <h2>Daftar Campaign</h2>

    <hr>

    <div class="row">

        <?php if(empty($campaigns)): ?>

            <div class="col-12">
                <div class="alert alert-warning">
                    Belum ada campaign yang tersedia.
                </div>
            </div>

        <?php endif; ?>

        <?php foreach($campaigns as $campaign): ?>

            <div class="col-md-4 mb-4">

                <div class="card h-100">

                    <?php if(!empty($campaign['gambar'])): ?>

                        <img
                            src="<?= base_url('uploads/campaign/'.$campaign['gambar']) ?>"
                            class="card-img-top"
                            style="height:220px; object-fit:cover;">

                    <?php endif; ?>

                    <div class="card-body">

                        <h5><?= esc($campaign['judul']) ?></h5>

                        <p>

                            Target Dana

                            <br>

                            <strong>

                                Rp <?= number_format($campaign['target_dana'],0,',','.') ?>

                            </strong>

                        </p>

                        <a
                            href="<?= base_url('donatur/campaign/'.$campaign['id']) ?>"
                            class="btn btn-success">

                            Lihat Detail

                        </a>

                    </div>

                </div>

            </div>

        <?php endforeach; ?>

    </div>

</div>

</body>
</html>s