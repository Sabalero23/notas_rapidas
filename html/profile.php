<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: index.php");
    exit();
}

$usersFile = __DIR__ . '/../private/users.php';
$users = include $usersFile;

$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $currentCode = $_POST['current_code'];
    $newUsername = trim($_POST['new_username']);
    $newCode = trim($_POST['new_code']);

    $currentHashedCode = md5($currentCode);

    if (isset($users[$currentHashedCode]) && $users[$currentHashedCode]['username'] === $_SESSION['username']) {
        if (!empty($newUsername) && !empty($newCode)) {
            $newHashedCode = md5($newCode);
            
            // Actualizar el nombre de usuario y el código
            unset($users[$currentHashedCode]);
            $users[$newHashedCode] = [
                'username' => $newUsername,
                'role' => 'user'
            ];

            $content = "<?php\nreturn " . var_export($users, true) . ";\n";
            if (file_put_contents($usersFile, $content) !== false) {
                $_SESSION['username'] = $newUsername;
                $_SESSION['user_id'] = $newHashedCode;
                $message = "Perfil actualizado correctamente.";
                $messageType = "success";
            } else {
                $message = "Error al actualizar el perfil.";
                $messageType = "error";
            }
        } else {
            $message = "Por favor, complete todos los campos.";
            $messageType = "error";
        }
    } else {
        $message = "Código actual incorrecto.";
        $messageType = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Editar Perfil</h1>
        
        <?php if (!empty($message)): ?>
            <div class="message <?php echo $messageType; ?>"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <form method="post">
            <input type="password" name="current_code" placeholder="Código Actual" required>
            <input type="text" name="new_username" placeholder="Nuevo Nombre de Usuario" required>
            <input type="password" name="new_code" placeholder="Nuevo Código" required>
            <button type="submit">Actualizar Perfil</button>
        </form>

        <div class="back-link">
            <a href="dashboard.php">Volver al Dashboard</a>
        </div>
    </div>
</body>
</html>