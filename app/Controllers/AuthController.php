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
            $username = filter_input(INPUT_POST, 'username');
            $password = filter_input(INPUT_POST, 'password');
            $csrfToken = filter_input(INPUT_POST, 'csrf_token');

            if ($username === null || $password === null || $csrfToken === null) {
                $this->view('auth/login', ['error' => 'Error en el envío del formulario. Por favor, inténtalo de nuevo.', 'csrf_token' => Session::generateCsrfToken()]);
                return;
            }

            // Protección CSRF
            if (!Session::verifyCsrfToken($csrfToken)) {
                $this->view('auth/login', ['error' => 'Error de seguridad CSRF.', 'csrf_token' => Session::generateCsrfToken()]);
                return;
            }

            if (empty($username) || empty($password)) {
                $this->view('auth/login', ['error' => 'Por favor, introduce usuario y contraseña.', 'csrf_token' => Session::generateCsrfToken()]);
                return;
            }

            $user = $this->userModel->findByUsername($username);

            if ($user && password_verify($password, $user['password'])) {
                // Inicio de sesión exitoso. Obtener permisos del usuario.
                // NOTA: Esto requiere un nuevo método en el modelo User, getPermissions($userId),
                // que debería hacer un JOIN entre users, roles, role_permissions y permissions
                // para obtener una lista [ 'permiso1', 'permiso2', ... ].
                $permissions = $this->userModel->getPermissions($user['id']);

                Session::set('user_id', $user['id']);
                Session::set('username', $user['username']);
                Session::set('user_role', $user['role_name']); // 'role_name' es el nombre del rol, ej: 'admin', 'editor'
                Session::set('user_permissions', $permissions); // Guardar los permisos en la sesión
                Session::delete('csrf_token'); // Eliminar el token CSRF después de un uso exitoso

                $this->redirect('dashboard');
            } else {
                $this->view('auth/login', ['error' => 'Credenciales incorrectas.', 'csrf_token' => Session::generateCsrfToken()]);
            }
        } else {
            $this->redirect('login'); // Redirige a la página de login si no es POST
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
            $username = filter_input(INPUT_POST, 'username');
            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            $password = filter_input(INPUT_POST, 'password');
            $confirmPassword = filter_input(INPUT_POST, 'confirm_password');
            $csrfToken = filter_input(INPUT_POST, 'csrf_token');

            if ($username === null || $email === null || $password === null || $confirmPassword === null || $csrfToken === null) {
                 $this->view('auth/register', ['error' => 'Error en el envío del formulario. Por favor, inténtalo de nuevo.', 'csrf_token' => Session::generateCsrfToken()]);
                return;
            }

            // Protección CSRF
            if (!Session::verifyCsrfToken($csrfToken)) {
                $this->view('auth/register', ['error' => 'Error de seguridad CSRF.', 'csrf_token' => Session::generateCsrfToken()]);
                return;
            }

            $errors = [];

            // Validaciones
            if (empty($username) || empty($password) || empty($confirmPassword)) {
                $errors[] = 'Todos los campos son obligatorios.';
            }

            if (!$email) {
                $errors[] = 'El formato del correo electrónico es inválido.';
            }

            if ($password !== $confirmPassword) {
                $errors[] = 'Las contraseñas no coinciden.';
            }

            if (strlen($password) < 6) {
                $errors[] = 'La contraseña debe tener al menos 6 caracteres.';
            }

            if ($this->userModel->findByUsername($username)) {
                $errors[] = 'El nombre de usuario ya está en uso.';
            }

            if ($this->userModel->findByEmail($email)) {
                $errors[] = 'El correo electrónico ya está registrado.';
            }

            if (!empty($errors)) {
                $this->view('auth/register', [
                    'errors' => $errors,
                    'csrf_token' => Session::generateCsrfToken(),
                    'username_val' => htmlspecialchars($username),
                    'email_val' => htmlspecialchars($email),
                ]);
                return;
            }

            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            // Al registrar un nuevo usuario, se le asigna el rol 'user' por defecto.
            // Asumimos que el rol 'user' tiene el ID 3 según nuestro SQL de inserción.
            // En una aplicación más compleja, podrías buscar el ID del rol por su nombre.
            $defaultRoleId = 3; 

            if ($this->userModel->create($username, $email, $hashedPassword, $defaultRoleId)) {
                $this->view('auth/login', ['success' => 'Registro exitoso. ¡Ahora puedes iniciar sesión!', 'csrf_token' => Session::generateCsrfToken()]);
            } else {
                $this->view('auth/register', ['error' => 'Error al registrar el usuario. Por favor, inténtalo de nuevo.', 'csrf_token' => Session::generateCsrfToken()]);
            }
        } else {
            $this->redirect('register');
        }
    }

    public function logout()
    {
        Session::destroy();
        $this->redirect(''); // Redirige a la página de inicio
    }
}
