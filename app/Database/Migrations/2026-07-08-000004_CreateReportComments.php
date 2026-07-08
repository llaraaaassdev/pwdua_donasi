<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateReportComments extends Migration
{
    public function up()
    {
        if ($this->db->tableExists('report_comments')) {
            return;
        }

        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'report_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'nama_pengomentar' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'email_pengomentar' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
                'null' => true,
            ],
            'komentar' => [
                'type' => 'TEXT',
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => 30,
                'default' => 'published',
            ],
            'ip_address' => [
                'type' => 'VARCHAR',
                'constraint' => 60,
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
        $this->forge->addKey('report_id');
        $this->forge->addKey('user_id');
        $this->forge->createTable('report_comments', true);
    }

    public function down()
    {
        $this->forge->dropTable('report_comments', true);
    }
}
