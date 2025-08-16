<?php
namespace App\Controllers;

/**
 * Clase BaseController
 * Clase padre para todos los controladores de la aplicación.
 * Proporciona métodos comunes como la carga de vistas y redirecciones.
 */
class BaseController
{
    /**
     * Carga una vista y le pasa datos.
     * La vista se carga dentro del layout principal.
     * @param string $path La ruta de la vista relativa a `app/Views/` (ej. 'home/index').
     * @param array $data Un array asociativo de datos a pasar a la vista.
     */
    protected function view($path, $data = [])
    {
        // Extrae el array $data para que sus claves se conviertan en variables
        // accesibles directamente en la vista (ej. $data['username'] se convierte en $username)
        extract($data);

        // Incluye el archivo de layout principal.
        // El contenido de la vista específica se cargará dentro del layout.
        require_once ROOT_PATH . 'app/Views/layout.php';
    }

    /**
     * Redirige el navegador a una URL específica.
     * @param string $url La URL a la que se desea redirigir (relativa a BASE_URL).
     */
    protected function redirect($url)
    {
        // Concatena BASE_URL con la URL proporcionada, eliminando cualquier barra inicial redundante.
        header('Location: ' . BASE_URL . ltrim($url, '/'));
        exit(); // Termina la ejecución del script después de la redirección
    }
}
