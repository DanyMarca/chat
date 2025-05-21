<?php
namespace BE\Controllers;

require_once BASE_PATH . 'BE\Models\User.php';
require_once BASE_PATH . 'BE\database\Database.php';
require_once BASE_PATH . 'BE\logs\Log.php';

use BE\database\Database;
use BE\logs\Log;
use BE\Models\User;
use Exception;

class AuthController{
    
    public static function login($email, $password) {
        $db = Database::getConnection();

        $sql = "SELECT * FROM Users WHERE email = :email";
        $stmt = $db->prepare($sql);
        $stmt->execute(['email' => $email]);

        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$user || !password_verify($password, $user['password'])) {
            return json_encode([
                'status' => 'error',
                'message' => 'Credenziali non valide'
            ]);
        }

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['email'] = $user['email']; // per coerenza
        $_SESSION['last_activity'] = time();

        return json_encode([
            'status' => 'success',
            'data' => [
                'id' => $user['id'],
                'email' => $user['email'],
                'username' => $user['username'],
                'created_at' => $user['created_at'],
                ]
        ]);
    }

    public static function isLogged() {
        if (isset($_SESSION['user_id'])) {
            if (!self::sessionttl()) {
                return json_encode([
                    'status' => 'error',
                    'message' => 'Sessione scaduta'
                ]);
            }
    
            return json_encode([
                'status' => 'success',
                'data' => 'user is logged'
            ]);
        } else {
            return json_encode([
                'status' => 'error',
                'data' => 'user is not logged'
            ]);
        }
    }

    public static function logOut() {
        session_unset();
        return json_encode([
            'status' => 'success',
            'data' => 'user disconnected'
        ]);
    }
    
    public static function sessionttl() {
        $timeout_duration = 1800; // 30 minuti
    
        if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout_duration) {
            session_unset();
            session_destroy();
            return false;
        }
    
        $_SESSION['last_activity'] = time(); // aggiorna l'attività
        return true;
    }
    
    public static function register($data) {
        try {
            $data['id'] = null;

            if (User::existsByUsername($data['username'])) {
                throw new \Exception("Username già in uso.");
            }
            if (User::existsByEmail($data['email'])) {
                throw new \Exception("Email già in uso.");
            }
            
            $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
            User::create($data);

            echo json_encode([
                "status" => "success"
            ]);
        } catch (\Exception $e) {
            echo json_encode([
                "status" => "failed",
                "error" => $e->getMessage()
            ]);
        }
    }

    


}