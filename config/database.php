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
define('DB_HOST', 'localhost'); // Generalmente se mantiene como 'localhost'
define('DB_NAME', 'cftechbr_cftechbros_db'); // El nombre COMPLETO de tu BD en cPanel
define('DB_USER', 'cftechbr_Cristhianac');      // El usuario COMPLETO de tu BD en cPanel
define('DB_PASS', 'Alianza_97');          // La contraseña que generaste en cPanel
