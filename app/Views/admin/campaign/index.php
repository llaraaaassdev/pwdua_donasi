<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>


<h3 class="fw-bold mb-4">
    Kelola Campaign
</h3>


<div class="card">


<div class="d-flex justify-content-between align-items-center mb-4">

<h4 class="fw-bold">
Daftar Campaign
</h4>


<button class="btn btn-success">

<i class="fa-solid fa-plus"></i>

Tambah Campaign

</button>


</div>



<form method="get">

<div class="row mb-4">


<div class="col-md-6">

<input 
type="text"
name="keyword"
class="form-control"
placeholder="Cari Campaign..."
value="<?= esc($keyword ?? '') ?>">

</div>



<div class="col-md-3">

<select 
name="status"
class="form-select">


<option value="">
Semua Status
</option>


<option value="aktif">
Aktif
</option>


<option value="selesai">
Selesai
</option>


<option value="nonaktif">
Nonaktif
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




<div class="table-responsive">


<table class="table table-bordered table-hover align-middle">


<thead>

<tr>

<th>No</th>

<th>Campaign</th>

<th>Yayasan</th>

<th>Kategori</th>

<th>Target</th>

<th>Gambar</th>

<th>Status</th>

<th>Aksi</th>

</tr>

</thead>



<tbody>


<?php $no=1; ?>


<?php foreach($campaigns as $c): ?>


<tr>


<td>
<?= $no++ ?>
</td>


<td>
<?= esc($c['judul']) ?>
</td>


<td>
<?= esc($c['nama_yayasan']) ?>
</td>


<td>
<?= esc($c['kategori']) ?>
</td>


<td>

Rp <?= number_format($c['target'],0,',','.') ?>

</td>


<td>

<?php if(!empty($c['gambar'])): ?>

<img 
src="<?= base_url('uploads/campaign/'.$c['gambar']) ?>"
width="80">

<?php endif; ?>

</td>


<td>

<span class="badge bg-success">

<?= esc($c['status']) ?>

</span>

</td>



<td>


<a 
href="<?= base_url('admin/campaign/detail/'.$c['id']) ?>"
class="btn btn-info btn-sm">

Detail

</a>


<a 
href="<?= base_url('admin/campaign/edit/'.$c['id']) ?>"
class="btn btn-warning btn-sm">

Edit

</a>


<a 
href="<?= base_url('admin/campaign/delete/'.$c['id']) ?>"
class="btn btn-danger btn-sm">

Delete

</a>


</td>


</tr>


<?php endforeach; ?>


</tbody>


</table>


</div>


</div>


<?= $this->endSection() ?>