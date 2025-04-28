<?php
session_start();

require_once(__DIR__ . "/../db/Verification.php");


$verification = new Verification();

if($_SERVER["REQUEST_METHOD"] == "GET"){
    if(isset($_GET['method']) && $_GET['method'] === "getServicesUserIsVerifiedFor"){

        $user_id = $_GET['user_id'];
        $service_ids = $_GET['service_ids'];

        if ($service_ids[0] != "empty") 
            $list_of_services_for_which_user_is_verified = $verification->isUserVerifiedFor($user_id, $service_ids);
        else
            $list_of_services_for_which_user_is_verified = ["none"];
        
        echo json_encode($list_of_services_for_which_user_is_verified);
    } else {

        echo json_encode(['error' => 'Method not defined for GET in Verification']);
    }

} 
else if($_SERVER["REQUEST_METHOD"] == "POST"){

    if(isset($_POST['action']) && $_POST['action'] === "insertNewVerifiedCustomer"){

        $user_id = $_POST['user_id'];
        $service_id = $_POST['service_id'];
        $userIsVerified = $verification->insertVerifiedUser($user_id, $service_id);

        echo json_encode($userIsVerified);

    } else {

        echo json_encode(['error' => 'Method not defined for POST in Verification']);
    }
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

