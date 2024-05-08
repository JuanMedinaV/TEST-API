<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUser extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'BIGINT',
                'constraint' => 255,
                'usigned' => true,
                'auto_increment' => true,
            ],
            'email' =>[
                'type' => 'VARCHAR',
                'unique' => true,
                'constrain' => '255',
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constrain' => '255',
            ],
            'created_Ad'=>[
                'type' => 'TIMESTAMP',
                'null' => true
            ],
            'update_at' =>[
                'type' => 'TIMESTAMP',
                'null' => true
            ]
            ]);
            $this->forge->addPrimaryKey('id');
            $this->forge->createTable('users');
    }

    public function down()
    { 
        $this->forge->droptable('users');
    }
}
