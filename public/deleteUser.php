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
$controller->destroy($id);

header('Location: index.php');
exit;
