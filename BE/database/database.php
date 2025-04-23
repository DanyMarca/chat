<?php
namespace BE\database;

class Database {
    private static $pdo = null;

    // Impostazioni per la connessione al database
    private static $host = 'localhost';
    private static $db = 'chat_db';
    private static $user = 'root';
    private static $password = '';
    private static $charset = 'utf8mb4';
    private static $dns;


    public static function getConnection(){
        if (self::$pdo === null) {
            $dsn = "mysql:host=" . self::$host . ";dbname=" . self::$db . ";charset=" . self::$charset;
    
            try {
                self::$pdo = new \PDO(
                    $dsn,
                    self::$user,
                    self::$password,
                    [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]
                );
                // echo "connesso";
            } catch (\PDOException $e) {
                echo "Errore nella connessione: " . $e->getMessage();
                exit;
            }
        }
    
        return self::$pdo;
    }
    

    public static function query($sql, $params = []){
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function closeConnection() {
        self::$pdo = null;
    }
}
?>