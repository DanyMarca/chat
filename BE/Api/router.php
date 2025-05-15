<?php
namespace BE\Api;

require_once  __DIR__ . '/../config.php';
require_once BASE_PATH . "BE\Controllers\UserController.php";
require_once BASE_PATH . "BE\Controllers\ChatController.php";
require_once BASE_PATH . "BE\controllers\Authcontroller.php";
require_once BASE_PATH . "BE\controllers\Sessioncontroller.php";
require_once BASE_PATH . "BE\controllers\MessageController.php";

require_once BASE_PATH . 'BE\logs\Log.php';

use BE\Controllers\UserController;
use BE\Controllers\ChatController;
use BE\Controllers\AuthController;
use BE\Controllers\MessageController;
use BE\Controllers\Sessioncontroller;
use BE\Controllers\User_ChatController;
use BE\logs\Log;

class Router {
    
    // Costruttore
    public function __construct() {
        

        // Impostazione intestazioni
        header("Content-type: application/json");
        
        
        $origin = "http://". $_SERVER['HTTP_HOST'];
        // Log::info("origin is: ".$origin);

        $allowed_origins = [
            'http://localhost',
            'http://127.0.0.1',
            'http://'.$_SERVER['SERVER_ADDR'],
            'http://'.strtolower(gethostname()),

        ];
        // Log::info(json_encode($allowed_origins));

        if(in_array($origin, $allowed_origins)){
        header("Access-Control-Allow-Origin: $origin");
        // Log::info('passa: '. $origin);

        }
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
            echo UserController::show($userID); //chat per l'utente
        }

        // CHAT------------------------------------
        elseif (preg_match('#^api/chat/(\d+)$#', $requestURI, $match)) {
            $userID = $match[1];
            echo ChatController::show($userID); //chat per l'utente

        }elseif ($requestURI === 'api/chat/create') {
            $data = json_decode(file_get_contents('php://input'), true);
            echo ChatController::create($data);

        }elseif ($requestURI === 'api/sendmessage') {
            $data = json_decode(file_get_contents('php://input'), true);
            echo MessageController::create($data);
        }

        // USER_CHAT------------------------------------
        elseif ($requestURI === 'api/chat/join') {
            $data = json_decode(file_get_contents('php://input'), true);
            echo User_ChatController::join($data);
        }

        // MESSAGE------------------------------------
        elseif ($requestURI === 'api/sendmessage') {
            $data = json_decode(file_get_contents('php://input'), true);
            echo MessageController::create($data);
        }

        elseif (preg_match('#^api/message/last/(\d+)$#', $requestURI, $match)) {
            $chat_id = $match[1];
            echo MessageController::lastmessage($chat_id); //chat per l'utente
        }
        
        // AUTH------------------------------------
        
        elseif ($requestURI === 'api/login' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            echo AuthController::login($data['email'], $data['password']);

        } elseif ($requestURI === 'api/islogged') {
            echo AuthController::isLogged();

        } elseif ($requestURI === 'api/sessioncheck') {
            $data = Sessioncontroller::sessionCheck();
            echo json_encode($data);

        }elseif ($requestURI === 'api/register' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);

            echo AuthController::register($data);

        }
        elseif ($requestURI === 'api/logout') {
            echo AuthController::logOut();
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

        elseif ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            // Se è una richiesta OPTIONS, rispondi con un 200 OK
            http_response_code(200);
            exit();  // Termina l'esecuzione per evitare che venga processata come una richiesta GET/POST
        }

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
