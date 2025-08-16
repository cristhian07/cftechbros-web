<?php
namespace App\Core;

/**
 * Clase Router
 * Encargada de gestionar y despachar las rutas de la aplicación a los controladores.
 */
class Router
{
    protected $routes = []; // Array que almacena todas las rutas definidas

    /**
     * Añade una nueva ruta a la lista de rutas.
     * @param string $method El método HTTP (GET, POST).
     * @param string $uri La URI de la ruta (ej. '/', '/login').
     * @param string $controller El controlador y método a llamar (ej. 'HomeController@index').
     */
    public function add($method, $uri, $controller)
    {
        $this->routes[] = [
            'uri' => $uri,
            'controller' => $controller,
            'method' => $method
        ];
    }

    /**
     * Método abreviado para añadir rutas GET.
     * @param string $uri La URI de la ruta.
     * @param string $controller El controlador y método a llamar.
     */
    public function get($uri, $controller)
    {
        $this->add('GET', $uri, $controller);
    }

    /**
     * Método abreviado para añadir rutas POST.
     * @param string $uri La URI de la ruta.
     * @param string $controller El controlador y método a llamar.
     */
    public function post($uri, $controller)
    {
        $this->add('POST', $uri, $controller);
    }

    /**
     * Despacha la solicitud actual al controlador y método correspondientes.
     * Si no se encuentra una ruta, muestra un error 404.
     */
    public function dispatch()
    {
        // Obtiene la URI solicitada (ej. /login, /dashboard)
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        // Obtiene el método HTTP de la solicitud (GET, POST)
        $method = $_SERVER['REQUEST_METHOD'];

        // Si la aplicación no está en la raíz del servidor web (ej. http://localhost/cftechbros/)
        // se remueve el BASE_URL para que la comparación de rutas sea correcta.
        if (BASE_URL !== '/') {
            $uri = str_replace(BASE_URL, '/', $uri);
        }

        // Itera sobre las rutas definidas para encontrar una coincidencia
        foreach ($this->routes as $route) {
            // Compara la URI y el método HTTP de la solicitud con la ruta definida
            if ($route['uri'] === $uri && $route['method'] === $method) {
                // Divide la cadena del controlador (ej. 'HomeController@index' -> ['HomeController', 'index'])
                $controllerParts = explode('@', $route['controller']);
                // Construye el nombre completo de la clase del controlador con su namespace
                $controllerName = 'App\\Controllers\\' . $controllerParts[0];
                // Obtiene el nombre del método a llamar
                $methodName = $controllerParts[1];

                // Verifica si la clase del controlador existe y si el método existe en esa clase
                if (class_exists($controllerName) && method_exists($controllerName, $methodName)) {
                    // Crea una instancia del controlador
                    $controllerInstance = new $controllerName();
                    // Llama al método del controlador
                    call_user_func([$controllerInstance, $methodName]);
                    return; // Termina la ejecución después de despachar la ruta
                }
            }
        }

        // Si ninguna ruta coincide, envía una cabecera 404 y muestra un mensaje
        header("HTTP/1.0 404 Not Found");
        echo "<h1>404 - Página no encontrada</h1>";
    }
}
