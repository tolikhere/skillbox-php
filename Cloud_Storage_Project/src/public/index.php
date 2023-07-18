<?php

use App\App;
use App\Config;
use App\Controller\UserController;
use App\Controller\AdminController;
use App\Controller\DirectoryController;
use App\Controller\FileController;
use App\Router;

require_once __DIR__ . '/../autoload.php';

session_start();

$_SESSION['is_user_login'] = $_SESSION['is_user_login'] ?? false;
$_SESSION['is_admin'] = $_SESSION['is_admin'] ?? false;

define('VIEW_PATH', __DIR__ . '/../views/');
define('STORAGE_PATH', __DIR__ . '/../storage/');

$router = new Router();
$router
    ->get('/login', [UserController::class, 'login'])
    ->post('/user/', [UserController::class, 'create'])
    ->get('/reset-password', [UserController::class, 'resetPassword'])
;

if ($_SESSION['is_user_login']) {
    /** USER ROUTER */
    $router
        ->get('/user/', [UserController::class, 'getAllUsers'])
        ->get('/users/{id}', [UserController::class, 'getUserById'])->addPatterns(['id' => '\d+'])
        ->get('/user/search/{email}', [UserController::class, 'getUserByEmail'])
            ->addPatterns(['email' => '\\S+@\\S+\\.\\S+'])
        ->put('/user/', [UserController::class, 'update'])
        ->delete('/user/{id}', [UserController::class, 'delete'])->addPatterns(['id' => '\d+'])
    ;

    /** LOGOUT */
    $router
        ->get('/logout', [UserController::class, 'logout'])
    ;

    /** FILES ROUTER */
    $router
        ->get('/file/', [FileController::class, 'getAllFiles'])
        ->get('/file/{id}', [FileController::class, 'getFile'])->addPatterns(['id' => '\d+'])
        ->post('/file/', [FileController::class, 'create'])
        ->put('/file/', [FileController::class, 'update'])
        ->delete('file/{id}', [FileController::class, 'delete'])->addPatterns(['id' => '\d+'])
    ;

    /** SHARE FILES ROUTER */
    $router
        ->get('/files/share/{id}', [FileController::class, 'getUsersWithAccess'])
            ->addPatterns(['id' => '\d+'])
        ->put('/files/share/{id}/{user_id}', [FileController::class, 'updateAccess'])
            ->addPatterns(['id' => '\d+', 'user_id' => '\d+'])
        ->delete('/files/share/{id}/{user_id}', [FileController::class, 'deleteAccess'])
            ->addPatterns(['id' => '\d+', 'user_id' => '\d+'])
    ;

    /** DIRECTORIES ROUTER */
    $router
        ->get('/directory/{id}', [DirectoryController::class, 'getFiles'])->addPatterns(['id' => '\d+'])
        ->post('/directory/', [DirectoryController::class, 'create'])
        ->put('/directory/', [DirectoryController::class, 'update'])
        ->delete('/directory/{id}', [DirectoryController::class, 'delete'])->addPatterns(['id' => '\d+'])
    ;

    if ($_SESSION['is_admin']) {
        $router
            ->get('/admin/user/', [AdminController::class, 'getAllUsers'])
            ->get('/admin/user/{id}', [AdminController::class, 'getUser'])->addPatterns(['id' => '\d+'])
            ->delete('/admin/user/{id}', [AdminController::class, 'delete'])->addPatterns(['id' => '\d+'])
            ->put('/admin/user/', [AdminController::class, 'update'])
        ;
    }
}

(new App(
    $router,
    [
        'uri' => $_SERVER['REQUEST_URI'],
        'method' => strtolower($_SERVER['REQUEST_METHOD'])
    ],
    new Config($_ENV)
))->run();
