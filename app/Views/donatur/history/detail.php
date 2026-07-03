<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">

<title>Detail Donasi</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-5">

<h2>Detail Donasi</h2>

<hr>

<table class="table table-bordered">

<tr>

<th>Invoice</th>

<td><?= esc($donation['invoice']) ?></td>

</tr>

<tr>

<th>Campaign</th>

<td><?= esc($donation['judul']) ?></td>

</tr>

<tr>

<th>Nominal</th>

<td>

Rp <?= number_format($donation['nominal'],0,',','.') ?>

</td>

</tr>

<tr>

<th>Status</th>

<td><?= ucfirst($donation['status']) ?></td>

</tr>

<tr>

<th>Metode Pembayaran</th>

<td><?= esc($donation['metode_pembayaran']) ?></td>

</tr>

<tr>

<th>Pesan</th>

<td><?= esc($donation['pesan']) ?></td>

</tr>

<tr>

<th>Tanggal Donasi</th>

<td><?= date('d-m-Y',strtotime($donation['tanggal_donasi'])) ?></td>

</tr>

<tr>

<th>Bukti Pembayaran</th>

<td>

<?php if($donation['bukti_pembayaran']): ?>

<img
src="<?= base_url('uploads/bukti_pembayaran/'.$donation['bukti_pembayaran']) ?>"
width="250">

<?php else: ?>

Belum upload bukti pembayaran.

<?php endif; ?>

</td>

</tr>

</table>

<a
href="<?= base_url('donatur/history') ?>"
class="btn btn-secondary">

Kembali

</a>

</div>

</body>
</html>