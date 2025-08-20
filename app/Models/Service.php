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
     * @return bool
     */
    public function create($name, $description, $icon_class, $route)
    {
        // Generar un nombre de permiso único y seguro basado en el nombre del servicio.
        // Ej: "Soporte Técnico" -> "access_soporte_tecnico"
        $permissionName = 'access_' . strtolower(preg_replace('/[^a-zA-Z0-9]+/', '_', str_replace(' ', '_', iconv('UTF-8', 'ASCII//TRANSLIT', $name))));
        $permissionDescription = "Permite el acceso al servicio: " . $name;

        $this->db->beginTransaction();

        try {
            // 1. Insertar el nuevo servicio
            $sqlService = "INSERT INTO services (name, description, icon_class, route) VALUES (:name, :description, :icon_class, :route)";
            $stmtService = $this->db->prepare($sqlService);
            $stmtService->execute([
                ':name' => $name,
                ':description' => $description,
                ':icon_class' => $icon_class,
                ':route' => $route
            ]);
            $serviceId = $this->db->lastInsertId();

            // 2. Insertar el nuevo permiso asociado
            $sqlPermission = "INSERT INTO permissions (name, description) VALUES (:name, :description)";
            $stmtPermission = $this->db->prepare($sqlPermission);
            $stmtPermission->execute([':name' => $permissionName, ':description' => $permissionDescription]);
            $permissionId = $this->db->lastInsertId();

            // 3. Vincular el servicio con su nuevo permiso en la tabla pivote
            $sqlLink = "INSERT INTO service_permission (service_id, permission_id) VALUES (:service_id, :permission_id)";
            $stmtLink = $this->db->prepare($sqlLink);
            $stmtLink->execute([':service_id' => $serviceId, ':permission_id' => $permissionId]);

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

    public function updatePermissions($serviceId, $permissionNames)
    {
        $this->db->beginTransaction();
        try {
            // 1. Borrar todos los permisos actuales del servicio
            $stmt = $this->db->prepare("DELETE FROM service_permission WHERE service_id = :service_id");
            $stmt->bindParam(':service_id', $serviceId, PDO::PARAM_INT);
            $stmt->execute();

            // 2. Obtener los IDs de los permisos a partir de sus nombres
            if (!empty($permissionNames)) {
                $placeholders = implode(',', array_fill(0, count($permissionNames), '?'));
                $sql = "SELECT id FROM permissions WHERE name IN ($placeholders)";
                $stmt = $this->db->prepare($sql);
                $stmt->execute($permissionNames);
                $permissionIds = $stmt->fetchAll(PDO::FETCH_COLUMN);

                // 3. Insertar los nuevos permisos para el servicio
                $insertSql = "INSERT INTO service_permission (service_id, permission_id) VALUES (:service_id, :permission_id)";
                $stmt = $this->db->prepare($insertSql);
                foreach ($permissionIds as $permissionId) {
                    $stmt->execute(['service_id' => $serviceId, 'permission_id' => $permissionId]);
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
