<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Auth\Auth;

Auth::startSession();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (Auth::login($email, $password)) {
        if(Auth::checkAdmin()) {
            header('Location: admin.php');
            exit;
        } else {
            header('Location: userAccount.php');
            exit;
        }
        
    } else {
        $error = "Identifiants invalides.";
    }
}
?>

<h2>Connexion</h2>
<?php if (isset($error)) echo "<p style='color:red'>$error</p>"; ?>

<form method="POST">
    <label>Email :</label>
    <input type="email" name="email" required><br>

    <label>Mot de passe :</label>
    <input type="password" name="password" required><br>

    <button type="submit">Se connecter</button>
</form>
