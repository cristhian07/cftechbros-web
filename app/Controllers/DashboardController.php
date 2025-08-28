<?php
namespace App\Controllers;

use App\Core\Session;
use App\Core\Auth;

/**
 * Clase DashboardController
 * Muestra el panel de control correspondiente al usuario logueado.
 */
class DashboardController extends BaseController
{
    /**
     * Constructor. Protege el acceso al dashboard, solo para usuarios logueados.
     */
    public function __construct()
    {
        if (!Session::has('user_id')) {
            $this->redirect('login');
        }
    }

    /**
     * Muestra el dashboard.
     * Si el usuario es administrador, muestra el panel de administración con layout de sidebar.
     * Si no, muestra el dashboard de usuario normal.
     */
    public function index()
    {
        // Todos los usuarios logueados usan el mismo layout de dashboard.
        // La diferencia está en el contenido que se carga en el área principal.
        if (Auth::isAdmin()) {
            // Los administradores ven la página de bienvenida de administración.
            $this->dashboardView('admin/dashboard', [
                'username' => Session::get('username'),
                'title' => 'Dashboard Admin'
            ]);
        } else {
            // Los usuarios regulares ven su página de bienvenida estándar.
            $this->dashboardView('dashboard/index', [
                'username' => Session::get('username'),
                'title' => 'Mi Dashboard'
            ]);
        }
    }
}