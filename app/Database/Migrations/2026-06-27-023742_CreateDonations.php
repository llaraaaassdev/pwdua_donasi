<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDonations extends Migration
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

            'campaign_id' => [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'unsigned'   => true,
            ],

            'user_id' => [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'unsigned'   => true,
            ],

            'invoice' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],

            'nominal' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
            ],

            'metode_pembayaran' => [
            'type'       => 'VARCHAR',
            'constraint' => 50,
            ],

            'bukti_pembayaran' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],

            'pesan' => [
                'type' => 'TEXT',
                'null' => true,
            ],

            'anonim' => [
                'type' => 'BOOLEAN',
                'default' => false,
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

            'tanggal_donasi' => [
                'type' => 'DATETIME',
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

        $this->forge->addUniqueKey('invoice');

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

        $this->forge->createTable('donations');
    }

    public function down()
    {
        $this->forge->dropTable('donations');
    }
}