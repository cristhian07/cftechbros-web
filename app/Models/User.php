<?php
namespace App\Models;

use App\Core\Database;
use PDO;

/**
 * Clase User (Modelo)
 * Representa la tabla `users` en la base de datos y maneja las operaciones CRUD básicas para usuarios.
 */
class User
{
    private $db; // Instancia de la conexión a la base de datos
    private $table = 'users'; // Nombre de la tabla de usuarios

    /**
     * Constructor de la clase User.
     * Inicializa la conexión a la base de datos.
     */
    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Busca un usuario por su nombre de usuario.
     * Utiliza prepared statements para prevenir inyección SQL.
     * @param string $username El nombre de usuario a buscar.
     * @return array|false El usuario como array asociativo si se encuentra, o false si no.
     */
    public function findByUsername($username)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE username = :username LIMIT 1");
        $stmt->bindParam(':username', $username); // Enlaza el parámetro
        $stmt->execute(); // Ejecuta la consulta
        return $stmt->fetch(PDO::FETCH_ASSOC); // Obtiene la primera fila como array asociativo
    }

    /**
     * Busca un usuario por su dirección de correo electrónico.
     * Utiliza prepared statements para prevenir inyección SQL.
     * @param string $email La dirección de correo electrónico a buscar.
     * @return array|false El usuario como array asociativo si se encuentra, o false si no.
     */
    public function findByEmail($email)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE email = :email LIMIT 1");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Crea un nuevo usuario en la base de datos.
     * La contraseña debe ser un hash seguro (ej. con `password_hash()`) antes de ser pasada a este método.
     * Utiliza prepared statements para una inserción segura.
     * @param string $username El nombre de usuario.
     * @param string $email La dirección de correo electrónico.
     * @param string $hashedPassword La contraseña ya hasheada.
     * @return bool True si el usuario se creó correctamente, false en caso contrario.
     */
    public function create($username, $email, $hashedPassword)
    {
        $stmt = $this->db->prepare("INSERT INTO {$this->table} (username, email, password) VALUES (:username, :email, :password)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);
        return $stmt->execute(); // Devuelve true en caso de éxito, false en caso de fallo
    }
}
