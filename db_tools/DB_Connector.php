<?php
// DB_Connector.php

class DB_Connector {
    private static $pdo = null;

    // Private constructor to prevent direct instantiation
    private function __construct() {
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
}
?>
