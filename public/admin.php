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
$users = $controller->index();
?>

<h1>👑 Panel Administrateur</h1>
<p>Connecté en tant que : <?= htmlspecialchars($_SESSION['user']['email']) ?></p>
<a href="logout.php">🚪 Déconnexion</a>
<hr>

<h2>Liste des utilisateurs</h2>
<table border="1" cellpadding="5">
    <tr>
        <th>ID</th><th>Photo</th><th>Nom</th><th>Email</th><th>Actions</th>
    </tr>
    <?php foreach ($users as $u): ?>
        <tr>
            <td><?= $u['id'] ?></td>
            <td style="text-align: center;">
                <?php if (!empty($u['profile_picture'])): ?>
                    <img src="<?= htmlspecialchars($u['profile_picture']) ?>" alt="Photo de profil" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover; display: block; margin: 0 auto;">
                <?php else: ?>
                    <span>Aucune photo</span>
                <?php endif; ?>
            </td>
            <td><?= htmlspecialchars($u['name']) ?></td>
            <td><?= htmlspecialchars($u['email']) ?></td>
            <td>
                <a href="editUser.php?id=<?= $u['id'] ?>">✏️ Modifier</a> |
                <a href="deleteUser.php?id=<?= $u['id'] ?>" onclick="return confirm('Supprimer cet utilisateur ?')">🗑️ Supprimer</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<hr>
<a href="addUser.php">➕ Ajouter un nouvel utilisateur</a>
