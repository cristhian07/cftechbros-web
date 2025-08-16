<?php
namespace App\Controllers;

use App\Core\Session; // Importa la clase Session para verificar el estado de autenticación

/**
 * Clase DashboardController
 * Maneja la lógica de la página del dashboard de usuario.
 */
class DashboardController extends BaseController
{
    /**
     * Muestra la página del dashboard.
     * Requiere que el usuario esté autenticado para acceder.
     */
    public function index()
    {
        // Proteger la ruta: si el usuario no está logueado, redirige al login
        if (!Session::has('user_id')) {
            $this->redirect('login');
        }

        // Obtiene el nombre de usuario de la sesión para mostrarlo en el dashboard
        $username = Session::get('username');
        // Carga la vista 'dashboard/index' y le pasa el nombre de usuario.
        $this->view('dashboard/index', ['username' => $username]);
    }
}
