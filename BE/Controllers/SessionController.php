<?php
namespace BE\Controllers;

require_once BASE_PATH . 'BE\logs\Log.php';

use BE\logs\Log;

class SessionController {

    public static function sessionCheck() {
        $timeout_duration = 900; // 15 minuti

        if (!isset($_SESSION['user_id'])) {
            return self::buildResponse(false);
        }

        if (!isset($_SESSION['last_activity']) || (time() - $_SESSION['last_activity']) > $timeout_duration) {
            session_unset();
            session_destroy();
            return self::buildResponse(false, 'Sessione scaduta');
        }

        return self::buildResponse(true, 'Utente loggato', [
            'user_id' => $_SESSION['user_id'],
            'email' => $_SESSION['email'] ?? null
        ]);
    }

    private static function buildResponse($loggedin, $message = '', $data = []) {
        return [
            'status' => $loggedin ? 'success' : 'error',
            'loggedin' => $loggedin,
            'message' => $message,
            'data' => $data
        ];
    }
}

