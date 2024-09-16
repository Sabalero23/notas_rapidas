<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutorial - Sistema de Notas Rápidas</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
    <style>
        .tutorial-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .tutorial-section {
            margin-bottom: 30px;
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .tutorial-section h2 {
            color: #007bff;
            margin-bottom: 15px;
        }
        .tutorial-section p {
            margin-bottom: 10px;
        }
        .tutorial-section ul {
            padding-left: 20px;
        }
        .tutorial-section li {
            margin-bottom: 5px;
        }
        .tutorial-image {
            max-width: 100%;
            height: auto;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .back-to-dashboard {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        .back-to-dashboard:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="tutorial-container">
        <h1>Tutorial del Sistema de Notas Rápidas</h1>

        <div class="tutorial-section">
            <h2>1. Inicio de Sesión</h2>
            <p>Para acceder al sistema, siga estos pasos:</p>
            <ol>
                <li>Ingrese a la página principal del sistema.</li>
                <li>Verá un teclado numérico en la pantalla.</li>
                <li>Ingrese su código de 6 dígitos utilizando el teclado numérico.</li>
                <li>Presione el botón "⏎" para iniciar sesión.</li>
            </ol>
            <p>Si el código es correcto, será redirigido al dashboard principal.</p>
        </div>

        <div class="tutorial-section">
            <h2>2. Dashboard Principal</h2>
            <p>En el dashboard principal encontrará:</p>
            <ul>
                <li>Una lista de sus notas existentes.</li>
                <li>Un menú de navegación en la parte inferior de la pantalla.</li>
            </ul>
            <p>El menú de navegación contiene las siguientes opciones:</p>
            <ul>
                <li><i class="fas fa-plus"></i> Crear una nueva nota</li>
                <li><i class="fas fa-search"></i> Buscar notas</li>
                <li><i class="fas fa-sort"></i> Ordenar notas</li>
                <li><i class="fas fa-user-edit"></i> Editar perfil (solo para usuarios no administradores)</li>
                <li><i class="fas fa-cog"></i> Configuraciones</li>
                <li><i class="fas fa-sign-out-alt"></i> Cerrar sesión</li>
            </ul>
        </div>

        <div class="tutorial-section">
            <h2>3. Crear una Nueva Nota</h2>
            <p>Para crear una nueva nota:</p>
            <ol>
                <li>Haga clic en el botón <i class="fas fa-plus"></i> del menú de navegación.</li>
                <li>Se abrirá una ventana modal con un campo de texto.</li>
                <li>Escriba el contenido de su nota en el campo de texto.</li>
                <li>Si desea adjuntar una imagen, haga clic en "Seleccionar archivo" y elija una imagen de su dispositivo.</li>
                <li>Haga clic en "Guardar" para crear la nota.</li>
            </ol>
        </div>

        <div class="tutorial-section">
            <h2>4. Editar una Nota Existente</h2>
            <p>Para editar una nota existente:</p>
            <ol>
                <li>En el dashboard, localice la nota que desea editar.</li>
                <li>Haga clic en el botón de edición <i class="fas fa-edit"></i> en la nota.</li>
                <li>Se abrirá una ventana modal con el contenido actual de la nota.</li>
                <li>Realice los cambios deseados en el texto o la imagen.</li>
                <li>Haga clic en "Guardar" para actualizar la nota.</li>
            </ol>
        </div>

        <div class="tutorial-section">
            <h2>5. Eliminar una Nota</h2>
            <p>Para eliminar una nota:</p>
            <ol>
                <li>En el dashboard, localice la nota que desea eliminar.</li>
                <li>Haga clic en el botón de eliminar <i class="fas fa-trash"></i> en la nota.</li>
                <li>Confirme la acción cuando se le solicite.</li>
            </ol>
        </div>

        <div class="tutorial-section">
            <h2>6. Buscar Notas</h2>
            <p>Para buscar notas:</p>
            <ol>
                <li>Haga clic en el botón de búsqueda <i class="fas fa-search"></i> en el menú de navegación.</li>
                <li>Se abrirá una ventana modal con un campo de búsqueda.</li>
                <li>Ingrese el término de búsqueda y presione "Buscar".</li>
                <li>Las notas que coincidan con el término de búsqueda se mostrarán en el dashboard.</li>
            </ol>
        </div>

        <div class="tutorial-section">
            <h2>7. Ordenar Notas</h2>
            <p>Para ordenar sus notas alfabéticamente:</p>
            <ol>
                <li>Haga clic en el botón de ordenar <i class="fas fa-sort"></i> en el menú de navegación.</li>
                <li>Las notas se reorganizarán automáticamente en orden alfabético.</li>
            </ol>
        </div>

        <div class="tutorial-section">
            <h2>8. Editar Perfil (Solo para usuarios no administradores)</h2>
            <p>Para editar su perfil:</p>
            <ol>
                <li>Haga clic en el botón de editar perfil <i class="fas fa-user-edit"></i> en el menú de navegación.</li>
                <li>Se le redirigirá a la página de edición de perfil.</li>
                <li>Ingrese su código actual para confirmar su identidad.</li>
                <li>Ingrese su nuevo nombre de usuario y/o nuevo código.</li>
                <li>Haga clic en "Actualizar Perfil" para guardar los cambios.</li>
            </ol>
        </div>

        <div class="tutorial-section">
            <h2>9. Configuraciones</h2>
            <p>Para cambiar la configuración del sistema:</p>
            <ol>
                <li>Haga clic en el botón de configuraciones <i class="fas fa-cog"></i> en el menú de navegación.</li>
                <li>Se abrirá una ventana modal con opciones de configuración.</li>
                <li>Actualmente, puede cambiar el tema entre claro y oscuro.</li>
                <li>Seleccione el tema deseado y haga clic en "Guardar".</li>
            </ol>
        </div>

        <div class="tutorial-section">
            <h2>10. Cerrar Sesión</h2>
            <p>Para cerrar sesión en el sistema:</p>
            <ol>
                <li>Haga clic en el botón de cerrar sesión <i class="fas fa-sign-out-alt"></i> en el menú de navegación.</li>
                <li>Será redirigido a la página de inicio de sesión.</li>
            </ol>
        </div>

        <a href="dashboard.php" class="back-to-dashboard">Volver al Dashboard</a>
    </div>
</body>
</html>