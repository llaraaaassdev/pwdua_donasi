<!DOCTYPE html>
<html>

<head>

    <title>Status Yayasan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container py-5">

    <div class="card shadow">

        <div class="card-header bg-success text-white">

            Status Verifikasi Yayasan

        </div>

        <div class="card-body">

            <h4>

                <?= $foundation['nama_yayasan']; ?>

            </h4>

            <hr>

            <p>

               <div class="info-title">
    Status Verifikasi
</div>

<div class="info-value">

<?php if($foundation['status']=='pending'): ?>

<span class="badge bg-warning">
    Pending
</span>

<?php elseif($foundation['status']=='verified'): ?>

<span class="badge bg-success">
    Verified
</span>

<?php else: ?>

<span class="badge bg-danger">
    Rejected
</span>

<?php endif; ?>

</div>
            </p>

        </div>

    </div>

</div>

</body>

</html>