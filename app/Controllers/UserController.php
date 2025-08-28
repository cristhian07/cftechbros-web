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
        $errorMessage = Session::get('error_message');
        Session::delete('error_message');

        $this->dashboardView('admin/users/index', [
            'users' => $users,
            'success' => $successMessage,
            'error' => $errorMessage,
            'csrf_token' => Session::generateCsrfToken(),
            'title' => 'Gestionar Usuarios'
        ]);
    }

    /**
     * Muestra el formulario para crear un nuevo usuario.
     */
    public function create()
    {
        $roles = $this->roleModel->getAll();

        $this->dashboardView('admin/users/create', [
            'roles' => $roles,
            'csrf_token' => Session::generateCsrfToken(),
            'title' => 'Crear Usuario'
        ]);
    }

    /**
     * Almacena un nuevo usuario en la base de datos.
     */
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!Session::verifyCsrfToken($_POST['csrf_token'])) {
                Session::set('error_message', 'Error de seguridad CSRF.');
                $this->redirect('admin/users');
                return;
            }

            $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            $password = $_POST['password'];
            $role_id = filter_input(INPUT_POST, 'role_id', FILTER_VALIDATE_INT);

            // Validaciones (simplificadas, se pueden expandir)
            if (empty($username) || !$email || empty($password) || !$role_id || strlen($password) < 6 || $this->userModel->findByUsername($username) || $this->userModel->findByEmail($email)) {
                Session::set('error_message', 'Datos inválidos o el usuario/email ya existe. La contraseña debe tener al menos 6 caracteres.');
                $this->redirect('admin/users/create');
                return;
            }

            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            if ($this->userModel->create($username, $email, $hashedPassword, $role_id)) {
                Session::set('success_message', 'Usuario "' . htmlspecialchars($username) . '" creado correctamente.');
            } else {
                Session::set('error_message', 'Error al crear el usuario.');
            }
        }
        $this->redirect('admin/users');
    }

    /**
     * Elimina un usuario de la base de datos.
     */
    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!Session::verifyCsrfToken($_POST['csrf_token'])) {
                Session::set('error_message', 'Error de seguridad CSRF.');
                $this->redirect('admin/users');
                return;
            }

            $user_id = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);

            // Reglas de seguridad:
            // 1. No se puede eliminar al super admin (ID 1).
            // 2. Un usuario no puede eliminarse a sí mismo.
            if ($user_id && $user_id != 1 && $user_id != Session::get('user_id')) {
                if ($this->userModel->delete($user_id)) {
                    Session::set('success_message', 'Usuario eliminado correctamente.');
                } else {
                    Session::set('error_message', 'Error al eliminar el usuario.');
                }
            } else {
                Session::set('error_message', 'No tienes permiso para eliminar a este usuario.');
            }
        }
        $this->redirect('admin/users');
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

        $this->dashboardView('admin/users/edit', [
            'user' => $user,
            'roles' => $roles,
            'csrf_token' => Session::generateCsrfToken(),
            'title' => 'Editar Rol de Usuario'
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

        $this->dashboardView('admin/users/manage_services', [
            'user' => $user,
            'all_services' => $all_services,
            'user_services_ids' => $user_services_ids,
            'csrf_token' => Session::generateCsrfToken(),
            'title' => 'Gestionar Servicios de Usuario'
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