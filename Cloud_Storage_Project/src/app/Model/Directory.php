<?php

namespace App\Model;

use App\Model;

class Directory extends Model
{
    public function __construct(private int $userId)
    {
        parent::__construct();
    }
    public function create(string $dirName, int $parentId)
    {
        if (! $parentId) {
            $parentId = null;
        }

        $stmt = $this->db->prepare(
            'INSERT INTO directories (dir_name, user_id, parent_id)
             VALUES (?, ?, ?)'
        );

        $stmt->execute([$dirName, $this->userId, $parentId]);

        return (int) $this->db->lastInsertId();
    }

    public function update(int $id, $dirName)
    {
        $stmt = $this->db->prepare(
            'UPDATE directories
             SET dir_name = ?
             WHERE id = ? AND user_id = ' . (string) $this->userId
        );

        $stmt->execute([$dirName, $id]);
    }

    public function getAllSubDir(int $id)
    {
        $param = [$this->userId];
        if (! $id) {
            $condition = 'IS NULL';
        } else {
            $condition = '= ?';
            $param[] = $id;
        }
        $stmt = $this->db->prepare(
            'SELECT * FROM directories WHERE user_id = ? AND parent_id ' . $condition
        );

        $stmt->execute($param);

        return $stmt->fetchAll();
    }

    public function deleteById(int $id)
    {
        $stmt = $this->db->prepare(
            'DELETE FROM directories
             WHERE id = ? AND user_id = ' . (string) $this->userId
        );

        $stmt->execute([$id]);
    }
}
