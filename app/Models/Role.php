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
        $sql = "SELECT p.name 
                FROM permissions p
                JOIN role_permission rp ON p.id = rp.permission_id
                WHERE rp.role_id = :role_id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':role_id', $roleId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function updatePermissions($roleId, $permissionNames)
    {
        $this->db->beginTransaction();
        try {
            // 1. Borrar todos los permisos actuales del rol
            $stmt = $this->db->prepare("DELETE FROM role_permission WHERE role_id = :role_id");
            $stmt->bindParam(':role_id', $roleId, PDO::PARAM_INT);
            $stmt->execute();

            // 2. Obtener los IDs de los permisos a partir de sus nombres
            if (!empty($permissionNames)) {
                $placeholders = implode(',', array_fill(0, count($permissionNames), '?'));
                $sql = "SELECT id FROM permissions WHERE name IN ($placeholders)";
                $stmt = $this->db->prepare($sql);
                $stmt->execute($permissionNames);
                $permissionIds = $stmt->fetchAll(PDO::FETCH_COLUMN);

                // 3. Insertar los nuevos permisos para el rol
                $insertSql = "INSERT INTO role_permission (role_id, permission_id) VALUES (:role_id, :permission_id)";
                $stmt = $this->db->prepare($insertSql);
                foreach ($permissionIds as $permissionId) {
                    $stmt->execute(['role_id' => $roleId, 'permission_id' => $permissionId]);
                }
            }

            $this->db->commit();
            return true;
        } catch (\Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }
}