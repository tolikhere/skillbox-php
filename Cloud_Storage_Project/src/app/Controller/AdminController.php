<?php

namespace App\Controller;

use App\Model\User;

class AdminController
{
    private $user;

    public function __construct()
    {
        $this->user = new User();
    }
    public function getAllUsers()
    {
        return $this->user->findAll();
    }

    public function getUser(int $id): string|bool
    {
        return json_encode($this->user->findById($id));
    }

    public function update()
    {
        parse_str(file_get_contents("php://input"), $data);
        if (isset($data['password'])) {
            $data['password'] = base64_encode($data['password']);
        }
        return $this->user->update($data);
    }

    public function delete(int $id): string
    {
        $this->user->delete($id);
        return 'Success';
    }
}
