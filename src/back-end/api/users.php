<?php
session_start();

require_once("../db/Users.php");

header('Content-Type: application/json');

$user = new Users();

if($_SERVER["REQUEST_METHOD"] == "GET"){
    if (isset($_GET['name'])) {
        $userData = $user->getUser($_GET['name']);
        
        if ($userData !== null) {
            echo json_encode($userData);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'User not found']);
        }
    } else if(isset($_GET['usercount']) && $_GET['usercount'] == 1){
        $userData = $user->getUserCount();
    
        if ($userData !== null){
            echo json_encode($userData);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'User Count not found']);
        }
    }

} 
else if($_SERVER["REQUEST_METHOD"] == "POST"){
    $name = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $result = $user->insertUser($name, $email, $password);

    if ($result) {
        http_response_code(201); // Created
        echo json_encode(['success' => 'User inserted successfully']);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to insert user']);
    }
} 
else if($_SERVER["REQUEST_METHOD"] == "PUT"){
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    $result = null;

    if(isset($data['type']) && $data['type'] === 'reset-password'){
        $result = $user->updatePassword($data['email'], $data['password']);
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

} 
else {
    http_response_code(400);
    print_r($_POST);
    echo json_encode(['error' => 'Name parameter is required']);
}


?>