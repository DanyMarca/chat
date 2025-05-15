<?php
namespace BE\Models;

use BE\logs\Log;
use BE\database\Database;

class User{
    private ?int $id;
    private string $username;
    private string $email;
    private string $password;

    public function __construct(?int $id, string $username, string $email, string $password) {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getusername(): string {
        return $this->username;
    }
    public function getEmail(): string {
        return $this->email;
    }
    public function getPassword(): string {
        return $this->password;
    }

    public static function create($data){
        $user = new self($data['id'], $data['username'], $data['email'], $data['password']);
        $user->save();
        return $user;
    }


    public function save() {
        $db = Database::getConnection();
    
        if ($this->id !== null) { // update
            $sql = "UPDATE Users SET username = :username, email = :email, password = :password WHERE id = :id";
            $stmt = $db->prepare($sql);
            $stmt->execute([
                ':username' => $this->username,
                ':email' => $this->email,
                ':password' => $this->password,
                ':id' => $this->id
            ]);
        } 
        
        else { // insert
            $sql = "INSERT INTO Users (username, email, password) VALUES (:username, :email, :password)";
            $stmt = $db->prepare($sql);
            $stmt->execute([
                ':username' => $this->username,
                ':email' => $this->email,
                ':password' => $this->password,
            ]);
            $this->id = $db->lastInsertId(); // assegna l'ID generato
        }
    }
    

    public static function All(){
        $db = Database::getConnection();
        

        $stmt = $db->query("SELECT * FROM Users");
        $users = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        foreach($users as &$user){
            $user['chats'] = self::getChatsForUser($db, $user['id']) ?? null;
        }
        return $users;
    }

    public static function Find(){
        $id = $_SESSION['user_id'];
        $db = Database::getConnection();

        $sql= "
            SELECT u.*
            FROM Users AS u
            where id = :id
        ";

        $stmt = $db->prepare($sql);
        $stmt->execute(['id' => $id]);

        $user = $stmt->fetch(\PDO::FETCH_ASSOC);
        $user['chats'] = self::getChatsForUser($db, $user['id']) ?? null;

        return $user;
    }

    protected static function getChatsForUser($db, $userId) {
        $sql = "
            SELECT c.*, COALESCE(m.last_message_date, c.created_at) AS last_activity
            FROM Chats AS c
            INNER JOIN users_chats AS uc ON c.id = uc.chat_id
            LEFT JOIN (
                SELECT chat_id, MAX(created_at) AS last_message_date
                FROM messages
                GROUP BY chat_id
            ) AS m ON m.chat_id = c.id
            WHERE uc.user_id = :user_id
            ORDER BY last_activity DESC, c.created_at DESC
        ";

        $stmt = $db->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        $chats = $stmt->fetchAll(\PDO::FETCH_ASSOC) ?? [];

        // Ora puoi recuperare l'ultimo messaggio per ogni chat se vuoi, ma attenzione alle query multiple
        foreach ($chats as &$chat) {
            $chat['last_message'] = Message::Last($chat['id']);
        }

        Log::info(json_encode($chats));
        return $chats;
    }

    
    public static function existsByEmail(string $email): bool {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetchColumn() > 0;
    }

    public static function existsByUsername(string $username): bool {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetchColumn() > 0;
    }
}
?>