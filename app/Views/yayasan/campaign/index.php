<!DOCTYPE html>
<html>

<head>

<title>Campaign Saya</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-5">

<h2>Campaign Saya</h2>

<hr>

<a
href="<?= base_url('yayasan/campaign/create') ?>"
class="btn btn-success mb-3">

Tambah Campaign

</a>

<table class="table table-bordered">

<tr>

<th>No</th>

<th>Judul</th>

<th>Target</th>

<th>Terkumpul</th>

<th>Status</th>

<th>Aksi</th>

</tr>

<?php $no=1; ?>

<?php foreach($campaigns as $campaign): ?>

<tr>

<td><?= $no++ ?></td>

<td><?= esc($campaign['judul']) ?></td>

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

</table>

</div>

</body>

</html>