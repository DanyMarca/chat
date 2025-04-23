<?php
namespace BE\Models;

use BE\database\Database;

class Message{
    private ?int $id;
    private ?int $user_id;
    private ?int $chat_id;
    private string $content;
    private string $created_at;

    public function __construct(?int $id, ?int $user_id, ?int $chat_id, string $content,string $created_at)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->chat_id = $chat_id;
        $this->content = $content;
        $this->created_at = $created_at;
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
    public function getContent(): string {
        return $this->content;
    }
    public function getCreated_at(): string {
        return $this->created_at;
    }

    public static function create($data){
        $mesage = new self($data['id'], $data['user_id'], $data['chat_id'], $data['content'], $data['created_at']);
        $mesage->save();
        return $mesage;
    }

    public function save() {
        $db = Database::getConnection();

        if ($this->id !== null) { // update
            $sql = "UPDATE Messages SET content = :content WHERE id = :id";
            $stmt = $db->prepare($sql);
            $stmt->execute([
                ':content' => $this->content,
                ':id' => $this->id
            ]);
        } else { // insert
            $sql = "INSERT INTO Messages (user_id, chat_id, content) VALUES (:user_id, :chat_id, :content)";
            $stmt = $db->prepare($sql);
            $stmt->execute([
                ':user_id' => $this->user_id,
                ':chat_id' => $this->chat_id,
                ':content' => $this->content,
            ]);
            $this->id = $db->lastInsertId(); // assegna l'ID generato
        }
    }
}

?>