<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">

<title>Detail Donasi</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-5">

<h2 class="mb-4">

Detail Donasi

</h2>

<table class="table table-bordered">

<tr>

<th width="250">

Nama Donatur

</th>

<td>

<?= esc($donation['nama']) ?>

</td>

</tr>

<tr>

<th>

Email

</th>

<td>

<?= esc($donation['email']) ?>

</td>

</tr>

<tr>

<th>

Campaign

</th>

<td>

<?= esc($donation['judul']) ?>

</td>

</tr>

<tr>

<th>

Nominal

</th>

<td>

Rp <?= number_format($donation['nominal'],0,',','.') ?>

</td>

</tr>

<tr>

<th>

Tanggal Donasi

</th>

<td>

<?= esc($donation['tanggal_donasi']) ?>

</td>

</tr>

<tr>

<th>

Metode Pembayaran

</th>

<td>

<?= esc($donation['metode_pembayaran']) ?>

</td>

</tr>

<tr>

<th>

Status

</th>

<td>

<?= esc($donation['status']) ?>

</td>

</tr>

<tr>

<th>

Bukti Pembayaran

</th>

<td>

<?php if(!empty($donation['bukti_pembayaran'])): ?>

<img
src="<?= base_url('uploads/bukti/'.$donation['bukti_pembayaran']) ?>"
width="250"
class="rounded">

<?php else: ?>

Belum ada bukti pembayaran.

<?php endif; ?>

</td>

</tr>

</table>

<div class="mt-4">

<a
href="<?= base_url('admin/donation') ?>"
class="btn btn-secondary">

Kembali

</a>
<?php if($donation['status']=="pending"): ?>

<a
href="<?= base_url('admin/donation/verify/'.$donation['id']) ?>"
class="btn btn-success"
onclick="return confirm('Verifikasi donasi ini?')">

Verifikasi

</a>

<?php endif; ?>
<?php if($donation['status']=="pending"): ?>

<a
href="<?= base_url('admin/donation/reject/'.$donation['id']) ?>"
class="btn btn-danger"
onclick="return confirm('Tolak donasi ini?')">

Tolak

</a>

<?php endif; ?>
</div>

</div>

</body>
</html>