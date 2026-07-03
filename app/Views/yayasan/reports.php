<?= $this->extend('layouts/main_yayasan') ?>


<?= $this->section('content') ?>


<h3 class="fw-bold mb-4">

    Laporan

</h3>


<div class="card">


    <h4 class="fw-bold mb-4">

        Laporan Donasi

    </h4>


    <div class="table-responsive">


        <table class="table table-bordered table-hover align-middle">


            <thead>


                <tr>

                    <th>No</th>

                    <th>Campaign</th>

                    <th>Total Donasi</th>

                    <th>Jumlah Donatur</th>

                    <th>Status</th>

                </tr>


            </thead>



            <tbody>


                <tr>


                    <td colspan="5" class="text-center py-5">


                        <i class="fa-solid fa-chart-column fa-3x text-success mb-3"></i>


                        <h5>

                            Belum Ada Laporan

                        </h5>


                        <p class="text-muted">

                            Data laporan akan tampil setelah ada donasi.

                        </p>


                    </td>


                </tr>


            </tbody>


        </table>


    </div>


</div>



<?= $this->endSection() ?>