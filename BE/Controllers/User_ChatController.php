<?php
namespace BE\Controllers;

require_once BASE_PATH . 'BE\logs\Log.php';
require_once BASE_PATH . 'BE\Models\Chat.php';
require_once BASE_PATH . 'BE\Models\User_Chat.php';

use BE\database\Database;
use BE\logs\Log;
use BE\Models\Chat;
use BE\Models\User_Chat;
use PDOStatement;

class User_ChatController{

    public static function addUsers($chat_id, ?int $user_id){
        $db = Database::getConnection();

        // log::info($user_id);

        if(self::chatExist($db, $chat_id)){ //check se la chat esiste
            
            Log::info($user_id);

            $user_chat = New User_Chat(null, $user_id, $chat_id);
            $user_chat->save();
            return $user_chat;
        }else{
            return json_encode([
                'status' => 'error',
                'message' => 'campi non validi'
            ]);
        }
    }

    private static function chatExist($db, $chat_id ){
        $sql = "
        SELECT count(*) as chat_n
        FROM chats
        where id = :id;
        ";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            'id' => $chat_id
        ]);
        $data = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $data['chat_n'] > 0 ? true : false;
    }
}