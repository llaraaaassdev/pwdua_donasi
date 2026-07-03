<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">

<title>Edit Campaign</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-5">

<h2>Edit Campaign</h2>

<form action="<?= base_url('admin/campaign/update/'.$campaign['id']) ?>" method="post" enctype="multipart/form-data">

<select
name="foundation_id"
class="form-select">

<?php foreach($foundations as $f): ?>

<option
value="<?= $f['id'] ?>"

<?= $campaign['foundation_id']==$f['id']?'selected':'' ?>>

<?= esc($f['nama_yayasan']) ?>

</option>

<?php endforeach; ?>

</select>

<select
name="category_id"
class="form-select">

<?php foreach($categories as $c): ?>

<option
value="<?= $c['id'] ?>"

<?= $c['category_id']==$c['id']?'selected':'' ?>>

<?= esc($c['nama_kategori']) ?>

</option>

<?php endforeach; ?>

</select>

<div class="mb-3">

<label>Judul</label>

<input
type="text"
name="judul"
class="form-control"
value="<?= esc($c['judul']) ?>">

</div>

<div class="mb-3">

<label>Deskripsi</label>

<textarea
name="deskripsi"
class="form-control"
rows="5"><?= esc($c['deskripsi']) ?></textarea>

</div>

<div class="mb-3">

<label>Target Donasi</label>

<input
type="number"
name="target_donasi"
class="form-control"
value="<?= $c['target_donasi'] ?>">

</div>

<div class="mb-3">

<label>Tanggal Mulai</label>

<input
type="date"
name="tanggal_mulai"
class="form-control"
value="<?= $c['tanggal_mulai'] ?>">

</div>

<div class="mb-3">

<label>Tanggal Selesai</label>

<input
type="date"
name="tanggal_selesai"
class="form-control"
value="<?= $c['tanggal_selesai'] ?>">

</div>
<div class="mb-3">

<label>Gambar Campaign</label>

<input
type="file"
name="gambar"
class="form-control"
accept="image/*">

</div>

<?php if(!empty($campaign['gambar'])): ?>

<img
src="<?= base_url('uploads/campaigns/'.$campaign['gambar']) ?>"
width="180"
class="mt-3 rounded">

<?php endif; ?>
<div class="mb-3">

<label>Status</label>

<select
name="status"
class="form-select">

<option value="aktif"
<?= $c['status']=='aktif'?'selected':'' ?>>
Aktif
</option>

<option value="nonaktif"
<?= $c['status']=='nonaktif'?'selected':'' ?>>
Nonaktif
</option>

</select>

</div>

<button class="btn btn-success">

Update Campaign

</button>

<a href="<?= base_url('admin/campaign') ?>"
class="btn btn-secondary">

Kembali

</a>

</form>

</div>

</body>

</html>