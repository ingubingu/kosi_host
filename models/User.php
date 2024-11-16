<?php
// models/User.php

class User {
    protected $id;
    protected $user_name;
    protected $role;

    public function __construct($id, $user_name, $role = 'user') {
        $this->id = $id;
        $this->user_name = $user_name;
        $this->role = $role;
    }

    public function getId() {
        return $this->id;
    }

    public function getUsername() {
        return $this->user_name;
    }

    public function getRole() {
        return $this->role;
    }

    public function isAdmin() {
        return $this->role === 'admin';
    }
}
