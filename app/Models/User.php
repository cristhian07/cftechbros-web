<?php
namespace App\Models;

use App\Core\Database;
use PDO;

/**
 * Clase User (Modelo)
 * Maneja las operaciones de la base de datos para la tabla `users`.
 */
class User
{
    private $db;
    private $table = 'users';

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Obtiene todos los usuarios con el nombre de su rol.
     * @return array
     */
    public function getAll()
    {
        $stmt = $this->db->query(
            "SELECT u.id, u.username, u.email, u.created_at, r.name as role_name
             FROM {$this->table} u
             LEFT JOIN roles r ON u.role_id = r.id
             ORDER BY u.id"
        );
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Busca un usuario por su nombre de usuario y obtiene el nombre de su rol.
     * @param string $username
     * @return array|false
     */
    public function findByUsername($username)
    {
        // Hacemos un JOIN con la tabla roles para obtener el nombre del rol directamente
        $stmt = $this->db->prepare(
            "SELECT u.*, r.name as role_name 
             FROM {$this->table} u
             LEFT JOIN roles r ON u.role_id = r.id
             WHERE u.username = :username"
        );
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Busca un usuario por su ID y obtiene su información completa, incluyendo el ID y nombre del rol.
     * @param int $id
     * @return array|false
     */
    public function findById($id)
    {
        $stmt = $this->db->prepare(
            "SELECT u.*, r.name as role_name 
             FROM {$this->table} u
             LEFT JOIN roles r ON u.role_id = r.id
             WHERE u.id = :id"
        );
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function findByEmail($email)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($username, $email, $password, $roleId)
    {
        $stmt = $this->db->prepare(
            "INSERT INTO {$this->table} (username, email, password, role_id) 
             VALUES (:username, :email, :password, :role_id)"
        );
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':role_id', $roleId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * Actualiza el rol de un usuario.
     * @param int $userId
     * @param int $roleId
     * @return bool
     */
    public function updateRole($userId, $roleId)
    {
        $stmt = $this->db->prepare("UPDATE {$this->table} SET role_id = :role_id WHERE id = :user_id");
        $stmt->bindParam(':role_id', $roleId, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * Obtiene un array con los IDs de los servicios contratados por un usuario.
     * @param int $userId
     * @return array
     */
    public function getServiceIds($userId)
    {
        $sql = "SELECT service_id FROM user_service WHERE user_id = :user_id AND status = 'activo'";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    /**
     * Actualiza los servicios contratados por un usuario.
     * @param int $userId
     * @param array $serviceIds
     * @return bool
     */
    public function updateServices($userId, $serviceIds)
    {
        $this->db->beginTransaction();
        try {
            // 1. Borrar todos los servicios activos actuales del usuario
            $stmt = $this->db->prepare("DELETE FROM user_service WHERE user_id = :user_id");
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->execute();

            // 2. Insertar los nuevos servicios para el usuario
            if (!empty($serviceIds)) {
                $insertSql = "INSERT INTO user_service (user_id, service_id, contract_date, status) VALUES (:user_id, :service_id, :contract_date, 'activo')";
                $stmt = $this->db->prepare($insertSql);
                $currentDate = date('Y-m-d');

                foreach ($serviceIds as $serviceId) {
                    $stmt->execute(['user_id' => $userId, 'service_id' => (int)$serviceId, 'contract_date' => $currentDate]);
                }
            }

            $this->db->commit();
            return true;
        } catch (\Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    /**
     * Obtiene los nombres de los permisos para un usuario específico a través de su rol.
     * @param int $userId
     * @return array Lista de nombres de permisos (ej: ['view_dashboard', 'delete_contact'])
     */
    public function getPermissions($userId)
    {   
        // 1. Obtener permisos del ROL del usuario
        $sql_role = "SELECT p.name 
                     FROM permissions p
                     JOIN role_permission rp ON p.id = rp.permission_id
                     JOIN users u ON rp.role_id = u.role_id
                     WHERE u.id = :user_id";
        $stmt_role = $this->db->prepare($sql_role);
        $stmt_role->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt_role->execute();
        $role_permissions = $stmt_role->fetchAll(PDO::FETCH_COLUMN);

        // 2. Obtener permisos de los SERVICIOS ACTIVOS del usuario
        $sql_service = "SELECT p.name
                        FROM permissions p
                        JOIN service_permission sp ON p.id = sp.permission_id
                        JOIN user_service us ON sp.service_id = us.service_id
                        WHERE us.user_id = :user_id AND us.status = 'activo'";
        $stmt_service = $this->db->prepare($sql_service);
        $stmt_service->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt_service->execute();
        $service_permissions = $stmt_service->fetchAll(PDO::FETCH_COLUMN);

        // 3. Unir ambos arrays y devolver una lista única de permisos
        $all_permissions = array_merge($role_permissions, $service_permissions);
        
        // array_unique elimina cualquier permiso duplicado (si un rol y un servicio otorgan el mismo permiso)
        return array_unique($all_permissions);
    }
}