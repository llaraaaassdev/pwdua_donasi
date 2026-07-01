<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run()
    {
        $data = [

            [
                'nama' => 'Administrator',
                'email' => 'admin@donasi.com',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'role' => 'admin',
                'status_verifikasi' => 'verified',
                'is_active' => 1,
            ],

            [
                'nama' => 'Yayasan Peduli Bangsa',
                'email' => 'yayasan@donasi.com',
                'password' => password_hash('yayasan123', PASSWORD_DEFAULT),
                'role' => 'yayasan',
                'status_verifikasi' => 'verified',
                'is_active' => 1,
            ],

            [
                'nama' => 'Budi Santoso',
                'email' => 'donatur@donasi.com',
                'password' => password_hash('donatur123', PASSWORD_DEFAULT),
                'role' => 'donatur',
                'status_verifikasi' => 'verified',
                'is_active' => 1,
            ],

        ];

        $this->db->table('users')->insertBatch($data);
    }
}