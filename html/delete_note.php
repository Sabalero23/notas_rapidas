<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    die(json_encode(['success' => false, 'message' => 'No autorizado']));
}

$userId = $_SESSION['user_id'];
$notesFile = __DIR__ . "/../private/notes_{$userId}.json";

if (!file_exists($notesFile)) {
    die(json_encode(['success' => false, 'message' => 'No se encontraron notas']));
}

$notes = json_decode(file_get_contents($notesFile), true);

$noteId = $_POST['id'] ?? null;

if ($noteId !== null && isset($notes[$noteId])) {
    if (isset($notes[$noteId]['image'])) {
        $imagePath = __DIR__ . '/' . $notes[$noteId]['image'];
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }
    unset($notes[$noteId]);
    $notes = array_values($notes); // Reindexar el array
    file_put_contents($notesFile, json_encode($notes));
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Nota no encontrada']);
}