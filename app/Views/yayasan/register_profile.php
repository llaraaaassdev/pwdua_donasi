<h2>Lengkapi Profil Yayasan</h2>

<form action="<?= base_url('yayasan/lengkapi-profil') ?>" 
method="post" enctype="multipart/form-data">
<?= csrf_field() ?>

<label>Nama Yayasan</label>

<input type="text" name="nama_yayasan">

<br><br>

<label>Email Yayasan</label>

<input type="email" name="email_yayasan">

<br><br>

<label>Telepon</label>

<input type="text" name="telepon">

<br><br>

<label>Alamat</label>

<textarea name="alamat"></textarea>

<br><br>

<label>Deskripsi</label>

<textarea name="deskripsi"></textarea>

<br><br>

<label>Nomor Izin</label>

<input type="text" name="nomor_izin">

<br><br>

<button type="submit">

Simpan

</button>

</form>