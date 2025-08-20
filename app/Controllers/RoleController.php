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
        $this->view('admin/roles/index', ['roles' => $roles, 'success' => $successMessage]);
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

        $this->view('admin/roles/edit', [
            'role' => $role,
            'all_permissions' => $all_permissions,
            'role_permissions_ids' => $role_permissions_ids,
            'csrf_token' => Session::generateCsrfToken()
        ]);
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