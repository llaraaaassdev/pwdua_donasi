<!DOCTYPE html>
<html>
<head>

    <title>Tambah Campaign</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-5">

<h2 class="mb-4">

Tambah Campaign

</h2>

<form action="<?= base_url('admin/campaign/store') ?>" method="post" enctype="multipart/form-data">

<div class="mb-3">

<label>Yayasan</label>

<select
name="foundation_id"
class="form-select"
required>

<option value=""> Pilih Yayasan </option>

<?php foreach($foundations as $f): ?>

<option value="<?= $f['id'] ?>">

<?= esc($f['nama_yayasan']) ?>

</option>

<?php endforeach; ?>

</select>

</div>

<div class="mb-3">

<label>Kategori</label>

<select
name="category_id"
class="form-select"
required>

<option value="">-- Pilih Kategori --</option>

<?php foreach($categories as $c): ?>

<option value="<?= $c['id'] ?>">

<?= esc($c['nama_kategori']) ?>

</option>

<?php endforeach; ?>

</select>

</div>

<div class="mb-3">

<label>Judul Campaign</label>

<input
type="text"
name="judul"
class="form-control"
required>

</div>

<div class="mb-3">

<label>Deskripsi</label>

<textarea
name="deskripsi"
class="form-control"
rows="5"></textarea>

</div>

<div class="mb-3">

<label>Target Donasi</label>

<input
type="number"
name="target_donasi"
class="form-control"
required>

</div>

<div class="mb-3">

<label>Tanggal Mulai</label>

<input
type="date"
name="tanggal_mulai"
class="form-control">

</div>

<div class="mb-3">

<label>Tanggal Selesai</label>

<input
type="date"
name="tanggal_selesai"
class="form-control">

</div>
<div class="mb-3">

<label>Gambar Campaign</label>

<input
type="file"
name="gambar"
class="form-control"
accept="image/*">

</div>
<button class="btn btn-success">

Simpan Campaign

</button>

<a href="<?= base_url('admin/campaign') ?>"
class="btn btn-secondary">

Kembali

</a>

</form>

</div>

</body>
</html>