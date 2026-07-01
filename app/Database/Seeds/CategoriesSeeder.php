<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    public function run()
    {
        $data = [

            [
                'nama_kategori' => 'Pendidikan',
                'deskripsi' => 'Donasi untuk sektor pendidikan',
                'icon' => 'graduation-cap'
            ],

            [
                'nama_kategori' => 'Kesehatan',
                'deskripsi' => 'Donasi untuk bantuan kesehatan',
                'icon' => 'heartbeat'
            ],

            [
                'nama_kategori' => 'Bencana Alam',
                'deskripsi' => 'Donasi korban bencana',
                'icon' => 'house-damage'
            ],

            [
                'nama_kategori' => 'Rumah Ibadah',
                'deskripsi' => 'Pembangunan rumah ibadah',
                'icon' => 'mosque'
            ],

            [
                'nama_kategori' => 'Sosial',
                'deskripsi' => 'Bantuan sosial masyarakat',
                'icon' => 'hands-helping'
            ],

        ];

        $this->db->table('categories')->insertBatch($data);
    }
}