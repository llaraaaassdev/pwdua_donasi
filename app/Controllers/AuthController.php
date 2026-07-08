<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\FoundationModel;
use App\Models\NotificationModel;

class AuthController extends BaseController
{
    protected $userModel;
    protected $foundationModel;
    protected $notificationModel;

    public function __construct()
    {
        $this->userModel       = new UserModel();
        $this->foundationModel = new FoundationModel();
        $this->notificationModel = new NotificationModel();
    }


    private function createNotification($userId, $title, $message, $type = 'info', $link = null)
    {
        if (empty($userId)) {
            return;
        }

        try {
            $this->notificationModel->insert([
                'user_id' => $userId,
                'title' => $title,
                'message' => $message,
                'type' => $type,
                'link' => $link,
                'is_read' => 0,
            ]);
        } catch (\Throwable $e) {
            // Notifikasi tidak boleh membuat proses registrasi gagal.
        }
    }

    private function notifyAdmins($title, $message, $type = 'info', $link = null)
    {
        $admins = $this->userModel
            ->where('role', 'admin')
            ->findAll();

        foreach ($admins as $admin) {
            $this->createNotification($admin['id'], $title, $message, $type, $link);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | LOGIN
    |--------------------------------------------------------------------------
    */

    public function login()
    {
        return view('auth/login');
    }

    public function loginProcess()
    {
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $this->userModel
            ->where('email', $email)
            ->first();

        if (!$user) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Email tidak ditemukan.');
        }

        if (!password_verify($password, $user['password'])) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Password salah.');
        }

        if (!$user['is_active']) {
            return redirect()->back()
                ->with('error', 'Akun tidak aktif.');
        }

        $foundationId = null;

        if ($user['role'] === 'yayasan') {
            $foundation = $this->foundationModel
                ->where('user_id', $user['id'])
                ->first();

            if ($foundation) {
                $foundationId = $foundation['id'];

                session()->set([
                    'id'            => $user['id'],
                    'nama'          => $user['nama'],
                    'email'         => $user['email'],
                    'role'          => $user['role'],
                    'foundation_id' => $foundationId,
                    'logged_in'     => true
                ]);

                if ($foundation['status'] === 'pending') {
                    return redirect()
                        ->to('/yayasan/status')
                        ->with('error', 'Akun yayasan masih menunggu verifikasi admin.');
                }

                if ($foundation['status'] === 'rejected') {
                    return redirect()
                        ->to('/yayasan/status')
                        ->with('error', 'Akun yayasan ditolak. Silakan perbaiki data.');
                }
            }
        }

        session()->set([
            'id'            => $user['id'],
            'nama'          => $user['nama'],
            'email'         => $user['email'],
            'role'          => $user['role'],
            'foundation_id' => $foundationId,
            'logged_in'     => true
        ]);

        if ($user['role'] === 'admin') {
            return redirect()->to('/admin/dashboard');
        }

        if ($user['role'] === 'yayasan') {
            return redirect()->to('/yayasan/dashboard');
        }

        if ($user['role'] === 'donatur') {
            return redirect()
                ->to('/')
                ->with('success', 'Halo ' . $user['nama'] . ', Anda sudah masuk sebagai donatur. Silakan pilih campaign untuk berdonasi.');
        }

        return redirect()->to('/');
    }

    /*
    |--------------------------------------------------------------------------
    | REGISTER DONATUR
    |--------------------------------------------------------------------------
    */

    public function register()
    {
        return view('auth/register');
    }

    public function registerProcess()
    {
        $rules = [
            'nama'     => 'required|min_length[3]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $this->userModel->insert([
            'nama'              => $this->request->getPost('nama'),
            'email'             => $this->request->getPost('email'),
            'password'          => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'              => 'donatur',
            'status_verifikasi' => 'verified',
            'is_active'         => 1
        ]);

        $userId = $this->userModel->getInsertID();

        session()->set([
            'id'        => $userId,
            'nama'      => $this->request->getPost('nama'),
            'email'     => $this->request->getPost('email'),
            'role'      => 'donatur',
            'logged_in' => true,
        ]);

        return redirect()
            ->to('/')
            ->with('success', 'Registrasi berhasil. Halo ' . $this->request->getPost('nama') . ', Anda sudah masuk sebagai donatur.');
    }

    /*
    |--------------------------------------------------------------------------
    | REGISTER YAYASAN
    |--------------------------------------------------------------------------
    */

    public function registerYayasan()
    {
        return view('auth/register_yayasan');
    }

    public function registerYayasanProcess()
    {
        $rules = [
            'nama'                => 'required|min_length[3]',
            'email'               => 'required|valid_email|is_unique[users.email]',
            'password'            => 'required|min_length[6]',
            'telepon'             => 'required|min_length[10]',
            'nama_yayasan'        => 'required|min_length[3]',
            'email_yayasan'       => 'required|valid_email',
            'nomor_izin'          => 'required',
            'alamat'              => 'required',
            'dokumen_verifikasi'  => 'uploaded[dokumen_verifikasi]|max_size[dokumen_verifikasi,4096]|ext_in[dokumen_verifikasi,pdf,jpg,jpeg,png]',
            'logo'                => 'permit_empty|max_size[logo,2048]|is_image[logo]|ext_in[logo,jpg,jpeg,png,webp]'
        ];

        $messages = [
            'nama' => [
                'required'   => 'Nama penanggung jawab wajib diisi.',
                'min_length' => 'Nama penanggung jawab minimal 3 karakter.'
            ],
            'email' => [
                'required'    => 'Email login wajib diisi.',
                'valid_email' => 'Format email login tidak valid.',
                'is_unique'   => 'Email login sudah digunakan.'
            ],
            'password' => [
                'required'   => 'Password wajib diisi.',
                'min_length' => 'Password minimal 6 karakter.'
            ],
            'telepon' => [
                'required'   => 'Nomor HP wajib diisi.',
                'min_length' => 'Nomor HP minimal 10 digit.'
            ],
            'nama_yayasan' => [
                'required'   => 'Nama yayasan wajib diisi.',
                'min_length' => 'Nama yayasan minimal 3 karakter.'
            ],
            'email_yayasan' => [
                'required'    => 'Email yayasan wajib diisi.',
                'valid_email' => 'Format email yayasan tidak valid.'
            ],
            'nomor_izin' => [
                'required' => 'Nomor izin yayasan wajib diisi.'
            ],
            'alamat' => [
                'required' => 'Alamat yayasan wajib diisi.'
            ],
            'dokumen_verifikasi' => [
                'uploaded' => 'Dokumen legalitas wajib diunggah.',
                'max_size' => 'Ukuran dokumen maksimal 4MB.',
                'ext_in'   => 'Dokumen legalitas harus berupa PDF, JPG, JPEG, atau PNG.'
            ],
            'logo' => [
                'max_size' => 'Ukuran logo maksimal 2MB.',
                'is_image' => 'Logo harus berupa gambar.',
                'ext_in'   => 'Logo harus berformat JPG, JPEG, PNG, atau WEBP.'
            ]
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $db = db_connect();

        $namaLogo    = null;
        $namaDokumen = null;

        $logoPath    = FCPATH . 'uploads/logo';
        $dokumenPath = FCPATH . 'uploads/dokumen';

        if (!is_dir($logoPath)) {
            mkdir($logoPath, 0777, true);
        }

        if (!is_dir($dokumenPath)) {
            mkdir($dokumenPath, 0777, true);
        }

        $db->transBegin();

        try {
            $userInserted = $this->userModel->insert([
                'nama'              => $this->request->getPost('nama'),
                'email'             => $this->request->getPost('email'),
                'password'          => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'no_hp'             => $this->request->getPost('telepon'),
                'role'              => 'yayasan',
                'status_verifikasi' => 'pending',
                'is_active'         => 1
            ]);

            if (!$userInserted) {
                throw new \RuntimeException('Gagal menyimpan akun yayasan.');
            }

            $userId = $this->userModel->getInsertID();

            $logo = $this->request->getFile('logo');

            if ($logo && $logo->isValid() && !$logo->hasMoved()) {
                $namaLogo = $logo->getRandomName();
                $logo->move($logoPath, $namaLogo);
            }

            $dokumen = $this->request->getFile('dokumen_verifikasi');

            if (!$dokumen || !$dokumen->isValid() || $dokumen->hasMoved()) {
                throw new \RuntimeException('Dokumen legalitas gagal diproses.');
            }

            $namaDokumen = $dokumen->getRandomName();
            $dokumen->move($dokumenPath, $namaDokumen);

            $foundationInserted = $this->foundationModel->insert([
                'user_id'             => $userId,
                'nama_yayasan'        => $this->request->getPost('nama_yayasan'),
                'email_yayasan'       => $this->request->getPost('email_yayasan'),
                'telepon'             => $this->request->getPost('telepon'),
                'alamat'              => $this->request->getPost('alamat'),
                'deskripsi'           => $this->request->getPost('deskripsi'),
                'nomor_izin'          => $this->request->getPost('nomor_izin'),
                'logo'                => $namaLogo,
                'dokumen_verifikasi'  => $namaDokumen,
                'status'              => 'pending'
            ]);

            if (!$foundationInserted) {
                $errors = $this->foundationModel->errors();
                throw new \RuntimeException($errors ? implode(' ', $errors) : 'Gagal menyimpan data yayasan.');
            }

            if ($db->transStatus() === false) {
                throw new \RuntimeException('Transaksi database gagal.');
            }

            $foundationId = $this->foundationModel->getInsertID();

            $db->transCommit();

            $this->createNotification(
                $userId,
                'Registrasi yayasan berhasil',
                'Registrasi yayasan berhasil dikirim. Silakan tunggu proses verifikasi admin.',
                'info',
                base_url('yayasan/status')
            );

            $this->notifyAdmins(
                'Verifikasi yayasan baru',
                'Ada registrasi yayasan baru yang menunggu verifikasi admin.',
                'warning',
                base_url('admin/yayasan/detail/' . $foundationId)
            );

            return redirect()
                ->to('/login')
                ->with('success', 'Registrasi yayasan berhasil. Silakan tunggu verifikasi admin.');
        } catch (\Throwable $e) {
            $db->transRollback();

            if ($namaLogo && file_exists($logoPath . '/' . $namaLogo)) {
                unlink($logoPath . '/' . $namaLogo);
            }

            if ($namaDokumen && file_exists($dokumenPath . '/' . $namaDokumen)) {
                unlink($dokumenPath . '/' . $namaDokumen);
            }

            return redirect()->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */

    public function logout()
    {
        session()->destroy();

        return redirect()
            ->to('/')
            ->with('success', 'Berhasil logout.');
    }
}