<?php
class Database {
    private static $pdo = null;

    // Impostazioni per la connessione al database
    private $host = 'localhost';
    private $db = 'chat_db';
    private $user = 'root';
    private $password = '';
    private $charset = 'utf8mb4';
    private $dns;

    // Costruttore della classe che inizializza la connessione
    private function __construct() {
        $this->dns = "mysql:host=" . self::$host . ";dbname=" . self::$db . ";charset=" . self::$charset;

    }

    public static function getConnection(){
        if(self::$pdo === null){
            try{
                self::$pdo = new PDO(
                    self::$dns,
                    self::$user,
                    self::$password,
                    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
                );
            }catch (PDOException $e){
                echo "Errore nella connessione: " . $e->getMessage();
                exit;
            }
        }

        return self::$pdo;
    }

    public static function query($sql, $params = []){
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function closeConnection() {
        self::$pdo = null;
    }
}
?>