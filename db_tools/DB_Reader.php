<?php
// DB_Reader.php

require_once 'DB_Connector.php';

class DB_Reader {
    protected $pdo;

    public function __construct(PDO $pdo = null) {
        // Use the provided PDO instance or get one from DB_Connector
        $this->pdo = $pdo ?? DB_Connector::getConnection();
    }

    public function readData($table, $columns = '*', $conditions = '', $params = []) {
        if (is_array($columns)) {
            $columns = implode(', ', $columns);
        }

        $sql = "SELECT $columns FROM `$table`";

        if ($conditions) {
            $sql .= " WHERE $conditions";
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    public function exists($table, $conditions = '', $params = []) {
        // Build the WHERE clause
        if (is_array($conditions)) {
            $whereClauses = [];
            foreach ($conditions as $column => $value) {
                $whereClauses[] = "`$column` = :$column";
            }
            $where = implode(' AND ', $whereClauses);
        } else {
            $where = $conditions;
        }

        $sql = "SELECT 1 FROM `$table`";
        if (!empty($where)) {
            $sql .= " WHERE $where";
        }
        $sql .= " LIMIT 1";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        // Fetch the result
        return (bool) $stmt->fetchColumn();
    }
}
?>
