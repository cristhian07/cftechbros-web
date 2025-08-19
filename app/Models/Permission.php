<?php
namespace App\Models;

use App\Core\Database;
use PDO;

class Permission
{
    private $db;
    private $table = 'permissions';

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAll()
    {
        $stmt = $this->db->query("SELECT * FROM {$this->table} ORDER BY description");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}