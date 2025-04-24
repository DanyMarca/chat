<?php
namespace BE\Api;

require_once  __DIR__ . '/../config.php';
require_once BASE_PATH . "BE\Controllers/UserController.php";
require_once BASE_PATH . "BE\controllers\Authcontroller.php";
require_once BASE_PATH . "BE\controllers\Sessioncontroller.php";

use BE\Controllers\UserController;
use BE\Controllers\AuthController;
use BE\Controllers\Sessioncontroller;

class Router {
    
    // Costruttore
    public function __construct() {
        // Impostazioni di sessione
        
        ini_set('session.cookie_httponly', 1);
        ini_set('session.cookie_secure', 1); // se usi HTTPS
        ini_set('session.use_strict_mode', 1);

        // Avvia la sessione
        session_start();

        // Impostazione intestazioni
        header("Content-type: application/json");
    }

    // Gestione della richiesta
    public function handleRequest() {
        // Ottieni la richiesta
        $requestURI = explode('?', $_SERVER['REQUEST_URI'])[0];
        $requestURI = str_replace('/chat/BE/', '', $requestURI);
        $requestURI = strtolower($requestURI);

        // Gestione delle rotte
        if ($requestURI === 'api/users') {
            echo UserController::index();
        } elseif (preg_match('#^api/users/(\d+)$#', $requestURI, $match)) {
            $userID = $match[1];
            echo UserController::show($userID);
        } elseif ($requestURI === 'api/login' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            echo AuthController::login($data['email'], $data['password']);
        } elseif ($requestURI === 'api/islogged') {
            echo AuthController::isLogged();
        } elseif ($requestURI === 'api/sessioncheck') {
            echo Sessioncontroller::sessionCheck();
        } else {
            // Default: rotte non trovate
            http_response_code(404);
            echo json_encode([
                'error' => 'Endpoint non trovato',
                'call' => $requestURI
            ]);
        }
    }
}

// Crea una nuova istanza del router e gestisci la richiesta
$router = new Router();
$router->handleRequest();
