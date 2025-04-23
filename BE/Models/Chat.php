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
}

?>