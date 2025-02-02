<?php

namespace App\config;

/**
 * Class SessionConfig
 *
 * Manages PHP session configurations, including secure session settings,
 * cookie parameters, and session regeneration.
 *
 * @package App\Config
 */
class SessionConfig
{
    /**
     * Starts the session with secure configurations.
     *
     * Defines the base URL, sets session parameters, and starts the session.
     * Also handles session regeneration to enhance security.
     *
     * @return void
     */
    public static function start()
    {
        define('BASE_URL', 'http://localhost:8080/public/');

        ini_set('session.use_strict_mode', 1);
        ini_set('session.use_only_cookies', 1);

        session_set_cookie_params([
            'lifetime' => 1800, 
            'path' => '/',
            'domain' => 'localhost',
            'secure' => false,
            'httponly' => true,
        ]);

        session_start();

        if (!isset($_SESSION['last_regeneration'])) {
            self::regenerateSession();
        } else {
            $interval = 60 * 30; 
            if (time() - $_SESSION['last_regeneration'] >= $interval) {
                self::regenerateSession();
            }
        }
    }

    /**
     * Regenerates the session ID and updates the last regeneration timestamp.
     *
     * @return void
     */
    private static function regenerateSession()
    {
        session_regenerate_id(true);
        $_SESSION['last_regeneration'] = time();
    }
}
