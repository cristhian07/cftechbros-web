<?php
namespace App\Models;

use App\Core\Database;
use PDO;
use PDOException;

/**
 * Clase Contact
 * Modelo para interactuar con la tabla `contacts` de la base de datos.
 */
class Contact
{
    private $db;

    /**
     * Constructor. Obtiene la instancia de la conexión a la base de datos.
     */
    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Crea un nuevo registro de contacto en la base de datos.
     * @param string $name
     * @param string $email
     * @param string $subject
     * @param string $message
     * @return bool True si se creó correctamente, false en caso contrario.
     */
    public function create($name, $email, $subject, $message)
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO contacts (name, email, subject, message, status) VALUES (?, ?, ?, ?, 'Pendiente')");
            return $stmt->execute([$name, $email, $subject, $message]);
        } catch (PDOException $e) {
            // En un entorno real, se debería registrar el error.
            return false;
        }
    }

    /**
     * Obtiene todos los mensajes de contacto, ordenados por fecha de creación descendente.
     * @return array
     */
    public function getAllContacts()
    {
        $stmt = $this->db->query("SELECT * FROM contacts ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    /**
     * Actualiza el estado de un mensaje de contacto.
     * @param int $id
     * @param string $status
     * @return bool
     */
    public function updateStatus($id, $status)
    {
        $stmt = $this->db->prepare("UPDATE contacts SET status = ? WHERE id = ?");
        return $stmt->execute([$status, $id]);
    }

    /**
     * Elimina un mensaje de contacto por su ID.
     * @param int $id
     * @return bool
     */
    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM contacts WHERE id = ?");
        return $stmt->execute([$id]);
    }

    /**
     * Obtiene el número de mensajes de contacto no leídos (con estado 'Pendiente').
     * @return int
     */
    public function getUnreadCount()
    {
        $stmt = $this->db->query("SELECT COUNT(*) as count FROM contacts WHERE status = 'Pendiente'");
        $result = $stmt->fetch();
        return $result ? (int)$result['count'] : 0;
    }
}