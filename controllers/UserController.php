<?php
// controllers/UserController.php

require_once '../services/UserService.php';
require_once '../handlers/Session.php';

class UserController {
    private $userService;

    public function __construct() {
        $this->userService = new UserService();
    }

    public function displayAccountAge($user_name) {
        return $this->userService->getAccountAge($user_name);
    }

    public function getAllUsers() {
        return $this->userService->getAllUsers();
    }

    public function register($user_name, $password) {
        return $this->userService->registerUser($user_name, $password);
    }

    public function getId($user_name) {
        return $this->userService->getId($user_name);
    }

    public function login($user_name, $password) {
        $user = $this->userService->authenticate($user_name, $password);

        if ($user) {
            // Store user data in the session
            Session::set('user', [
                'id' => $user->getId(),
                'user_name' => $user->getUsername(),
                'role' => $user->getRole(),
            ]);

            return $user;
        }

        return null;
    }

    public function updateUser($userId, $data) {
        return $this->userService->updateUser($userId, $data);
    }

    public function deleteUser($userId) {
        return $this->userService->deleteUser($userId);
    }

    public function changeUserRole($userId, $newRole) {
        return $this->userService->changeUserRole($userId, $newRole);
    }

    public function getUserInstances($userId) {
        return $this->userService->getUserInstances($userId);
    }

    public function getUserDetails($userId) {
        return $this->userService->getUserDetails($userId);
    }

    public function createTable($table_name, $columns) {
        return $this->userService->createTable($table_name, $columns);
    }

    public function getUserByUsername($username) {
        // Implement the logic to get user by username
        // For example, you can query the database to get the user details
        // Return the user details as an associative array or false if not found
        $user = [
            'username' => $username,
            'email' => 'user@example.com',
            'name' => 'John Doe'
        ];
        return $user;
    }
}
?>