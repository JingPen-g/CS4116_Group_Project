<?php
//Global varriables 
//Note: They must be set with the appropriate method call first
$list_of_conversations = null; //[index => "Other_ID"]
$current_conversation = null; //[[Message1],[Message2]] Note: Message contains all details from a row in TABLE Messaging
$other_user_info = null;//Object represning a row

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
            $list_of_conversations[] = $decode_review_object;

            $response = substr($response, strpos($response,'}',0) + 1, strlen($response) - strpos($response,'}',0));
        }

    } else
        $list_of_conversations[0] = "empty";

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
function insertNewMessage($userId, $otherId, $message) {

    if (getMessageCount($userId, $otherId) < 2) {
        echo "Conversation must be accepted before you can send a message";        
        return -1;
    }
        

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
 * inquire PUT
 * Reach out to a user
 */
function inquire($userId, $otherId) {

    if (getmessagecount($userid, $otherid) != 0) {
        echo "Conversations already started";        
        return -1;
    }

    insertNewMessage($userId, $otherId, "PENDING");
}

/**
 * responsdToInquiry PUT
 * Respond to users request for communication
 * @param response - 0 == ACCEPT & 1 == REJECT
 */
function responsdToInquiry($userId, $otherId, $response) {

    if (getmessagecount($userid, $otherid) != 1) {
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

}
?>
