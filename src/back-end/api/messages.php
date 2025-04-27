<?php
require_once("../db/Messages.php");
require_once("../db/Users.php");
require_once("../db/Business.php");

header('Content-Type: application/json');

$user = new Users();
$business = new Business();
$messages = new Messages();

if($_SERVER["REQUEST_METHOD"] == "GET"){
    if (isset($_GET['conversations'])) {
        $conversations = $messages->getConversations($_GET['name']);
        
        if ($conversations !== null) {
            echo json_encode($conversations);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Conversations not found']);
        }
    } else if(isset($_GET['convo'])){
        $userData = $user->getUserCount();
    
        if ($userData !== null){
            echo json_encode($userData);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'User Count not found']);
        }
    }

} // if exists just need an ajax 
else if($_SERVER["REQUEST_METHOD"] == "POST"){
    $formId = $_POST["id"] ?? "";

    if ($formId === "send_message") {
        
}
else if($_SERVER["REQUEST_METHOD"] == "PUT"){
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    $result = null;

    if(isset($data['type']) && $data['type'] === 'send message'){
        $result = $messages->updatePassword($data['email'], $data['password']);
    }

    if ($result) {
        http_response_code(201); // Created
        echo json_encode(['success' => 'User inserted successfully']);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to insert user']);
    }
} 
else if($_SERVER["REQUEST_METHOD"] == "DELETE") {
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    $result = null;

    if(isset($data['type']) && $data['type'] == 'delete-user'){
        $result = $user->deleteUser($data['name']);
    }

    if ($result) {
        http_response_code(201); // Created
        echo json_encode(['success' => 'User inserted successfully']);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to insert user']);
    }
}
}

else {
    http_response_code(400);
    
}

function test_input($data)  {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


?>