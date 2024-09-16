# Tutorial del Sistema de Notas Rápidas

## 1. Configuración inicial

### 1.1 Configuración del servidor
Asegúrese de que su servidor web esté configurado correctamente y que PHP esté instalado y funcionando. El directorio raíz del servidor web debe apuntar a la carpeta `html/` de la aplicación.

### 1.2 Configuración de permisos
Asegúrese de que el directorio `uploads/` tenga permisos de escritura:
```
chmod 755 /var/www/uploads
```

### 1.3 Configuración de usuarios
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

## 2. Inicio de sesión

1. Acceda a la aplicación a través de su navegador web.
2. Verá una pantalla de inicio de sesión con un teclado numérico.
3. Ingrese el código '123456' (o el que haya configurado) usando el teclado numérico.
4. Haga clic en el botón de entrada (⏎) para iniciar sesión.

## 3. Dashboard

Después de iniciar sesión, será dirigido al dashboard. Aquí encontrará:

- Un área principal donde se muestran sus notas.
- Una barra de navegación en la parte inferior con botones para diferentes acciones.

### 3.1 Crear una nueva nota

1. Haga clic en el botón '+' en la barra de navegación.
2. Se abrirá un modal donde puede escribir su nota.
3. Opcionalmente, puede adjuntar una imagen haciendo clic en el botón de selección de archivo.
4. Haga clic en 'Guardar' para crear la nota.

### 3.2 Editar una nota

1. En la lista de notas, haga clic en el icono de edición (lápiz) de la nota que desea modificar.
2. Se abrirá un modal con el contenido actual de la nota.
3. Realice los cambios necesarios.
4. Haga clic en 'Guardar' para actualizar la nota.

### 3.3 Eliminar una nota

1. En la lista de notas, haga clic en el icono de eliminación (papelera) de la nota que desea borrar.
2. Confirme la acción cuando se le solicite.

### 3.4 Buscar notas

1. Haga clic en el icono de búsqueda en la barra de navegación.
2. Ingrese el término de búsqueda en el campo de texto que aparece.
3. Las notas se filtrarán en tiempo real mientras escribe.

### 3.5 Ordenar notas

Haga clic en el icono de ordenación en la barra de navegación para ordenar las notas alfabéticamente.

### 3.6 Cambiar el tema

1. Haga clic en el icono de configuración en la barra de navegación.
2. En el modal que se abre, seleccione el tema deseado (claro u oscuro).
3. Haga clic en 'Guardar' para aplicar el cambio.

## 4. Administración de usuarios (solo para administradores)

Si ha iniciado sesión como administrador, verá un icono adicional en la barra de navegación para gestionar usuarios.

### 4.1 Añadir un nuevo usuario

1. En la página de administración de usuarios, encuentre el formulario "Añadir Usuario".
2. Complete el nombre de usuario, código y seleccione el rol.
3. Haga clic en "Añadir Usuario".

### 4.2 Editar un usuario existente

1. En la lista de usuarios, encuentre el usuario que desea editar.
2. Modifique los campos necesarios en la fila correspondiente.
3. Haga clic en "Editar" para guardar los cambios.

### 4.3 Eliminar un usuario

1. En la lista de usuarios, encuentre el usuario que desea eliminar.
2. Haga clic en el botón "Eliminar" en la fila correspondiente.
3. Confirme la acción cuando se le solicite.

## 5. Editar perfil (para usuarios no administradores)

Si ha iniciado sesión como usuario regular, verá un icono de perfil en la barra de navegación.

1. Haga clic en el icono de perfil.
2. En la página de edición de perfil, puede cambiar su nombre de usuario y código.
3. Ingrese su código actual para confirmar los cambios.
4. Haga clic en "Actualizar Perfil" para guardar los cambios.

## 6. Cierre de sesión

Para cerrar sesión, simplemente haga clic en el icono de salida en la barra de navegación.

Este tutorial cubre las funcionalidades básicas del Sistema de Notas Rápidas. A medida que use la aplicación, se familiarizará con su interfaz intuitiva y sus características adicionales.