<?php
namespace BE\Controllers;

require_once BASE_PATH . 'BE\logs\Log.php';
require_once BASE_PATH . 'BE\Models\Chat.php';

use BE\logs\Log;
use BE\Models\Chat;

class ChatController{

    public static function show($id){

        $chat = Chat::show($id);
        
        return json_encode([
            'status'=>'succsess',
            'data'=>$chat
        ]);
    }

    
}