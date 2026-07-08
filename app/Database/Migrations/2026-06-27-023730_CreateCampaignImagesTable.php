<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCampaignImagesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([

            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],

            'campaign_id' => [
    'type' => 'BIGINT',
    'constraint' => 20,
    'unsigned' => true,
],

            'image' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],

            'is_cover' => [
                'type'       => 'BOOLEAN',
                'default'    => false,
            ],

            'sort_order' => [
                'type'       => 'INT',
                'constraint' => 5,
                'default'    => 0,
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
        $this->forge->addKey('campaign_id');

        $this->forge->addForeignKey(
            'campaign_id',
            'campaigns',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->createTable('campaign_images');
    }

    public function down()
    {
        $this->forge->dropTable('campaign_images');
    }
}