<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    die(json_encode(['success' => false, 'message' => 'No autorizado']));
}

$userId = $_SESSION['user_id'];
$notesFile = __DIR__ . "/../private/notes_{$userId}.json";

$notes = file_exists($notesFile) ? json_decode(file_get_contents($notesFile), true) : [];

$noteText = $_POST['text'] ?? '';
$noteId = $_POST['id'] ?? null;

$noteData = ['text' => $noteText, 'timestamp' => time()];

if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
    $imageDir = __DIR__ . "/uploads/{$userId}/";
    if (!is_dir($imageDir)) {
        mkdir($imageDir, 0755, true);
    }

    $imageFile = $imageDir . basename($_FILES['image']['name']);
    if (move_uploaded_file($_FILES['image']['tmp_name'], $imageFile)) {
        $noteData['image'] = "uploads/{$userId}/" . basename($_FILES['image']['name']);
    }
}

if ($noteId !== null && isset($notes[$noteId])) {
    $notes[$noteId] = $noteData;
} else {
    $notes[] = $noteData;
}

if (file_put_contents($notesFile, json_encode($notes)) === false) {
    die(json_encode(['success' => false, 'message' => 'Error al guardar la nota']));
}

echo json_encode(['success' => true]);