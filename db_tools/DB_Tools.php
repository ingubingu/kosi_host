<?php
// db_tools/DB_Tools.php

class DB_Tools {
    private static $pdo = null;

    // Change constructor to public to allow instantiation
    public function __construct() {
    }

    /**
     * Returns a singleton PDO connection.
     *
     * @return PDO The PDO connection instance.
     * @throws PDOException If the connection fails.
     */
    public static function getConnection() {
        if (self::$pdo === null) {
            // Include the configuration file
            $config = require '../includes/config.php';

            // Extract configuration parameters
            $host    = $config['servername'];
            $db      = $config['dbname'];
            $user    = $config['username'];
            $pass    = $config['password'];
            $charset = $config['charset'] ?? 'utf8mb4';

            // Data Source Name
            $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

            // PDO options
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            try {
                // Establish a new PDO connection
                self::$pdo = new PDO($dsn, $user, $pass, $options);
            } catch (\PDOException $e) {
                // Handle connection errors
                throw new \PDOException('Database connection failed: ' . $e->getMessage(), (int)$e->getCode());
            }
        }
        return self::$pdo;
    }

    public static function updateData($table, $data, $conditions, $params = []) {
        $pdo = self::getConnection();
        // Build the SET part of the query
        $setPart = '';
        foreach ($data as $column => $value) {
            $setPart .= "`$column` = :$column, ";
        }
        $setPart = rtrim($setPart, ', ');

        $sql = "UPDATE `$table` SET $setPart WHERE $conditions";

        // Merge data and condition parameters
        $allParams = array_merge($data, $params);

        $stmt = $pdo->prepare($sql);

        try {
            $stmt->execute($allParams);
            return $stmt->rowCount(); // Number of affected rows
        } catch (\PDOException $e) {
            throw new \Exception('Update Error: ' . $e->getMessage());
        }
    }

    public static function readData($table, $columns = '*', $conditions = '', $params = []) {
        $pdo = self::getConnection();
        if (is_array($columns)) {
            $columns = implode(', ', $columns);
        }

        $sql = "SELECT $columns FROM `$table`";

        if ($conditions) {
            $sql .= " WHERE $conditions";
        }

        $stmt = $pdo->prepare($sql);

        try {
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (\PDOException $e) {
            throw new \Exception('Read Error: ' . $e->getMessage());
        }
    }

    public static function exists($table, $conditions = '', $params = []) {
        $pdo = self::getConnection();
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

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        // Fetch the result
        return (bool) $stmt->fetchColumn();
    }

    public static function insertData($table, $data) {
        $pdo = self::getConnection();
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));

        $sql = "INSERT INTO `$table` ($columns) VALUES ($placeholders)";

        $stmt = $pdo->prepare($sql);

        try {
            $stmt->execute($data);
            return $pdo->lastInsertId();
        } catch (\PDOException $e) {
            throw new \Exception('Insert Error: ' . $e->getMessage());
        }
    }

    public static function deleteData($table, $conditions, $params = []) {
        $pdo = self::getConnection();
        $sql = "DELETE FROM `$table` WHERE $conditions";

        $stmt = $pdo->prepare($sql);

        try {
            $stmt->execute($params);
            return $stmt->rowCount(); // Number of deleted rows
        } catch (\PDOException $e) {
            throw new \Exception('Delete Error: ' . $e->getMessage());
        }
    }

    public static function createTable($table_name, $columns) {
        $pdo = self::getConnection();
        try {
            // Start building the SQL statement
            $sql = "CREATE TABLE IF NOT EXISTS `$table_name` (";
            
            // Initialize an array to hold column definitions
            $columnDefinitions = [];
            
            foreach ($columns as $column) {
                $columnName = $column['name'];
                $columnType = $column['type'];
                
                // Sanitize column name to prevent SQL injection
                $safeColumnName = preg_replace('/[^a-zA-Z0-9_]/', '', $columnName);
                $columnDefinitions[] = "`$safeColumnName` $columnType";
            }
            
            // Join the column definitions
            $sql .= implode(", ", $columnDefinitions);
            
            // Close the SQL statement
            $sql .= ") DEFAULT CHARSET=utf8mb4;";

            // Execute the SQL statement
            $pdo->exec($sql);
        } catch (\PDOException $e) {
            throw new \Exception('Error creating table: ' . $e->getMessage());
        }
    }
}