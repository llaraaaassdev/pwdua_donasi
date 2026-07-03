<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<title>Donasi Masuk</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-5">

<h2>Donasi Masuk</h2>

<hr>

<table class="table table-bordered">

<thead>

<tr>

<th>No</th>

<th>Campaign</th>

<th>Donatur</th>

<th>Nominal</th>

<th>Status</th>

<th>Tanggal</th>

<th>Aksi</th>

</tr>

</thead>

<tbody>

<?php $no=1; ?>

<?php foreach($donations as $donation): ?>

<tr>

<td><?= $no++ ?></td>

<td><?= esc($donation['judul']) ?></td>

<td><?= esc($donation['nama']) ?></td>

<td>

Rp <?= number_format($donation['nominal'],0,',','.') ?>

</td>

<td>

<?= esc($donation['status']) ?>

</td>

<td>

<?= date('d-m-Y',strtotime($donation['created_at'])) ?>

</td>

<td>

<a

href="<?= base_url('foundation/donation/detail/'.$donation['id']) ?>"

class="btn btn-primary btn-sm">

Detail

</a>

</td>

</tr>

<?php endforeach; ?>

</tbody>

</table>

</div>

</body>

</html>