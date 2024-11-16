<?php
// models/AdminUser.php

require_once 'User.php';
require_once '../services/UserService.php';

class AdminUser extends User {
    public function __construct($id, $user_name) {
        parent::__construct($id, $user_name, 'admin');
    }

    // Admin-specific methods
    public function accessDashboard() {
        // Implement admin dashboard access
    }

    public function assignInstance($userId, $instanceId) {
        $userService = new UserService();
        return $userService->assignInstance($userId, $instanceId);
    }
}
