<?php

require_once __DIR__ . '/../core/Database.php';

class UserModel {
    private $pdo;

    public function __construct($pdo){
        $this->pdo = $pdo;
    }

    public function create($email, $username, $password) {
        $stmt = $this->pdo->prepare("INSERT INTO users (email, username, password) VALUES (?, ?, ?)");
        return $stmt->execute([$email, $username, $password]);
    }

    public function findByEmail($email) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findByUsername($username) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateProfile($id, $username, $avatarPath = null) {
        if ($avatarPath) {
            $stmt = $this->pdo->prepare("UPDATE users SET username = ?, avatar_path = ? WHERE id = ?");
            return $stmt->execute([$username, $avatarPath, $id]);
        } else {
            $stmt = $this->pdo->prepare("UPDATE users SET username = ? WHERE id = ?");
            return $stmt->execute([$username, $id]);
        }
    }

}
