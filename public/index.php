<?php
/**
 * public/index.php
 * Archivo principal de entrada (Front Controller) de la aplicación PHP MVC para CFTechBros.
 * Este archivo es el punto de entrada para todas las solicitudes web.
 */

// Define el directorio raíz de la aplicación
define('ROOT_PATH', __DIR__ . '/../');

// Define la ruta base para las URLs (ajusta si es necesario para subdirectorios)
// Si tu aplicación está en http://localhost/cftechbros/, pon '/cftechbros/'
define('BASE_URL', '/'); // Para cuando public/ es la raíz del servidor

// Habilitar la visualización de errores (solo para desarrollo, deshabilitar en producción)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Autocargador de clases
// Este cargador automático busca las clases en la estructura de carpetas `app/`
spl_autoload_register(function ($class) {
    // Convierte el namespace a ruta de archivo (ej. App\Core\Router -> app/Core/Router.php)
    $file = ROOT_PATH . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

// Incluye el archivo de configuración de la base de datos
require_once ROOT_PATH . 'config/database.php';
// Incluye la clase de gestión de sesiones
require_once ROOT_PATH . 'app/Core/Session.php';

// Inicia la sesión de PHP
\App\Core\Session::start();

// Importa las clases necesarias del namespace App\Core
use App\Core\Router;
use App\Core\Session;

// Crea una instancia del router
$router = new Router();

// --- Definición de Rutas ---
// Cada ruta asocia una URL con un método de un controlador.
// Rutas Públicas (accesibles sin iniciar sesión)
$router->get('/', 'HomeController@index');              // Página principal y presentación de servicios
$router->get('/login', 'AuthController@showLoginForm'); // Muestra el formulario de login
$router->post('/login', 'AuthController@login');        // Procesa el inicio de sesión
$router->get('/register', 'AuthController@showRegisterForm'); // Muestra el formulario de registro
$router->post('/register', 'AuthController@register');    // Procesa el registro de nuevos usuarios

// Rutas de Usuario Autenticado (requieren que el usuario haya iniciado sesión)
$router->get('/dashboard', 'DashboardController@index'); // Muestra el dashboard del usuario
$router->get('/logout', 'AuthController@logout');       // Procesa el cierre de sesión

// Dispatch de la solicitud
// Este método analiza la URL actual y el método de la solicitud (GET, POST, etc.)
// para llamar al controlador y método apropiados.
$router->dispatch();
