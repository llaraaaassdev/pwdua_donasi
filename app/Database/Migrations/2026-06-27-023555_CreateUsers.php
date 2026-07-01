<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsers extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
                'auto_increment' => true,
            ],

            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],

            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],

            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],

            'no_hp' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],

            'foto' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],

            'role' => [
            'type' => 'ENUM',
            'constraint' => [
                'admin',
                'yayasan',
                'donatur'
                ],
            'default' => 'donatur',
            ],

            'status_verifikasi' => [
            'type' => 'ENUM',
            'constraint' => [
                'pending',
                'verified',
                'rejected'
                ],
            'default' => 'pending',
            ],

            'is_active' => [
                'type' => 'BOOLEAN',
                'default' => true,
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
        $this->forge->addUniqueKey('email');
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}

