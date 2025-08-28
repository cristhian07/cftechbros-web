<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\Session;
use App\Models\Role;
use App\Models\Permission;

class RoleController extends BaseController
{
    private $roleModel;
    private $permissionModel;

    public function __construct()
    {
        $this->roleModel = new Role();
        $this->permissionModel = new Permission();

        // Para que esta sección sea accesible, el usuario debe tener el permiso 'manage_roles'.
        // El rol 'admin' lo tendrá por defecto.
        if (!Auth::can('manage_roles')) {
            $this->redirect('dashboard');
        }
    }

    /**
     * Muestra la lista de roles.
     */
    public function index()
    {
        $roles = $this->roleModel->getAll();
        $successMessage = Session::get('success_message');
        Session::delete('success_message'); // Limpiar el mensaje después de mostrarlo
        $errorMessage = Session::get('error_message');
        Session::delete('error_message');

        $this->dashboardView('admin/roles/index', [
            'roles' => $roles,
            'success' => $successMessage,
            'error' => $errorMessage,
            'csrf_token' => Session::generateCsrfToken(),
            'title' => 'Gestionar Roles'
        ]);
    }

    /**
     * Muestra el formulario para editar los permisos de un rol.
     */
    public function edit()
    {
        $role_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if (!$role_id) {
            $this->redirect('admin/roles');
        }

        $role = $this->roleModel->findById($role_id);
        if (!$role) {
            $this->redirect('admin/roles');
        }

        $all_permissions = $this->permissionModel->getAll();
        $role_permissions = $this->roleModel->getPermissions($role_id);

        // Extraer solo los IDs de los permisos que el rol ya tiene, para facilitar la comprobación en la vista.
        $role_permissions_ids = array_column($role_permissions, 'id');

        $this->dashboardView('admin/roles/edit', [
            'role' => $role,
            'all_permissions' => $all_permissions,
            'role_permissions_ids' => $role_permissions_ids,
            'csrf_token' => Session::generateCsrfToken(),
            'title' => 'Editar Rol'
        ]);
    }

    /**
     * Muestra el formulario para crear un nuevo rol.
     */
    public function create()
    {
        $this->dashboardView('admin/roles/create', [
            'csrf_token' => Session::generateCsrfToken(),
            'title' => 'Crear Rol'
        ]);
    }

    /**
     * Almacena un nuevo rol en la base de datos.
     */
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $csrfToken = filter_input(INPUT_POST, 'csrf_token');
            if (!Session::verifyCsrfToken($csrfToken)) {
                $this->redirect('admin/roles');
                return;
            }

            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
            $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);

            if (empty($name) || empty($description)) {
                Session::set('error_message', 'El nombre y la descripción del rol son obligatorios.');
                // Idealmente, también se deberían devolver los valores introducidos al formulario.
                $this->redirect('admin/roles/create');
                return;
            }

            if ($this->roleModel->create($name, $description)) {
                Session::set('success_message', 'Rol "' . htmlspecialchars($name) . '" creado correctamente.');
            } else {
                Session::set('error_message', 'Error al crear el rol. Es posible que el nombre ya exista.');
            }
        }
        $this->redirect('admin/roles');
    }

    /**
     * Elimina un rol.
     */
    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $csrfToken = filter_input(INPUT_POST, 'csrf_token');
            if (!Session::verifyCsrfToken($csrfToken)) {
                $this->redirect('admin/roles');
                return;
            }

            $role_id = filter_input(INPUT_POST, 'role_id', FILTER_VALIDATE_INT);
            $role = $this->roleModel->findById($role_id);

            if (!$role || $role['name'] === 'admin' || $role['name'] === 'user') {
                Session::set('error_message', 'Este rol está protegido y no puede ser eliminado.');
                $this->redirect('admin/roles');
                return;
            }

            if ($this->roleModel->isRoleInUse($role_id)) {
                Session::set('error_message', 'No se puede eliminar el rol "' . htmlspecialchars($role['name']) . '" porque está asignado a uno o más usuarios.');
                $this->redirect('admin/roles');
                return;
            }

            if ($this->roleModel->delete($role_id)) {
                Session::set('success_message', 'Rol "' . htmlspecialchars($role['name']) . '" eliminado correctamente.');
            } else {
                Session::set('error_message', 'Error al eliminar el rol.');
            }
        }
        $this->redirect('admin/roles');
    }

    /**
     * Actualiza los permisos de un rol.
     */
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $csrfToken = filter_input(INPUT_POST, 'csrf_token');
            if (!Session::verifyCsrfToken($csrfToken)) {
                 $this->redirect('admin/roles');
                 return;
            }

            $role_id = filter_input(INPUT_POST, 'role_id', FILTER_VALIDATE_INT);
            // Los permisos vienen como un array desde los checkboxes del formulario
            $permissions = $_POST['permissions'] ?? [];

            $role = $this->roleModel->findById($role_id);

            if ($role && $role['name'] !== 'admin') {
                $this->roleModel->updatePermissions($role_id, $permissions);
                Session::set('success_message', 'Permisos para el rol "' . htmlspecialchars($role['name']) . '" actualizados correctamente.');
            }
        }
        $this->redirect('admin/roles');
    }
}