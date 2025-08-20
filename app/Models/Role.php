<?php
namespace App\Models;

use App\Core\Database;
use PDO;

class Role
{
    private $db;
    private $table = 'roles';

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAll()
    {
        $stmt = $this->db->query("SELECT * FROM {$this->table} ORDER BY id");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getPermissions($roleId)
    {
        // Se modifica para devolver tanto el ID como el nombre, para que el controlador pueda extraer los IDs fácilmente.
        $sql = "SELECT p.id, p.name 
                FROM permissions p
                JOIN role_permission rp ON p.id = rp.permission_id
                WHERE rp.role_id = :role_id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':role_id', $roleId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updatePermissions($roleId, $permissionIds)
    {
        $this->db->beginTransaction();
        try {
            // 1. Borrar todos los permisos actuales del rol
            $stmt = $this->db->prepare("DELETE FROM role_permission WHERE role_id = :role_id");
            $stmt->bindParam(':role_id', $roleId, PDO::PARAM_INT);
            $stmt->execute();

            // 2. Insertar los nuevos permisos para el rol directamente con los IDs recibidos del formulario.
            if (!empty($permissionIds)) {
                $insertSql = "INSERT INTO role_permission (role_id, permission_id) VALUES (:role_id, :permission_id)";
                $stmt = $this->db->prepare($insertSql);
                foreach ($permissionIds as $permissionId) {
                    $stmt->execute(['role_id' => $roleId, 'permission_id' => (int)$permissionId]);
                }
            }

            $this->db->commit();
            return true;
        } catch (\Exception $e) {
            $this->db->rollBack();
            // Opcional: registrar el error en un log. error_log($e->getMessage());
            return false;
        }
    }
}