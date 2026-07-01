<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class FoundationsSeeder extends Seeder
{
    public function run()
    {
        $data = [

            [
                'user_id' => 2,
                'nama_yayasan' => 'Yayasan Peduli Bangsa',
                'email_yayasan' => 'yayasan@donasi.com',
                'telepon' => '081234567890',
                'alamat' => 'Jakarta',
                'deskripsi' => 'Yayasan sosial yang bergerak di bidang pendidikan, kesehatan, dan kemanusiaan.',
                'logo' => 'logo.png',
                'dokumen_verifikasi' => 'legalitas.pdf',
                'nomor_izin' => 'YPB-2026-001',
                'status' => 'verified',
            ]

        ];

        $this->db->table('foundations')->insertBatch($data);
    }
}