<?php
namespace BE;

// Includi manualmente il file Database.php
require_once __DIR__ . '/database/Database.php';

use BE\database\Database;

try {
    $pdo = Database::getConnection();

    $stmt = $pdo->query("SELECT * FROM Users");
    $messages = $stmt->fetchAll(\PDO::FETCH_ASSOC);

    echo json_encode($messages, JSON_PRETTY_PRINT) . PHP_EOL;

} catch (\PDOException $e) {
    echo "Errore durante il recupero dei messaggi: " . $e->getMessage();
}
