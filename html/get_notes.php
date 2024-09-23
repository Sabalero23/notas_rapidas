<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    die(json_encode(['error' => 'No autorizado']));
}

$userId = $_SESSION['user_id'];
$notesFile = __DIR__ . "/../private/notes_{$userId}.json";
$usersFile = __DIR__ . "/../private/users.php";

if (!file_exists($notesFile)) {
    die(json_encode([]));
}

$notes = json_decode(file_get_contents($notesFile), true);
$users = include $usersFile;

if ($notes === null) {
    die(json_encode(['error' => 'Error al leer las notas']));
}

// Función para obtener el nombre de usuario
function getUserName($userId, $users) {
    return $users[$userId]['username'] ?? $userId;
}

// Filtrar las notas y añadir nombres de usuario
$filteredNotes = array_map(function($note) use ($userId, $users) {
    $note['owner_name'] = getUserName($note['owner'], $users);
    $note['shared_with_names'] = array_map(function($sharedUserId) use ($users) {
        return getUserName($sharedUserId, $users);
    }, $note['shared_with'] ?? []);
    return $note;
}, array_filter($notes, function($note) use ($userId) {
    return $note['owner'] === $userId || (isset($note['shared_with']) && in_array($userId, $note['shared_with']));
}));

// Buscar notas compartidas por otros usuarios
$usersDir = __DIR__ . "/../private/";
$files = glob($usersDir . "notes_*.json");
foreach ($files as $file) {
    if ($file !== $notesFile) {
        $otherUserNotes = json_decode(file_get_contents($file), true);
        if ($otherUserNotes) {
            foreach ($otherUserNotes as $note) {
                if (isset($note['shared_with']) && in_array($userId, $note['shared_with'])) {
                    $note['owner_name'] = getUserName($note['owner'], $users);
                    $note['shared_with_names'] = array_map(function($sharedUserId) use ($users) {
                        return getUserName($sharedUserId, $users);
                    }, $note['shared_with'] ?? []);
                    $filteredNotes[] = $note;
                }
            }
        }
    }
}

die(json_encode(array_values($filteredNotes)));