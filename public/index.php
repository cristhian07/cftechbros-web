<?php
/**
 * public/index.php
 * Archivo principal de entrada (Front Controller) de la aplicación PHP MVC para CFTechBros.
 * Este archivo es el punto de entrada para todas las solicitudes web.
 */

// Define el directorio raíz de la aplicación
// ROOT_PATH debe apuntar a la carpeta 'cftechbros-website/'
define('ROOT_PATH', __DIR__ . '/../');

// Define la ruta base para las URLs. ¡Importante configurar esto correctamente!
// Si accedes como `http://localhost/cftechbros-web/public/`, entonces la base es `/cftechbros-web/public/`
define('BASE_URL', '/cftechbros-web/public/'); 

// Habilitar la visualización de errores (solo para desarrollo, deshabilitar en producción)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Autocargador de clases
// Este cargador automático busca las clases en la estructura de carpetas `app/`
spl_autoload_register(function ($class) {
    // Convierte el namespace a ruta de archivo.
    // Asegura que 'App\' del namespace se mapee a 'app/' en la ruta del archivo.
    // Esto es vital para sistemas de archivos sensibles a mayúsculas/minúsculas.
    $file = ROOT_PATH . str_replace('App\\', 'app/', $class) . '.php';
    // Además, convierte cualquier otra barra invertida a barra normal
    $file = str_replace('\\', '/', $file); 

    // Línea de depuración para ver qué ruta está intentando cargar el autocargador
    // echo "DEBUG Autoloader: Intentando cargar: " . $file . "<br>";

    if (file_exists($file)) {
        require_once $file;
    } else {
        // Opcional: Para depuración, puedes ver qué clase no se encontró y la ruta esperada
        // echo "DEBUG Autoloader: Clase no encontrada: " . $class . " en ruta esperada: " . $file . "<br>";
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

// Rutas del Formulario de Contacto
$router->get('/contact', 'ContactController@showContactForm');
$router->post('/contact', 'ContactController@submitContactForm');

// Rutas de Usuario Autenticado (requieren que el usuario haya iniciado sesión)
$router->get('/dashboard', 'DashboardController@index'); // Muestra el dashboard del usuario
$router->get('/logout', 'AuthController@logout');       // Procesa el cierre de sesión

$router->get('/admin/contacts', 'AdminController@showContacts'); // Muestra los mensajes de contacto


// Rutas de administración
$router->get('/admin/contacts', 'AdminController@showContacts');
$router->post('/admin/contacts/update-status', 'AdminController@updateStatus');
$router->post('/admin/contacts/delete', 'AdminController@deleteContact'); // Esta es la ruta que necesitas


// Dispatch de la solicitud
// Este método analiza la URL actual y el método de la solicitud (GET, POST, etc.)
// para llamar al controlador y método apropiados.
$router->dispatch();
