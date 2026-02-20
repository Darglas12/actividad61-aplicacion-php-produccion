# Aplicación CRUD PS5 - Guía de Uso

## Descripción
Aplicación web desarrollada en PHP con MySQL para gestionar una base de datos de videojuegos de PS5. Incluye autenticación de usuarios, CRUD completo (Create, Read, Update, Delete) y diseño PS5-temático.

## Características
- ✅ Autenticación segura con contraseñas hasheadas (bcrypt)
- ✅ CRUD completo para videojuegos
- ✅ Registro de nuevos usuarios
- ✅ Prepared statements para prevenir SQL injection
- ✅ Diseño PS5-temático con glassmorphism
- ✅ Sistema de sesiones
- ✅ Bootstrap 5 para responsive design

## Requisitos
- Docker
- Docker Compose

## Instalación y Ejecución

### 1. Iniciar los contenedores
```bash
cd /home/ubuntu/actividad61-aplicacion-php-desarrollo
docker-compose up -d
```

### 2. Verificar que los contenedores están corriendo
```bash
docker-compose ps
```

Deberías ver dos contenedores:
- `apache-php-crud` (Puerto 80)
- `mariadb-crud` (Puerto 3306)

### 3. Acceder a la aplicación
Abre tu navegador y ve a:
```
http://localhost
```

## Usuarios de Prueba
La aplicación viene preconfigurada con 5 usuarios:

| Usuario | Contraseña | Email |
|---------|-----------|-------|
| admin | admin123 | admin@example.com |
| usuario1 | user123 | user1@example.com |
| diego | 2402 | diego@example.com |
| tester | test123 | tester@example.com |
| player | play123 | player@example.com |

## Flujo de la Aplicación

### 1. Login
- Página de inicio permite iniciar sesión con **usuario o email**
- Contraseñas están hasheadas con bcrypt
- Acceso denegado si credenciales son incorrectas

### 2. Registro
- Opción para crear nuevos usuarios
- Validación de duplicados (usuario y email)
- Contraseñas hasheadas automáticamente

### 3. Página Principal (Home)
Una vez logueado, se visualiza:
- Tabla con todos los videojuegos de PS5
- Botones para editar cada juego
- Botones para eliminar cada juego
- Botón para añadir nuevo juego

### 4. Añadir Videojuego
Formulario para crear un nuevo juego con:
- **Título** (único, no puede repetirse)
- **Género** (acción, RPG, deportes, etc.)
- **Precio** (número decimal)
- **Plataforma** (PS5)
- **Año de Lanzamiento** (año)
- **Stock** (cantidad disponible)

### 5. Editar Videojuego
Permite modificar:
- Género
- Precio
- Plataforma
- Año de lanzamiento
- Stock

*Nota: El título no es editable por que es UNIQUE*

### 6. Eliminar Videojuego
Elimina el videojuego de la base de datos

### 7. Logout
Cierra la sesión y vuelve a la página de login

## Estructura de Bases de Datos

### Tabla: usuarios
```sql
CREATE TABLE usuarios (
    usuario_id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_usuario VARCHAR(50) UNIQUE NOT NULL,
    contrasena VARCHAR(255) NOT NULL,
    correo VARCHAR(100) UNIQUE NOT NULL,
    creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### Tabla: videojuegos
```sql
CREATE TABLE videojuegos (
    videojuego_id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(100) UNIQUE NOT NULL,
    genero VARCHAR(50),
    precio DECIMAL(8, 2),
    plataforma VARCHAR(20),
    lanzamiento YEAR,
    stock INT
);
```

## Archivos Principales

| Archivo | Función |
|---------|---------|
| `index.php` | Página principal/login |
| `login.php` | Formulario de login |
| `login_action.php` | Procesamiento de login con autenticación |
| `registro.php` | Formulario de registro |
| `registro_action.php` | Procesamiento de registro |
| `home.php` | Página con lista de videojuegos |
| `add.php` | Formulario para añadir juego |
| `add_action.php` | Procesamiento de adición |
| `edit.php` | Formulario para editar juego |
| `edit_action.php` | Procesamiento de edición |
| `delete.php` | Eliminación de juego |
| `logout.php` | Cierre de sesión |
| `config.php` | Configuración de base de datos |

## Configuración de Base de Datos

Las credenciales se configuran en `.env`:

```env
MARIADB_HOST=mariadb-crud
MARIADB_DATABASE=ps5crud
MARIADB_USER=usuario
MARIADB_PASSWORD=usuario@1
MARIADB_ROOT_PASSWORD=rootpass
```

## Seguridad

### Medidas Implementadas:
1. **Hashing de contraseñas**: Uso de `password_hash()` con bcrypt
2. **Verificación**: `password_verify()` para validar contraseñas
3. **Prepared Statements**: Prevención de SQL injection
4. **Sesiones**: Autenticación basada en sesiones
5. **Validación de entrada**: Validación de campos requeridos

## Troubleshooting

### Los contenedores no inician
```bash
docker-compose down -v
docker-compose up -d
```

### No puedo conectar a la base de datos
- Verifica que los contenedores estén corriendo: `docker-compose ps`
- Verifica los logs: `docker-compose logs mariadb-crud`

### El login no funciona
- Verifica que el usuario existe: `docker-compose exec mariadb-crud mariadb -u root -prootpass ps5crud -e "SELECT nombre_usuario FROM usuarios;"`
- Probado con usuario `diego` y contraseña `2402`

### Ver logs de la aplicación
```bash
docker-compose logs apache-php-crud
```

## Acceso a la Base de Datos

Para acceder directamente a MariaDB:
```bash
docker-compose exec mariadb-crud mariadb -u usuario -pusuario@1 ps5crud
```

## Puerto de Acceso
- **Aplicación Web**: http://localhost:80
- **MariaDB**: localhost:3306

## Desinstalar

Para eliminar todos los contenedores y volúmenes:
```bash
docker-compose down -v
```

---

**Desarrollado**: PHP 8.2 + MariaDB 12.2.2 + Docker
**Tema**: PS5 Gaming CRUD
**Última actualización**: 2024
