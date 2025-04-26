<?php
namespace BE;

// Includi manualmente il file Database.php
require_once __DIR__ . '/database/Database.php';
require_once BASE_PATH . 'BE\logs\Log.php';

use BE\database\Database;
use BE\logs\Log;

$path = session_save_path();
$files = scandir($path);

foreach ($files as $file) {
    if (strpos($file, 'sess_') === 0) {
        echo "FILE: $file\n";
        echo file_get_contents($path . DIRECTORY_SEPARATOR . $file);
        echo "\n\n";
    }
}

// session_start();
// session_unset();
// session_destroy();


// try {
//     $pdo = Database::getConnection();

//     $stmt = $pdo->query("SELECT * FROM Users");
//     $messages = $stmt->fetchAll(\PDO::FETCH_ASSOC);

//     echo json_encode($messages, JSON_PRETTY_PRINT) . PHP_EOL;

// } catch (\PDOException $e) {
//     echo "Errore durante il recupero dei messaggi: " . $e->getMessage();
// }
