<?php
session_start();

require_once("../db/Users.php");
require_once("../db/Business.php");

header('Content-Type: application/json');

$user = new Users();
$business = new Business();

$username = $_SESSION['username'] ?? "";

if($_SERVER["REQUEST_METHOD"] == "GET"){


} else if($_SERVER["REQUEST_METHOD"] == "POST"){
    $description = trim($_POST["description"] ?? "");
    $phone = trim($_POST["phone"] ?? "");

    $username = $_SESSION['username'];

    // Handle file upload
    if (isset($_FILES["profilePic"]) && $_FILES["profilePic"]["error"] == UPLOAD_ERR_OK) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["profilePic"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
        // Allow certain file formats
        if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
            echo json_encode(["error" => "Sorry, only JPG, JPEG, PNG & GIF files are allowed."]);
            exit();
        }

        if (move_uploaded_file($_FILES["profilePic"]["tmp_name"], $target_file)) {
            // Update profile picture in the database
            $user->updateProfilePicture($username, $target_file);
        } else {
            echo json_encode(["error" => "Sorry, there was an error uploading your file."]);
            exit();
        }
    } 


    $description = test_input($description);
    $phone = test_input($phone);

    if (!empty($description)) {
        // update description in the database
        $user->updateDescription($username, $description);               
    }
        
    if (!empty($phone)) {
        // update phone number in the database
        $user->updatePhone($username, $phone);
    }
    header("Location: http://localhost:8080/userprofile");
    exit();
    

} else if($_SERVER["REQUEST_METHOD"] == "PUT"){

} else if($_SERVER["REQUEST_METHOD"] == "DELETE") {

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