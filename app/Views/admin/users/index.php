<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>


<div class="d-flex justify-content-between align-items-center mb-4">

    <h2>Kelola User</h2>

</div>


<?php if(session()->getFlashdata('success')) : ?>

    <div class="alert alert-success">

        <?= session()->getFlashdata('success') ?>

    </div>

<?php endif; ?>


<?php if(session()->getFlashdata('error')): ?>

    <div class="alert alert-danger">

        <?= session()->getFlashdata('error'); ?>

    </div>

<?php endif; ?>



<div class="card shadow border-0">

    <div class="card-header bg-white">

        <strong>Daftar User</strong>

    </div>


    <div class="card-body">


        <table class="table table-bordered table-striped">


            <thead class="table-success">


            <tr>

                <th width="60">No</th>

                <th>Nama</th>

                <th>Email</th>

                <th>No HP</th>

                <th>Role</th>

                <th>Status</th>

                <th width="220">Aksi</th>

            </tr>


            </thead>



            <tbody>


            <?php if(!empty($users)): ?>


                <?php $no=1; ?>


                <?php foreach($users as $user): ?>


                    <tr>


                        <td><?= $no++ ?></td>


                        <td><?= esc($user['nama']) ?></td>


                        <td><?= esc($user['email']) ?></td>


                        <td><?= esc($user['no_hp']) ?></td>


                        <td><?= ucfirst($user['role']) ?></td>


                        <td>


                            <?php if($user['is_active']) : ?>


                                <span class="badge bg-success">

                                    Aktif

                                </span>


                            <?php else : ?>


                                <span class="badge bg-danger">

                                    Nonaktif

                                </span>


                            <?php endif; ?>


                        </td>



                        <td>


                            <a 
                            href="<?= base_url('admin/users/detail/'.$user['id']) ?>"
                            class="btn btn-info btn-sm">

                                Detail

                            </a>



                            <a 
                            href="<?= base_url('admin/users/edit/'.$user['id']) ?>"
                            class="btn btn-warning btn-sm">

                                Edit

                            </a>




                            <a 
                            href="<?= base_url('admin/users/delete/'.$user['id']) ?>"
                            onclick="return confirm('Yakin ingin menghapus user ini?')"
                            class="btn btn-danger btn-sm">

                                Hapus

                            </a>


                        </td>



                    </tr>


                <?php endforeach; ?>



            <?php else : ?>


                <tr>

                    <td colspan="7" class="text-center">

                        Belum ada data user.

                    </td>

                </tr>


            <?php endif; ?>


            </tbody>


        </table>


    </div>


</div>



<?= $this->endSection() ?>