<?php

use App\User;
use App\Config;

require_once '../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

try {
    $db = new User(
        Config::DRIVER->toString(),
        Config::HOST->toString(),
        Config::DATABASE->toString(),
        Config::USER->toString(),
        Config::PASS->toString()
    );

    $dbConnection = $db->getConnection();

    $method = $_POST['method'] ?? '';

    $dbConnection->beginTransaction();

    if ($method === 'delete') {
        $db->delete((int) $_POST['id']);
    } elseif ($method === 'update') {
        $db->update($_POST);
    } elseif ($method === 'create') {
        $db->create($_POST);
    }

    $dbConnection->commit();

    $users = $db->list();
} catch (\PDOexception $e) {
    if ($dbConnection->inTransaction()) {
        $dbConnection->rollBack();
    }

    throw new \PDOException($e->getMessage());
}

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Info</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <style>
        table thead {
            position: -webkit-sticky;
            position: sticky;
            top: 0;
            z-index: 1;
            background: #fff;
        }
    </style>
  </head>
  <body>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
            <th scope="col">Id</th>
            <th scope="col">First Name</th>
            <th scope="col">Last Name</th>
            <th scope="col">Age</th>
            <th scope="col">Email</th>
            <th scope="col">Date Created</th>
            <th scope="col">Action</th>
            </tr>
        </thead>
        </tbody>
            <?php if (! empty($users)) : ?>
                <?php foreach ($users as $user) : ?>
                    <tr>
                        <form action="index.php" method="POST">
                            <input type="hidden"  name="id" value="<?= htmlspecialchars($user['id'], ENT_QUOTES) ?>">
                            <th scope="row"><?= $user['id'] ?></th>
                            <td><input class="form-control" type="text" name="firstName" value="<?= htmlspecialchars($user['first_name'], ENT_QUOTES) ?>"></td>
                            <td><input class="form-control" type="text" name="lastName" value="<?= htmlspecialchars($user['last_name'], ENT_QUOTES) ?>"></td>
                            <td><input class="form-control" type="text" name="age" value="<?= htmlspecialchars($user['age'], ENT_QUOTES) ?>"></td>
                            <td><input class="form-control" type="text" name="email" value="<?= htmlspecialchars($user['email'], ENT_QUOTES) ?>"></td>
                            <td><input class="form-control" type="text" name="dateCreated" value="<?= htmlspecialchars($user['date_created'], ENT_QUOTES) ?>"></td>
                            <td>
                                <button class="btn btn-primary" type="submit" name="method" value="update">Edit</button>
                                <button class="btn btn-danger" type="submit" name="method" value="delete">Delete</button>
                            </td>
                        </form>
                    </tr>
                <?php endforeach ?>
            <?php endif ?>
            <tr>
                <form action="index.php" method="POST">
                    <th scope="row">#</th>
                    <td><input class="form-control" type="text" name="firstName"></td>
                    <td><input class="form-control" type="text" name="lastName"></td>
                    <td><input class="form-control" type="text" name="age"></td>
                    <td><input class="form-control" type="email" name="email"></td>
                    <td><input class="form-control" type="text" name="dateCreated" placeholder="The current time is set"></td>
                    <td>
                        <button class="btn btn-primary" type="submit" name="method" value="create">Add User</button>
                    </td>
                </form>
            </tr>
        </tbody>
    </table>
  </body>
</html>
