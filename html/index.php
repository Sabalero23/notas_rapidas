<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso Seguro - Sistema Futurista</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="keypad.css">
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h1>Acceso Seguro</h1>
            <p>Sistema de Notas Avanzado</p>
        </div>
        <div class="keypad-container">
            <div id="code-display" class="code-display">
                <span class="code-digit"></span>
                <span class="code-digit"></span>
                <span class="code-digit"></span>
                <span class="code-digit"></span>
                <span class="code-digit"></span>
                <span class="code-digit"></span>
            </div>
            <div id="keypad" class="keypad">
                <button class="keypad-btn" data-key="1">1</button>
                <button class="keypad-btn" data-key="2">2</button>
                <button class="keypad-btn" data-key="3">3</button>
                <button class="keypad-btn" data-key="4">4</button>
                <button class="keypad-btn" data-key="5">5</button>
                <button class="keypad-btn" data-key="6">6</button>
                <button class="keypad-btn" data-key="7">7</button>
                <button class="keypad-btn" data-key="8">8</button>
                <button class="keypad-btn" data-key="9">9</button>
                <button class="keypad-btn" data-key="clear"><i class="fas fa-backspace"></i></button>
                <button class="keypad-btn" data-key="0">0</button>
                <button class="keypad-btn" data-key="enter"><i class="fas fa-arrow-right"></i></button>
            </div>
        </div>
        <div id="message" class="message"></div>
    </div>
    <div class="particles" id="particles"></div>
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <script src="keypad.js"></script>
</body>
</html>