<?php
// services/UserService.php

require_once '../db_tools/DB_Tools.php';
require_once '../models/User.php';
require_once '../models/AdminUser.php';
require_once '../models/RegularUser.php';

class UserService {
    private $dbTools;

    public function __construct() {
        $this->dbTools = new DB_Tools();
    }

    public function updateUser($userId, $data) {
        $this->dbTools->updateData('users', $data, 'id = :id', ['id' => $userId]);
        return true;
    }
    
    public function deleteUser($userId) {
        $this->dbTools->deleteData('users', 'id = :id', ['id' => $userId]);
        return true;
    }
    
    public function changeUserRole($userId, $newRole) {
        $this->dbTools->updateData('users', ['role' => $newRole], 'id = :id', ['id' => $userId]);
        return true;
    }

    public function getUserDetails($userId) {
        return $this->dbTools->readData('users', ['id', 'user_name', 'role', 'created_at'], 'id = :id', ['id' => $userId]);
    }
    
    public function getUserInstances($userId) {
        return $this->dbTools->readData('user_instances', ['instance_id', 'assigned_at'], 'user_id = :user_id', ['user_id' => $userId]);
    }
    
    public function isUsernameTaken($user_name) {
        return $this->dbTools->exists('users', 'user_name = :user_name', ['user_name' => $user_name]);
    }

    public function registerUser($user_name, $password) {
        if ($this->isUsernameTaken($user_name)) {
            throw new Exception('Username already exists.');
        }

        $data = [
            'user_name' => $user_name,
            'password' => $password, // Password hashing is recommended
            'role' => 'user', // Default role
        ];

        $this->dbTools->insertData('users', $data);
        return true;
    }

    public function authenticate($user_name, $password) {
        $result = $this->dbTools->readData(
            'users',
            ['id', 'user_name', 'role'],
            'user_name = :user_name AND password = :password',
            ['user_name' => $user_name, 'password' => $password]
        );

        if (!empty($result)) {
            $userData = $result[0];
            return $this->createUserObject($userData);
        }
        return null;
    }

    private function createUserObject($userData) {
        if ($userData['role'] === 'admin') {
            return new AdminUser($userData['id'], $userData['user_name']);
        } else {
            return new RegularUser($userData['id'], $userData['user_name']);
        }
    }

    public function getAccountAge($user_name) {
        $result = $this->dbTools->readData(
            'users',
            ['created_at', 'role'],
            'user_name = :user_name',
            ['user_name' => $user_name]
        );

        if (!empty($result)) {
            $row = $result[0];
            $created_at = new DateTime($row['created_at']);
            $current_date = new DateTime();
            $interval = $created_at->diff($current_date);

            return [
                'account_age_months' => $interval->m + ($interval->y * 12),
                'account_age_days' => $interval->d,
                'account_age_hours' => $interval->h,
                'account_age_minutes' => $interval->i,
                'role' => $row['role'],
            ];
        }

        return null;
    }

    public function getAllUsers() {
        $result = $this->dbTools->readData('users', ['user_name']);

        $users = [];
        foreach ($result as $row) {
            $users[] = $row['user_name'];
        }
        return $users;
    }

    public function assignInstance($userId, $instanceId) {
        $data = [
            'user_id' => $userId,
            'instance_id' => $instanceId,
        ];

        $this->dbTools->insertData('user_instances', $data);
        return true;
    }

    public function getId($user_name) {
        $result = $this->dbTools->readData(
            'users',
            ['id'],
            'user_name = :user_name',
            ['user_name' => $user_name]
        );

        if (!empty($result)) {
            return $result[0]['id'];
        }

        return null; // Return null if user not found
    }


//create function that makes table from columns using db_tools function
    public function createTable($table_name, $columns) {
        $this->dbTools->createTable($table_name, $columns);
        return true;
    }


}

?>

