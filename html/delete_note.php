<?php
session_start();
header('Content-Type: application/json');

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

if ($noteId === null) {
    die(json_encode(['success' => false, 'message' => 'ID de nota no proporcionado']));
}

// Buscar la nota por su ID
$noteIndex = false;
foreach ($notes as $index => $note) {
    if ($note['id'] === $noteId) {
        $noteIndex = $index;
        break;
    }
}

if ($noteIndex !== false) {
    $note = $notes[$noteIndex];
    if ($note['owner'] !== $userId) {
        die(json_encode(['success' => false, 'message' => 'No tienes permiso para eliminar esta nota']));
    }
    
    if (isset($note['image'])) {
        $imagePath = __DIR__ . '/' . $note['image'];
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }
    
    array_splice($notes, $noteIndex, 1);
    
    if (file_put_contents($notesFile, json_encode($notes, JSON_PRETTY_PRINT)) === false) {
        die(json_encode(['success' => false, 'message' => 'Error al guardar los cambios']));
    }
    
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Nota no encontrada']);
}