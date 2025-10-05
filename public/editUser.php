<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Auth\Auth;
use App\Controllers\UserController;

Auth::startSession();

if (!Auth::checkAdmin()) {
    header('Location: login.php');
    exit;
}

$controller = new UserController();

if (!isset($_GET['id'])) {
    die("❌ ID utilisateur manquant.");
}

$id = (int) $_GET['id'];
$user = $controller->getById($id);

if (!$user) {
    die("❌ Utilisateur introuvable.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->update([
        'id' => $id,
        'name' => $_POST['name'],
        'email' => $_POST['email'],
        'password' => $_POST['password'] ?? null
    ]);
    header('Location: index.php');
    exit;
}
?>
<h1>Modifier l'utilisateur</h1>

<form method="POST">
    <label>Nom :</label>
    <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required><br>

    <label>Email :</label>
    <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required><br>

    <label>Nouveau mot de passe (laisser vide pour ne pas changer) :</label>
    <input type="password" name="password"><br>

    <button type="submit">💾 Enregistrer</button>
</form>

<a href="index.php">⬅️ Retour à la liste</a>
