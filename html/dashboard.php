<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

function getUserNotes($userId) {
    $notesFile = __DIR__ . "/../private/notes_{$userId}.json";
    if (file_exists($notesFile)) {
        return json_decode(file_get_contents($notesFile), true);
    }
    return [];
}

$userNotes = getUserNotes($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Notas Rápidas</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="app-container">
        <header>
            <h1>Notas Rápidas</h1>
            <p>Bienvenido, <?php echo htmlspecialchars($_SESSION['username']); ?></p>
        </header>
        
        <main>
            <div id="noteContainer" class="note-container">
                <!-- Las notas se cargarán aquí dinámicamente -->
            </div>
        </main>
    </div>
    
    <nav id="mobileKeypad" class="mobile-keypad">
        <button class="keypad-btn" data-action="newNote"><i class="fas fa-plus"></i></button>
        <button class="keypad-btn" data-action="searchNotes"><i class="fas fa-search"></i></button>
        <button class="keypad-btn" data-action="sortNotes"><i class="fas fa-sort"></i></button>
        <?php if ($_SESSION['role'] === 'admin'): ?>
            <button class="keypad-btn" data-action="manageUsers"><i class="fas fa-users"></i></button>
        <?php else: ?>
            <button class="keypad-btn" data-action="editProfile"><i class="fas fa-user-edit"></i></button>
        <?php endif; ?>
        <button class="keypad-btn" data-action="settings"><i class="fas fa-cog"></i></button>
        <button class="keypad-btn" data-action="logout"><i class="fas fa-sign-out-alt"></i></button>
    </nav>

    <div id="noteModal" class="modal" style="display: none;">
        <div class="modal-content">
            <h2 id="modalTitle">Crear Nota</h2>
            <textarea id="noteText" rows="4" placeholder="Escribe tu nota aquí..."></textarea>
            <input type="file" id="noteImage" accept="image/*">
            <div class="modal-actions">
                <button id="saveNote" class="btn-primary">Guardar</button>
                <button id="closeModal" class="btn-secondary">Cancelar</button>
            </div>
        </div>
    </div>

    <div id="searchModal" class="modal" style="display: none;">
        <div class="modal-content">
            <h2>Buscar Notas</h2>
            <input type="text" id="searchInput" placeholder="Buscar...">
            <div class="modal-actions">
                <button id="performSearch" class="btn-primary">Buscar</button>
                <button id="closeSearchModal" class="btn-secondary">Cancelar</button>
            </div>
        </div>
    </div>

    <div id="settingsModal" class="modal" style="display: none;">
        <div class="modal-content">
            <h2>Configuraciones</h2>
            <label for="themeSelect">Tema:</label>
            <select id="themeSelect">
                <option value="light">Claro</option>
                <option value="dark">Oscuro</option>
            </select>
            <div class="modal-actions">
                <button id="saveSettings" class="btn-primary">Guardar</button>
                <button id="closeSettingsModal" class="btn-secondary">Cancelar</button>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>
    <script src="dashboard.js"></script>
</body>
</html>