<?php
session_start();

// Si el usuario ya está logueado, redirigir al dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

// Función para verificar las credenciales del usuario
function verifyUserCredentials($code) {
    $usersFile = __DIR__ . '/../private/users.php';
    if (!file_exists($usersFile)) {
        throw new Exception("Archivo de usuarios no encontrado");
    }
    $users = include $usersFile;
    $hashedCode = md5($code);
    return isset($users[$hashedCode]) ? $users[$hashedCode] : false;
}

// Procesar el formulario de login
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    header('Content-Type: application/json');
    try {
        $code = $_POST['code'] ?? '';
        $user = verifyUserCredentials($code);
        
        if ($user) {
            $_SESSION['user_id'] = md5($code);
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Código incorrecto']);
        }
    } catch (Exception $e) {
        error_log($e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Error del servidor. Por favor, intente más tarde.']);
    }
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Seguro</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Login Seguro</h1>
        <div id="code-display"></div>
        <div id="keypad">
            <button class="keypad-btn">1</button>
            <button class="keypad-btn">2</button>
            <button class="keypad-btn">3</button>
            <button class="keypad-btn">4</button>
            <button class="keypad-btn">5</button>
            <button class="keypad-btn">6</button>
            <button class="keypad-btn">7</button>
            <button class="keypad-btn">8</button>
            <button class="keypad-btn">9</button>
            <button class="keypad-btn clear">C</button>
            <button class="keypad-btn">0</button>
            <button class="keypad-btn enter">⏎</button>
        </div>
        <div id="message"></div>
    </div>
    <script src="script.js"></script>
</body>
</html>