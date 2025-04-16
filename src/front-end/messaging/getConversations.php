<?php 
require_once(__DIR__ . "/../../back-end/db/Users.php");
require_once(__DIR__ . "/../../back-end/db/Messages.php");
function generate_conversations() {
    /*$user_id = "Howm"
    $messaging = new Messages();
    $conversations = $messaging->getConversations($user_id);*/
    $users = new Users();
    $conversations = ["John", "Hello"];

    foreach ($conversations as $conversationName) :
        echo "$conversationName <button> <tr>";
    endforeach;
    }
    
?>

