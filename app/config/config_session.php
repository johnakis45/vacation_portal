<?php

define('BASE_URL', 'http://localhost:8080/public/');

// Secure session settings
ini_set('session.use_strict_mode', 1);
ini_set('session.use_only_cookies', 1);

// Set session cookie parameters
session_set_cookie_params([
    'lifetime' => 1800,  // 30 minutes
    'path' => '/',
    'domain' => 'localhost',
    'secure' => false,  // Set to true if using HTTPS
    'httponly' => true,
]);

session_start();

// Regenerate session if needed
if (!isset($_SESSION['last_regeneration'])) {
    regenerate_session();
} else {
    $interval = 60 * 30;  // 30 minutes
    if (time() - $_SESSION['last_regeneration'] >= $interval) {
        regenerate_session();
    }
}

function regenerate_session() {
    session_regenerate_id(true); // True = delete old session
    $_SESSION['last_regeneration'] = time();
}
