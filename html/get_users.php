<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    die(json_encode(['error' => 'No autorizado']));
}

$usersFile = __DIR__ . '/../private/users.php';
$users = include $usersFile;

// Eliminar información sensible antes de enviar al frontend
foreach ($users as &$user) {
    unset($user['role']);
}

echo json_encode($users);