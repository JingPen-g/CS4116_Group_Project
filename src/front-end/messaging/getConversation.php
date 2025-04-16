<?php 
require_once(__DIR__ . "/../../back-end/db/Users.php");
require_once(__DIR__ . "/../../back-end/db/Messages.php");
function generate_conversation($user_id, $reciever_Id) {
    $messaging = new Messages();
    $reciever_Id = [$reciever_Id];
   // $conversation = $messaging->getConversation($user_id, $reciever_Id);
    $t = date(DATE_RFC822,time());
    $timeStamps = [$t];
    $messages = ["Test to show this works"];


    for($i=0; $i<count($timeStamps)-1; $i++) {
        echo $timeStamps[$i].'-'.$messages[$i];
      }


    }
?>
