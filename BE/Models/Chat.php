<?php
namespace BE\Models;

use BE\database\Database;

class Chat{
    private ?int $id;
    private string $name;

    public function __construct(?int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
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
            $sql = "INSERT INTO Chats (name) VALUES (:name)";
            $stmt = $db->prepare($sql);
            $stmt->execute([
                ':name' => $this->name,
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

}

?>