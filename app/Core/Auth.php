<?php
namespace App\Core;

/**
 * Clase Auth
 * Proporciona métodos estáticos para manejar la autorización y el estado de autenticación.
 */
class Auth
{
    /**
     * Verifica si el usuario está autenticado.
     * @return bool
     */
    public static function check()
    {
        return Session::has('user_id');
    }

    /**
     * Obtiene el rol del usuario actual.
     * @return string|null
     */
    public static function role()
    {
        return Session::get('user_role');
    }

    /**
     * Verifica si el usuario actual es un administrador.
     * @return bool
     */
    public static function isAdmin()
    {
        return self::role() === 'admin';
    }

    /**
     * Verifica si el usuario actual tiene un permiso específico.
     * El rol 'admin' siempre tiene todos los permisos.
     * @param string $permission El nombre del permiso a verificar.
     * @return bool
     */
    public static function can($permission)
    {
        if (!self::check()) {
            return false;
        }

        // El administrador siempre tiene permiso.
        if (self::isAdmin()) {
            return true;
        }

        // Obtiene los permisos del usuario de la sesión.
        $permissions = Session::get('user_permissions', []);
        
        // Verifica si el permiso está en la lista de permisos del usuario.
        return in_array($permission, $permissions);
    }
}