<?php
namespace BE\database;
require_once __DIR__ . '/Database.php';


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
                name VARCHAR(100) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            );
        ";
        
        $createChats = "
            CREATE TABLE IF NOT EXISTS Chats (
                id BIGINT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(100) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            );
        ";

        $createUsers_Chats = "
            CREATE TABLE IF NOT EXISTS Users_Chats (
                id BIGINT AUTO_INCREMENT PRIMARY KEY,
                user_id BIGINT NOT NULL,
                chat_id BIGINT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
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
            echo "Created: Users-----------\n";

            $this->pdo->exec($createChats);
            echo "Created: Chats-----------\n";

            $this->pdo->exec($createUsers_Chats);
            echo "Created: Users_Chats-----------\n";

            $this->pdo->exec($createMessages);
            echo "Created: Messages-----------\n";

            echo "\n";
        } catch (\PDOException $e) {
            echo "Errore nella migrazione: " . $e->getMessage();
        }
    }

    public function dropDB(){
        echo "\n";
        // Disabilita i controlli delle chiavi esterne
        $this->pdo->exec("SET FOREIGN_KEY_CHECKS = 0;");
    
        // Recupera e elimina tutte le tabelle
        $stmt = $this->pdo->query("SELECT table_name FROM information_schema.tables WHERE table_schema = 'chat_db';");
        foreach ($stmt->fetchAll(\PDO::FETCH_COLUMN) as $table) {
            $this->pdo->exec("DROP TABLE IF EXISTS `$table`;");
            echo "Tabella $table droppata\n";
        }
    
        // Riabilita i controlli delle chiavi esterne
        $this->pdo->exec("SET FOREIGN_KEY_CHECKS = 1;");
    
        echo "Tutte le tabelle sono state droppate.\n\n";
    }
    
}


?>