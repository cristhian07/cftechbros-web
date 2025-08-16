<?php
namespace App\Controllers;

use App\Core\Session; // Importa la clase Session para verificar el estado de autenticación

/**
 * Clase HomeController
 * Maneja la lógica de la página principal de la aplicación.
 */
class HomeController extends BaseController
{
    /**
     * Muestra la página de inicio.
     * Pasa el estado de autenticación del usuario a la vista.
     */
    public function index()
    {
        // Verifica si hay un 'user_id' en la sesión, lo que indica que el usuario está logueado.
        $data['isLoggedIn'] = Session::has('user_id');
        // Carga la vista 'home/index' y le pasa los datos.
        $this->view('home/index', $data);
    }
}
