<?php
namespace BE\Api;

require_once  __DIR__ . '/../config.php';
require_once BASE_PATH . "BE\Controllers\UserController.php";


use BE\Controllers\UserController;

header("Content-type: application/json");

$requestURI = explode('?',  $_SERVER['REQUEST_URI'])[0];
$requestURI = str_replace('/chat/BE', '', $requestURI);
$requestURI = strtolower($requestURI);

switch($requestURI){
    
    case '/api/users':
            $responce = UserController::index();
            echo $responce;
        break;

    default:
        http_response_code(404);
        echo json_encode([
            'error'  => 'Endpoint non trovato',
            'call' => $requestURI
        ]);
}