<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Auth\Auth;
use App\Controllers\UserController;

Auth::startSession();

if (!Auth::checkAdmin()) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new UserController();
    $controller->store($_POST);
    header('Location: index.php');
    exit;
}
?>
<h1>Ajouter un utilisateur</h1>
<form method="POST" enctype="multipart/form-data">
    Nom: <input type="text" name="name" required><br><br>
    Email: <input type="email" name="email" required><br><br>
    Mot de passe: <input type="password" name="password" required><br><br>
    Rôle: 
    <select name="role">
        <option value="user">Utilisateur</option>
        <option value="admin">Admin</option>
    </select><br><br>
    <input type="file" name="profilePicture" size="5" required><br><br>
    <button type="submit">Ajouter</button>
</form>
