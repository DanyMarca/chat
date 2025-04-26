<?php
namespace BE\Controllers;

require_once BASE_PATH . 'BE\logs\Log.php';

use BE\logs\Log;

class SessionController {

    public static function sessionCheck() {
        

        $timeout_duration = 900; // 15 minuti

        if (!isset($_SESSION['user_id'])) {
            self::respond(false);
            return;
        }

        if (!isset($_SESSION['last_activity']) || (time() - $_SESSION['last_activity']) > $timeout_duration) {
            session_unset();
            session_destroy();
            self::respond(false, 'Sessione scaduta');
            return;
        }

        $_SESSION['last_activity'] = time(); // aggiorna attività

        self::respond(true, 'Utente loggato', [
            'user_id' => $_SESSION['user_id'],
            'email' => $_SESSION['email'] ?? null
        ]);
    }

    private static function respond($loggedin, $message = '', $data = []) {
        header('Content-Type: application/json');
        Log::info('Session: '. $loggedin .
                '; '. $message.
                '$data: '.json_encode($data).'; ' );
        echo json_encode([
            'status' => $loggedin ? 'success' : 'error',
            'loggedin' => $loggedin,
            'message' => $message,
            'data' => $data
        ]);
    }
}
