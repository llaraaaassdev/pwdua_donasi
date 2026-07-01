<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';

    protected $returnType       = 'array';

    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'nama',
        'email',
        'password',
        'no_hp',
        'foto',
        'role',
        'status_verifikasi',
        'is_active'
    ];

    protected $useTimestamps = true;

    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    //REGISTRASI
    public function register()
        {
        return view('auth/register');
        }
    //PROSES REISRASI
    public function registerProcess()
{
    $userModel = new UserModel();

    // Validasi input
    $rules = [
        'nama' => 'required|min_length[3]',
        'email' => 'required|valid_email|is_unique[users.email]',
        'password' => 'required|min_length[6]'
    ];

    if (!$this->validate($rules)) {
        return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }

    // Simpan data
    $userModel->save([
        'nama' => $this->request->getPost('nama'),
        'email' => $this->request->getPost('email'),
        'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
        'role' => 'donatur',
        'status_verifikasi' => 'verified',
        'is_active' => 1
    ]);

    return redirect()->to('/login')->with('success', 'Registrasi berhasil. Silakan login.');
}
}