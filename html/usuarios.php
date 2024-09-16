<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

$usersFile = __DIR__ . '/../private/users.php';

function getUsers() {
    global $usersFile;
    return include $usersFile;
}

function saveUsers($users) {
    global $usersFile;
    $content = "<?php\nreturn " . var_export($users, true) . ";\n";
    return file_put_contents($usersFile, $content) !== false;
}

$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $users = getUsers();

    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add':
                $newCode = trim($_POST['new_code']);
                $newUsername = trim($_POST['new_username']);
                $newRole = $_POST['new_role'];
                if (!empty($newCode) && !empty($newUsername)) {
                    $hashedCode = md5($newCode);
                    if (!isset($users[$hashedCode])) {
                        $users[$hashedCode] = ['username' => $newUsername, 'role' => $newRole];
                        if (saveUsers($users)) {
                            $message = "Usuario añadido correctamente.";
                            $messageType = "success";
                        } else {
                            $message = "Error al añadir usuario.";
                            $messageType = "error";
                        }
                    } else {
                        $message = "El código ya existe.";
                        $messageType = "error";
                    }
                } else {
                    $message = "Por favor, complete todos los campos.";
                    $messageType = "error";
                }
                break;

            case 'edit':
                $oldCode = $_POST['old_code'];
                $newCode = trim($_POST['edit_code']);
                $newUsername = trim($_POST['edit_username']);
                $newRole = $_POST['edit_role'];
                $oldHashedCode = $oldCode; // Ya está hasheado
                if (isset($users[$oldHashedCode])) {
                    unset($users[$oldHashedCode]);
                    $newHashedCode = md5($newCode);
                    $users[$newHashedCode] = ['username' => $newUsername, 'role' => $newRole];
                    if (saveUsers($users)) {
                        $message = "Usuario actualizado correctamente.";
                        $messageType = "success";
                    } else {
                        $message = "Error al actualizar usuario.";
                        $messageType = "error";
                    }
                } else {
                    $message = "Usuario no encontrado.";
                    $messageType = "error";
                }
                break;

            case 'delete':
                $codeToDelete = $_POST['delete_code'];
                if (isset($users[$codeToDelete])) {
                    unset($users[$codeToDelete]);
                    if (saveUsers($users)) {
                        $message = "Usuario eliminado correctamente.";
                        $messageType = "success";
                    } else {
                        $message = "Error al eliminar usuario.";
                        $messageType = "error";
                    }
                } else {
                    $message = "Usuario no encontrado.";
                    $messageType = "error";
                }
                break;
        }
    }
}

$users = getUsers();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de Usuarios</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <style>
        .user-management {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .user-form {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .user-form input[type="text"],
        .user-form input[type="password"],
        .user-form select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }
        .user-table {
            width: 100%;
            border-collapse: collapse;
        }
        .user-table th, .user-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }
        .user-table th {
            background-color: #e9ecef;
            font-weight: bold;
        }
        .user-actions {
            display: flex;
            gap: 10px;
        }
        .user-actions button {
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .edit-user {
            background-color: #ffc107;
            color: #212529;
        }
        .delete-user {
            background-color: #dc3545;
            color: white;
        }
        .message {
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .message.success {
            background-color: #d4edda;
            color: #155724;
        }
        .message.error {
            background-color: #f8d7da;
            color: #721c24;
        }
        @media (max-width: 768px) {
            .user-table, .user-table thead, .user-table tbody, .user-table th, .user-table td, .user-table tr {
                display: block;
            }
            .user-table thead tr {
                position: absolute;
                top: -9999px;
                left: -9999px;
            }
            .user-table tr {
                border: 1px solid #ccc;
                margin-bottom: 10px;
            }
            .user-table td {
                border: none;
                position: relative;
                padding-left: 50%;
            }
            .user-table td:before {
                content: attr(data-label);
                position: absolute;
                left: 6px;
                width: 45%;
                padding-right: 10px;
                white-space: nowrap;
                font-weight: bold;
            }
            .user-actions {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="user-management">
        <h1>Administración de Usuarios</h1>
        
        <?php if (!empty($message)): ?>
            <div class="message <?php echo $messageType; ?>"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <h2>Añadir Usuario</h2>
        <form method="post" class="user-form">
            <input type="hidden" name="action" value="add">
            <input type="text" name="new_username" placeholder="Nombre de Usuario" required>
            <input type="password" name="new_code" placeholder="Código" required>
            <select name="new_role" required>
                <option value="user">Usuario</option>
                <option value="admin">Administrador</option>
            </select>
            <button type="submit">Añadir Usuario</button>
        </form>

        <h2>Usuarios Existentes</h2>
        <div class="table-responsive">
            <table class="user-table">
                <thead>
                    <tr>
                        <th>Nombre de Usuario</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $code => $user): ?>
                    <tr>
                        <td data-label="Nombre de Usuario"><?php echo htmlspecialchars($user['username']); ?></td>
                        <td data-label="Rol"><?php echo htmlspecialchars($user['role']); ?></td>
                        <td data-label="Acciones">
                            <div class="user-actions">
                                <form method="post" style="display:inline;">
                                    <input type="hidden" name="action" value="edit">
                                    <input type="hidden" name="old_code" value="<?php echo htmlspecialchars($code); ?>">
                                    <input type="text" name="edit_username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                                    <input type="password" name="edit_code" placeholder="Nuevo Código" required>
                                    <select name="edit_role" required>
                                        <option value="user" <?php echo $user['role'] == 'user' ? 'selected' : ''; ?>>Usuario</option>
                                        <option value="admin" <?php echo $user['role'] == 'admin' ? 'selected' : ''; ?>>Administrador</option>
                                    </select>
                                    <button type="submit" class="edit-user">Editar</button>
                                </form>
                                <form method="post" style="display:inline;">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="delete_code" value="<?php echo htmlspecialchars($code); ?>">
                                    <button type="submit" class="delete-user" onclick="return confirm('¿Estás seguro de que quieres eliminar este usuario?');">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="back-link">
            <a href="dashboard.php">Volver al Dashboard</a>
        </div>
    </div>
</body>
</html>