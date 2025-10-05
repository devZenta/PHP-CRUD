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
<form method="POST">
    Nom: <input type="text" name="name" required><br>
    Email: <input type="email" name="email" required><br>
    Mot de passe: <input type="password" name="password" required><br>
    Rôle: 
    <select name="role">
        <option value="user">Utilisateur</option>
        <option value="admin">Admin</option>
    </select><br>
    <button type="submit">Ajouter</button>
</form>
