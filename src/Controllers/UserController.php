<?php
namespace App\Controllers;

use App\Models\User;

class UserController {
    private User $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function index(): array {
        return $this->userModel->getAll();
    }

    public function getById(int $id) : ?array {
        return $this->userModel->getById($id);
    }

    public function store(array $data): bool {
        return $this->userModel->create($data['name'], $data['email'], $data['password'], $data['role'] ?? 'user');
    }

    public function update(array $data): bool {
        return $this->userModel->update((int)$data['id'], $data['name'], $data['email'], $data['password'] ?? null);
    }

    public function destroy(int $id): bool {
        return $this->userModel->delete($id);
    }
}
