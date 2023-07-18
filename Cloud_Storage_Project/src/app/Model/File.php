<?php

namespace App\Model;

use App\Model;

class File extends Model
{
    public function __construct(private int $userId)
    {
        parent::__construct();
    }
    public function create(string $fileName, int $dirId, string $storedFileName)
    {
        if (! $dirId) {
            $dirId = null;
        }

        $stmt = $this->db->prepare(
            'INSERT INTO files (file_name, stored_fname, user_id, dir_id, created_at, updated_at)
             VALUES (?, ?, ?, ?, NOW(), NOW())'
        );

        return $stmt->execute([$fileName, $storedFileName, $this->userId, $dirId]);
    }

    public function findAll()
    {
        $stmt = $this->db->query(
            "SELECT * FROM files WHERE user_id = {$this->userId}"
        );

        return $stmt->fetchAll() ?? [];
    }

    public function findById(int $id)
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM files WHERE id = ? AND user_id = {$this->userId}"
        );

        $stmt->execute([$id]);

        return $stmt->fetch();
    }

    public function findAllFilesByParentId(int $id)
    {
        if (! $id) {
            $condition = 'IS NULL';
        } else {
            $condition = '= ?';
        }
        $stmt = $this->db->prepare(
            "SELECT * FROM files WHERE dir_id {$condition} AND user_id = {$this->userId}"
        );

        $stmt->execute($id ? [$id] : null);
        return $stmt->fetchAll();
    }

    public function deleteById(int $id)
    {
        $stmt = $this->db->prepare(
            "DELETE FROM files WHERE id = ? AND user_id = {$this->userId}"
        );

        $stmt->execute([$id]);
    }

    public function update(int $id, string $fileName = null, int $dirId = null)
    {
        $file = $this->findById($id);
        $dirId = $dirId ?: null;

        $stmt = $this->db->prepare(
            "UPDATE files
             SET file_name = ?, dir_id = ?, updated_at = NOW()
             WHERE id = ? AND user_id = {$this->userId}"
        );

        $newDirId = is_null($dirId) ? $file['dir_id'] : ($dirId ?: null);

        $stmt->execute([
            $fileName ?? $file['file_name'],
            $newDirId,
            $id
        ]);
    }

    public function getSharedUsers(int $id)
    {
        $stmt = $this->db->prepare(
            'SELECT users.id, users.email, users.role
             FROM users
             INNER JOIN shared_files
             ON users.id = shared_files.user_id
             AND shared_files.file_id = ?'
        );

        $stmt->execute([$id]);

        return $stmt->fetchAll();
    }

    public function updateAccess(int $id, int $userId)
    {
        $stmt = $this->db->prepare(
            'INSERT INTO shared_files (user_id, file_id)
             VALUE (?, ?)'
        );

        return $stmt->execute([$userId, $id]);
    }

    public function deleteAccess(int $id, int $userId)
    {
        $stmt = $this->db->prepare(
            'DELETE FROM shared_files
             WHERE user_id = ? AND file_id = ?'
        );

        $stmt->execute([$userId, $id]);
    }
}
