<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateReportsDetails extends Migration
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

            'report_id' => [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'unsigned'   => true,
            ],

            'nama_pengeluaran' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
            ],

            'nominal' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
            ],

            'keterangan' => [
                'type' => 'TEXT',
                'null' => true,
            ],

            'foto' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
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
            'report_id',
            'reports',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->createTable('reports_details');
    }

    public function down()
    {
        $this->forge->dropTable('reports_details');
    }
}