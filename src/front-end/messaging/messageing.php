

<?php
    include 'getConversations.php' ;
    function userTable(){
        $users = new Users();
        return $users;
    }
    function getUserId() {
        $users = userTable();
        $id = $users->getUser(get_current_user());
        return $id;
    }
    function getUserConversations(){
       // $user = getUserId();
        generate_conversations();
    }
    function getUserConversation($recivierid, $user_id){
        generate_conversation($recivierid, $user_id);
    }
    getUserId()
?>


<!DOCTYPE html>

<html lang = "en">
    <head>  
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Conversations</title>
        
    </head>

    </div>
    <div>
        <section class="flex-1 bg-white p-6 rounded-lg shadow-md">
            <section class="message-list" id="message-list">
        </section>
        <?php getUserConversations()?>
        <table class='conversations' >

        <tbody>
            <?php
                if(1 < 0){
                    /*while(){
                        echo 
                        "<tr>".
                        
                        "</tr>";
                    }*/
                } else{
                    echo 'conversations';
                }
            ?>
        </tbody>
      </table>
      <script type="application/javascript" src="js/messages.js"></script>
    </div>
    
</html>