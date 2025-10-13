<?php
namespace App\Controllers;

use Dotenv\Dotenv;
use App\Models\User;
use Cloudinary\Cloudinary;
use App\Utils\AppLogger;
use Exception;

class UserController {
    private User $userModel;

    public function __construct() {

        $dotenv = Dotenv::createImmutable(dirname(__DIR__, 2));
        $dotenv->load();

        $this->userModel = new User();
    }

    public function index(): array {
        return $this->userModel->getAll();
    }

    public function getById(int $id) : ?array {
        return $this->userModel->getById($id);
    }

    public function store(array $data): bool {

        try {
            
            $cloudinary = new Cloudinary($_ENV['CLOUDINARY_URL']);

            $name = $data['name'];
            $email = $data['email'];
            $password = $data['password'];
            $role = $data['role'] ?? 'user';
            $profilePicturePath = $_FILES['profilePicture']['tmp_name'];

            $uploadResult = $cloudinary->uploadApi()->upload($profilePicturePath, [
                'folder' => 'user_profiles'
            ]);

            $profilePicture = $uploadResult['secure_url'];

            return $this->userModel->create($name, $email, $password, $role, $profilePicture);

        } catch (Exception $e) {

            AppLogger::getLogger()->error("Error creating user: " . $e->getMessage(), [
                'exception' => $e,
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return false;

        }
        
    }

    public function update(array $data): bool {
        return $this->userModel->update((int)$data['id'], $data['name'], $data['email'], $data['password'] ?? null);
    }

    public function destroy(int $id): bool {
        return $this->userModel->delete($id);
    }
}
