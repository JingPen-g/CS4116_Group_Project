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

    $username = $_SESSION['userData'][0]['Name'];
    $_SESSION['I want to see username'] = $username;
    $description = test_input($description);
    $phone = test_input($phone);

    if (!empty($description)) {
        if (isset($_SESSION['userData'][0]) && $_SESSION['userData'][0]['usertype'] === "business owner") {
            $result = $business->updateDescription($username, $description);  
        } else {
            $result = $user->updateDescription($username, $description);  
        }
        $_SESSION['userData'][0]['Description'] = $description;
    }
        
    if (!empty($phone)) {
        if (isset($_SESSION['userData'][0]) && $_SESSION['userData'][0]['usertype'] === "business owner") {
            $result = $business->updatePhone($username, $phone);  
        } else {
            $result = $user->updatePhone($username, $phone);
        }
        $_SESSION['userData'][0]['Phone'] = $phone;
    }

    // Handle file upload
    if (isset($_FILES["profile_picture"]) && $_FILES["profile_picture"]["error"] == UPLOAD_ERR_OK) {
        
        $target_dir = "/var/www/html/uploads/";

        if (is_writable('/var/www/html/uploads')) {
            $_SESSION['file write'] = "Uploads dir is writable!";
        } else {
            $_SESSION['file write'] =  "Uploads dir is NOT writable!";
        }

        $imageFileType = strtolower(pathinfo($_FILES["profile_picture"]["name"], PATHINFO_EXTENSION));
        $filename = uniqid("profile_", true) . "." . $imageFileType;
        $target_file = $target_dir . $filename;

        $_SESSION['file name'] = "Uploaded file name: " . $_FILES["profile_picture"]["name"];
        $_SESSION['extension'] = "Detected extension: " . $imageFileType;
        if ($_FILES['profile_picture']['size'] > 5 * 1024 * 1024) {
            $_SESSION['fileTypeError'] = "File is too large. Max size: 5MB.";
        }
        if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
            $_SESSION['fileTypeError'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        } else {
            $filename = uniqid("profile_", true) . "." . $imageFileType;
            $target_file = $target_dir . $filename;
            if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
                $_SESSION['profile_picture'] = $_SESSION['profile_picture'] = "/uploads/" . $filename;
                $_SESSION['target_file'] = $target_file;
                $web_path = "/uploads/" . $filename;
                if (isset($_SESSION['userData'][0]) && $_SESSION['userData'][0]['usertype'] === "business owner") {
                    $result = $business->updateProfilePicture($username, $web_path);
                    $_SESSION['uploaded'] = $result;
                } else {
                    $result = $user->updateProfilePicture($username, $web_path);
                    $_SESSION['uploaded'] = $result;
                }
                $_SESSION['userData'][0]['ProfilePicturePath'] = $web_path;
            } else {
                $_SESSION['fileTypeError'] = "Failed to move uploaded file.";
            } 
            
        }

        
    } 

    header("Location: /userprofile");
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
    $data = strip_tags($data);
    return $data;
}
?>