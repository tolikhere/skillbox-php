<?php

namespace App\Model;

use App\Model;

class User extends Model
{
    final public const ROLE_USER  = 'ROLE_USER';
    final public const ROLE_ADMIN = 'ROLE_ADMIN';

    public function create(string $email, string $password, string $role)
    {
        $stmt = $this->db->prepare(
            'INSERT INTO users (email, `password`, `role`)
             VALUES (?, ?, ?)'
        );

        $stmt->execute([$email, $password, $role]);

        return (int) $this->db->lastInsertId();
    }

    public function findById(int $id): array
    {
        $stmt = $this->db->prepare(
            'SELECT *
             FROM users
             WHERE id = ?'
        );

        $stmt->execute([$id]);

        return $stmt->fetch() ?: [];
    }

    public function findAll(): array
    {
        $stmt = $this->db->query('SELECT * FROM users');

        return $stmt->fetchAll() ?: [];
    }

    public function update(array $data)
    {
        $user = $this->findById($data['id']);
        $stmt = $this->db->prepare(
            'UPDATE users
             SET email = ?, `password` = ?, `role` = ?
             WHERE id = ?'
        );

        $stmt->execute([
            $data['email'] ?? $user['email'],
            $data['password'] ?? $user['password'],
            $data['role']     ?? $user['role'],
            $data['id']
        ]);

        return $stmt->fetch();
    }

    public function delete(int $id)
    {
        $stmt = $this->db->prepare(
            'DELETE FROM users
             WHERE id = ?'
        );

        $stmt->execute([$id]);
    }

    public function findByEmail(string $email)
    {
        $stmt = $this->db->prepare(
            'SELECT *
             FROM users
             WHERE email = ?'
        );

        $stmt->execute([$email]);

        return $stmt->fetch();
    }
}
