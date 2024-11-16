<?php
// models/RegularUser.php

require_once 'User.php';

class RegularUser extends User {
    public function __construct($id, $user_name) {
        parent::__construct($id, $user_name, 'user');
    }

    // RegularUser-specific methods can go here
}
