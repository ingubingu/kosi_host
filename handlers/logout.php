<?php
// public/logout.php

require_once '../handlers/Session.php';
require_once '../handlers/Message.php';
require_once 'utility.php';

Session::start();
Session::destroy();

// Optionally regenerate the session ID for security
Session::regenerate();

Message::addMessage('You have been successfully logged out.', 'success');



// Redirect the user to the home page or login page
Utility::vdirect('home');
exit;
?>
