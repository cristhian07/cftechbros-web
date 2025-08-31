<?php
/**
 * public/index.php
 * Archivo principal de entrada (Front Controller) de la aplicación PHP MVC para CFTechBros.
 * Este archivo es el punto de entrada para todas las solicitudes web.
 */

// Define el directorio raíz de la aplicación
// ROOT_PATH debe apuntar a la carpeta 'cftechbros-website/'
define('ROOT_PATH', realpath(__DIR__ . '/../') . '/');

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

// Rutas para Servicios Contratados
$router->get('/services', 'ServiceController@index'); // Muestra la lista de servicios del usuario
$router->get('/services/view', 'ServiceController@show'); // Muestra el detalle de un servicio específico

// Rutas de administración
$router->get('/admin/contacts', 'AdminController@showContacts');
$router->post('/admin/contacts/update-status', 'AdminController@updateStatus');
$router->post('/admin/contacts/delete', 'AdminController@deleteContact'); // Esta es la ruta que necesitas

// Rutas para la gestión de Roles y Permisos (accesibles solo por administradores)
$router->get('/admin/roles', 'RoleController@index'); // Listar roles
$router->get('/admin/roles/create', 'RoleController@create'); // Formulario para crear un rol
$router->post('/admin/roles/store', 'RoleController@store'); // Procesar la creación de un rol
$router->get('/admin/roles/edit', 'RoleController@edit'); // Mostrar formulario para editar un rol
$router->post('/admin/roles/update', 'RoleController@update'); // Procesar la actualización de permisos de un rol
$router->post('/admin/roles/delete', 'RoleController@delete'); // Procesar la eliminación de un rol

// Rutas para la gestión de Permisos
$router->get('/admin/permissions', 'AdminPermissionController@index');
$router->get('/admin/permissions/create', 'AdminPermissionController@create');
$router->post('/admin/permissions/store', 'AdminPermissionController@store');
$router->get('/admin/permissions/edit', 'AdminPermissionController@edit');
$router->post('/admin/permissions/update', 'AdminPermissionController@update');
$router->post('/admin/permissions/delete', 'AdminPermissionController@delete');

// Rutas para la gestión de Usuarios (accesibles solo por administradores)
$router->get('/admin/users', 'UserController@index'); // Listar usuarios
$router->get('/admin/users/create', 'UserController@create'); // Formulario para crear usuario
$router->post('/admin/users/store', 'UserController@store'); // Procesar la creación de usuario
$router->get('/admin/users/edit', 'UserController@edit'); // Mostrar formulario para editar el rol de un usuario
$router->post('/admin/users/update-role', 'UserController@updateRole'); // Procesar la actualización del rol de un usuario
$router->get('/admin/users/manage-services', 'UserController@manageServices'); // Mostrar formulario para gestionar servicios de un usuario
$router->post('/admin/users/update-services', 'UserController@updateServices'); // Procesar la actualización de servicios de un usuario
$router->post('/admin/users/delete', 'UserController@delete'); // Procesar la eliminación de un usuario

// Rutas para la gestión de Permisos de Servicios (accesibles solo por administradores)
$router->get('/admin/services', 'AdminServiceController@index'); // Listar servicios para asignarles permisos
$router->get('/admin/services/edit', 'AdminServiceController@edit'); // Formulario para editar permisos de un servicio
$router->get('/admin/services/create', 'AdminServiceController@create'); // Formulario para crear un nuevo servicio
$router->post('/admin/services/store', 'AdminServiceController@store'); // Procesar la creación de un nuevo servicio
$router->post('/admin/services/update', 'AdminServiceController@update'); // Procesar la actualización de permisos de un servicio
$router->post('/admin/services/delete', 'AdminServiceController@delete'); // Procesar la eliminación de un servicio

// Dispatch de la solicitud
// Este método analiza la URL actual y el método de la solicitud (GET, POST, etc.)
// para llamar al controlador y método apropiados.
$router->dispatch();
