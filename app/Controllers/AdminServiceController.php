<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\Session;
use App\Models\Service;
use App\Models\Permission;

class AdminServiceController extends BaseController
{
    private $serviceModel;
    private $permissionModel;

    public function __construct()
    {
        // Para que esta sección sea accesible, el usuario debe tener el permiso 'manage_service_permissions'.
        if (!Auth::can('manage_service_permissions')) {
            $this->redirect('dashboard');
        }

        $this->serviceModel = new Service();
        $this->permissionModel = new Permission();
    }

    public function index()
    {
        $services = $this->serviceModel->getAll();
        $successMessage = Session::get('success');
        Session::delete('success');
        $errorMessage = Session::get('error');
        Session::delete('error');

        $this->dashboardView('admin/services/index', [
            'services' => $services,
            'success' => $successMessage,
            'error' => $errorMessage,
            'csrf_token' => Session::generateCsrfToken(),
            'title' => 'Gestión de Servicios'
        ]);
    }

    public function create()
    {
        $all_permissions = $this->permissionModel->getAll();
        $this->dashboardView('admin/services/create', [
            'all_permissions' => $all_permissions,
            'csrf_token' => Session::generateCsrfToken(),
            'title' => 'Crear Servicio'
        ]);
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('admin/services');
        }

        if (!Session::verifyCsrfToken($_POST['csrf_token'])) {
            Session::set('error', 'Error de seguridad CSRF.');
            $this->redirect('admin/services/create');
        }

        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
        $icon_class = filter_input(INPUT_POST, 'icon_class', FILTER_SANITIZE_STRING);
        $image_url = filter_input(INPUT_POST, 'image_url', FILTER_SANITIZE_URL);
        $is_featured = isset($_POST['is_featured']) ? 1 : 0;
        $permissions = $_POST['permissions'] ?? [];
        
        // Generar una ruta simple a partir del nombre
        $route = 'services/' . strtolower(str_replace(' ', '-', $name));

        if (empty($name) || empty($description) || empty($icon_class)) {
            Session::set('error', 'Todos los campos son obligatorios.');
            $this->redirect('admin/services/create');
        }

        if ($this->serviceModel->create($name, $description, $icon_class, $route, $image_url, $is_featured, $permissions)) {
            Session::set('success', 'Servicio creado exitosamente.');
            $this->redirect('admin/services');
        } else {
            Session::set('error', 'Hubo un error al crear el servicio.');
            $this->redirect('admin/services/create');
        }
    }

    public function edit()
    {
        $serviceId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if (!$serviceId) {
            $this->redirect('admin/services');
        }

        $service = $this->serviceModel->findById($serviceId);
        if (!$service) {
            Session::set('error', 'Servicio no encontrado.');
            $this->redirect('admin/services');
        }

        $service = $this->serviceModel->findById($serviceId);
        $all_permissions = $this->permissionModel->getAll();
        $service_permissions = $this->serviceModel->getPermissions($serviceId);

        $this->dashboardView('admin/services/edit', [
            'service' => $service,
            'all_permissions' => $all_permissions,
            'service_permissions' => $service_permissions,
            'csrf_token' => Session::generateCsrfToken(),
            'title' => 'Editar Servicio'
        ]);
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('admin/services');
        }

        if (!Session::verifyCsrfToken($_POST['csrf_token'])) {
            Session::set('error', 'Error de seguridad CSRF.');
            $this->redirect('admin/services');
        }

        $service_id = filter_input(INPUT_POST, 'service_id', FILTER_VALIDATE_INT);
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
        $icon_class = filter_input(INPUT_POST, 'icon_class', FILTER_SANITIZE_STRING);
        $image_url = filter_input(INPUT_POST, 'image_url', FILTER_SANITIZE_URL);
        $is_featured = isset($_POST['is_featured']) ? 1 : 0;
        $permissions = $_POST['permissions'] ?? [];

        $route = 'services/' . strtolower(str_replace(' ', '-', $name));

        if ($this->serviceModel->update($service_id, $name, $description, $icon_class, $route, $image_url, $is_featured, $permissions)) {
            Session::set('success', 'Servicio actualizado exitosamente.');
            $this->redirect('admin/services');
        } else {
            Session::set('error', 'Hubo un error al actualizar el servicio.');
            $this->redirect('admin/services/edit?id=' . $service_id);
        }
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('admin/services');
        }

        if (!Session::verifyCsrfToken($_POST['csrf_token'])) {
            Session::set('error', 'Error de seguridad CSRF.');
            $this->redirect('admin/services');
        }

        $service_id = filter_input(INPUT_POST, 'service_id', FILTER_VALIDATE_INT);

        if (!$service_id) {
            Session::set('error', 'ID de servicio inválido.');
            $this->redirect('admin/services');
        }

        if ($this->serviceModel->isServiceInUse($service_id)) {
            Session::set('error', 'No se puede eliminar el servicio porque está asignado a uno o más usuarios.');
            $this->redirect('admin/services');
            return;
        }

        if ($this->serviceModel->delete($service_id)) {
            Session::set('success', 'Servicio eliminado exitosamente.');
        } else {
            Session::set('error', 'Hubo un error al eliminar el servicio.');
        }
        $this->redirect('admin/services');
    }
}