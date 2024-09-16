<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    die(json_encode([]));
}

$userId = $_SESSION['user_id'];
$notesFile = __DIR__ . "/../private/notes_{$userId}.json";

if (file_exists($notesFile)) {
    $notes = json_decode(file_get_contents($notesFile), true);
    if ($notes === null) {
        error_log("Error decodificando JSON para el usuario $userId");
        die(json_encode([]));
    }
    echo json_encode($notes);
} else {
    echo json_encode([]);
}