<?php
namespace App\Controllers;

use App\Core\Session;
use App\Models\Contact; // Importa el modelo de Contacto

/**
 * Clase ContactController
 * Maneja la lógica del formulario de contacto.
 */
class ContactController extends BaseController
{
    private $contactModel;

    public function __construct()
    {
        $this->contactModel = new Contact();
    }

    /**
     * Muestra el formulario de contacto.
     */
    public function showContactForm()
    {
        $this->view('contact/form', ['csrf_token' => Session::generateCsrfToken()]);
    }

    /**
     * Procesa la solicitud de envío del formulario de contacto (POST).
     */
    public function submitContactForm()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = filter_input(INPUT_POST, 'name');
            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            $subject = filter_input(INPUT_POST, 'subject');
            $message = filter_input(INPUT_POST, 'message');
            $csrfToken = filter_input(INPUT_POST, 'csrf_token');

            if (!Session::verifyCsrfToken($csrfToken)) {
                $this->view('contact/form', ['error' => 'Error de seguridad CSRF.', 'csrf_token' => Session::generateCsrfToken()]);
                return;
            }

            $errors = [];

            if (empty($name) || empty($email) || empty($message)) {
                $errors[] = 'El nombre, el correo y el mensaje son obligatorios.';
            }

            if (!$email) {
                $errors[] = 'El formato del correo electrónico es inválido.';
            }

            if (!empty($errors)) {
                $this->view('contact/form', [
                    'errors' => $errors,
                    'csrf_token' => Session::generateCsrfToken(),
                    'name_val' => htmlspecialchars($name),
                    'email_val' => htmlspecialchars($email),
                    'subject_val' => htmlspecialchars($subject),
                    'message_val' => htmlspecialchars($message),
                ]);
                return;
            }
            
            // Lógica para guardar en la base de datos
            if ($this->contactModel->create($name, $email, $subject, $message)) {
                $this->view('contact/form', ['success' => '¡Tu mensaje ha sido enviado correctamente! Nos pondremos en contacto contigo pronto.', 'csrf_token' => Session::generateCsrfToken()]);
            } else {
                $this->view('contact/form', ['error' => 'Error al enviar el mensaje. Por favor, inténtalo de nuevo.', 'csrf_token' => Session::generateCsrfToken()]);
            }

        } else {
            $this->redirect('contact');
        }
    }
}