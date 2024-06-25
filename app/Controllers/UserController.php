<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;
use Exception;

class UserController extends BaseController
{
    use ResponseTrait;

    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function create()
    {
        $password = $this->request->getVar('password');
        $confirmPassword = $this->request->getVar('confirm_password');

        if ($password !== $confirmPassword) {
            return $this->fail([
                'message' => 'Erro ao salvar Usuário!',
                'errors' => [
                    'confirm_password' => 'The confirm_password field does not match the password field.'
                ]
            ], 409);
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $data = [
            'email' => $this->request->getVar('email'),
            'password' => $hashedPassword,
        ];

        try {
            if ($this->userModel->insert($data)) {
                return $this->respond(['message' => 'Usuário Cadastrado!'], 200);
            } else {
                $response = [
                    'message' => "Erro ao salvar Usuário!",
                    'errors' => $this->userModel->errors()
                ];

                return $this->fail($response, 409);
            }
        } catch (Exception $e) {
            $response = [
                'message' => "Erro ao salvar usuário!",
                'errors' => [
                    'exception' => $e->getMessage()
                ]
            ];

            return $this->fail($response, 400);
        }
    }

    public function list()
    {
        return $this->respond(['users' => $this->userModel->findAll()], 200);
    }
}
