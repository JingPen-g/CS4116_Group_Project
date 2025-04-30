<?php

//Global varriables 
//Note: They must be set with the appropriate method call first
$list_of_conversations = null; //[index => "Other_ID"]
$current_conversation = null; //[[Message1],[Message2]] Note: Message contains all details from a row in TABLE Messaging
$other_user_info = null;//Object represning a row
include __DIR__ . '/../global/get-nav.php';
$user = getUserId();
$type = 'customer';

/*
 * messaging.php
 * Functions:
 *
 * retreive_user_data - Gets the row in the user table with the passed user id
 * getListOfConversations - sets list_of_conversations
 * setCurrentConversation - sets current_conversation
 * insertNewMessage - Inserts a new message
 * inquire - Sends inquiry message
 * responsdToInquiry - Sends message in response to inquiry
 * getMessageCount - Gets the number of messages between two ids
 */


/* retreive_user_data 
 * This method gets the rows in the user table with User_ID
 * matching user_ids in a review
 * @param: the user id of the other person 
 * @return: an object represnting the row in the table or string "empty"
 */
function retreive_user_data($otherId){
    global $other_user_info;

    //Get Information on posted Ad_ID 
    $_SERVER["REQUEST_METHOD"] = "GET";
    $_GET['method'] = 'getUsersOfID';
    $_GET['user_ids'] = [$otherId];
    ob_start(); // read in data echoed from advertisement.php
    include __DIR__ . '/../../back-end/api/users.php'; 
    $response = ob_get_clean();

    echo "<BR>RAW RESPONSE<BR>" . $response ."<BR><BR>RAW RESPONSE END<BR>";//testing

    //TEST PARSE RESPONSE
    if (str_contains(substr($response, strpos($response,'{',0), strlen($response) - strpos($response,'}',0)), "{")) 
            while (str_contains($response, "{")) {

            $user_review_object = substr($response, strpos($response, '{',0), strpos($response, '}',0) - strpos($response, '{',0) + 1);
            $decode_user_review_object = json_decode($user_review_object);
            $other_user_info = $decode_user_review_object;

            $response = substr($response, strpos($response,'}',0) + 1, strlen($response) - strpos($response,'}',0));

    } else
        $other_user_info = "empty";
}

//DONE

/**
 * getListOfConversations
 * returns an array of ids that a user has messages with
 * @param userId - The current users id
 * @return nothing just sets global array $list_of_conversations which the [0] will be = empty if empty
 */
function getUserId():string {


        
        if (isset($_SESSION['userData'][0]['Users_ID'])) {
            $GLOBALS['user'] = $_SESSION['userData'][0]['Users_ID'];
            return $_SESSION['userData'][0]['Users_ID'];
        }
        else if(isset($_SESSION['userData'][0]['Business_ID'])){
            global $type;
            $type = "business";
            if($_SESSION['userData'][0]['Business_ID'] != null){
                $GLOBALS['user'] = $_SESSION['userData'][0]['Business_ID'];
                return $_SESSION['userData'][0]['Business_ID'];
            }
    }
    return "noUser";
}
function getListOfConversations($userId) {

    global $list_of_conversations;
    $current_conversation = array();

    //Get Information on posted Ad_ID 
    $_SERVER["REQUEST_METHOD"] = "GET";
    $_GET['method'] = 'getAllConversations';
    $_GET['userId'] = $userId;
    ob_start(); 
    include __DIR__ . '/../../back-end/api/messaging.php'; 
    $response = ob_get_clean();

    //Testing
    /*"<BR>RAW RESPONSE<BR>" . $response ."<BR><BR>RAW RESPONSE END<BR>";
    
    $debug = explode("}",$response);
    foreach ($debug as $messagingRow) {
        echo "<BR>";
        print_r($messagingRow);
    }
    echo "<BR>";*/
     

    //parse response
    if (str_contains(substr($response, strpos($response,'}',0), strlen($response) - strpos($response,'}',0)), "{")) {
        while (str_contains($response, "{")) {

            $review_object = substr($response, strpos($response, '{',0), strpos($response, '}',0) - strpos($response, '{',0) + 1);
            $decode_review_object = json_decode($review_object, true);
            $list_of_conversations[] = $decode_review_object;

            $response = substr($response, strpos($response,'}',0) + 1, strlen($response) - strpos($response,'}',0));
        }

    } 
        //echo "this is the problem";
}

//
/**
 * getCurrentConversation GET
 * Gets all messages between two user/business ids
 * @param userId -  The current users id
 * @param otherId -  The id of the other user/business
 * @return messages {array} - An array containg all of the messages between the two ids sorted in order
 */
function setCurrentConversation($userId, $otherId) {

    global $current_conversation;
    $current_conversation = array();

    //Get Information on posted Ad_ID 
    $_SERVER["REQUEST_METHOD"] = "GET";
    $_GET['method'] = 'getAllMessageForUsers';
    $_GET['userId'] = $userId;
    $_GET['otherId'] = $otherId;
    ob_start(); // read in data echoed from advertisement.php
    include __DIR__ . '/../../back-end/api/messaging.php'; 
    $response = ob_get_clean();
    //Testing
    //echo "<BR>RAW RESPONSE<BR>" . $response ."<BR><BR>RAW RESPONSE END<BR>";
    /*
    $debug = explode("}",$response);
    foreach ($debug as $messagingRow) {
        echo "<BR>";
        print_r($messagingRow);
    }
    echo "<BR>";
     */

    //parse response
    if (str_contains(substr($response, strpos($response,'}',0), strlen($response) - strpos($response,'}',0)), "{")) {
        while (str_contains($response, "{")) {

            $review_object = substr($response, strpos($response, '{',0), strpos($response, '}',0) - strpos($response, '{',0) + 1);
            $decode_review_object = json_decode($review_object, true);
            $current_conversation[] = $decode_review_object;

            $response = substr($response, strpos($response,'}',0) + 1, strlen($response) - strpos($response,'}',0));

        }

        $current_conversation = sortMessages($current_conversation);
    } else
        $current_conversation[0] = "empty";
}

/**
 * sortMessages
 * sorts message by the other in which they were sent
 * using insertion sort
 */
function sortMessages($currentConversation) {

    $sortedMessage = [];
    $i = 0;
    while ($i < count($currentConversation)){

        $j = $i;
        while ($j > 0 && $currentConversation[$j - 1]['Message_ID'] > $currentConversation[$j]['Message_ID']) {

            $swap = $currentConversation[$j - 1];
            $currentConversation[$j - 1] = $currentConversation[$j];
            $currentConversation[$j] = $swap;
            $j--;
        }
        $i++;
    }
    return $currentConversation;
}


/**
 * insertNewMessage PUT
 * inserts a new row into Messaging table
 */
/*function switchConvo($otherId){
    $_SERVER["REQUEST_METHOD"] = "PUT";
    $_PUT['method'] = 'insertmessage';
    $_PUT['userId'] = $userId;

}*/
function insertNewMessage($userId, $otherId, $message) {

    /*if (getMessageCount($userId, $otherId) < 2) {
        echo "Conversation must be accepted before you can send a message";        
        return -1;
    }*/

    $_SERVER["REQUEST_METHOD"] = "PUT";
    $_PUT['method'] = 'insertmessage';
    $_PUT['userId'] = $userId;
    $_PUT['otherId'] = $otherId;
    $_PUT['message'] = $message;
    ob_start(); // read in data echoed from advertisement.php
    include __dir__ . '/../../back-end/api/messaging.php';
    $response = ob_get_clean();
    echo $response;
    //echo "<br>raw response<br>" . $response ."<br><br>raw response end<br>";//testing
}

/**
 * inquire PUT
 * Reach out to a user
 */
function inquire($userId, $otherId, $message) {
    
    if (getmessagecount($userId, $otherId) > 2) {   
        return -1;
        // NORMAL OPERATIONS

    }else if(getmessagecount($userId, $otherId) == 0 ){
        // Starting a convo
        //insertNewMessage($userId, $otherId, "PENDING");
        //acceptorReject($otherId);
        return 1;

    }else if(getmessagecount($userId, $otherId) == 1 ){
        return 0;
        //ACCEPT OR REJECT
    }
}

/**
 * responsdToInquiry PUT
 * Respond to users request for communication
 * @param response - 0 == ACCEPT & 1 == REJECT
 */
function responsdToInquiry($userId, $otherId, $response) {

    if (getMessageCount($userId, $otherId) != 1) {
        echo "Inquiry has not been sent yet";        
        return -1;
    }

    if ($response == 0)
        insertNewMessage($userId, $otherId, "ACCPETED");

    else if ($response == 1)
        insertNewMessage($userId, $otherId, "REJECTED");
    else
        return -1;
}

/**
 * getMessageCount GET
 * Gets the number of messages exchanged between two users
 */
function getMessageCount($userId, $otherId) {

    $_SERVER["REQUEST_METHOD"] = "GET";
    $_GET['method'] = 'getMessageCount';
    $_GET['userId'] = $userId;
    $_GET['otherId'] = $otherId;
    ob_start(); // read in data echoed from advertisement.php
    include __dir__ . '/../../back-end/api/messaging.php';
    $response = ob_get_clean();

    //echo "<br>raw response<br>" . $response ."<br><br>raw response end<br>";//testing
    //ensures a json object is contained in output
    if ( str_contains($response, ']') && str_contains($response, '[') && strrpos($response, ']',0) > strrpos($response, '[',0) ) {

        $rawobject = substr($response, strrpos($response, '[', 0), ( strrpos($response, ']',0) - strrpos($response, '[', 0)) + 1 );
        $objectasarray = json_decode($rawobject);
        //print_r($objectasarray);//testing
        return $objectasarray[0];
    } else 
        return -1;

}function generate_convo_elements() {
    global $list_of_conversations;
    $userId = getUserId();
    global $user;
    getListOfConversations($user);
    global $current_conversations;
    if($list_of_conversations != null){
        foreach ($list_of_conversations as $row) {
            $otherId = $row['Other_ID'];
            echo "<div class=\"col-10 d-flex align-items-center justify-content-center\">" ;
                echo "<div class=\"group-container\">";
                    echo "<div class=\"Convo-btn\">";
                        echo '<div style ="display: inline-block;>';
                        echo '<img src="user1.png" class="msgimg" />';
                        echo '<a href="messaging"><button class="convo-button" onclick="openExisting(' . htmlspecialchars($userId) . ', ' . htmlspecialchars($otherId) . ')" style="padding: 10px;">' . htmlspecialchars($otherId) . '</button></a>';
                    echo "</div>";
                echo "</div>";
            echo "</div>";
        echo "</div>";
        }
    }else {
        echo "no current convos";
    }
}   
function generate_message($message, $timestamp, $sender){
    echo "<div class='messageRow'>";
       echo "<div class='col grey-light' style='background-color: lightgrey; opacity: 0.5;'> </div>";
        echo '<div class="col-8">';
          echo '<div class="group-container">';
                echo '<div class="row message-border-top">';
                    echo '<div class="col-8 grey">';
                        echo '<div class="message">';
                            //echo '<img class="user-profile" src="default_profile.jpg" alt="profile picture">';
                            if($sender){
                                one_message_sender($message, $timestamp);
                            }else{
                                one_message_recieve($message, $timestamp);
                            }
                            echo '<p>' ;
                            echo '</p>';
                            echo '</div>';
                        echo '</div>';
                    echo '</div>';
                echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '<div class="col grey" style="background-color: grey; opacity: 0.5;"> </div>';
        echo '</>';
}
function one_message_sender($message, $time){

    
    echo '<div class="received">';
        echo '<div class="received-chats-img">';
            echo '</div>';
            echo '<div class="received">';
              echo '<div class="received-msg">';
                echo'<p data-"">';
                echo $message;
                echo'</p>';
                echo'<div style ="display: inline-block;">';
                echo '<span class="time">';
                echo $time ;
                echo '</span>';
              echo'</div>';
            echo'</div>';
          echo'</div>';
}
function one_message_recieve($message, $time){
    echo '<div class="outgoing">';
        echo '<div class="outgoing-chats-img">';
            echo '</div>';
            echo '<div class="outgoing">';
              echo '<div class="outgoing-msg">';
                echo'<p>';
                echo $message;
                echo'</p>';
                echo'<div style ="display: inline-block;">';
                echo '<span class="time">';
                echo $time ;
                echo '</span>';
                echo '</div>';
              echo'</div>';
            echo'</div>';
          echo'</div>';
}

function genereate_convo($convo){
    // called by side button
    // needs to set everything else off
    if(isset($_SESSION['currentOther'])){

    $_SESSION['currentOther']= $convo;
    global $type;
    $thisType = $type;
    setCurrentConversation($GLOBALS['user'],$convo);
    global $current_conversation;
    if(inquire($GLOBALS['user'], $convo, "") == -1){
        $message = $current_conversation[1]['Message'];
        if(strcmp($message, "REJECTED123") != 0){
            generate_existing($GLOBALS['user'],$convo);
        }else{
            generate_rejected();
        }
        // "Normal Convo";
    }
    else if(inquire($GLOBALS['user'], $convo, "") == 0){
        // pending in the CONVO
        insertNewMessage($GLOBALS['user'], $convo, "PENDING");
        $_SESSION['currentOther']=$convo;
        generate_new_convo($convo);
        

    }else if(inquire($GLOBALS['user'], $convo, "") == 1){
        // accept / reject
        generate_pending_convo($convo);
    }
    }
}
function generate_rejected(){
    
    echo "<div class='pending'> Rejected </div>";   
}
function generate_new_convo($otherParty){
    //acceptorReject($otherParty);
    global $list_of_conversations;
    global $user;
    
    $userId = $user;
    
    getListOfConversations($userId);
    
    global $currentOther;
    global $current_conversation;
    setCurrentConversation($userId,$_SESSION['currentOther']);


    $sender = $current_conversation[0]['Sender_ID'];
    print_r($sender);
    if(strcmp($sender, string2: $userId) != 0){
        
        acceptorReject($otherParty);
    }
    
    else {
        echo "<div class='pending'> Waiting for  \"$otherParty \"  to Respond</div>";   
    }
  // 0 messages We send a PENDING inquiry
  // 1 we need accept or Reject;
  // more than 2 Normal function like now
  // 2 we need to check the 2nd message for "REJECT123"

}
function generate_pending_convo($otherParty){
    
    global $list_of_conversations;
    global $user;
    
    $userId = $user;
    
    getListOfConversations($userId);
    
    global $currentOther;
    global $current_conversation;
    setCurrentConversation($userId,$_SESSION['currentOther']);
    $sender = ""; 
    /*foreach($current_conversation as $message){
        $sender= $message['Sender_ID'];
    }
    if(strcmp($sender, string2: $userId) != 0){
        
        acceptorReject($otherParty);
    }
    
    else {
        echo "<div class='pending'> Waiting for  \"$otherParty \"  to Respond</div>";   
    }*/

    
}
function generate_existing($userId, $otherUser){
    global $list_of_conversations;

    getListOfConversations($userId);
    getListOfConversations($userId);
    global $currentOther;
    global $current_conversation;
    setCurrentConversation($userId,$_SESSION['currentOther']);

    foreach($current_conversation as $message){
        $messageString =$message['Message']; 
        $time= $message['Timestamp'];
        $user = $message['Sender_ID'];
        if(strcmp($userId, $user) === 0){
            $sender = true;
        }else{
            $sender = false;
        }
        if(strcmp($messageString, "PENDING") != 0 && strcmp($messageString, "ACCEPTED123") !=0 &&  strcmp($messageString, "REJECTED123") != 0){
            generate_message($messageString,$time,$sender);
        }
    }
}
function acceptorReject($User){

    echo '<div class="pending" id="pending" >';
        echo '<p> Pending conversation from ' . $User .' Accept or Reject </p>';
        echo '<div class="make-an-offer-accept-or-reject-choice">';
        echo "<button type='button' id='accept' onclick='accept(\"{$GLOBALS['user']}\", \"{$_SESSION['currentOther']}\")'class='accept'>Accept</button>";
        echo "<button type='button' id='reject' onclick='reject(\"{$GLOBALS['user']}\", \"{$_SESSION['currentOther']}\")' class='reject'>Reject</button>";
        echo '</div>';
    echo '</div>';

}
?>


<!DOCTYPE html>

<html lang = "en">
<head>  
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../front-end/global/css/global-style.css">
    <link rel="stylesheet" href="../front-end/global/css/nav.css">

    <style>
        .across{
            display: flex;
            flex-direction: row;
        }
        .messageRow{
            visibility: visible;
        }
        .messageRow-hidden{
            visibility: : hidden;
        }
        .navBar{
            display: inline-block;
            vertical-align: top;
            text-align: center;
        }
        .Convo-btn {
            border: 2px solid black;
            background-color: lightskyblue;
        }
        .pending-hidden{
            visibility: hidden;
        }
        .pending {
            display: inline-block;
            padding: 20px;
            vertical-align: top;
            width: 92%;
            text-align: center 
        }
        .accept {
            width: 20%;
            color: black;
            font-size: 1rem;
            background-color: ;
            background-color: #c3cf62;
            margin-left: 20px;
            margin-right: 20px;
            margin-bottom: 10px;
            border-radius: 30px;
            border: solid 5px black;
            box-shadow: 5px 5px #4c4949;
        }
        .accept:hover {
            cursor: pointer;
            background-color:  #8f9c30;
        }
        .reject {
            width: 20%;
            color: black;
            font-size: 1rem;
            background-color: ;
            background-color:rgb(215, 145, 59);
            margin-left: 20px;
            margin-right: 20px;
            margin-bottom: 10px;
            border-radius: 30px;
            border: solid 5px black;
            box-shadow: 5px 5px #4c4949;
        }
        .reject:hover {
            cursor: pointer;
            background-color:  #8f9c30;
        }
        .convo-button {
            font-size: 16px;
            border-radius: 10px;
            min-width: 100%;
        }
        .convo-button:hover{
            cursor: pointer;
            background-color:rgb(209, 212, 184);
        }
        received-chats-img {
            display: inline-block;
            width: 50px;
            float: right;
        }

        .received {
            display: inline-block;
            padding: 0 0 0 10px;
            vertical-align: top;
            width: 92%;
        }
        .received-msg {
            width: 57%;
        }

        .received-msg p {
            background: #efefef none repeat scroll 0 0;
            border-radius: 10px;
            color: #646464;
            font-size: 14px;
            margin-left: 1rem;
            padding: 1rem;
            width: 100%;
            box-shadow: rgb(0 0 0 / 25%) 0px 5px 5px 2px;
        }
            p {
            overflow-wrap: break-word;
        }

        .time {
            color: #777;
            display: block;
            font-size: 12px;
            margin: 8px 0 0;
        }
        .outgoing{
            display: inline-block;
            padding: 0 0 0 10px;
            vertical-align: top;
            width: 92%;
        }

        .outgoing-msg p {
            background: #efefef none repeat scroll 0 0;
            border-radius: 10px;
            color: #646464;
            font-size: 14px;
            margin-left: 1rem;
            padding: 1rem;
            width: 100%;
            box-shadow: rgb(0 0 0 / 25%) 0px 5px 5px 2px;
        }
        .outgoing-msg {
                float: right;
                width: 46%;
            }
        .navbar{
            display: flex;
            gap: 10px;
            align-items: center;
        }
     
    </style>

</head>
    <div style="navbar" >
        <?php get_nav() ?>
    </div>
<div id="header"></div>
    <div style="height: 100vh; min-width: 20%; float:left; margin-right: 10px;">
        <div>
            <?php generate_convo_elements($list_of_conversations) ?>
         </div>
         </div>
         </div>
    </div>
    </div>
    </div>
    <div style="height: 80vh;min-width: 50%;width:50%;  display: inline-block; background-color: darkturquoise;">
        <div  class = right>
            <table class='conversation' >
            <tbody style = image-item>
                <?php
                    if(isset($_SESSION['currentOther']))
                    genereate_convo($_SESSION['currentOther']);
                ?>
                </tbody>
            </table>
            <div style="position: absolute; bottom: 10%; padding: 20px;">


                <?php
                    if(isset($_SESSION['currentOther'])){
                    echo '<input type="message"  id="message" placeholder="Message" name="Message">';
                    echo "<a href='messaging'><button id='send_button' onclick='send_button(\"{$GLOBALS['user']}\", \"{$_SESSION['currentOther']}\")'>Send</button></a>";
                    }
                ?>

            </div>
        </div>
    </div>
</div>
<script type="application/javascript" src="js/messages.js"></script>
</div>
</html>

