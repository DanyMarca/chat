<?php
require_once 'connection.php';

class Migration {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    public function migrateDB() {
        $createUsers = "
            CREATE TABLE IF NOT EXISTS Users (
                id BIGINT AUTO_INCREMENT PRIMARY KEY,
                email VARCHAR(255) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                name VARCHAR(100) NOT NULL
            );
        ";
        
        $createChats = "
            CREATE TABLE IF NOT EXISTS Chats (
                id BIGINT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(100) NOT NULL
            );
        ";

        $createUsers_Chats = "
            CREATE TABLE IF NOT EXISTS Users_Chats (
                id BIGINT AUTO_INCREMENT PRIMARY KEY,
                user_id BIGINT NOT NULL,
                chat_id BIGINT NOT NULL,
                FOREIGN KEY (user_id) REFERENCES Users(id) ON DELETE CASCADE,
                FOREIGN KEY (chat_id) REFERENCES Chats(id) ON DELETE CASCADE
            );
        ";

        $createMessages = "
            CREATE TABLE IF NOT EXISTS Messages (
                id BIGINT AUTO_INCREMENT PRIMARY KEY,
                user_id BIGINT NOT NULL,
                chat_id BIGINT NOT NULL,
                content VARCHAR(1000) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES Users(id) ON DELETE CASCADE,
                FOREIGN KEY (chat_id) REFERENCES Chats(id) ON DELETE CASCADE
            );
        ";

        try {
            $this->pdo->exec($createUsers);
            echo "Creata: Users<br>";

            $this->pdo->exec($createChats);
            echo "Creata: Chats<br>";

            $this->pdo->exec($createUsers_Chats);
            echo "Creata: Users_Chats<br>";

            $this->pdo->exec($createMessages);
            echo "Creata: Messages<br>";
        } catch (PDOException $e) {
            echo "Errore nella migrazione: " . $e->getMessage();
        }
    }
}


?>