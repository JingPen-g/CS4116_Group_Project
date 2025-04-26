<?php

$list_of_conversations = null; //["User_ID" => "Other_ID"]
$current_conversation = null; //[[Message1],[Message2]] Note: Message contains all details from a row in TABLE Messaging
$user_info = null; //[]

//= null; //[]
/**
 *
 */
function getUserInfo() {
}
//= null; //[]
/**
 *
 */
function getOtherInfo() {
}


//= null; //["User_ID" => "Other_ID"]
/**
 * getListOfConversations
 * returns an array of ids that a user has messages with
 */
function getListOfConversations() {
}


//DONE
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
function insertNewMessage($userId, $otherId, $message) {

    $_SERVER["REQUEST_METHOD"] = "PUT";
    $_PUT['method'] = 'insertmessage';
    $_PUT['userId'] = $userId;
    $_PUT['otherId'] = $otherId;
    $_PUT['message'] = $message;
    ob_start(); // read in data echoed from advertisement.php
    include __dir__ . '/../../back-end/api/messaging.php';
    $response = ob_get_clean();

    //echo "<br>raw response<br>" . $response ."<br><br>raw response end<br>";//testing
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

}


//TESTING 
echo getMessageCount(13,15); //user_id, other_id
echo "<BR>";
//setCurrentConversation(13,15);

//insertNewMessage(13,15, "Hows she cutting"); //user_id, other_id, message
?>
