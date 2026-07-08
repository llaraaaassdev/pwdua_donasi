<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFoundationProfileChanges extends Migration
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
            'foundation_id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
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
                'null' => true,
            ],
            'nomor_izin' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['pending', 'approved', 'rejected'],
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
        $this->forge->addKey(['foundation_id', 'status']);
        $this->forge->addForeignKey('foundation_id', 'foundations', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('verified_by', 'users', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('foundation_profile_changes');
    }

    public function down()
    {
        $this->forge->dropTable('foundation_profile_changes');
    }
}
