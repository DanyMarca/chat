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
        $chat_code = self::generateUniqueCode($pdo);
        return new Chat($id, $name, $chat_code);
    }

    public static function create(): Chat{
        $chat = self::makefake();
        $chat->save();
        return $chat;
    }

    private static function generateUniqueCode(\PDO $pdo): string {
        do {
            $code = bin2hex(random_bytes(8)); // 16 caratteri esadecimali
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM chats WHERE chat_code = :code");
            $stmt->execute(['code' => $code]);
            $exists = $stmt->fetchColumn() > 0;
            
        } while ($exists);
    
        return $code;
    }
}

?>