<?php
namespace BE\seeding;

require_once __DIR__ . '/../database/Database.php';
require_once __DIR__ . '/../Models/Chat.php';

use BE\database\Database;
use BE\Models\Chat;

class ChatFactory{
    public static function makefake(): Chat{
        $pdo = Database::getConnection();
        $id = null;
        $name = "Chat_".rand(1000, 9999);
        $chat_code = Chat::generateUniqueCode($pdo);
        return new Chat($id, $name, $chat_code);
    }

    public static function create(): Chat{
        $chat = self::makefake();
        $chat->save();
        return $chat;
    }
}

?>