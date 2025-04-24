<?php
namespace BE\seeding;

require_once __DIR__ . '\UserFactory.php';
require_once __DIR__ . '\ChatFactory.php';
require_once __DIR__ . '\MessageFactory.php';
require_once __DIR__ . '\User_ChatFactory.php';

class Seeder{
    public static $obj_n = 10;

    public static function factoryDB()
    {
    for ($i = 0; $i < self::$obj_n; $i++) {
        UserFactory::create();
    }
    echo "---Userfactory---\n";

    for ($i = 0; $i < self::$obj_n *3; $i++) {
        ChatFactory::create();
    }
    echo "---Chatfactory---\n";

    for ($i = 0; $i < self::$obj_n *10; $i++) {
        MessageFactory::create();
    }
    echo "---MessageFactory---\n";

    for ($i = 0; $i < self::$obj_n *5; $i++) {
        User_ChatFactory::create();
    }
    echo "---User_ChatFactory---\n";

    }
}
