<?php


function insertNewMessagePost($_POST["userId"], $_POST["otherId"], $_POST["message"]) {
    //getJsonInput();

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
    echo "<br>raw response<br>" . $response ."<br><br>raw response end<br>";//testing
}