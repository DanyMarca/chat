<?php
namespace BE\Models;

use BE\database\Database;
use BE\logs\Log;

class Chat{
    private ?int $id;
    private string $name;
    private string $chat_code;

    public function __construct(?int $id, string $name, string $chat_code)
    {
        $this->id = $id;
        $this->name = $name;
        $this->chat_code = $chat_code;
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function save(){
        $db = Database::getConnection();

        if($this->id !== null){
            $sql = "UPDATE Chats SET name = :name, WHERE id = :id";
            $stmt = $db->prepare($sql);
            $stmt->execute([
                ':name' => $this->name,
                ':id' => $this->id,
            ]);
        }else{
            $sql = "INSERT INTO Chats (name, chat_code) VALUES (:name, :chat_code)";
            $stmt = $db->prepare($sql);
            $stmt->execute([
                ':name' => $this->name,
                ':chat_code' => $this->chat_code,
            ]);
            $this->id = $db->lastInsertId();
        }
        
    }

    public static function show($chat_id)
    {
        $db = Database::getConnection();

        $sql = "
            SELECT *
            FROM Chats AS c
            WHERE c.id = :chat_id
        ";

        $stmt = $db->prepare($sql);
        $stmt->execute([
            'chat_id' => $chat_id,
        ]);
        $chat = $stmt->fetch(\PDO::FETCH_ASSOC);
        $chat['user_id'] = $_SESSION['user_id']?? null;
        return [
            'chat' => $chat,
            'messages' => self::renderMessagesFromChat($db, $chat_id)
        ];
    }

    private static function renderMessagesFromChat($db, $chat_id)
    {
        $sql = "
            SELECT m.id, m.created_at, m.user_id, m.chat_id, m.content
            FROM Chats AS c
            INNER JOIN Messages AS m ON c.id = m.chat_id
            WHERE c.id = :chat_id
            ORDER BY m.created_at ASC
        ";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            'chat_id' => $chat_id,
        ]);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }


    public static function generateUniqueCode(?\PDO $pdo): string {
        if($pdo === null){
            $pdo = Database::getConnection();
        }
        do {
            $code = bin2hex(random_bytes(8)); // 16 caratteri esadecimali
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM chats WHERE chat_code = :code");
            $stmt->execute(['code' => $code]);
            $exists = $stmt->fetchColumn() > 0;
            
            Log::info($code);
        } while ($exists);
    
        return $code;
    }
}

?>