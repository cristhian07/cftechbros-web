<?php
namespace App\Models;

use App\Core\Database;
use PDO;

class Permission
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAll()
    {
        $stmt = $this->db->query("SELECT * FROM permissions ORDER BY name");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM permissions WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findByName($name)
    {
        $stmt = $this->db->prepare("SELECT * FROM permissions WHERE name = :name");
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($name, $description, $serviceIds)
    {
        $this->db->beginTransaction();
        try {
            // 1. Insertar el nuevo permiso
            $sqlPermission = "INSERT INTO permissions (name, description) VALUES (:name, :description)";
            $stmtPermission = $this->db->prepare($sqlPermission);
            $stmtPermission->execute([':name' => $name, ':description' => $description]);
            $permissionId = $this->db->lastInsertId();

            // 2. Vincular el permiso con los servicios seleccionados
            if (!empty($serviceIds)) {
                $sqlLink = "INSERT INTO service_permission (service_id, permission_id) VALUES (:service_id, :permission_id)";
                $stmtLink = $this->db->prepare($sqlLink);
                foreach ($serviceIds as $serviceId) {
                    $stmtLink->execute([':service_id' => $serviceId, ':permission_id' => $permissionId]);
                }
            }

            $this->db->commit();
            return $permissionId;
        } catch (\Exception $e) {
            $this->db->rollBack();
            error_log("Error al crear permiso: " . $e->getMessage());
            return false;
        }
    }

    public function update($id, $name, $description, $serviceIds)
    {
        // Comprobar la unicidad del nombre antes de la transacción para una mejor experiencia de usuario.
        $existing = $this->findByName($name);
        if ($existing && $existing['id'] != $id) {
            // El nombre ya está en uso por otro permiso.
            error_log("Intento de actualizar el permiso #{$id} con un nombre duplicado '{$name}' que ya usa el permiso #{$existing['id']}");
            return false;
        }

        $this->db->beginTransaction();
        try {
            // 1. Actualizar los detalles del permiso
            $sql = "UPDATE permissions SET name = :name, description = :description WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':id' => $id, ':name' => $name, ':description' => $description]);

            // 2. Actualizar los servicios asociados (borrar e insertar)
            $stmtDelete = $this->db->prepare("DELETE FROM service_permission WHERE permission_id = :permission_id");
            $stmtDelete->execute([':permission_id' => $id]);

            if (!empty($serviceIds)) {
                $insertSql = "INSERT INTO service_permission (service_id, permission_id) VALUES (:service_id, :permission_id)";
                $stmtInsert = $this->db->prepare($insertSql);
                foreach ($serviceIds as $serviceId) {
                    $stmtInsert->execute(['service_id' => $serviceId, 'permission_id' => $id]);
                }
            }

            $this->db->commit();
            return true;
        } catch (\Exception $e) {
            $this->db->rollBack();
            error_log("Error al actualizar permiso: " . $e->getMessage());
            return false;
        }
    }

    public function delete($id)
    {
        $this->db->beginTransaction();
        try {
            // Eliminar de role_permission
            $stmtRole = $this->db->prepare("DELETE FROM role_permission WHERE permission_id = :id");
            $stmtRole->execute([':id' => $id]);

            // Eliminar de service_permission
            $stmtService = $this->db->prepare("DELETE FROM service_permission WHERE permission_id = :id");
            $stmtService->execute([':id' => $id]);

            // Eliminar de permissions
            $stmtPerm = $this->db->prepare("DELETE FROM permissions WHERE id = :id");
            $stmtPerm->execute([':id' => $id]);

            $this->db->commit();
            return true;
        } catch (\Exception $e) {
            $this->db->rollBack();
            error_log("Error al eliminar permiso: " . $e->getMessage());
            return false;
        }
    }

    public function getAssociatedServiceIds($permissionId)
    {
        $sql = "SELECT service_id FROM service_permission WHERE permission_id = :permission_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':permission_id', $permissionId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function isPermissionInUseByRole($permissionId)
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM role_permission WHERE permission_id = :permission_id");
        $stmt->bindParam(':permission_id', $permissionId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }
}