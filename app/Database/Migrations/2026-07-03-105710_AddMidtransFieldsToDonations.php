<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddMidtransFieldsToDonations extends Migration
{
    public function up()
    {
        $fields = [

            'snap_token' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'invoice'
            ],

            'transaction_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
                'after'      => 'snap_token'
            ],

            'payment_type' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
                'after'      => 'transaction_id'
            ],

            'bank' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
                'after'      => 'payment_type'
            ],

            'va_number' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
                'after'      => 'bank'
            ],

            'gross_amount' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
                'null'       => true,
                'after'      => 'va_number'
            ],

            'transaction_status' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
                'after'      => 'gross_amount'
            ],

            'fraud_status' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
                'null'       => true,
                'after'      => 'transaction_status'
            ],

            'paid_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'fraud_status'
            ]

        ];

        $this->forge->addColumn('donations', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('donations', [
            'snap_token',
            'transaction_id',
            'payment_type',
            'bank',
            'va_number',
            'gross_amount',
            'transaction_status',
            'fraud_status',
            'paid_at'
        ]);
    }
}