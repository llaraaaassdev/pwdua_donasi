<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<title><?= esc($campaign['judul']) ?></title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>


<body>


<div class="container mt-5 mb-5">


    <a href="<?= base_url('donatur/campaign') ?>" 
       class="btn btn-secondary mb-4">

        ← Kembali

    </a>



    <div class="card shadow">


        <!-- =========================
            GALLERY
        ========================== -->

        <?php if (!empty($campaignImages)): ?>


        <div id="campaignCarousel" 
             class="carousel slide"
             data-bs-ride="carousel">


            <div class="carousel-indicators">


                <?php foreach($campaignImages as $key => $image): ?>


                    <button
                        type="button"
                        data-bs-target="#campaignCarousel"
                        data-bs-slide-to="<?= $key ?>"
                        class="<?= $key == 0 ? 'active' : '' ?>">
                    </button>


                <?php endforeach; ?>


            </div>



            <div class="carousel-inner">


                <?php foreach($campaignImages as $key => $image): ?>


                <div class="carousel-item <?= $key == 0 ? 'active' : '' ?>">


                    <img

                        src="<?= base_url('uploads/campaign/'.$image['image']) ?>"

                        class="d-block w-100"

                        style="height:420px;object-fit:cover;"

                        alt="Campaign Image">


                </div>


                <?php endforeach; ?>


            </div>




            <?php if(count($campaignImages) > 1): ?>


            <button

                class="carousel-control-prev"

                type="button"

                data-bs-target="#campaignCarousel"

                data-bs-slide="prev">


                <span class="carousel-control-prev-icon"></span>


            </button>



            <button

                class="carousel-control-next"

                type="button"

                data-bs-target="#campaignCarousel"

                data-bs-slide="next">


                <span class="carousel-control-next-icon"></span>


            </button>


            <?php endif; ?>


        </div>



        <?php elseif(!empty($campaign['gambar'])): ?>


            <img

                src="<?= base_url('uploads/campaign/'.$campaign['gambar']) ?>"

                class="card-img-top"

                style="height:420px;object-fit:cover;">


        <?php endif; ?>





        <div class="card-body p-4">


            <h2 class="fw-bold">

                <?= esc($campaign['judul']) ?>

            </h2>


            <hr>



            <div class="row">


                <div class="col-md-6">


                    <h6>

                        Target Dana

                    </h6>


                    <h3 class="text-success">

                        Rp <?= number_format($campaign['target_dana'],0,',','.') ?>

                    </h3>


                </div>




                <div class="col-md-6">


                    <h6>

                        Dana Terkumpul

                    </h6>


                    <h4>

                        Rp <?= number_format($campaign['dana_terkumpul'],0,',','.') ?>

                    </h4>


                </div>


            </div>



            <hr>




            <h5>

                Deskripsi

            </h5>


            <p>

                <?= nl2br(esc($campaign['deskripsi'])) ?>

            </p>



            <hr>



            <a

                href="<?= base_url('donatur/donation/create/'.$campaign['id']) ?>"

                class="btn btn-success btn-lg w-100">


                Donasi Sekarang


            </a>



        </div>


    </div>


</div>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>