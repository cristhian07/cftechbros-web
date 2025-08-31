<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\Session;
use App\Models\Permission;
use App\Models\Service;

class AdminPermissionController extends BaseController
{
    private $permissionModel;
    private $serviceModel;

    public function __construct()
    {
        // El permiso 'manage_permissions' debe ser creado y asignado al rol 'admin'
        if (!Auth::can('manage_permissions')) {
            $this->redirect('dashboard');
        }
        $this->permissionModel = new Permission();
        $this->serviceModel = new Service();
    }

    public function index()
    {
        $permissions = $this->permissionModel->getAll();
        $this->dashboardView('admin/permissions/index', [
            'permissions' => $permissions,
            'success' => Session::get('success', null, true),
            'error' => Session::get('error', null, true),
            'csrf_token' => Session::generateCsrfToken(),
            'title' => 'Gestionar Funcionalidades'
        ]);
    }

    public function create()
    {
        $services = $this->serviceModel->getAll();
        $this->dashboardView('admin/permissions/create', [
            'services' => $services,
            'csrf_token' => Session::generateCsrfToken(),
            'title' => 'Crear Funcionalidad',
            'old' => Session::get('old_input', [], true)
        ]);
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !Session::verifyCsrfToken($_POST['csrf_token'])) {
            Session::set('error', 'Error de seguridad.');
            $this->redirect('admin/permissions');
            return;
        }

        $name = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING));
        $description = trim(filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING));
        $serviceIds = $_POST['services'] ?? [];

        if (empty($name) || empty($description) || empty($serviceIds)) {
            Session::set('error', 'Nombre, descripción y al menos un servicio son obligatorios.');
            Session::set('old_input', $_POST);
            $this->redirect('admin/permissions/create');
            return;
        }
        
        if ($this->permissionModel->findByName($name)) {
            Session::set('error', 'El nombre del permiso ya existe.');
            Session::set('old_input', $_POST);
            $this->redirect('admin/permissions/create');
            return;
        }

        if ($this->permissionModel->create($name, $description, $serviceIds)) {
            Session::set('success', 'Permiso creado exitosamente.');
            $this->redirect('admin/permissions');
        } else {
            Session::set('error', 'Hubo un error al crear el permiso.');
            Session::set('old_input', $_POST);
            $this->redirect('admin/permissions/create');
        }
    }

    public function edit()
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if (!$id) {
            $this->redirect('admin/permissions');
        }

        $permission = $this->permissionModel->findById($id);
        if (!$permission) {
            Session::set('error', 'Permiso no encontrado.');
            $this->redirect('admin/permissions');
        }

        $services = $this->serviceModel->getAll();
        $associated_service_ids = $this->permissionModel->getAssociatedServiceIds($id);

        $this->dashboardView('admin/permissions/edit', [
            'permission' => $permission,
            'services' => $services,
            'associated_service_ids' => $associated_service_ids,
            'csrf_token' => Session::generateCsrfToken(),
            'title' => 'Editar Permiso'
        ]);
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !Session::verifyCsrfToken($_POST['csrf_token'])) {
            Session::set('error', 'Error de seguridad.');
            $this->redirect('admin/permissions');
            return;
        }

        $id = filter_input(INPUT_POST, 'permission_id', FILTER_VALIDATE_INT);
        $name = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING));
        $description = trim(filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING));
        $serviceIds = $_POST['services'] ?? [];

        if (!$id || empty($name) || empty($description) || empty($serviceIds)) {
            Session::set('error', 'Nombre, descripción y al menos un servicio son obligatorios.');
            $this->redirect('admin/permissions/edit?id=' . $id);
            return;
        }

        if ($this->permissionModel->update($id, $name, $description, $serviceIds)) {
            Session::set('success', 'Funcionalidad actualizada exitosamente.');
            $this->redirect('admin/permissions');
        } else {
            Session::set('error', 'Hubo un error al actualizar la funcionalidad. Es posible que el nombre ya esté en uso.');
            $this->redirect('admin/permissions/edit?id=' . $id);
        }
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !Session::verifyCsrfToken($_POST['csrf_token'])) {
            Session::set('error', 'Error de seguridad.');
            $this->redirect('admin/permissions');
            return;
        }

        $id = filter_input(INPUT_POST, 'permission_id', FILTER_VALIDATE_INT);
        if (!$id) {
            $this->redirect('admin/permissions');
        }

        if ($this->permissionModel->isPermissionInUseByRole($id)) {
            Session::set('error', 'No se puede eliminar la funcionalidad porque está asignada a uno o más roles.');
            $this->redirect('admin/permissions');
            return;
        }

        if ($this->permissionModel->delete($id)) {
            Session::set('success', 'Funcionalidad eliminada exitosamente.');
        } else {
            Session::set('error', 'Hubo un error al eliminar la funcionalidad.');
        }
        $this->redirect('admin/permissions');
    }
}