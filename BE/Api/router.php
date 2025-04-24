<?php
namespace BE\Api;

require_once  __DIR__ . '/../config.php';
require_once BASE_PATH . "BE\Controllers\UserController.php";
require_once BASE_PATH . "BE\controllers\Authcontroller.php";


use BE\Controllers\UserController;
use BE\Controllers\AuthController;

header("Content-type: application/json");

$requestURI = explode('?',  $_SERVER['REQUEST_URI'])[0];
$requestURI = str_replace('/chat/BE/', '', $requestURI);
$requestURI = strtolower($requestURI);

// USER--------------
if ($requestURI === 'api/users') {
    $responce = UserController::index();
    echo $responce;
}
elseif (preg_match('#^api/users/(\d+)$#', $requestURI, $match)) {
    $userID = $match[1];
    $responce = UserController::show($userID);
    echo $responce;
}

// AUTH--------------
elseif ($requestURI === 'api/login' && $_SERVER['REQUEST_METHOD'] === 'POST'){
    $data = json_decode(file_get_contents('php://input'), true);
    $responce = AuthController::login($data['email'],$data['password']);
    echo $responce;
}

elseif ($requestURI === 'api/islogged') {
    $responce = AuthController::isLogged();
    echo $responce;
}


// DEFAULT--------------
else {
    http_response_code(404);
    echo json_encode([
        'error' => 'Endpoint non trovato',
        'call' => $requestURI
    ]);
}