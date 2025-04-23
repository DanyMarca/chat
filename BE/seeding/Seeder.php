<?php
namespace BE\seeding;
require_once __DIR__  . '\Factory.php';
// require_once 'factories/ChatFactory.php';

class Seeder{
    private static $obj_n = 10;

    public static function factoryDB(){
    for ($i = 0; $i < self::$obj_n; $i++) {
        $user = UserFactory::create();
    }
    echo "---Userfactory---\n";

    // for ($i = 0; $i < 5; $i++) {
    //     $chat = ChatFactory::create();
    //     echo "Creata chat: " . $chat->getName() . "<br>";
    // }

    }
}
