<?php

namespace TODO\App\Lib;

class SessionHdlr {
    public static $interval = 30 * 60;

    public function regenerate_id() {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_regenerate_id();
            $_SESSION['last_regeneration'] = time();
        }
    }

    public function sessionHandel() {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            ini_set('session.use_only_cookies', 1);
            ini_set('session.use_strict_mode', 1);

            session_set_cookie_params([
                'lifetime' => 1800,
                'domain' => 'localhost',
                'path' => '/',
                'secure' => true,
                'httponly' => true
            ]);

            session_start();
        }

        if (!isset($_SESSION['last_regeneration'])) {
            $this->regenerate_id();
        } else {
            self::$interval = 60 * 30;
            if (time() - $_SESSION['last_regeneration'] >= self::$interval) {
                $this->regenerate_id();
            }
        }
    }

    public static function sessionDestroy() {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_unset();
            session_destroy();
        }
    }
}
?>
