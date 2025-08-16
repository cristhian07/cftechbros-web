<?php
/**
 * config/database.php
 * Archivo de configuración para la conexión a la base de datos MySQL.
 *
 * IMPORTANTE:
 * Por seguridad, en un entorno de producción, estas credenciales
 * deberían cargarse desde variables de entorno o un archivo fuera
 * del control de versiones (ej. usando .env con phpdotenv).
 * Para este ejemplo, se definen directamente.
 */

// Define las constantes de conexión a la base de datos
define('DB_HOST', 'localhost'); // Host de la base de datos (generalmente 'localhost')
define('DB_NAME', 'cftechbros_db'); // Nombre de tu base de datos
define('DB_USER', 'root');      // Usuario de la base de datos (¡Cambiar en producción!)
define('DB_PASS', '');          // Contraseña del usuario de la base de datos (¡Cambiar en producción!)
