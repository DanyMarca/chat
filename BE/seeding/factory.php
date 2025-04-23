<?php
namespace BE\seeding;

require_once __DIR__ . '/../database/Database.php';
require_once __DIR__ . '/../Models/User.php';

use BE\database\Database;
use BE\Models\User;

class UserFactory {
    public static function make(): User {
        // Puoi usare anche Faker per dati più realistici
        $id = null;
        $name = "Utente_" . rand(1000, 9999);
        $email = strtolower($name) . "@esempio.com";
        $password = password_hash("password", PASSWORD_BCRYPT);

        return new User($id, $name, $email, $password);
    }

    public static function create(): User {
        $user = self::make();
        $pdo = Database::getConnection();

        $stmt = $pdo->prepare("INSERT INTO Users (name, email, password) VALUES (:name, :email, :password)");
        $stmt->execute([
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'password' => $user->getPassword()
        ]);

        // Recuperiamo l'id generato
        $userId = $pdo->lastInsertId();
        return new User($userId, $user->getName(), $user->getEmail(), $user->getPassword());
    }
}

?>