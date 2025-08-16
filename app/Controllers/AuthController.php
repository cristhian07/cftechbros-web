<?php
namespace App\Controllers;

use App\Models\User;     // Importa el modelo de usuario para interactuar con la DB
use App\Core\Session;   // Importa la clase Session para manejar sesiones y CSRF

/**
 * Clase AuthController
 * Maneja toda la lógica relacionada con la autenticación de usuarios:
 * login, registro y logout.
 */
class AuthController extends BaseController
{
    private $userModel; // Instancia del modelo User

    /**
     * Constructor de AuthController.
     * Inicializa el modelo User.
     */
    public function __construct()
    {
        $this->userModel = new User();
    }

    /**
     * Muestra el formulario de inicio de sesión.
     * Redirige al dashboard si el usuario ya está logueado.
     */
    public function showLoginForm()
    {
        if (Session::has('user_id')) {
            $this->redirect('dashboard');
        }
        // Pasa un token CSRF a la vista del formulario
        $this->view('auth/login', ['csrf_token' => Session::generateCsrfToken()]);
    }

    /**
     * Procesa la solicitud de inicio de sesión (POST).
     * Realiza validaciones, verifica credenciales y gestiona la sesión.
     */
    public function login()
    {
        if (Session::has('user_id')) {
            $this->redirect('dashboard');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Saneamiento de entradas para prevenir XSS
            $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
            $csrfToken = filter_input(INPUT_POST, 'csrf_token', FILTER_SANITIZE_STRING);

            // Protección CSRF
            if (!Session::verifyCsrfToken($csrfToken)) {
                $this->view('auth/login', ['error' => 'Error de seguridad CSRF.', 'csrf_token' => Session::generateCsrfToken()]);
                return;
            }

            // Validación básica de campos
            if (empty($username) || empty($password)) {
                $this->view('auth/login', ['error' => 'Por favor, introduce usuario y contraseña.', 'csrf_token' => Session::generateCsrfToken()]);
                return;
            }

            // Busca el usuario en la base de datos por nombre de usuario
            $user = $this->userModel->findByUsername($username);

            // Verifica si el usuario existe y si la contraseña es correcta
            if ($user && password_verify($password, $user['password'])) {
                // Inicio de sesión exitoso: guarda el ID y nombre de usuario en la sesión
                Session::set('user_id', $user['id']);
                Session::set('username', $user['username']);
                Session::delete('csrf_token'); // Eliminar el token CSRF después de un uso exitoso (seguridad)

                // Redirige al dashboard del usuario
                $this->redirect('dashboard');
            } else {
                // Credenciales incorrectas
                $this->view('auth/login', ['error' => 'Credenciales incorrectas.', 'csrf_token' => Session::generateCsrfToken()]);
            }
        } else {
            // Si la solicitud no es POST, redirige al formulario de login
            $this->redirect('login');
        }
    }

    /**
     * Muestra el formulario de registro de usuario.
     * Redirige al dashboard si el usuario ya está logueado.
     */
    public function showRegisterForm()
    {
        if (Session::has('user_id')) {
            $this->redirect('dashboard');
        }
        // Pasa un token CSRF a la vista del formulario
        $this->view('auth/register', ['csrf_token' => Session::generateCsrfToken()]);
    }

    /**
     * Procesa la solicitud de registro de nuevo usuario (POST).
     * Realiza validaciones, crea el usuario y gestiona la redirección.
     */
    public function register()
    {
        if (Session::has('user_id')) {
            $this->redirect('dashboard');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Saneamiento de entradas
            $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
            $confirmPassword = filter_input(INPUT_POST, 'confirm_password', FILTER_SANITIZE_STRING);
            $csrfToken = filter_input(INPUT_POST, 'csrf_token', FILTER_SANITIZE_STRING);

            // Protección CSRF
            if (!Session::verifyCsrfToken($csrfToken)) {
                $this->view('auth/register', ['error' => 'Error de seguridad CSRF.', 'csrf_token' => Session::generateCsrfToken()]);
                return;
            }

            $errors = []; // Array para almacenar mensajes de error

            // Validaciones
            if (empty($username) || empty($email) || empty($password) || empty($confirmPassword)) {
                $errors[] = 'Todos los campos son obligatorios.';
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'El formato del correo electrónico es inválido.';
            }

            if ($password !== $confirmPassword) {
                $errors[] = 'Las contraseñas no coinciden.';
            }

            if (strlen($password) < 6) {
                $errors[] = 'La contraseña debe tener al menos 6 caracteres.';
            }

            // Verificar si el nombre de usuario o email ya existen
            if ($this->userModel->findByUsername($username)) {
                $errors[] = 'El nombre de usuario ya está en uso.';
            }

            if ($this->userModel->findByEmail($email)) {
                $errors[] = 'El correo electrónico ya está registrado.';
            }

            // Si hay errores, mostrar el formulario de registro con los mensajes de error
            if (!empty($errors)) {
                // Se vuelven a pasar los datos POST para que el usuario no tenga que rellenar todo de nuevo
                $this->view('auth/register', ['errors' => $errors, 'csrf_token' => Session::generateCsrfToken()]);
                return;
            }

            // Hashear la contraseña antes de almacenarla
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            // Intenta crear el usuario
            if ($this->userModel->create($username, $email, $hashedPassword)) {
                // Registro exitoso: redirige al formulario de login con un mensaje de éxito
                $this->view('auth/login', ['success' => 'Registro exitoso. ¡Ahora puedes iniciar sesión!', 'csrf_token' => Session::generateCsrfToken()]);
            } else {
                // Error al registrar
                $this->view('auth/register', ['error' => 'Error al registrar el usuario. Por favor, inténtalo de nuevo.', 'csrf_token' => Session::generateCsrfToken()]);
            }
        } else {
            // Si la solicitud no es POST, redirige al formulario de registro
            $this->redirect('register');
        }
    }

    /**
     * Cierra la sesión del usuario.
     * Elimina todos los datos de sesión y redirige a la página de inicio.
     */
    public function logout()
    {
        Session::destroy(); // Destruye la sesión
        $this->redirect(''); // Redirige a la raíz de la aplicación
    }
}
