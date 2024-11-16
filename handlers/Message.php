<?php
// handlers/Message.php

require_once 'Session.php';

class Message {
    const SESSION_KEY = "messages";

    public static function addMessage($message, $type = 'error') {
        Session::start();
        $messages = Session::get(self::SESSION_KEY, []);
        $messages[] = [
            'text' => $message,
            'type' => $type
        ];
        Session::set(self::SESSION_KEY, $messages);
    }

    public static function getMessages() {
        Session::start();
        $messages = Session::get(self::SESSION_KEY, []);
        Session::remove(self::SESSION_KEY); // Clear messages after retrieval
        return $messages;
    }

    public static function logInStatus() {
        $user = Session::get('user');
        if ($user === null || !isset($user['user_name'])) {
            echo 'Currently not logged in';
        } else {
            echo 'Logged in as, ' . htmlspecialchars($user['user_name']);
        }
    }

    public static function homeWelcome() {
        if (Session::has('user')) {
            echo 'Welcome to our homepage, ' . htmlspecialchars(Session::get('user')['user_name']);
        } else {
            echo 'Welcome to our homepage,';
        }
    }
}
