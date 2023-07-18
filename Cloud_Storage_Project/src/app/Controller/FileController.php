<?php

namespace App\Controller;

use App\Model\File;

class FileController
{
    private File $file;

    public function __construct()
    {
        $this->file = new File($_SESSION['user_id']);
    }

    private function upload(string $fileName)
    {
        $filePath = STORAGE_PATH . $fileName;
        move_uploaded_file($_FILES['file']['tmp_name'], $filePath);
    }

    private function generateFileName(array $fileInfo)
    {
        $base = preg_replace("/[^\w-]/", '_', $fileInfo['filename']);
        $extension = $fileInfo['extension'];

        $filename = $base . '.' . $fileInfo['extension'];

        $i = 1;

        while (file_exists(STORAGE_PATH . $filename)) {
            $filename = $base . "($i).{$extension}";
            $i++;
        }

        return $filename;
    }

    public function create()
    {
        if (empty($_FILES)) {
            throw new \Exception('Upload a file');
        }
        $originalFileName = $_FILES['file']['name'];
        $fileInfo = pathinfo($originalFileName);
        $generatedFileName = $this->generateFileName($fileInfo);


        $dirId = $_POST['dirId'];
        if ($this->file->create($originalFileName, $dirId, $generatedFileName)) {
            $this->upload($generatedFileName);
            http_response_code(201);
            return 'Success';
        }
        http_response_code(404);
        return 'Fail to upload the file';
    }

    public function getAllFiles()
    {
        return $this->file->findAll();
    }

    public function getFile(int $id)
    {
        return $this->file->findById($id);
    }

    public function delete(int $id)
    {
        $storedFileName = $this->file->findById($id)['stored_fname'] ?? null;
        if (is_null($storedFileName)) {
            http_response_code(404);
            return 'Fail to Delete';
        }
        $this->file->deleteById($id);
        unlink(STORAGE_PATH . $storedFileName);
        return 'Success';
    }

    public function update()
    {
        parse_str(file_get_contents("php://input"), $data);
        $dirId = $data['dirId'] ?? null;
        $fileName = $data['fileName'] ?? null;
        $id = $data['id'];
        $this->file->update($id, $fileName, $dirId);
        return 'Success';
    }

    public function getUsersWithAccess(int $id)
    {
        return $this->file->getSharedUsers($id);
    }

    public function updateAccess(int $id, int $user_id)
    {
        return $this->file->updateAccess($id, $user_id);
    }

    public function deleteAccess(int $id, int $user_id)
    {
        return $this->file->deleteAccess($id, $user_id);
    }
}
