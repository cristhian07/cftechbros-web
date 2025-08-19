<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\Session;
use App\Models\User;
use App\Models\Role;
use App\Models\Service;

class UserController extends BaseController
{
    private $userModel;
    private $roleModel;
    private $serviceModel;

    public function __construct()
    {
        $this->userModel = new User();
        $this->roleModel = new Role();
        $this->serviceModel = new Service();

        // Proteger toda la sección. Solo usuarios con el permiso 'manage_users' pueden acceder.
        if (!Auth::can('manage_users')) {
            $this->redirect('dashboard');
        }
    }

    /**
     * Muestra la lista de usuarios del sistema.
     */
    public function index()
    {
        $users = $this->userModel->getAll();
        $successMessage = Session::get('success_message');
        Session::delete('success_message');

        $this->view('admin/users/index', [
            'users' => $users,
            'success' => $successMessage
        ]);
    }

    /**
     * Muestra el formulario para editar el rol de un usuario.
     */
    public function edit()
    {
        $user_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if (!$user_id) {
            $this->redirect('admin/users');
        }

        $user = $this->userModel->findById($user_id);
        if (!$user) {
            $this->redirect('admin/users');
        }

        // Obtener todos los roles disponibles para el dropdown
        $roles = $this->roleModel->getAll();

        $this->view('admin/users/edit', [
            'user' => $user,
            'roles' => $roles,
            'csrf_token' => Session::generateCsrfToken()
        ]);
    }

    /**
     * Actualiza el rol de un usuario.
     */
    public function updateRole()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $csrfToken = filter_input(INPUT_POST, 'csrf_token');
            if (!Session::verifyCsrfToken($csrfToken)) {
                $this->redirect('admin/users');
                return;
            }

            $user_id = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);
            $role_id = filter_input(INPUT_POST, 'role_id', FILTER_VALIDATE_INT);

            $user = $this->userModel->findById($user_id);

            // Regla de seguridad: No se puede cambiar el rol del super admin (ID 1)
            // ni el rol del usuario que está actualmente logueado.
            if ($user && $role_id && $user['id'] != 1 && $user['id'] != Session::get('user_id')) {
                if ($this->userModel->updateRole($user_id, $role_id)) {
                    Session::set('success_message', 'Rol del usuario "' . htmlspecialchars($user['username']) . '" actualizado correctamente.');
                }
            } else {
                // Opcional: Añadir un mensaje de error si se intenta una acción no permitida.
                Session::set('error_message', 'No se puede cambiar el rol de este usuario.');
            }
        }
        $this->redirect('admin/users');
    }

    /**
     * Muestra el formulario para gestionar los servicios de un usuario.
     */
    public function manageServices()
    {
        // Este método requiere un permiso diferente para separar responsabilidades
        if (!Auth::can('manage_user_services')) {
            $this->redirect('dashboard');
        }

        $user_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if (!$user_id) {
            $this->redirect('admin/users');
        }

        $user = $this->userModel->findById($user_id);
        if (!$user) {
            $this->redirect('admin/users');
        }

        // Obtener todos los servicios disponibles en la plataforma
        $all_services = $this->serviceModel->getAll();
        // Obtener los IDs de los servicios que el usuario ya tiene
        $user_services_ids = $this->userModel->getServiceIds($user_id);

        $this->view('admin/users/manage_services', [
            'user' => $user,
            'all_services' => $all_services,
            'user_services_ids' => $user_services_ids,
            'csrf_token' => Session::generateCsrfToken()
        ]);
    }

    /**
     * Actualiza los servicios contratados por un usuario.
     */
    public function updateServices()
    {
        if (!Auth::can('manage_user_services')) {
            $this->redirect('dashboard');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $csrfToken = filter_input(INPUT_POST, 'csrf_token');
            if (!Session::verifyCsrfToken($csrfToken)) {
                $this->redirect('admin/users');
                return;
            }

            $user_id = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);
            // Los IDs de los servicios vienen como un array desde los checkboxes
            $service_ids = $_POST['services'] ?? [];

            if ($user_id) {
                $this->userModel->updateServices($user_id, $service_ids);
                Session::set('success_message', 'Servicios del usuario actualizados correctamente.');
            }
        }
        $this->redirect('admin/users');
    }
}