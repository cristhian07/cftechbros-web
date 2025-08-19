<?php
namespace App\Controllers;

use App\Core\Session;
use App\Core\Auth;
use App\Models\Contact;

/**
 * Clase AdminController
 * Maneja la lógica del panel de administración.
 */
class AdminController extends BaseController
{
    private $contactModel;

    public function __construct()
    {
        $this->contactModel = new Contact();
    }

    /**
     * Muestra la lista de mensajes de contacto.
     * Requiere que el usuario esté logueado y sea administrador para acceder.
     */
    public function showContacts()
    {
        // Usar el nuevo sistema de permisos. Redirige si no tiene el permiso.
        if (!Auth::can('view_admin_contacts')) {
            $this->redirect('dashboard');
        }

        $contacts = $this->contactModel->getAllContacts();
        // Pasa el token CSRF a la vista
        $csrf_token = Session::generateCsrfToken();
        $this->view('admin/contacts', ['contacts' => $contacts, 'csrf_token' => $csrf_token]);
    }

    /**
     * Actualiza el estado de un mensaje de contacto.
     * Se accede a través de una petición POST.
     * Requiere que el usuario esté logueado y sea administrador.
     */
    public function updateStatus()
    {
        if (!Auth::can('update_contact_status')) {
            $this->redirect('admin/contacts');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
            $status = filter_input(INPUT_POST, 'status');
            $csrfToken = filter_input(INPUT_POST, 'csrf_token');

            if (!Session::verifyCsrfToken($csrfToken)) {
                 $this->redirect('admin/contacts');
                 return;
            }

            if ($id && ($status === 'Leído' || $status === 'Pendiente')) {
                $this->contactModel->updateStatus($id, $status);
            }
        }
        $this->redirect('admin/contacts');
    }
    /**
     * Elimina un mensaje de contacto.
     * Se accede a través de una petición POST.
     * Requiere que el usuario esté logueado y sea administrador.
     */
    public function deleteContact()
    {
        if (!Auth::can('delete_contact')) {
            $this->redirect('admin/contacts');
        }

        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

        if ($id) {
            $this->contactModel->delete($id);
        }
        $this->redirect('admin/contacts');
    }
}
