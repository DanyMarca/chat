<?php
namespace BE\Controllers;

require_once BASE_PATH . 'BE\logs\Log.php';
require_once BASE_PATH . 'BE\Models\Chat.php';
require_once BASE_PATH . 'BE\Models\Message.php';

use BE\database\Database;
use BE\logs\Log;
use BE\Models\Chat;
use BE\Models\Message;

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
        // Log::info(
        //     'user_id: ' . $logged['data']['user_id'] . "\n" .
        //     'chat_id: '. $data['chat_id'] . "\n" .
        //     'content: '. $data['message']
        // );
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

    public static function lastmessage($chat_id){
        echo json_encode(Message::Last($chat_id));
    }
}