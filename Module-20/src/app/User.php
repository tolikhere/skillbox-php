<?php

namespace App;

class User
{
    private \PDO $connection;

    public function __construct(string $driver, string $host, string $db, string $user, string $pass)
    {
        $this->connection = new \PDO("{$driver}:host={$host};dbname={$db}", $user, $pass);
    }

    public function create(array $userInfo): void
    {
        $query = 'INSERT INTO users (email, first_name, last_name, age, date_created)
                  VALUES (:email, :first_name, :last_name, :age, :date_created)';

        $stmt = $this->connection->prepare($query);

        $stmt->bindValue(':email', $userInfo['email']);
        $stmt->bindValue(':first_name', $userInfo['firstName']);
        $stmt->bindValue(':last_name', $userInfo['lastName']);
        $stmt->bindValue(':age', $userInfo['age']);
        $stmt->bindValue(
            ':date_created',
            empty($userInfo['dateCreated']) ? date('Y-m-d H:i:s') : $userInfo['dateCreated']
        );

        $stmt->execute();
    }

    public function update(array $data): void
    {
        $query = 'UPDATE users
                  SET email        = :email,
                      first_name   = :firstName,
                      last_name    = :lastName,
                      age          = :age,
                      date_created = :dateCreated
                  WHERE id = :id';

        $stmt = $this->connection->prepare($query);

        $stmt->bindValue(':id', (int) $data['id'], \PDO::PARAM_INT);
        $stmt->bindValue(':email', $data['email']);
        $stmt->bindValue(':firstName', $data['firstName']);
        $stmt->bindValue(':lastName', $data['lastName']);
        $stmt->bindValue(':age', (int) $data['age'], \PDO::PARAM_INT);
        $stmt->bindValue(':dateCreated', $data['dateCreated']);

        $stmt->execute();
    }

    public function delete(int $id): void
    {
        $stmt = $this->connection->prepare('
            DELETE FROM users WHERE id = :id
        ');

        $stmt->bindValue(':id', $id);

        $stmt->execute();
    }

    public function list(): array
    {
        $stmt = $this->connection->query('SELECT * FROM users');

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getConnection(): \PDO
    {
        return $this->connection;
    }
}
