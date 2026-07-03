<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>


<h3 class="fw-bold mb-4">
    Kelola Campaign
</h3>


<div class="card">


<div class="d-flex justify-content-between align-items-center mb-4">

<h4 class="fw-bold">
Daftar Campaign
</h4>

<a href="<?= base_url('admin/campaign/create') ?>"
class="btn btn-success">

<i class="fa-solid fa-plus"></i>

Tambah Campaign

</a>

</div>