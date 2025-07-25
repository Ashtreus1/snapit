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

    public function handleUpdate() {
        requireAuth();

        $userId = $_SESSION['user_id'];
        $username = $_POST['username'] ?? null;

        if (!$username) {
            $_SESSION['error'] = "Username is required.";
            header("Location: " . basePath('/profile'));
            exit;
        }

        $avatarPath = null;

        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/avatars/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

            $tmpName = $_FILES['avatar']['tmp_name'];
            $fileName = uniqid() . '-' . basename($_FILES['avatar']['name']);
            $targetPath = $uploadDir . $fileName;

            if (move_uploaded_file($tmpName, $targetPath)) {
                $avatarPath = $targetPath;
            }
        }

        $this->userModel->updateProfile($userId, $username, $avatarPath);

        // Refresh session data with latest user info
        $updatedUser = $this->userModel->findById($userId);
        $_SESSION['username'] = $updatedUser['username'];
        if (!empty($updatedUser['avatar_path'])) {
            $_SESSION['avatar'] = $updatedUser['avatar_path'];
        } else {
            unset($_SESSION['avatar']);
        }

        $_SESSION['success'] = "Profile updated successfully.";
        header("Location: " . basePath('/profile'));
    }


    public function handleLogout() {
        session_destroy();
        header("Location: " . basePath('/login'));
    }
}
