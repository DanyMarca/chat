<?php
namespace BE\seeding;

require_once __DIR__ . '/../database/Database.php';
require_once __DIR__ . '/../Models/User.php';

use BE\database\Database;
use BE\Models\User;

class UserFactory {
    public static function makefake(): User {
        $id = null;
        $name = "Utente_" . rand(1000, 9999);
        $email = strtolower($name) . "@esempio.com";
        $password = password_hash("password", PASSWORD_BCRYPT);

        return new User($id, $name, $email, $password);
    }

    public static function create(): User {
        $user = self::makefake();
        $user->save();
        return $user;
    }
}

?>