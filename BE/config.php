<?php
namespace BE;

define('BASE_PATH', dirname(__DIR__) . "\\") ; // prende la cartella root

require_once BASE_PATH . 'BE\logs\Log.php';

use BE\logs\Log;



// Impostazioni di sessione
// $originDomain =  $_SERVER['HTTP_HOST'];

// $domain = $_SERVER['HTTP_HOST'];
// $domain = explode(':', $domain)[0]; // Rimuove eventuale porta

// session_set_cookie_params([
//     'lifetime' => 0,
//     'path' => '/',
//     'domain' => $domain,  // CORRETTO!
//     'secure' => false,    // true se HTTPS
//     'httponly' => true,
//     'samesite' => 'Lax',
// ]);

// ini_set('session.cookie_httponly', 1);
// ini_set('session.cookie_secure', 1); // se usi HTTPS
// ini_set('session.use_strict_mode', 1);

// Nome dispositivo	DESKTOP-58NCJAT
