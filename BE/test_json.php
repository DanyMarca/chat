<?php
namespace BE;

// Includi manualmente il file Database.php
require_once __DIR__ . '/database/Database.php';

use BE\database\Database;

session_start();

$_SESSION['user_id'] = 1;
echo $_SESSION['user_id'];
// try {
//     $pdo = Database::getConnection();

//     $stmt = $pdo->query("SELECT * FROM Users");
//     $messages = $stmt->fetchAll(\PDO::FETCH_ASSOC);

//     echo json_encode($messages, JSON_PRETTY_PRINT) . PHP_EOL;

// } catch (\PDOException $e) {
//     echo "Errore durante il recupero dei messaggi: " . $e->getMessage();
// }
