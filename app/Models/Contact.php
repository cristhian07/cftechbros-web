<?php
namespace App\Models;

use App\Core\Database;
use PDO;

/**
 * Clase Contact (Modelo)
 * Representa la tabla `contacts` en la base de datos y maneja las operaciones de guardado y obtención de mensajes.
 */
class Contact
{
    private $db;
    private $table = 'contacts';

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Actualiza el estado de un mensaje de contacto.
     * @param int $id El ID del mensaje.
     * @param string $status El nuevo estado ('Leído' o 'Pendiente').
     * @return bool
     */
    public function updateStatus($id, $status)
    {
        $stmt = $this->db->prepare("UPDATE {$this->table} SET status = :status WHERE id = :id");
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * Guarda un nuevo mensaje de contacto en la base de datos.
     * @param string $name
     * @param string $email
     * @param string $subject
     * @param string $message
     * @return bool
     */
    public function create($name, $email, $subject, $message)
    {
        $stmt = $this->db->prepare("INSERT INTO {$this->table} (name, email, subject, message) VALUES (:name, :email, :subject, :message)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':subject', $subject);
        $stmt->bindParam(':message', $message);
        return $stmt->execute();
    }

    /**
     * Obtiene todos los mensajes de contacto de la base de datos.
     * @return array
     */
    public function getAllContacts()
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} ORDER BY created_at DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    /**
     * Elimina un mensaje de contacto de la base de datos.
     * @param int $id El ID del mensaje a eliminar.
     * @return bool
     */
    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}