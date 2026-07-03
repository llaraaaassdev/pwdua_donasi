<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<title>Detail User</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-5">

    <div class="card">

        <div class="card-header">

            <h3>Detail User</h3>

        </div>

        <div class="card-body">

            <table class="table table-bordered">

                <tr>

                    <th width="250">ID User</th>

                    <td><?= $user['id'] ?></td>

                </tr>

                <tr>

                    <th>Nama</th>

                    <td><?= esc($user['nama']) ?></td>

                </tr>

                <tr>

                    <th>Email</th>

                    <td><?= esc($user['email']) ?></td>

                </tr>

                <tr>

                    <th>No HP</th>

                    <td><?= esc($user['no_hp']) ?></td>

                </tr>

                <tr>

                    <th>Role</th>

                    <td><?= ucfirst($user['role']) ?></td>

                </tr>

                <tr>

                    <th>Status Verifikasi</th>

                    <td><?= ucfirst($user['status_verifikasi']) ?></td>

                </tr>

                <tr>

                    <th>Status Akun</th>

                    <td>

                        <?php if($user['is_active']) : ?>

                            <span class="badge bg-success">

                                Aktif

                            </span>

                        <?php else : ?>

                            <span class="badge bg-danger">

                                Nonaktif

                            </span>

                        <?php endif; ?>

                    </td>

                </tr>

                <tr>

                    <th>Dibuat</th>

                    <td><?= $user['created_at'] ?></td>

                </tr>

            </table>

            <a href="<?= base_url('admin/users') ?>" class="btn btn-secondary">

                Kembali

            </a>

            <a href="<?= base_url('admin/users/edit/'.$user['id']) ?>"
               class="btn btn-warning">

                Edit

            </a>

        </div>

    </div>

</div>

</body>

</html>