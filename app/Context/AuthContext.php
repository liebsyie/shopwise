<?php
session_start();
require_once 'db.php'; // Assumes you have a DB connection here

class AuthContext {
    private $db;
    public $currentUser = null;

    public function __construct($db) {
        $this->db = $db;
        if (isset($_SESSION['user_id'])) {
            $this->currentUser = $this->getUserById($_SESSION['user_id']);
        }
    }

    public function isAuthenticated() {
        return $this->currentUser !== null;
    }

    public function login($email, $password) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && hash('sha256', $password) === $user['password']) {
            $_SESSION['user_id'] = $user['id'];
            $this->updateLastLogin($user['id']);
            $this->currentUser = $user;
            return true;
        }
        return false;
    }

    public function register($name, $email, $password) {
        // Check for existing email
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->rowCount() > 0) {
            throw new Exception("Email already registered");
        }

        $hashedPassword = hash('sha256', $password);
        $createdAt = date('Y-m-d H:i:s');
        $lastLogin = $createdAt;

        $stmt = $this->db->prepare("INSERT INTO users (name, email, password, photo_url, created_at, last_login) VALUES (?, ?, ?, '', ?, ?)");
        $stmt->execute([$name, $email, $hashedPassword, $createdAt, $lastLogin]);

        $_SESSION['user_id'] = $this->db->lastInsertId();
        $this->currentUser = $this->getUserById($_SESSION['user_id']);
        return true;
    }

    public function logout() {
        session_destroy();
        $this->currentUser = null;
    }

    public function updateProfile($updates) {
        if (!$this->currentUser) {
            throw new Exception("No user logged in");
        }

        $name = $updates['name'] ?? $this->currentUser['name'];
        $photoURL = $updates['photoURL'] ?? $this->currentUser['photo_url'];

        $stmt = $this->db->prepare("UPDATE users SET name = ?, photo_url = ? WHERE id = ?");
        $stmt->execute([$name, $photoURL, $this->currentUser['id']]);

        $this->currentUser = $this->getUserById($this->currentUser['id']);
        return true;
    }

    public function deleteAccount() {
        if (!$this->currentUser) return;

        $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$this->currentUser['id']]);

        session_destroy();
        $this->currentUser = null;
    }

    private function updateLastLogin($userId) {
        $stmt = $this->db->prepare("UPDATE users SET last_login = ? WHERE id = ?");
        $stmt->execute([date('Y-m-d H:i:s'), $userId]);
    }

    private function getUserById($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}