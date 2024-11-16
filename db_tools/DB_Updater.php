<?php
// DB_Updater.php

require_once 'DB_Connector.php';

class DB_Updater {
    protected $pdo;

    public function __construct(PDO $pdo = null) {
        $this->pdo = $pdo ?? DB_Connector::getConnection();
    }

    public function updateData($table, $data, $conditions, $params = []) {
        // Build the SET part of the query
        $setPart = '';
        foreach ($data as $column => $value) {
            $setPart .= "`$column` = :$column, ";
        }
        $setPart = rtrim($setPart, ', ');

        $sql = "UPDATE `$table` SET $setPart WHERE $conditions";

        // Merge data and condition parameters
        $allParams = array_merge($data, $params);

        $stmt = $this->pdo->prepare($sql);

        try {
            $stmt->execute($allParams);
            return $stmt->rowCount(); // Number of affected rows
        } catch (\PDOException $e) {
            throw new \Exception('Update Error: ' . $e->getMessage());
        }
    }
}
?>
