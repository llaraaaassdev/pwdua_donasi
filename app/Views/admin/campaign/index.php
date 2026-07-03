<form method="get">

<div class="row mb-4">

<div class="col-md-5">

<input
type="text"
name="keyword"
class="form-control"
placeholder="Cari Campaign..."
value="<?= esc($keyword ?? '') ?>">

</div>

<div class="col-md-4">

<select
name="status"
class="form-select">

<option value="">Semua Status</option>

<option
value="aktif"
<?= ($status=='aktif')?'selected':'' ?>>

Aktif

</option>

<option
value="nonaktif"
<?= ($status=='nonaktif')?'selected':'' ?>>

Nonaktif

</option>

<option
value="selesai"
<?= ($status=='selesai')?'selected':'' ?>>

Selesai

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
<h2>Daftar Campaign</h2>
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
<table>
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

<?php $no=1; ?>

<?php foreach($campaigns as $c): ?>

<tr>

<td><?= $no++ ?></td>

<td><?= esc($c['judul']) ?></td>

<td><?= esc($c['nama_yayasan']) ?></td>

<td><?= esc($c['nama_kategori']) ?></td>

<td>

Rp <?= number_format($c['target_dana'],0,',','.') ?>

</td>
<td>

<?php if($c['gambar']): ?>

<img

src="<?= base_url('uploads/campaigns/'.$c['gambar']) ?>"

width="80"

class="rounded">

<?php endif; ?>

</td>

<td>

<?= esc($c['status']) ?>

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
class="btn btn-danger btn-sm"
onclick="return confirm('Yakin hapus campaign?')">

Delete

</a>

</td>

</tr>

<?php endforeach; ?>
</table>