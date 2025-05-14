<?php
namespace BE\Controllers;

require_once BASE_PATH . 'BE\logs\Log.php';
require_once BASE_PATH . 'BE\Models\Chat.php';
require_once BASE_PATH . 'BE\Controllers\User_ChatController.php';

use BE\logs\Log;
use BE\Models\Chat;
use BE\Controllers\User_ChatController;
use Exception;

class ChatController{

    public static function show($id){

        $chat = Chat::show($id);
        
        return json_encode([
            'status'=>'succsess',
            'data'=>$chat
        ]);
    }

    public static function create($data){
        try{

        
        $name = $data['name'] ?? null;
        $chat_code = Chat::generateUniqueCode(NULL);;
        Log::info($name. $chat_code);

        if($name === null && $chat_code === null){
            return json_encode([
                'status' => 'error',
                'message' => 'campi non validi'
            ]);
        }

        $chat = new Chat(null, $name, $chat_code);
        $chat->save();
        // $ueser_chat = User_ChatController::addUsers($chat->getId(), $_SESSION['user_id']);

        $ueser_chat = User_ChatController::addUsers($chat->getId(), $_SESSION['user_id']);
        return json_encode([
            'status'=>'succsess',
            'data'=>$ueser_chat
        ]);
        }catch(Exception $e){
            Log::error($e);
        }
    }

    
}