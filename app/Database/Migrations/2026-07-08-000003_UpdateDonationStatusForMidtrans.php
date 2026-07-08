<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateDonationStatusForMidtrans extends Migration
{
    public function up()
    {
        if (!$this->db->tableExists('donations')) {
            return;
        }

        $this->forge->modifyColumn('donations', [
            'status' => [
                'name'       => 'status',
                'type'       => 'VARCHAR',
                'constraint' => 30,
                'default'    => 'pending',
            ],
        ]);
    }

    public function down()
    {
        if (!$this->db->tableExists('donations')) {
            return;
        }

        $this->forge->modifyColumn('donations', [
            'status' => [
                'name'       => 'status',
                'type'       => 'ENUM',
                'constraint' => ['pending', 'verified', 'rejected'],
                'default'    => 'pending',
            ],
        ]);
    }
}
