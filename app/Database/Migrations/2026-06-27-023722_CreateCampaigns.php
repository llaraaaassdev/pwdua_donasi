<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCampaigns extends Migration
{
    public function up()
    {
        $this->forge->addField([

            'id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
                'auto_increment' => true,
            ],

            'category_id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
            ],

            'foundation_id' => [
            'type' => 'BIGINT',
            'constraint' => 20,
            'unsigned' => true,
            ],

            'judul' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
            ],

            'slug' => [
                'type' => 'VARCHAR',
                'constraint' => 220,
            ],

            'deskripsi' => [
                'type' => 'LONGTEXT',
            ],

            'target_dana' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
                'default' => 0,
            ],

            'dana_terkumpul' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
                'default' => 0,
            ],

            'gambar' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],

            'lokasi' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
                'null' => true,
            ],

            'tanggal_mulai' => [
                'type' => 'DATE',
            ],

            'tanggal_berakhir' => [
                'type' => 'DATE',
            ],

            'status' => [
                'type' => 'ENUM',
                'constraint' => ['draft','aktif','selesai'],
                'default' => 'draft',
            ],

            'jumlah_donatur' => [
            'type' => 'INT',
            'constraint' => 11,
            'default' => 0,
            ],

            'views' => [
            'type' => 'INT',
            'constraint' => 11,
            'default' => 0,
            ],

            'status_verifikasi' => [
    'type' => 'ENUM',
    'constraint' => [
        'pending',
        'approved',
        'rejected'
    ],
    'default' => 'pending',
],
'verified_by' => [
    'type' => 'BIGINT',
    'constraint' => 20,
    'unsigned' => true,
    'null' => true,
],
'verified_at' => [
    'type' => 'DATETIME',
    'null' => true,
],

            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],

            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ]

        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('foundation_id', 'foundations',
            'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('category_id', 'categories', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey(
            'verified_by',
            'users',
            'id',
            'CASCADE',
            'SET NULL'
        );
        $this->forge->createTable('campaigns');
    }

    public function down()
    {
        $this->forge->dropTable('campaigns');
    }
}