<?php
session_start();

require_once(__DIR__ . "/../db/Transaction.php");


$transaction = new Transaction();

if($_SERVER["REQUEST_METHOD"] == "GET"){

    echo json_encode(['error' => 'Method not defined']);
} 
else if($_SERVER["REQUEST_METHOD"] == "POST"){

    if (isset($_POST["action"]) && $_POST["action"] == "insertNewTransaction") {

        $var = $transaction->insertTransaction($_POST['user_id'],$_POST['business_id'],$_POST['service_id'],$_POST['amount'],$_POST['status']); 
        echo json_encode($var);
    } 
    else
        echo json_encode(['error' => 'Method not defined in POST transactions api']);
} 
else if($_SERVER["REQUEST_METHOD"] == "PUT"){

        echo json_encode(['error' => 'Method not defined']);
} 
else if($_SERVER["REQUEST_METHOD"] == "DELETE") {

    echo json_encode(['error' => 'Method not defined']);
} 
else {
    http_response_code(400);
    print_r($_POST);
    echo json_encode(['error' => 'Name parameter is required']);
}
?>

