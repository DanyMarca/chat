<?php
require_once 'Factory.php';
// require_once 'factories/ChatFactory.php';

for ($i = 0; $i < 10; $i++) {
    $user = UserFactory::create(); // crea e inserisce nel DB
    echo "Creato utente: " . $user->getEmail() . "<br>";
}

// for ($i = 0; $i < 5; $i++) {
//     $chat = ChatFactory::create();
//     echo "Creata chat: " . $chat->getName() . "<br>";
// }
