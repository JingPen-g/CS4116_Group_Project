<?php 
include "Messages.php";
include "Users.php";
function generate_conversation($user_id, $reciever_Id) {
    $messaging = new Messages();
    $conversations = $messaging.getUserConversation($reciever_Id, $user_id);
    $users = new Users();


echo "<section class=\"wrapper\">" ;

    foreach ($conversations as $conversation) {
        
        echo "<h3>$conversation<h3>";

        echo "<h3>I should just kill myself</h3>";
    }



    }
?>
