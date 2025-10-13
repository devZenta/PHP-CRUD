<?php
namespace App\Models;

use App\Config\Database;
use Exception;
use PDO;

class User {
    private PDO $conn;
    private string $table = 'users';

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function getAll(): array {
        $stmt = $this->conn->query("SELECT * FROM {$this->table}");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById(int $id): ?array {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function getByEmail(string $email): ?array {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function create(string $name, string $email, string $password, string $role = 'user', string $profilePicture): bool {
        $stmt = $this->conn->prepare("INSERT INTO {$this->table} (name, email, password, role, profile_picture) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$name, $email, password_hash($password, PASSWORD_DEFAULT), $role, $profilePicture]);
    }

    public function update(int $id, string $name, string $email, ?string $password = null): bool {
        if ($password) {
            $stmt = $this->conn->prepare("UPDATE {$this->table} SET name=?, email=?, password=? WHERE id=?");
            return $stmt->execute([$name, $email, password_hash($password, PASSWORD_DEFAULT), $id]);
        } else {
            $stmt = $this->conn->prepare("UPDATE {$this->table} SET name=?, email=? WHERE id=?");
            return $stmt->execute([$name, $email, $id]);
        }
    }

    public function delete(int $id): bool {
        $stmt = $this->conn->prepare("DELETE FROM {$this->table} WHERE id=?");
        return $stmt->execute([$id]);
    }
}
