<?php

namespace App\Controller;

use App\Model\User;

class UserController
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

    public function create()
    {
        $email = $_POST['email'] ?? null;
        $password = base64_encode($_POST['password']) ?? null;
        $role = User::ROLE_USER;
        $id = $this->user->create($email, $password, $role);
        http_response_code(201);
        return $this->getUser($id);
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

    public function getUserByEmail(string $email)
    {
        return $this->user->findByEmail($email);
    }

    public function login()
    {
        ['email' => $email, 'password' => $pwd] = $_GET;
        $user = $this->user->findByEmail($email);
        $decodedPassword = base64_decode($user['password']);
        if ($decodedPassword !== $pwd) {
            http_response_code(401);
            throw new \Exception('Wrong password or email');
        }
        $_SESSION['is_user_login'] = true;
        $_SESSION['user_id'] = $user['id'];
        if ($user['role'] === User::ROLE_ADMIN) {
            $_SESSION['is_admin'] = true;
        }

        return true;
    }

    public function logout()
    {
        // Unset all of the session variables.
        $_SESSION = array();

        // If it's desired to kill the session, also delete the session cookie.
        // Note: This will destroy the session, and not just the session data!
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // Finally, destroy the session.
        session_destroy();

        return true;
    }

    public function resetPassword()
    {
        $to = $_GET['email'];
        $subject = $_GET['subject'];
        $message = $_GET['message'];

        $header = "From: cloudstorage@example.com\r\n";
        $header .= "Reply-To: noreply@example.com\r\n";
        $header .= "Cc: resetpassword@example.com\r\n";
        $header .= "MIME-Version: 1.0\r\n";
        $header .= "Content-type: text/html; charset=utf-8\r\n";

        if (mail($to, $subject, $message, $header)) {
            echo "Message sent successfully...";
        } else {
            echo "Message could not be sent...";
        }
    }
}
