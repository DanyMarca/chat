<?php
namespace BE\Controllers;

require_once BASE_PATH . 'BE\Models\User.php';
require_once BASE_PATH . 'BE\database\Database.php';

use BE\Models\User;
use BE\database\Database;

class UserController{

    public static function index(){
        $users = User::All();
        return json_encode([
            'status'=>'succsess',
            'data'=>$users
        ]);
    }

    public static function show($id){
        $users = User::Find($id);
        return json_encode([
            'status'=>'succsess',
            'data'=>$users
        ]);
    }
}