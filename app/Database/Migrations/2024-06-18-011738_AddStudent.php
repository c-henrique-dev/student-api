<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStudent extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'BIGINT',
                'constraint' => 255,
                'unsigned' => true,
                'auto_increment' => true
            ],

            'name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],

            'age' => [
                'type' => 'INT',
                'constraint' => '3',
            ],

            'email' => [
                'type' => 'VARCHAR',
                'unique' => true,
                'constraint' => '255',
            ],

            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true
            ],

            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => true
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('students');
    }

    public function down()
    {
        //
    }
}
