

<?php
    require_once(__DIR__ . "/../../back-end/db/Users.php");
    require_once(__DIR__ . "/../../back-end/db/Messages.php");
    include 'getConversation.php' ;


    $users = new Users();
    $messages = new Messages();
    $recivier_name = "jeff";
    function getUserId() {
        
        /*$id = $GLOBALS['users']->getUser(1);
        return $id;*/
        return isset($_SESSION['username'])
    }
    function getRecieverId($name){
        $users = userTable();
        $name = array($name);
        $id = $users->getUser([$name]);
        return $id;
    }
    function getUserConversation(){
        $recivier_id = getRecieverId($GLOBALS['recivier_name']);
        $user_id = getUserId();
        generate_conversation($user_id, $recivier_id);
    }
    function conversation(){
        generate_conversation(getUserId(),$GLOBALS['recivier_name']);
    }
    function sendmessage($message){
        //$messages = new Message();
        $t = time();
        $t = date($t);
        $GLOBALS['messages']->insertMessage(getUserId(), $message, getRecieverId($GLOBALS['recivier_name']), $t);
    }

?>


<!DOCTYPE html>

<html lang = "en">
    <head>  
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>

    </div>
    <div>
        <table class='conversation' >

        <tbody>
            <?php
                conversation();         
            
            ?>
            <tr>
                <input type="message"  id="message" placeholder="Message" name="Message">
                <button id="send_button">Send</button>
                e
            </tr>
        </tbody>
      </table>
      <script type="application/javascript" src="js/messages.js"></script>
    </div>
    
</html>