<?php
namespace BE\seeding;

require_once __DIR__ . '/../database/Database.php';
require_once __DIR__ . '/../Models/User_Chat.php';

use BE\database\Database;
use BE\Models\User_Chat;


class User_ChatFactory{
    public static function makefake(): User_Chat{
        $pdo = Database::getConnection();

        $id = null;
        $user_id = $pdo->query("SELECT id FROM Users ORDER BY RAND() LIMIT 1")->fetchColumn();
        $chat_id = $pdo->query("SELECT id FROM Chats ORDER BY RAND() LIMIT 1")->fetchColumn();

        return new User_Chat($id, $user_id, $chat_id);
    }

    public static function create(): User_Chat{
        $chat = self::makefake();
        $chat->save();
        return $chat;
    }
}

?>