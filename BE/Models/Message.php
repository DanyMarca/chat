<?php
namespace BE\Models;

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
}

?>