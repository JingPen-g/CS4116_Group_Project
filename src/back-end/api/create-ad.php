<?php
session_start();

require_once(__DIR__ . "/../db/Advertisment.php");

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

$ad = new Advertisment();

$username = $_SESSION['username'] ?? "";

if($_SERVER["REQUEST_METHOD"] == "GET"){


} else if($_SERVER["REQUEST_METHOD"] == "POST"){

    $serviceDetails["Name"] = $_POST['adName']; 
    $serviceDetails["Description"] = $_POST['adDescription']; 
    $serviceDetails["Business_ID"] = $_SESSION['businessData'][0]['Business_ID'];
    $serviceDetails["Label"] = '[' . $_POST['serviceIds'] . ']'; 

    echo $service->insertAd($serviceDetails);

    

} else if($_SERVER["REQUEST_METHOD"] == "PUT"){

} else if($_SERVER["REQUEST_METHOD"] == "DELETE") {

}
else {
    http_response_code(400);
    
}
?>
