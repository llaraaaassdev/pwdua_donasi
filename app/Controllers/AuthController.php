<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    public function login()
    {
        return view('auth/login');
    }

    public function loginProcess()
    {
        $userModel = new UserModel();

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $userModel->where('email', $email)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Email tidak ditemukan.');
        }

        if (!password_verify($password, $user['password'])) {
            return redirect()->back()->with('error', 'Password salah.');
        }

        if (!$user['is_active']) {
            return redirect()->back()->with('error', 'Akun tidak aktif.');
        }

        session()->set([
            'id' => $user['id'],
            'nama' => $user['nama'],
            'email' => $user['email'],
            'role' => $user['role'],
            'logged_in' => true
        ]);

        switch ($user['role']) {
            case 'admin':
                return redirect()->to('/admin/dashboard');

            case 'yayasan':
                return redirect()->to('/yayasan/dashboard');

            default:
                return redirect()->to('/dashboard');
        }
    }
    public function register()
    {
        return view('auth/register');
    }

    public function registerProcess()
    {

        $userModel = new UserModel();

        $rules = [
            'nama' => 'required|min_length[3]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
        ];

        if (!$this->validate($rules)) {

            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());

        }

        $userModel->save([

            'nama' => $this->request->getPost('nama'),

            'email' => $this->request->getPost('email'),

            'password' => password_hash(
                $this->request->getPost('password'),
                PASSWORD_DEFAULT
            ),

            'role' => 'donatur',

            'status_verifikasi' => 'verified',

            'is_active' => 1

        ]);

        return redirect()->to('/login')
            ->with('success','Registrasi berhasil.');
    }

}