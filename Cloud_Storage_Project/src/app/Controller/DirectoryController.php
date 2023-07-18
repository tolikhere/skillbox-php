<?php

namespace App\Controller;

use App\Model\Directory;
use App\Model\File;

class DirectoryController
{
    private Directory $directory;
    public function __construct()
    {
        $this->directory = new Directory($_SESSION['user_id']);
    }

    public function create()
    {
        $dirName = $this->normalizeName($_POST['dirName']);
        $parentId = $_POST['parentId'];
        http_response_code(201);
        $this->directory->create($dirName, $parentId);
    }

    public function update()
    {
        parse_str(file_get_contents("php://input"), $data);
        $dirName = $data['dirName'];
        $id = $data['id'];
        $this->directory->update($id, $dirName);
        return 'Success';
    }

    public function getFiles(int $id)
    {
        return [
            'directories' => $this->directory->getAllSubDir($id),
            'files'       => (new File($_SESSION['user_id']))->findAllFilesByParentId($id),
        ];
    }

    public function delete(int $id)
    {
        $this->directory->deleteById($id);

        return 'Success';
    }

    private function normalizeName(string $name): string
    {
        $name = preg_replace("/[^\w\- ]/", '_', $name);
        $name = preg_replace("/\s+/", ' ', $name);
        return trim($name);
    }
}
