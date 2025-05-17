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

    public static function join($data){
        try{
            $db = Database::getConnection();
            $db->beginTransaction();

            $sql = "
                SELECT *
                FROM chats
                WHERE chat_code = :chat_code
            ";
            $stmt = $db->prepare($sql);
            $stmt->execute([
                'chat_code' => $data['chat_code']
            ]);
            $responce = $stmt->fetch(\PDO::FETCH_ASSOC);

            if(User_Chat::userlist($responce['id'])){
                return json_encode([
                    'status' => 'error',
                    'message' => 'user alredy in chat ',
                    'chat_name' => $responce['name']
                ],400);
            }else{
                self::addUsers($responce['id'], $_SESSION['user_id']);
            }
            $db->commit();
        }catch(\Exception $e){
            $db->rollback();
            Log::error($e);
        }
    }

    public static function exitUserFromChat($chat_id){
        $responce = User_Chat::delete($chat_id['chat_id']);
        return json_encode([
            'status' => "success",
            'data' => $responce,
        ]);
    }

}