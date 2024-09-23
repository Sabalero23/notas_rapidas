<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    die(json_encode(['success' => false, 'message' => 'No autorizado']));
}

$userId = $_SESSION['user_id'];
$noteId = $_POST['noteId'] ?? '';
$shareWithUserId = $_POST['shareWithUserId'] ?? '';

if (empty($noteId) || empty($shareWithUserId)) {
    die(json_encode(['success' => false, 'message' => 'Faltan datos requeridos']));
}

// Validar que el ID del usuario con el que se quiere compartir existe
$usersFile = __DIR__ . '/../private/users.php';
$users = include $usersFile;

if (!isset($users[$shareWithUserId])) {
    die(json_encode(['success' => false, 'message' => 'El usuario con el que quieres compartir no existe']));
}

if ($shareWithUserId === $userId) {
    die(json_encode(['success' => false, 'message' => 'No puedes compartir una nota contigo mismo']));
}

$notesFile = __DIR__ . "/../private/notes_{$userId}.json";

if (!file_exists($notesFile)) {
    die(json_encode(['success' => false, 'message' => 'No se encontraron notas para este usuario']));
}

$notes = json_decode(file_get_contents($notesFile), true);

if ($notes === null) {
    die(json_encode(['success' => false, 'message' => 'Error al leer las notas']));
}

$noteToShare = null;
foreach ($notes as &$note) {
    if ($note['id'] === $noteId) {
        $noteToShare = &$note;
        break;
    }
}

if ($noteToShare === null) {
    die(json_encode(['success' => false, 'message' => 'Nota no encontrada']));
}

if (!isset($noteToShare['shared_with'])) {
    $noteToShare['shared_with'] = [];
}

if (!in_array($shareWithUserId, $noteToShare['shared_with'])) {
    $noteToShare['shared_with'][] = $shareWithUserId;
    
    // Guardar los cambios en el archivo de notas del propietario
    if (file_put_contents($notesFile, json_encode($notes, JSON_PRETTY_PRINT)) === false) {
        die(json_encode(['success' => false, 'message' => 'Error al guardar los cambios']));
    }
    
    echo json_encode(['success' => true, 'message' => 'Nota compartida exitosamente con ' . $users[$shareWithUserId]['username']]);
} else {
    echo json_encode(['success' => true, 'message' => 'La nota ya está compartida con ' . $users[$shareWithUserId]['username']]);
}