<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\LessonModel;
use App\Models\StudentlessonModel;
use App\Models\StudentModel;
use CodeIgniter\API\ResponseTrait;
use Exception;

class StudentController extends BaseController
{
    use ResponseTrait;

    private $studentModel;
    private $lessonModel;
    private $studentLessonModel;

    public function __construct()
    {
        $this->studentModel = new StudentModel();
        $this->lessonModel = new LessonModel();
        $this->studentLessonModel = new StudentlessonModel();
    }

    public function create()
    {
        $data = [
            'name' => $this->request->getVar('name'),
            'age' => $this->request->getVar('age'),
            'email' => $this->request->getVar('email'),
        ];

        $lessons = $this->request->getVar('lessons');

        try {

            $studentId = $this->studentModel->insert($data);

            if ($studentId === false) {
                throw new Exception('Erro ao salvar estudante!');
            }

            foreach ($lessons as $lessonId) {

                $studentsLessons = [
                    'student_id' => $studentId,
                    'lesson_id' => $lessonId,
                ];

                if ($studentsLessons) {
                    $this->studentLessonModel->insert($studentsLessons);
                }
            }

            return $this->respond(['message' => 'Estudante cadastrado!'], 201);
        } catch (Exception $e) {
            $response = [
                'message' => "Erro ao salvar estudante!",
                'errors' => [
                    'exception' => $e->getMessage()
                ]
            ];

            return $this->fail($response, 400);
        }
    }

    public function list()
    {
        try {
            $students = $this->studentModel->findAll();

            foreach ($students as &$student) {
                $lessonIds = $this->studentLessonModel
                    ->select('lesson_id')
                    ->where('student_id', $student['id'])
                    ->findAll();

                $lessonIds = array_column($lessonIds, 'lesson_id');

                if (!empty($lessonIds)) {
                    $lessons = $this->lessonModel
                        ->whereIn('id', $lessonIds)
                        ->findAll();
                    $student['lessons'] = $lessons;
                } else {
                    $student['lessons'] = [];
                }
            }

            return $this->respond(['students' => $students], 200);
        } catch (Exception $e) {
            $response = [
                'message' => "Erro ao listar estudantes!",
                'errors' => [
                    'exception' => $e->getMessage()
                ]
            ];

            return $this->fail($response, 400);
        }
    }

    public function update($id)
    {
        $data = [
            'name' => $this->request->getVar('name'),
            'age' => $this->request->getVar('age'),
            'email' => $this->request->getVar('email'),
        ];

        try {
            $student = $this->studentModel->find($id);

            if (!$student) {
                throw new Exception('Estudante não encontrado!');
            }

            $this->studentModel->update($id, $data);

            return $this->respond(['message' => 'Estudante atualizado!'], 200);
        } catch (Exception $e) {
            $response = [
                'message' => "Erro ao atualizar estudante!",
                'errors' => [
                    'exception' => $e->getMessage()
                ]
            ];

            return $this->fail($response, 400);
        }
    }


    public function delete($id)
    {
        
        try {
            $student = $this->studentModel->find($id);

            if (!$student) {
                throw new Exception('Estudante não encontrado!');
            }

            $this->studentModel->delete($id);

            return $this->respond(['message' => 'Estudante deletado!'], 200);
        } catch (Exception $e) {
            $response = [
                'message' => "Erro ao deletar o estudante!",
                'errors' => [
                    'exception' => $e->getMessage()
                ]
            ];

            return $this->fail($response, 400);
        }
    }
}
