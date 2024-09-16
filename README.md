# Sistema de Notas Rápidas

## Descripción
Este es un sistema de notas rápidas desarrollado en PHP. Permite a los usuarios crear, editar, eliminar y buscar notas, así como adjuntar imágenes a las mismas. El sistema incluye autenticación de usuarios, roles de usuario (admin y user), y un panel de administración para gestionar usuarios.

## Características principales
- Autenticación de usuarios mediante código numérico
- Creación, edición y eliminación de notas
- Adjuntar imágenes a las notas
- Búsqueda y ordenación de notas
- Cambio de tema (claro/oscuro)
- Panel de administración para gestionar usuarios
- Perfil de usuario editable (para usuarios no administradores)
- Diseño responsive para dispositivos móviles

## Requisitos del sistema
- PHP 7.4 o superior
- Servidor web (por ejemplo, Apache)
- Permisos de escritura en el directorio de la aplicación para guardar notas e imágenes

## Estructura de directorios
```
/var/www/
├── html/  (directorio público)
│   ├── dashboard.php
│   ├── dashboard.js
│   ├── delete_note.php
│   ├── get_notes.php
│   ├── index.php
│   ├── login.php
│   ├── logout.php
│   ├── save_note.php
│   ├── script.js
│   ├── styles.css
│   ├── usuarios.php
│   └── profile.php
├── uploads/
└── private/
    ├── .htaccess
    └── users.php
```

## Instalación
1. Clone o descargue este repositorio en su servidor web.
2. Asegúrese de que el directorio `uploads/` tenga permisos de escritura.
3. Configure su servidor web para que el directorio `html/` sea el directorio raíz público.
4. Asegúrese de que el archivo `.htaccess` en el directorio `private/` esté configurado correctamente para denegar el acceso directo.
5. Cree un archivo `users.php` en el directorio `private/` con al menos un usuario administrador.

## Configuración inicial
Edite el archivo `private/users.php` para añadir el primer usuario administrador:

```php
<?php
return array(
  md5('123456') => array(
    'username' => 'Admin',
    'role' => 'admin',
  ),
);
```

## Uso
1. Acceda a la aplicación a través de su navegador web.
2. Inicie sesión con el código de usuario (en este ejemplo, '123456').
3. Use el panel de navegación para crear notas, buscar, cambiar la configuración o administrar usuarios (si es administrador).

## Seguridad
- Asegúrese de cambiar el código del usuario administrador después de la primera instalación.
- Mantenga el directorio `private/` fuera del alcance público.
- Considere implementar HTTPS para una comunicación segura.

## Contribución
Las contribuciones son bienvenidas. Por favor, abra un issue o realice un pull request para sugerir cambios o mejoras.

## Licencia
[MIT License](https://opensource.org/licenses/MIT)