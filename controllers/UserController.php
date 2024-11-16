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

    /**
     * Updates user information.
     *
     * @param int $userId
     * @param array $data
     * @return bool
     */
    public function updateUser($userId, $data) {
        return $this->userService->updateUser($userId, $data);
    }

    /**
     * Deletes a user.
     *
     * @param int $userId
     * @return bool
     */
    public function deleteUser($userId) {
        return $this->userService->deleteUser($userId);
    }

    /**
     * Changes the role of a user.
     *
     * @param int $userId
     * @param string $newRole
     * @return bool
     */
    public function changeUserRole($userId, $newRole) {
        return $this->userService->changeUserRole($userId, $newRole);
    }

    /**
     * Retrieves instances assigned to a user.
     *
     * @param int $userId
     * @return array
     */
    public function getUserInstances($userId) {
        return $this->userService->getUserInstances($userId);
    }
}
