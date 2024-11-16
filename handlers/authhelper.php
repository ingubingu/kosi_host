<?php
// handlers/AuthHelper.php

require_once 'Session.php';
require_once 'utility.php';

class AuthHelper {

    public static function isAuthenticated() {
        return Session::has('user');
    }

    public static function ensureAuthenticated() {
        if (!self::isAuthenticated()) {
            // Redirect to the login page
            header('Location: /public/home.php'); // Adjust the path to your login page
            exit;
        }
    }

    public static function logout() {
        Session::start(); // Ensure the session is started
        Session::destroy();
        // Redirect to the home page
        Utility::vdirect('home');
        exit;
    }

    public static function restrictAccess($requiredRole) {
        if (!self::isAuthenticated()) {
            // Redirect to the login page
            Utility::vdirect('home'); // Adjust the path to your login page
            exit;
        }

        $user = Session::get('user');
        if ($user['role'] !== $requiredRole) {
            // Redirect to an unauthorized access page
            Utility::vdirect('home'); // Create this page as needed
            exit;
        }
    }
}
