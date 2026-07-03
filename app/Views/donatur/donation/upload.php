<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">

<title>Upload Bukti Pembayaran</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>

<div class="container mt-5">

<h2>Upload Bukti Pembayaran</h2>

<hr>

<div class="alert alert-info">

Invoice :

<b><?= esc($donation['invoice']) ?></b>

</div>

<form
method="post"
enctype="multipart/form-data">

<div class="mb-3">

<label>Bukti Pembayaran</label>

<input
type="file"
name="bukti"
class="form-control"
required>

</div>

<button class="btn btn-success">

Upload Bukti

</button>

</form>

</div>

</body>
</html>