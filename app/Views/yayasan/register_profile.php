<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>Profil Yayasan</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body class="bg-light">

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-9">

            <div class="card shadow border-0 rounded-4">

                <div class="card-header bg-primary text-white">

                    <h3 class="mb-0">

                        <i class="fa-solid fa-building me-2"></i>

                        Lengkapi Profil Yayasan

                    </h3>

                </div>

                <div class="card-body p-4">

                    <?php if(session()->getFlashdata('errors')) : ?>

                        <div class="alert alert-danger">

                            <ul class="mb-0">

                                <?php foreach(session()->getFlashdata('errors') as $error) : ?>

                                    <li><?= esc($error) ?></li>

                                <?php endforeach ?>

                            </ul>

                        </div>

                    <?php endif; ?>

                    <form action="<?= base_url('yayasan/profile/store') ?>"
                        method="post"
                        enctype="multipart/form-data">

                        <?= csrf_field() ?>

                        <div class="mb-3">

                            <label>Nama Yayasan</label>

                            <input
                                type="text"
                                name="nama_yayasan"
                                class="form-control"
                                value="<?= old('nama_yayasan') ?>">

                        </div>

                        <div class="mb-3">

                            <label>Email Yayasan</label>

                            <input
                                type="email"
                                name="email_yayasan"
                                class="form-control"
                                value="<?= old('email_yayasan') ?>">

                        </div>

                        <div class="mb-3">

                            <label>Nomor Telepon</label>

                            <input
                                type="text"
                                name="telepon"
                                class="form-control"
                                value="<?= old('telepon') ?>">

                        </div>

                        <div class="mb-3">

                            <label>Alamat</label>

                            <textarea
                                name="alamat"
                                rows="3"
                                class="form-control"><?= old('alamat') ?></textarea>

                        </div>

                        <div class="mb-3">

                            <label>Deskripsi Yayasan</label>

                            <textarea
                                name="deskripsi"
                                rows="5"
                                class="form-control"><?= old('deskripsi') ?></textarea>

                        </div>

                        <div class="mb-3">

                            <label>Nomor Izin Yayasan</label>

                            <input
                                type="text"
                                name="nomor_izin"
                                class="form-control"
                                value="<?= old('nomor_izin') ?>">

                        </div>

                        <div class="mb-3">

                            <label>Logo Yayasan</label>

                            <input
                                type="file"
                                name="logo"
                                class="form-control">

                        </div>

                        <div class="mb-4">

                            <label>Upload Legalitas (PDF)</label>

                            <input
                                type="file"
                                name="dokumen_verifikasi"
                                class="form-control">

                        </div>

                        <button class="btn btn-primary">

                            <i class="fa-solid fa-floppy-disk"></i>

                            Simpan Profil

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

</body>

</html>