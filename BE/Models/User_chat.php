<?php
namespace BE\Models;

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
}
?>