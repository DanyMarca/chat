<?php
namespace BE\Models;

use BE\database\Database;

class User{
    private ?int $id;
    private string $name;
    private string $email;
    private string $password;

    public function __construct(?int $id, string $name, string $email, string $password) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }
    public function getEmail(): string {
        return $this->email;
    }
    public function getPassword(): string {
        return $this->password;
    }

    public static function create($data){
        $user = new self($data['id'], $data['name'], $data['email'], $data['password']);
        $user->save();
        return $user;
    }


    public function save() {
        $db = Database::getConnection();
    
        if ($this->id !== null) { // update
            $sql = "UPDATE Users SET name = :name, email = :email, password = :password WHERE id = :id";
            $stmt = $db->prepare($sql);
            $stmt->execute([
                ':name' => $this->name,
                ':email' => $this->email,
                ':password' => $this->password,
                ':id' => $this->id
            ]);
        } else { // insert
            $sql = "INSERT INTO Users (name, email, password) VALUES (:name, :email, :password)";
            $stmt = $db->prepare($sql);
            $stmt->execute([
                ':name' => $this->name,
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
            $user['cahts'] = self::getChatsForUser($db, $user['id']) ?? null;
        }
        return $users;
    }

    public static function Find($id){
        $db = Database::getConnection();

        $sql= "
            SELECT u.*
            FROM Users AS u
            where id = :id
        ";

        $stmt = $db->prepare($sql);
        $stmt->execute(['id' => $id]);

        $user = $stmt->fetch(\PDO::FETCH_ASSOC);
        $user['cahts'] = self::getChatsForUser($db, $user['id']) ?? null;

        return $user;
    }

    protected static function getChatsForUser($db, $userId) {
        $sql = "
            SELECT c.*
            FROM Chats AS c
            INNER JOIN users_chats AS uc ON c.id = uc.chat_id
            WHERE uc.user_id = :user_id
        ";
    
        $stmt = $db->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC) ?? null;
    }
}
?>