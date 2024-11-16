<?php

function checkUserNameExists($user_name) {
    try {
        $reader = new DB_Reader();
        return $reader->exists(
            'users',                   // Table name
            'user_name = :user_name',  // Condition
            ['user_name' => $user_name] // Parameters for the condition
        );
    } catch (Exception $e) {
        // Handle exceptions (e.g., log the error, display a message)
        throw $e;
    }
}



?>