<?php
session_start();

require_once("../db/Users.php");

header('Content-Type: application/json');

$user = new Users();

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
} else if($_SERVER["REQUEST_METHOD"] == "POST"){
    $name = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user->insertUser($name, $email, $password);
}
else {
    http_response_code(400);
    print_r($_POST);
    echo json_encode(['error' => 'Name parameter is required']);
}
?>