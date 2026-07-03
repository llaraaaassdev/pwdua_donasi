<?= $this->extend('layouts/main') ?>


<?= $this->section('content') ?>


<h3 class="fw-bold mb-4">
    Kelola Yayasan
</h3>


<div class="card">


    <div class="d-flex justify-content-between align-items-center mb-4">

        <h4 class="fw-bold mb-0">
            Daftar Yayasan
        </h4>


        <button class="btn btn-success">

            <i class="fa-solid fa-plus"></i>

            Tambah Yayasan

        </button>


    </div>



    <!-- FILTER -->

    <form method="get">


        <div class="row mb-4">


            <div class="col-md-5">

                <input
                    type="text"
                    name="keyword"
                    class="form-control"
                    placeholder="Cari nama yayasan..."
                    value="<?= esc($keyword ?? '') ?>">

            </div>



            <div class="col-md-4">


                <select name="status" class="form-select">


                    <option value="">
                        Semua Status
                    </option>


                    <option value="pending"
                    <?= ($status ?? '')=='pending' ? 'selected':'' ?>>

                        Pending

                    </option>


                    <option value="verified"
                    <?= ($status ?? '')=='verified' ? 'selected':'' ?>>

                        Verified

                    </option>



                    <option value="rejected"
                    <?= ($status ?? '')=='rejected' ? 'selected':'' ?>>

                        Rejected

                    </option>


                </select>


            </div>



            <div class="col-md-3">


                <button class="btn btn-success w-100">

                    Filter

                </button>


            </div>


        </div>


    </form>





    <?php if(session()->getFlashdata('success')): ?>


        <div class="alert alert-success">

            <?= session()->getFlashdata('success') ?>

        </div>


    <?php endif; ?>






    <!-- TABLE -->


    <div class="table-responsive">


        <table class="table table-bordered table-hover align-middle">



            <thead>


                <tr>

                    <th>No</th>

                    <th>Nama Yayasan</th>

                    <th>Penanggung Jawab</th>

                    <th>Email</th>

                    <th>Status</th>

                    <th>Aksi</th>


                </tr>


            </thead>



            <tbody>



            <?php $no=1; ?>



            <?php if(empty($foundations)): ?>


                <tr>


                    <td colspan="6" class="text-center">

                        Belum ada data yayasan.

                    </td>


                </tr>



            <?php else: ?>



            <?php foreach($foundations as $f): ?>



                <tr>


                    <td>

                        <?= $no++ ?>

                    </td>



                    <td>

                        <?= esc($f['nama_yayasan']) ?>

                    </td>



                    <td>

                        <?= esc($f['nama']) ?>

                    </td>



                    <td>

                        <?= esc($f['email_yayasan']) ?>

                    </td>



                    <td>


                    <?php if($f['status']=='pending'): ?>


                        <span class="badge bg-warning">

                            Pending

                        </span>


                    <?php elseif($f['status']=='verified'): ?>


                        <span class="badge bg-success">

                            Verified

                        </span>


                    <?php else: ?>


                        <span class="badge bg-danger">

                            Rejected

                        </span>


                    <?php endif; ?>


                    </td>





                    <td>



                        <a href="<?= base_url('admin/yayasan/detail/'.$f['id']) ?>"
                        class="btn btn-info btn-sm">


                            <i class="fa-solid fa-eye"></i>


                        </a>




                        <a href="<?= base_url('admin/yayasan/approve/'.$f['id']) ?>"
                        class="btn btn-success btn-sm"
                        onclick="return confirm('Approve yayasan ini?')">


                            <i class="fa-solid fa-check"></i>


                        </a>





                        <a href="<?= base_url('admin/yayasan/delete/'.$f['id']) ?>"
                        class="btn btn-danger btn-sm"
                        onclick="return confirm('Hapus yayasan ini?')">


                            <i class="fa-solid fa-trash"></i>


                        </a>



                    </td>



                </tr>




            <?php endforeach; ?>



            <?php endif; ?>



            </tbody>



        </table>


    </div>


</div>




<div class="mt-5 text-center text-muted">


<hr>


<p>

© <?= date('Y') ?> Donasi Transparan |
Sistem Informasi Donasi Berbasis Web

</p>


</div>



<?= $this->endSection() ?>