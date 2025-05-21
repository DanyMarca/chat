<?php
namespace BE\Models;

use BE\logs\Log;
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

    public static function Last($id){
        $db = Database::getConnection();
        $sql = "SELECT *
                FROM Messages AS m
                WHERE chat_id = :id
                ORDER BY created_at DESC
                LIMIT 10";
    
        $stmt = $db->prepare($sql);
        $stmt->execute([
            'id' => $id
        ]);
    
        return $stmt->fetch(\PDO::FETCH_ASSOC); // oppure FETCH_OBJ se preferisci
    }
    
    public static function messageFromChat(array $chats): string {


        if (isset($chats['error'])) {
            return json_encode($chats); // errore nei dati in ingresso
        }

        try {
            $db = Database::getConnection();
            $newMessages = [];

            foreach ($chats['data'] as $chat) {
                $lastMessage = self::Last($chat['chat_id']);

                if (!$lastMessage) continue;

                $messageTime = strtotime($lastMessage['created_at']);
                
                // Log::info("difference: " .$_SESSION['last_activity'] - $messageTime ." user: ". $_SESSION['user_id']);
                if ($messageTime > $_SESSION['last_activity']) {
                    $newMessages[] = [
                        'chat_id' => $chat['chat_id'],
                        'last_message' => $lastMessage
                    ];
                }
            }

            return json_encode([
                'status' => 'success',
                'has_new_messages' => count($newMessages) > 0,
                'new_messages' => $newMessages,
                'last_activity' => $_SESSION['last_activity'],
                'user_id' => $_SESSION['user_id']
            ]);
        } catch (\Exception $e) {
            return json_encode([
                'status' => 'failed',
                'error' => $e->getMessage()
            ]);
        }
    }


}


?>