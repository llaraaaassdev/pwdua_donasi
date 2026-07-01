<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateReports extends Migration
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

            'campaign_id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
            ],

            'user_id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
            ],

            'judul_laporan' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
            ],

            'deskripsi' => [
                'type' => 'LONGTEXT',
            ],

            'total_pengeluaran' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
                'default' => 0,
            ],

            'tanggal_laporan' => [
                'type' => 'DATE',
            ],

            'status' => [
                'type' => 'ENUM',
                'constraint' => [
                    'draft',
                    'published'
                ],
                'default' => 'draft',
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
            ],

        ]);

        $this->forge->addKey('id', true);

        $this->forge->addForeignKey(
            'campaign_id',
            'campaigns',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->addForeignKey(
            'user_id',
            'users',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->createTable('reports');
    }

    public function down()
    {
        $this->forge->dropTable('reports');
    }
}