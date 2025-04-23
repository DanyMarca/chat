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
    
}
?>