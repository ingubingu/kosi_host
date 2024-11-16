<?php
// DB_Inserter.php

require_once 'DB_Connector.php';

class DB_Inserter {
    protected $pdo;

    public function __construct(PDO $pdo = null) {
        $this->pdo = $pdo ?? DB_Connector::getConnection();
    }

    public function insertData($table, $data) {
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));

        $sql = "INSERT INTO `$table` ($columns) VALUES ($placeholders)";

        $stmt = $this->pdo->prepare($sql);

        try {
            $stmt->execute($data);
            return $this->pdo->lastInsertId();
        } catch (\PDOException $e) {
            throw new \Exception('Insert Error: ' . $e->getMessage());
        }
    }
}
?>
