<?php
namespace App\Core;

/**
 * Clase Session
 * Encargada de gestionar las operaciones de la sesión de PHP,
 * incluyendo el manejo de tokens CSRF para protección contra ataques.
 */
class Session
{
    /**
     * Inicia la sesión de PHP si aún no ha sido iniciada.
     */
    public static function start()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Establece un valor en la sesión.
     * @param string $key La clave del valor a almacenar.
     * @param mixed $value El valor a almacenar.
     */
    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Obtiene un valor de la sesión.
     * @param string $key La clave del valor a obtener.
     * @param mixed $default El valor por defecto si la clave no existe.
     * @return mixed El valor de la sesión o el valor por defecto.
     */
    public static function get($key, $default = null)
    {
        return $_SESSION[$key] ?? $default;
    }

    /**
     * Verifica si una clave existe en la sesión.
     * @param string $key La clave a verificar.
     * @return bool True si la clave existe, false en caso contrario.
     */
    public static function has($key)
    {
        return isset($_SESSION[$key]);
    }

    /**
     * Elimina una clave de la sesión.
     * @param string $key La clave a eliminar.
     */
    public static function delete($key)
    {
        if (self::has($key)) {
            unset($_SESSION[$key]);
        }
    }

    /**
     * Destruye todos los datos de la sesión.
     */
    public static function destroy()
    {
        session_unset(); // Elimina todas las variables de sesión
        session_destroy(); // Destruye la sesión
    }

    /**
     * Genera y guarda un token CSRF (Cross-Site Request Forgery) en la sesión.
     * Solo se genera si no existe uno ya.
     * @return string El token CSRF generado o existente.
     */
    public static function generateCsrfToken()
    {
        if (!self::has('csrf_token')) {
            // Genera un token seguro utilizando bytes aleatorios
            self::set('csrf_token', bin2hex(random_bytes(32)));
        }
        return self::get('csrf_token');
    }

    /**
     * Verifica un token CSRF recibido con el almacenado en la sesión.
     * @param string $token El token a verificar, usualmente del formulario POST.
     * @return bool True si el token es válido (coincide y existe), false en caso contrario.
     */
    public static function verifyCsrfToken($token)
    {
        return self::has('csrf_token') && self::get('csrf_token') === $token;
    }
}
