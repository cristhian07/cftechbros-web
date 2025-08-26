<?php
namespace App\Controllers;

use App\Core\Session; // Importa la clase Session para verificar el estado de autenticación
use App\Models\Service;

/**
 * Clase HomeController
 * Maneja la lógica de la página de inicio.
 */
class HomeController extends BaseController
{
    private $serviceModel;

    public function __construct()
    {
        $this->serviceModel = new Service();
    }

    /**
     * Muestra la página de inicio.
     */
    public function index()
    {
        // Obtener los servicios destacados de la base de datos
        $featuredServices = $this->serviceModel->getFeaturedServices();

        $this->view('home/index', ['services' => $featuredServices]);
    }
}
