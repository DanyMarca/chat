<?php
namespace BE\Models;

use BE\database\Database;

class User_Chat{
    private ?int $id;
    private ?int $user_id;
    private ?int $chat_id;

    public function __construct(?int $id, ?int $user_id, ?int $chat_id)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->chat_id = $chat_id;
    }
    public function getId(): ?int {
        return $this->id;
    }
    public function getUser_Id(): ?int {
        return $this->user_id;
    }
    public function getChat_Id(): ?int {
        return $this->chat_id;
    }

    public static function create($data){
        $mesage = new self($data['id'], $data['user_id'], $data['chat_id']);
        $mesage->save();
        return $mesage;
    }

    public function save() {
        $db = Database::getConnection();

        if ($this->id !== null) { // update
            
        } else { // insert
            $sql = "INSERT INTO Users_Chats(user_id, chat_id) VALUES (:user_id, :chat_id)";
            $stmt = $db->prepare($sql);
            $stmt->execute([
                ':user_id' => $this->user_id,
                ':chat_id' => $this->chat_id,
                
            ]);
            $this->id = $db->lastInsertId();
        }
    }

}
?>