<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStudentLesson extends Migration
{
    public function up()
    {
        $this->forge->addField(array(
            'student_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
            ],
            'lesson_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
            ],
        ));
        $this->forge->addKey(['student_id', 'lesson_id'], TRUE);
        $this->forge->createTable('student_lessons');
    }

    public function down()
    {
        $this->forge->dropTable('student_lessons');
    }
}
