<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\Session;
use App\Models\Service;

class ServiceController extends BaseController
{
    private $serviceModel;

    public function __construct()
    {
        // Proteger toda la sección. Solo usuarios autenticados pueden acceder.
        if (!Auth::check()) {
            $this->redirect('login');
        }
        $this->serviceModel = new Service();
    }

    /**
     * Muestra la lista de servicios contratados por el usuario.
     */
    public function index()
    {
        $userId = Session::get('user_id');
        $services = $this->serviceModel->getServicesByUserId($userId);

        $this->view('services/index', [
            'services' => $services,
            'username' => Session::get('username')
        ]);
    }

    /**
     * Muestra la vista detallada de un servicio específico.
     */
    public function view()
    {
        $userId = Session::get('user_id');
        $serviceId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (!$serviceId) {
            $this->redirect('services');
        }

        // Verificar que el usuario tiene este servicio contratado y activo
        $service = $this->serviceModel->findUserActiveServiceById($serviceId, $userId);

        if (!$service) {
            // Si el usuario no tiene acceso a este servicio, lo redirigimos a su lista de servicios.
            $this->redirect('services');
        }

        // Aquí podrías añadir lógica adicional para obtener datos específicos del servicio
        // Por ejemplo, historial de tickets, reportes, etc.
        // Por ahora, solo mostramos la información básica.

        $this->view('services/view', [
            'service' => $service,
            'username' => Session::get('username')
        ]);
    }
}