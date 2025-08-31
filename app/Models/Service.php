<?php
namespace App\Models;

use App\Core\Database;
use PDO;

class Service
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Obtiene todos los servicios marcados como destacados para la página de inicio.
     * @return array
     */
    public function getFeaturedServices()
    {
        // Esta consulta asume que la tabla 'services' tiene las columnas 'is_featured' y 'image_url'.
        $stmt = $this->db->prepare("SELECT name, description, image_url FROM services WHERE is_featured = 1 ORDER BY id ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene todos los servicios contratados y activos por un usuario específico.
     * @param int $userId
     * @return array
     */
    public function getServicesByUserId($userId)
    {
        $sql = "SELECT s.id, s.name, s.description, s.icon_class, s.route, us.status, us.contract_date
                FROM services s
                JOIN user_service us ON s.id = us.service_id
                WHERE us.user_id = :user_id AND us.status = 'activo'
                ORDER BY s.name";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene un servicio específico por su ID, pero solo si el usuario lo tiene contratado y activo.
     * @param int $serviceId
     * @param int $userId
     * @return array|false
     */
    public function findUserActiveServiceById($serviceId, $userId)
    {
        $sql = "SELECT s.id, s.name, s.description, s.icon_class, s.route, us.status, us.contract_date
                FROM services s
                JOIN user_service us ON s.id = us.service_id
                WHERE s.id = :service_id AND us.user_id = :user_id AND us.status = 'activo'";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':service_id', $serviceId, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene todos los servicios disponibles en el sistema.
     * @return array
     */
    public function getAll()
    {
        $stmt = $this->db->query("SELECT * FROM services ORDER BY name");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Crea un nuevo servicio y su permiso de acceso asociado de forma transaccional.
     * @param string $name
     * @param string $description
     * @param string $icon_class
     * @param string $route
     * @param string|null $image_url
     * @param int $is_featured
     * @param array $additionalPermissionNames
     * @return bool
     */
    public function create($name, $description, $icon_class, $route, $image_url, $is_featured, $additionalPermissionNames)
    {
        $this->db->beginTransaction();

        try {
            // 1. Insertar el nuevo servicio
            $sqlService = "INSERT INTO services (name, description, icon_class, route, image_url, is_featured) VALUES (:name, :description, :icon_class, :route, :image_url, :is_featured)";
            $stmtService = $this->db->prepare($sqlService);
            $stmtService->execute([
                ':name' => $name,
                ':description' => $description,
                ':icon_class' => $icon_class,
                ':route' => $route,
                ':image_url' => $image_url,
                ':is_featured' => $is_featured
            ]);
            $serviceId = $this->db->lastInsertId();

            // Vincular los permisos adicionales seleccionados
            if (!empty($additionalPermissionNames)) {
                $placeholders = implode(',', array_fill(0, count($additionalPermissionNames), '?'));
                $sqlGetIds = "SELECT id FROM permissions WHERE name IN ($placeholders)";
                $stmtGetIds = $this->db->prepare($sqlGetIds);
                $stmtGetIds->execute($additionalPermissionNames);
                $permissionIds = $stmtGetIds->fetchAll(PDO::FETCH_COLUMN);

                $insertSql = "INSERT INTO service_permission (service_id, permission_id) VALUES (:service_id, :permission_id)";
                $stmt = $this->db->prepare($insertSql);
                foreach ($permissionIds as $permId) {
                    $stmt->execute(['service_id' => $serviceId, 'permission_id' => $permId]);
                }
            }

            $this->db->commit();
            return true;
        } catch (\Exception $e) {
            $this->db->rollBack();
            error_log("Error al crear servicio: " . $e->getMessage()); // Opcional: para depuración
            return false;
        }
    }

    public function findById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM services WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getPermissions($serviceId)
    {
        $sql = "SELECT p.name 
                FROM permissions p
                JOIN service_permission sp ON p.id = sp.permission_id
                WHERE sp.service_id = :service_id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':service_id', $serviceId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    /**
     * Actualiza un servicio existente y sus permisos asociados de forma transaccional.
     * @param int $id
     * @param string $name
     * @param string $description
     * @param string $icon_class
     * @param string $route
     * @param string|null $image_url
     * @param int $is_featured
     * @param array $permissionNames
     * @return bool
     */
    public function update($id, $name, $description, $icon_class, $route, $image_url, $is_featured, $permissionNames)
    {
        $this->db->beginTransaction();
        try {
            // 1. Actualizar los detalles del servicio
            $sql = "UPDATE services SET name = :name, description = :description, icon_class = :icon_class, route = :route, image_url = :image_url, is_featured = :is_featured WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':id' => $id,
                ':name' => $name,
                ':description' => $description,
                ':icon_class' => $icon_class,
                ':route' => $route,
                ':image_url' => $image_url,
                ':is_featured' => $is_featured
            ]);

            // 2. Actualizar los permisos (borrar e insertar)
            $stmtDelete = $this->db->prepare("DELETE FROM service_permission WHERE service_id = :service_id");
            $stmtDelete->execute([':service_id' => $id]);

            if (!empty($permissionNames)) {
                $placeholders = implode(',', array_fill(0, count($permissionNames), '?'));
                $sqlGetIds = "SELECT id FROM permissions WHERE name IN ($placeholders)";
                $stmtGetIds = $this->db->prepare($sqlGetIds);
                $stmtGetIds->execute($permissionNames);
                $permissionIds = $stmtGetIds->fetchAll(PDO::FETCH_COLUMN);

                $insertSql = "INSERT INTO service_permission (service_id, permission_id) VALUES (:service_id, :permission_id)";
                $stmt = $this->db->prepare($insertSql);
                foreach ($permissionIds as $permissionId) {
                    $stmt->execute(['service_id' => $id, 'permission_id' => $permissionId]);
                }
            }
            $this->db->commit();
            return true;
        } catch (\Exception $e) {
            $this->db->rollBack();
            error_log("Error al actualizar servicio: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Comprueba si un servicio está siendo utilizado por algún usuario.
     * @param int $serviceId
     * @return bool
     */
    public function isServiceInUse($serviceId)
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM user_service WHERE service_id = :service_id");
        $stmt->bindParam(':service_id', $serviceId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    /**
     * Elimina un servicio y todas sus asociaciones de forma transaccional.
     * @param int $id El ID del servicio a eliminar.
     * @return bool
     */
    public function delete($id)
    {
        $this->db->beginTransaction();
        try {
            // 1. Eliminar asignaciones a usuarios en 'user_service'
            $stmtUser = $this->db->prepare("DELETE FROM user_service WHERE service_id = :id");
            $stmtUser->execute([':id' => $id]);

            // 2. Eliminar asignaciones de permisos en 'service_permission'
            $stmtSvcPerm = $this->db->prepare("DELETE FROM service_permission WHERE service_id = :id");
            $stmtSvcPerm->execute([':id' => $id]);

            // NOTA: Ya no se elimina el permiso asociado automáticamente.
            // Esto debe hacerse manualmente desde la sección de gestión de permisos si se desea.

            // 3. Finalmente, eliminar el servicio de la tabla 'services'
            $stmtService = $this->db->prepare("DELETE FROM services WHERE id = :id");
            $stmtService->execute([':id' => $id]);

            $this->db->commit();
            return true;
        } catch (\Exception $e) {
            $this->db->rollBack();
            error_log("Error al eliminar servicio: " . $e->getMessage());
            return false;
        }
    }
}
