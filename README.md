# Sistema de Notas Rápidas

## Descripción
Este es un sistema de notas rápidas desarrollado en PHP. Permite a los usuarios crear, editar, eliminar, buscar y compartir notas, así como adjuntar imágenes a las mismas. El sistema incluye autenticación de usuarios, roles de usuario (admin y user), un panel de administración para gestionar usuarios y la capacidad de compartir notas entre usuarios.

## Características principales
- Autenticación de usuarios mediante código numérico
- Creación, edición y eliminación de notas
- Compartir notas entre usuarios
- Adjuntar imágenes a las notas
- Búsqueda y ordenación de notas
- Cambio de tema (claro/oscuro)
- Panel de administración para gestionar usuarios
- Perfil de usuario editable (para usuarios no administradores)
- Diseño responsive para dispositivos móviles

## Actualizaciones recientes
- Compartir notas: Los usuarios pueden ahora compartir sus notas con otros usuarios del sistema.
- Visualización de notas compartidas: Los usuarios pueden ver tanto sus propias notas como las que otros han compartido con ellos.
- Control de visibilidad: Se ha añadido un botón para mostrar/ocultar las notas compartidas por otros usuarios.
- Información de propiedad: Cada nota muestra el nombre del propietario y el número de usuarios con los que se ha compartido.
- Selección de usuarios para compartir: Al compartir una nota, se muestra una lista desplegable con los usuarios disponibles.
- Inicialización mejorada: Las notas compartidas ahora están ocultas por defecto al iniciar sesión.

## Requisitos del sistema
- PHP 7.4 o superior
- Servidor web (por ejemplo, Apache)
- Permisos de escritura en el directorio de la aplicación para guardar notas e imágenes
- Configuración adecuada de permisos para permitir la escritura en archivos de notas de otros usuarios

## Estructura de directorios
```
/var/www/
├── html/  (directorio público)
│   ├── dashboard.php
│   ├── dashboard.js
│   ├── delete_note.php
│   ├── get_notes.php
│   ├── get_users.php
│   ├── index.php
│   ├── login.php
│   ├── logout.php
│   ├── save_note.php
│   ├── share_note.php
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
6. Asegúrese de que PHP tenga permisos para escribir en los archivos de notas de todos los usuarios.

## Uso
1. Acceda a la aplicación a través de su navegador web.
2. Inicie sesión con el código de usuario.
3. Use el panel de navegación para crear notas, buscar, cambiar la configuración o administrar usuarios (si es administrador).
4. Para compartir una nota, haga clic en el icono de compartir en la nota deseada y seleccione el usuario con el que desea compartirla de la lista desplegable.
5. Use el botón "Mostrar notas compartidas" / "Ocultar notas compartidas" en la parte superior de la página para controlar la visibilidad de las notas compartidas por otros usuarios.

## Compartir notas
- Cada nota tiene un botón de compartir representado por un icono.
- Al hacer clic en este botón, se abre un modal con una lista desplegable de usuarios disponibles.
- Solo el propietario de una nota puede compartirla.
- Los usuarios pueden ver tanto sus propias notas como las que otros han compartido con ellos.
- Cada nota muestra el nombre del propietario y el número de usuarios con los que se ha compartido.
- Los usuarios pueden ocultar o mostrar las notas compartidas por otros usuarios utilizando el botón de toggle en la parte superior de la página.
- Por defecto, las notas compartidas están ocultas al iniciar sesión.

## Seguridad
- Asegúrese de cambiar el código del usuario administrador después de la primera instalación.
- Mantenga el directorio `private/` fuera del alcance público.
- Considere implementar HTTPS para una comunicación segura.
- Configure adecuadamente los permisos de los archivos para evitar accesos no autorizados.

## Contribución
Las contribuciones son bienvenidas. Por favor, abra un issue o realice un pull request para sugerir cambios o mejoras.

## Licencia
[MIT License](https://opensource.org/licenses/MIT)