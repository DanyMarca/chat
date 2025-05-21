<?php
namespace BE\Controllers;

require_once BASE_PATH . 'BE\logs\Log.php';
require_once BASE_PATH . 'BE\Models\Chat.php';
require_once BASE_PATH . 'BE\Models\Message.php';

use BE\database\Database;
use BE\logs\Log;
use BE\Models\Chat;
use BE\Models\Message;
use ReturnTypeWillChange;

use function PHPSTORM_META\type;

class MessageController{

    public static function create($data) {
        $logged = SessionController::sessionCheck();

        if(!$logged['loggedin'] || !isset($logged['loggedin'])){
            return json_encode([
                'status' => 'error',
                'data' => 'user is not logged'
            ]);
        }
        
        
        if($data['message'] == ""){
            return json_encode([
                'status' => 'error',
                'data' => 'message empty'
            ]);
        }

        try {
            // Connessione al database
            $db = Database::getConnection();

            // Prepara e esegui la query di inserimento
            $sql = "INSERT INTO messages (user_id, chat_id, content) VALUES (:user_id, :chat_id, :content)";
            $stmt = $db->prepare($sql);
            $stmt->execute([
                ':user_id' => $logged['data']['user_id'],
                ':chat_id' => $data['chat_id'],
                ':content' => $data['message']
            ]);

            // Se l'inserimento ha successo, restituisci una risposta positiva
            
            return json_encode([
                'status' => 'success',
                'data' => 'Message sent successfully'
            ]);
        } catch (\PDOException $e) {
            // Gestisci eventuali errori di database
            Log::error("Database error: " . $e->getMessage());
            return json_encode([
                'status' => 'error',
                'data' => 'Database error'
            ]);
        }
    }

    public static function lastmessage($chat_id) {
        $data = Message::Last($chat_id); // array associativo
        $data['loggeduser_id'] = $_SESSION['user_id'] ?? null; // aggiungo nuova chiave al risultato
        echo json_encode($data);
    }


    public static function checknew() {
        $chats = Chat::index();
        return Message::messageFromChat($chats);
    }

}