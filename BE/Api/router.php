<?php
namespace BE\Api;

require_once  __DIR__ . '/../config.php';
require_once BASE_PATH . "BE\Controllers/UserController.php";
require_once BASE_PATH . "BE\controllers\Authcontroller.php";
require_once BASE_PATH . "BE\controllers\Sessioncontroller.php";
require_once BASE_PATH . 'BE\logs\Log.php';

use BE\Controllers\UserController;
use BE\Controllers\AuthController;
use BE\Controllers\Sessioncontroller;
use BE\logs\Log;

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
        // SOLO per sviluppo, non per produzione!
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type");
        header("Access-Control-Allow-Credentials: true");

    }

    // Gestione della richiesta
    public function handleRequest() {

        $requestURI = explode('?', $_SERVER['REQUEST_URI'])[0];  //togliamo una possibile query
        $requestURI = str_replace('/chat/BE/', '', $requestURI);    //togliamo tutto quello che viene prima dell'url che ci interessa
        $requestURI = strtolower($requestURI); //tutto in caratteri minuscoli


        // USER------------------------------------
        if ($requestURI === 'api/users') {
            echo UserController::index(); //tutti gli utenti con le loro chat
            
        } elseif (preg_match('#^api/users/(\d+)$#', $requestURI, $match)) {//# epr avere definire inizio e fine della stringa, (\d+) per dire che ci potrebbe essere uno o più decimali
            $userID = $match[1];
            Log::info(json_encode($match));
            echo UserController::show($userID); //chat per l'utente
        }
        // AUTH------------------------------------
        
        elseif ($requestURI === 'api/login' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            echo AuthController::login($data['email'], $data['password']);

        } elseif ($requestURI === 'api/islogged') {
            echo AuthController::isLogged();

        } elseif ($requestURI === 'api/sessioncheck') {
            echo Sessioncontroller::sessionCheck();
        }
        elseif ($requestURI === 'api/me') {
            
            switch (session_status()) {
                case PHP_SESSION_DISABLED:
                    echo "Sessioni disabilitate nel server.";
                    break;
                case PHP_SESSION_NONE:
                    echo "Nessuna sessione attiva.";
                    break;
                case PHP_SESSION_ACTIVE:
                    echo "Sessione già avviata.";
                    break;
            }
        }
        // DEFAULT------------------------------------
        else {
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
