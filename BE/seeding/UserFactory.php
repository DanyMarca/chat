<?php
namespace BE\seeding;

require_once __DIR__ . '/../database/Database.php';
require_once __DIR__ . '/../Models/User.php';

use BE\database\Database;
use BE\Models\User;

class UserFactory {
    public static function makefake(): User {
        $id = null;
        $username = "Utente_" . rand(1000, 9999);
        $email = strtolower($username) . "@esempio.com";
        $password = password_hash("password", PASSWORD_BCRYPT);

        return new User($id, $username, $email, $password);
    }

    public static function create(): User {
        $user = self::makefake();
        $user->save();
        return $user;
    }
}

?>