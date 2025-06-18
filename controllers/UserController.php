<?php

require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../core/Database.php';

class UserController {
    private $userModel;

    public function __construct() {
        $pdo = new Database();
        $this->userModel = new UserModel($pdo->connection);
    }

    public function handleRegister() {
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirm_password'];

        if ($password !== $confirmPassword) {
            $_SESSION['error'] = "Passwords do not match.";
            header("Location: " . basePath('/register'));
            exit;
        }

        if ($this->userModel->findByEmail($email) || $this->userModel->findByUsername($username)) {
            $_SESSION['error'] = "Email or username already exists.";
            header("Location: " . basePath('/register'));
            exit;
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $this->userModel->create($email, $username, $hashedPassword);

        $_SESSION['success'] = "Registration successful! You can now log in.";
        header("Location: " . basePath('/login'));
    }

    public function handleLogin() {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = $this->userModel->findByEmail($email);

        if (!$user || !password_verify($password, $user['password'])) {
            $_SESSION['error'] = "Invalid credentials.";
            header("Location: " . basePath('/login'));
            exit;
        }

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: " . basePath('/feed'));
    }

    public function getCurrentUser()
    {
        if (!isset($_SESSION['user_id'])) return null;
        return $this->userModel->findById($_SESSION['user_id']);
    }

    public function handleLogout() {
        session_destroy();
        header("Location: " . basePath('/login'));
    }
}
