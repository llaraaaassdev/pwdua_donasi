<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<title>Edit User</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-5">

<div class="card">

<div class="card-header">

<h3>Edit User</h3>

</div>

<div class="card-body">

<form action="<?= base_url('admin/users/update/'.$user['id']) ?>" method="post">

<?= csrf_field(); ?>

<div class="mb-3">

<label>Nama</label>

<input
type="text"
name="nama"
class="form-control"
value="<?= old('nama',$user['nama']) ?>">

</div>

<div class="mb-3">

<label>Email</label>

<input
type="email"
name="email"
class="form-control"
value="<?= old('email',$user['email']) ?>">

</div>

<div class="mb-3">

<label>No HP</label>

<input
type="text"
name="no_hp"
class="form-control"
value="<?= old('no_hp',$user['no_hp']) ?>">

</div>

<div class="mb-3">

<label>Role</label>

<select name="role" class="form-select">

<option value="admin"
<?= $user['role']=='admin'?'selected':'' ?>>

Admin

</option>

<option value="yayasan"
<?= $user['role']=='yayasan'?'selected':'' ?>>

Yayasan

</option>

<option value="donatur"
<?= $user['role']=='donatur'?'selected':'' ?>>

Donatur

</option>

</select>

</div>

<div class="mb-4">

<label>Status</label>

<select
name="is_active"
class="form-select">

<option value="1"
<?= $user['is_active']==1?'selected':'' ?>>

Aktif

</option>

<option value="0"
<?= $user['is_active']==0?'selected':'' ?>>

Nonaktif

</option>

</select>

</div>

<button class="btn btn-primary">

Simpan

</button>

<a href="<?= base_url('admin/users') ?>"
class="btn btn-secondary">

Kembali

</a>

</form>

</div>

</div>

</div>

</body>

</html>