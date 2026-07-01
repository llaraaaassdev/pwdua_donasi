<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFoundations extends Migration
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

            'user_id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
            ],

            'nama_yayasan' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
            ],

            'email_yayasan' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],

            'telepon' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],

            'alamat' => [
                'type' => 'TEXT',
            ],

            'deskripsi' => [
                'type' => 'LONGTEXT',
                'null' => true,
            ],

            'logo' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],

            'dokumen_verifikasi' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],

            'nomor_izin' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],

            'status' => [
                'type' => 'ENUM',
                'constraint' => [
                    'pending',
                    'verified',
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
            'user_id',
            'users',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->addForeignKey(
            'verified_by',
            'users',
            'id',
            'CASCADE',
            'SET NULL'
        );

        $this->forge->createTable('foundations');
    }

    public function down()
    {
        $this->forge->dropTable('foundations');
    }
}