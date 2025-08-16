<?php
namespace App\Core;

use PDO;
use PDOException;

/**
 * Clase Database
 * Implementa el patrón Singleton para asegurar una única instancia de conexión a la base de datos (PDO).
 */
class Database
{
    private static $instance = null; // Almacena la única instancia de la clase
    private $connection; // Objeto de conexión PDO

    /**
     * Constructor privado para prevenir instanciación directa.
     * Establece la conexión a la base de datos usando PDO.
     */
    private function __construct()
    {
        // Cadena de conexión DSN (Data Source Name)
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
        try {
            // Crea una nueva conexión PDO
            $this->connection = new PDO($dsn, DB_USER, DB_PASS);
            // Configura el modo de errores para lanzar excepciones
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // Configura el modo de fetch predeterminado para devolver arrays asociativos
            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // En caso de error de conexión, termina la ejecución y muestra el mensaje de error
            // En producción, esto debería ser manejado de forma más elegante (ej. loggear el error y mostrar una página amigable)
            die('Error de conexión a la base de datos: ' . $e->getMessage());
        }
    }

    /**
     * Obtiene la única instancia de la clase Database.
     * Si la instancia no existe, la crea.
     * @return Database La instancia única de la clase Database.
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Obtiene el objeto de conexión PDO.
     * @return PDO El objeto PDO de la conexión a la base de datos.
     */
    public function getConnection()
    {
        return $this->connection;
    }
}
