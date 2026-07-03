<?= $this->extend('layouts/main_yayasan') ?>

<?= $this->section('content') ?>


<h3 class="fw-bold mb-4">

Campaign Saya

</h3>


<div class="card">


<div class="d-flex justify-content-between align-items-center mb-4">


<h4 class="fw-bold mb-0">

Daftar Campaign

</h4>



<a
href="<?= base_url('yayasan/campaign/create') ?>"
class="btn btn-success">


<i class="fa-solid fa-plus"></i>

Tambah Campaign


</a>


</div>




<div class="table-responsive">


<table class="table table-bordered table-hover align-middle">


<thead>


<tr>


<th>No</th>

<th>Judul</th>

<th>Target</th>

<th>Terkumpul</th>

<th>Status</th>

<th>Aksi</th>


</tr>


</thead>



<tbody>


<?php $no=1; ?>


<?php foreach($campaigns as $campaign): ?>


<tr>


<td>

<?= $no++ ?>

</td>



<td>

<?= esc($campaign['judul']) ?>

</td>



<td>

Rp <?= number_format($campaign['target_dana'],0,',','.') ?>

</td>




<td>

Rp <?= number_format($campaign['dana_terkumpul'],0,',','.') ?>

</td>




<td>

<?= esc($campaign['status']) ?>

</td>





<td>



<a
href="<?= base_url('yayasan/campaign/detail/'.$campaign['id']) ?>"
class="btn btn-info btn-sm">


Detail


</a>





<a
href="<?= base_url('yayasan/campaign/edit/'.$campaign['id']) ?>"
class="btn btn-warning btn-sm">


Edit


</a>





<a
href="<?= base_url('yayasan/campaign/delete/'.$campaign['id']) ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Yakin ingin menghapus campaign ini?')">


<i class="fa fa-trash"></i>

Hapus


</a>



</td>



</tr>



<?php endforeach; ?>



</tbody>


</table>


</div>


</div>


<?= $this->endSection() ?>