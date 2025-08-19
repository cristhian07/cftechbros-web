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
        $this->serviceModel = new Service();
        $this->permissionModel = new Permission();

        // Proteger toda la sección. Solo usuarios con el permiso 'manage_service_permissions' pueden acceder.
        if (!Auth::can('manage_service_permissions')) {
            $this->redirect('dashboard');
        }
    }

    /**
     * Muestra la lista de servicios para gestionar sus permisos.
     */
    public function index()
    {
        $services = $this->serviceModel->getAll();
        $successMessage = Session::get('success_message');
        Session::delete('success_message');

        $this->view('admin/services/index', [
            'services' => $services,
            'success' => $successMessage
        ]);
    }

    /**
     * Muestra el formulario para editar los permisos de un servicio.
     */
    public function edit()
    {
        $service_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if (!$service_id) {
            $this->redirect('admin/services');
        }

        $service = $this->serviceModel->findById($service_id);
        if (!$service) {
            $this->redirect('admin/services');
        }

        $all_permissions = $this->permissionModel->getAll();
        $service_permissions = $this->serviceModel->getPermissions($service_id);

        $this->view('admin/services/edit', [
            'service' => $service,
            'all_permissions' => $all_permissions,
            'service_permissions' => $service_permissions,
            'csrf_token' => Session::generateCsrfToken()
        ]);
    }

    /**
     * Actualiza los permisos de un servicio.
     */
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $csrfToken = filter_input(INPUT_POST, 'csrf_token');
            if (!Session::verifyCsrfToken($csrfToken)) {
                $this->redirect('admin/services');
                return;
            }

            $service_id = filter_input(INPUT_POST, 'service_id', FILTER_VALIDATE_INT);
            $permissions = $_POST['permissions'] ?? [];

            $service = $this->serviceModel->findById($service_id);

            if ($service) {
                $this->serviceModel->updatePermissions($service_id, $permissions);
                Session::set('success_message', 'Permisos para el servicio "' . htmlspecialchars($service['name']) . '" actualizados correctamente.');
            }
        }
        $this->redirect('admin/services');
    }
}