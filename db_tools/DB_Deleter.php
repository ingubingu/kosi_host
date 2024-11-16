<?php
// DB_Deleter.php

require_once 'DB_Connector.php';

class DB_Deleter {
    protected $pdo;

    public function __construct(PDO $pdo = null) {
        $this->pdo = $pdo ?? DB_Connector::getConnection();
    }

    public function deleteData($table, $conditions, $params = []) {
        $sql = "DELETE FROM `$table` WHERE $conditions";

        $stmt = $this->pdo->prepare($sql);

        try {
            $stmt->execute($params);
            return $stmt->rowCount(); // Number of deleted rows
        } catch (\PDOException $e) {
            throw new \Exception('Delete Error: ' . $e->getMessage());
        }
    }
}
?>
