<!DOCTYPE html>

<html>

<head>

<meta charset="UTF-8">

<title>Tambah Campaign</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-5">

<h2>Tambah Campaign</h2>

<hr>

<form
method="post"
action="<?= base_url('yayasan/campaign/store') ?>" 
enctype="multipart/form-data">

<div class="mb-3">

<label>Judul</label>

<input
type="text"
name="judul"
class="form-control"
required>

</div>
<div class="mb-3">

    <label>Kategori</label>

    <select name="category_id" class="form-select" required>

        <option value="">-- Pilih Kategori --</option>

        <?php foreach($categories as $category): ?>

            <option value="<?= $category['id'] ?>">

                <?= esc($category['nama_kategori']) ?>

            </option>

        <?php endforeach; ?>

    </select>

</div>
<div class="mb-3">

<label>Deskripsi</label>

<textarea
name="deskripsi"
class="form-control"
rows="5"
required></textarea>

</div>

<div class="mb-3">

<label>Target Donasi</label>

<input
type="number"
name="target_dana"
class="form-control"
required>

</div>

<div class="row">

<div class="col-md-6">

<label>Tanggal Mulai</label>

<input
type="date"
name="tanggal_mulai"
class="form-control"
required>

</div>

<div class="col-md-6">

<label>Tanggal Selesai</label>

<input
type="date"
name="tanggal_berakhir"
class="form-control"
required>

</div>
<div class="mb-3">

<label>Gambar Campaign</label>

<input
type="file"
name="gambar"
class="form-control"
accept="image/*">

</div>

</div>

<br>

<button
class="btn btn-success">

Simpan

</button>

<a
href="<?= base_url('yayasan/campaign/index') ?>"
class="btn btn-secondary">

Batal

</a>

</form>

</div>

</body>

</html>