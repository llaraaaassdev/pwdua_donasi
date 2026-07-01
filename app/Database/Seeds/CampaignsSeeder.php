<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CampaignsSeeder extends Seeder
{
    public function run()
    {
        $data = [

            [
                'category_id' => 1,
                'foundation_id' => 1,
                'judul' => 'Beasiswa Anak Indonesia',
                'slug' => 'beasiswa-anak-indonesia',
                'deskripsi' => 'Penggalangan dana untuk membantu anak-anak kurang mampu agar tetap dapat melanjutkan pendidikan.',
                'target_dana' => 50000000,
                'dana_terkumpul' => 12500000,
                'jumlah_donatur' => 32,
                'views' => 540,
                'gambar' => 'beasiswa.jpg',
                'lokasi' => 'Bandung',
                'tanggal_mulai' => '2026-06-01',
                'tanggal_berakhir' => '2026-08-31',
                'status' => 'aktif',
                'status_verifikasi' => 'approved',
                'verified_by' => 1,
                'verified_at' => date('Y-m-d H:i:s'),
            ],

            [
                'category_id' => 2,
                'foundation_id' => 1,
                'judul' => 'Bantu Operasi Jantung Anak',
                'slug' => 'operasi-jantung-anak',
                'deskripsi' => 'Donasi untuk membantu biaya operasi jantung anak dari keluarga kurang mampu.',
                'target_dana' => 100000000,
                'dana_terkumpul' => 42000000,
                'jumlah_donatur' => 87,
                'views' => 1024,
                'gambar' => 'jantung.jpg',
                'lokasi' => 'Jakarta',
                'tanggal_mulai' => '2026-06-10',
                'tanggal_berakhir' => '2026-09-10',
                'status' => 'aktif',
                'status_verifikasi' => 'approved',
                'verified_by' => 1,
                'verified_at' => date('Y-m-d H:i:s'),
            ],

            [
                'category_id' => 3,
                'foundation_id' => 1,
                'judul' => 'Bantuan Korban Banjir',
                'slug' => 'bantuan-korban-banjir',
                'deskripsi' => 'Penggalangan dana bagi masyarakat terdampak banjir untuk kebutuhan pangan dan tempat tinggal sementara.',
                'target_dana' => 75000000,
                'dana_terkumpul' => 65000000,
                'jumlah_donatur' => 165,
                'views' => 1890,
                'gambar' => 'banjir.jpg',
                'lokasi' => 'Bekasi',
                'tanggal_mulai' => '2026-05-20',
                'tanggal_berakhir' => '2026-07-20',
                'status' => 'aktif',
                'status_verifikasi' => 'approved',
                'verified_by' => 1,
                'verified_at' => date('Y-m-d H:i:s'),
            ],

            [
                'category_id' => 5,
                'foundation_id' => 1,
                'judul' => 'Paket Sembako untuk Lansia',
                'slug' => 'paket-sembako-lansia',
                'deskripsi' => 'Program bantuan sembako bagi lansia yang membutuhkan di berbagai daerah.',
                'target_dana' => 30000000,
                'dana_terkumpul' => 8700000,
                'jumlah_donatur' => 18,
                'views' => 275,
                'gambar' => 'sembako.jpg',
                'lokasi' => 'Yogyakarta',
                'tanggal_mulai' => '2026-06-15',
                'tanggal_berakhir' => '2026-09-15',
                'status' => 'aktif',
                'status_verifikasi' => 'approved',
                'verified_by' => 1,
                'verified_at' => date('Y-m-d H:i:s'),
            ]

        ];

        $this->db->table('campaigns')->insertBatch($data);
    }
}