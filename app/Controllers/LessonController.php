<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\LessonModel;
use CodeIgniter\API\ResponseTrait;
use Exception;

class LessonController extends BaseController
{
    use ResponseTrait;

    private $lessonModel;

    public function __construct()
    {
        $this->lessonModel = new LessonModel();
    }

    public function create()
    {
        $data = [
            'title' => $this->request->getVar('title'),
            'description' => $this->request->getVar('description'),
        ];

        try {
            if ($this->lessonModel->insert($data)) {
                return $this->respond(['message' => 'Lesson cadastrada!'], 200);
            } else {
                $response = [
                    'message' => "Erro ao salvar lesson!",
                    'errors' => $this->lessonModel->errors()
                ];

                return $this->fail($response, 409);
            }
        } catch (Exception $e) {
            $response = [
                'message' => "Erro ao salvar lesson!",
                'errors' => [
                    'exception' => $e->getMessage()
                ]
            ];

            return $this->fail($response, 400);
        }
    }
}
