<form method="get">

<div class="row mb-4">

<div class="col-md-5">

<input
type="text"
name="keyword"
class="form-control"
placeholder="Cari Donatur / Campaign..."
value="<?= esc($keyword ?? '') ?>">

</div>

<div class="col-md-4">

<select
name="status"
class="form-select">

<option value="">Semua Status</option>

<option
value="pending"
<?= ($status=='pending')?'selected':'' ?>>

Pending

</option>

<option
value="berhasil"
<?= ($status=='berhasil')?'selected':'' ?>>

Berhasil

</option>

<option
value="ditolak"
<?= ($status=='ditolak')?'selected':'' ?>>

Ditolak

</option>

</select>

</div>

<div class="col-md-3">

<button
class="btn btn-success w-100">

Filter

</button>

</div>

</div>

</form>
<h2>Daftar Donasi</h2>

<?php if(session()->getFlashdata('success')): ?>

<div class="alert alert-success">

<?= session()->getFlashdata('success') ?>

</div>

<?php endif; ?>

<?php if(session()->getFlashdata('error')): ?>

<div class="alert alert-danger">

<?= session()->getFlashdata('error') ?>

</div>

<?php endif; ?>

<table border="1" cellpadding="10">

<tr>

<th>No</th>

<th>Donatur</th>

<th>Campaign</th>

<th>Nominal</th>

<th>Status</th>

<th>Aksi</th>

</tr>

<?php $no=1; ?>

<?php foreach($donations as $d): ?>

<tr>

<td><?= $no++ ?></td>

<td><?= esc($d['nama']) ?></td>

<td><?= esc($d['judul']) ?></td>

<td>

Rp <?= number_format($d['nominal'],0,',','.') ?>

</td>

<td>

<?= esc($d['status']) ?>

</td>

<td>

<a
href="<?= base_url('admin/donation/detail/'.$d['id']) ?>"
class="btn btn-info btn-sm">

Detail

</a>

</td>

</tr>

<?php endforeach; ?>

</table>