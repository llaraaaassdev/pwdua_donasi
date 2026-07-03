<?= $this->extend('layouts/main_yayasan') ?>

<?= $this->section('content') ?>


<h3 class="fw-bold mb-4">

Tambah Campaign

</h3>


<div class="card">


<form
method="post"
action="<?= base_url('yayasan/campaign/store') ?>"
enctype="multipart/form-data">



<div class="mb-3">


<label class="form-label">

Judul

</label>


<input
type="text"
name="judul"
class="form-control"
required>


</div>





<div class="mb-3">


<label class="form-label">

Kategori

</label>


<select 
name="category_id"
class="form-select"
required>


<option value="">

-- Pilih Kategori --

</option>


<?php foreach($categories as $category): ?>


<option value="<?= $category['id'] ?>">


<?= esc($category['nama_kategori']) ?>


</option>


<?php endforeach; ?>


</select>


</div>






<div class="mb-3">


<label class="form-label">

Deskripsi

</label>


<textarea
name="deskripsi"
class="form-control"
rows="5"
required></textarea>


</div>






<div class="mb-3">


<label class="form-label">

Target Donasi

</label>


<input
type="number"
name="target_dana"
class="form-control"
required>


</div>







<div class="row">


<div class="col-md-6 mb-3">


<label class="form-label">

Tanggal Mulai

</label>


<input
type="date"
name="tanggal_mulai"
class="form-control"
required>


</div>





<div class="col-md-6 mb-3">


<label class="form-label">

Tanggal Selesai

</label>


<input
type="date"
name="tanggal_berakhir"
class="form-control"
required>


</div>


</div>






<div class="mb-4">


<label class="form-label">

Gambar Campaign

</label>


<input
type="file"
name="gambar"
class="form-control"
accept="image/*">


</div>







<button
class="btn btn-success">


<i class="fa-solid fa-save"></i>

Simpan


</button>





<a
href="<?= base_url('yayasan/campaign/index') ?>"
class="btn btn-secondary">


Batal


</a>




</form>


</div>


<?= $this->endSection() ?>