<?php
session_start();

require_once(__DIR__ . "/../db/Service.php");

/*
echo "<BR>";
print_r($_SESSION);
echo "<BR>";
print_r($_POST);
echo "<BR>";
print_r($_FILES);
echo "<BR>";
require_once("../db/Users.php");
require_once("../db/Business.php");
 */

$service = new Service();

$username = $_SESSION['username'] ?? "";

if($_SERVER["REQUEST_METHOD"] == "GET"){


} else if($_SERVER["REQUEST_METHOD"] == "POST"){

    $serviceDetails["Name"] = $_POST['serviceName']; 
    $serviceDetails["Description"] = $_POST['serviceDescription']; 
    $serviceDetails["Price"] = $_POST['price']; 
    $serviceDetails["Label"] = '{"labels": "' . $_POST['labelString'] . '"}'; 
    $serviceDetails["Location"] = "Ireland"; 
    $serviceDetails["Business_ID"] = $_SESSION['userData'][0]['Business_ID'];

    echo $service->insertService($serviceDetails);

    

} else if($_SERVER["REQUEST_METHOD"] == "PUT"){

} else if($_SERVER["REQUEST_METHOD"] == "DELETE") {

}
else {
    http_response_code(400);
    
}
?>
