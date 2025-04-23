<?php
namespace BE\seeding;

require_once __DIR__ . '/../database/Database.php';
require_once __DIR__ . '/../Models/Message.php';

use BE\database\Database;
use BE\Models\Message;

class MessageFactory{
    public static function makefake(): Message{
        $pdo = Database::getConnection();

        $id = null;
        $user_id = $pdo->query("SELECT id FROM Users ORDER BY RAND() LIMIT 1")->fetchColumn();
        $chat_id = $pdo->query("SELECT id FROM Chats ORDER BY RAND() LIMIT 1")->fetchColumn();
        $content = "Messaggio_" . rand(100, 9999);
        $created_at = "";

        return new Message($id, $user_id, $chat_id, $content, $created_at);
    }

    public static function create(): Message{
        $chat = self::makefake();
        $chat->save();
        return $chat;
    }
}

?>