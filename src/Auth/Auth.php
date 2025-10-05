<?php
namespace App\Auth;

use App\Models\User;

class Auth {

    public static function startSession(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function login(string $email, string $password): bool {
        self::startSession();

        $userModel = new User();
        $user = $userModel->getByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = [
                'id' => $user['id'],
                'email' => $user['email'],
                'role' => $user['role'],
                'name' => $user['name']
            ];
            return true;
        }

        return false;
    }

    public static function checkAdmin(): bool {
        self::startSession();
        return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
    }

    public static function logout(): void {
        self::startSession();
        session_destroy();
    }
}
