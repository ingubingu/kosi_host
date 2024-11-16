<?php
// services/UserService.php

require_once '../db_tools/DB_Deleter.php';
require_once '../db_tools/DB_Updater.php';
require_once '../db_tools/DB_Reader.php';
require_once '../db_tools/DB_Inserter.php';
require_once '../models/User.php';
require_once '../models/AdminUser.php';
require_once '../models/RegularUser.php';

class UserService {
    private $dbReader;
    private $dbInserter;
    private $dbUpdater;
    private $dbDeleter;

    public function __construct() {
        $this->dbReader = new DB_Reader();
        $this->dbInserter = new DB_Inserter();
        $this->dbUpdater = new DB_Updater();
        $this->dbDeleter = new DB_Deleter();
    }

    public function updateUser($userId, $data) {
        $this->dbUpdater->updateData('users', $data, 'id = :id', ['id' => $userId]);
        return true;
    }
    
    public function deleteUser($userId) {
        $this->dbDeleter->deleteData('users', 'id = :id', ['id' => $userId]);
        return true;
    }
    
    public function changeUserRole($userId, $newRole) {
        $this->dbUpdater->updateData('users', ['role' => $newRole], 'id = :id', ['id' => $userId]);
        return true;
    }

    public function getUserDetails($userId) {
        return $this->dbReader->readData('users', ['id', 'user_name', 'role', 'created_at'], 'id = :id', ['id' => $userId]);
    }
    
    public function getUserInstances($userId) {
        return $this->dbReader->readData('user_instances', ['instance_id', 'assigned_at'], 'user_id = :user_id', ['user_id' => $userId]);
    }
    

    /**
     * Checks if a username is already taken.
     *
     * @param string $user_name
     * @return bool
     */
    public function isUsernameTaken($user_name) {
        return $this->dbReader->exists('users', 'user_name = :user_name', ['user_name' => $user_name]);
    }

    /**
     * Registers a new user.
     *
     * @param string $user_name
     * @param string $password
     * @return bool
     * @throws Exception
     */
    public function registerUser($user_name, $password) {
        if ($this->isUsernameTaken($user_name)) {
            throw new Exception('Username already exists.');
        }

        $data = [
            'user_name' => $user_name,
            'password' => $password, // Password hashing is recommended
            'role' => 'user', // Default role
        ];

        $this->dbInserter->insertData('users', $data);
        return true;
    }

    /**
     * Authenticates a user.
     *
     * @param string $user_name
     * @param string $password
     * @return User|null
     */
    public function authenticate($user_name, $password) {
        $result = $this->dbReader->readData(
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

    /**
     * Creates a User object based on role.
     *
     * @param array $userData
     * @return User
     */
    private function createUserObject($userData) {
        if ($userData['role'] === 'admin') {
            return new AdminUser($userData['id'], $userData['user_name']);
        } else {
            return new RegularUser($userData['id'], $userData['user_name']);
        }
    }

    /**
     * Retrieves account age information.
     *
     * @param string $user_name
     * @return array|null
     */
    public function getAccountAge($user_name) {
        $result = $this->dbReader->readData(
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

    /**
     * Retrieves all usernames.
     *
     * @return array
     */
    public function getAllUsers() {
        $result = $this->dbReader->readData('users', ['user_name']);

        $users = [];
        foreach ($result as $row) {
            $users[] = $row['user_name'];
        }
        return $users;
    }

    /**
     * Assigns an instance to a user (Admin action).
     *
     * @param int $userId
     * @param int $instanceId
     * @return bool
     */
    public function assignInstance($userId, $instanceId) {
        $data = [
            'user_id' => $userId,
            'instance_id' => $instanceId,
        ];

        $this->dbInserter->insertData('user_instances', $data);
        return true;
    }

    

    /**
     * Retrieves the ID of a user by their username.
     *
     * @param string $user_name
     * @return int|null
     */
    public function getId($user_name) {
        $result = $this->dbReader->readData(
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

    
}
