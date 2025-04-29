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
    $description = test_input($description);
    $phone = test_input($phone);

    if (!empty($description)) {
        $_SESSION['description'] = $description;
        if ((isset($_SESSION['userId']) && $_SESSION['userId'] === "business owner") 
        or (isset($_SESSION['usertype']) && $_SESSION['usertype'] === "business owner")) {
            $result = $business->updateDescription($username, $description);  
        } else if (isset($_SESSION['userType']) && $_SESSION['userType'] === "customer"){
            $result = $user->updateDescription($username, $description);  
        }
    }
        
    if (!empty($phone)) {
        $_SESSION['phone'] = $phone;
        if ((isset($_SESSION['userId']) && $_SESSION['userId'] === "business owner") 
        or (isset($_SESSION['usertype']) && $_SESSION['usertype'] === "business owner")) {
            $result = $business->updatePhone($username, $phone);  
        } else if (isset($_SESSION['userType']) && $_SESSION['userType'] === "customer"){
            $result = $user->updatePhone($username, $phone);

        }
    }

    // Handle file upload
    if (isset($_FILES["profile_picture"]) && $_FILES["profile_picture"]["error"] == UPLOAD_ERR_OK) {
        
        $target_dir = "/var/www/html/uploads/";

        if (is_writable('/var/www/html/uploads')) {
            $_SESSION['file write'] = "Uploads dir is writable!";
        } else {
            $_SESSION['file write'] =  "Uploads dir is NOT writable!";
        }

        $target_file = $target_dir . basename($_FILES["profile_picture"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $_SESSION['file name'] = "Uploaded file name: " . $_FILES["profile_picture"]["name"];
        $_SESSION['extension'] = "Detected extension: " . $imageFileType;
        if ($_FILES['profile_picture']['size'] > 5 * 1024 * 1024) {
            $_SESSION['fileTypeError'] = "File is too large. Max size: 5MB.";
        }
        if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
            $_SESSION['fileTypeError'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        } else {

            $_SESSION['fileTypeError'] = "no type error";
            $filename = uniqid("profile_", true) . "." . $imageFileType;
            $target_file = $target_dir . $filename;
            if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
                $_SESSION['profile_picture'] = $_SESSION['profile_picture'] = "/uploads/" . $filename;
                $_SESSION['target_file'] = $target_file;
                $web_path = "/uploads/" . $filename;
                if ((isset($_SESSION['userId']) && $_SESSION['userId'] === "business owner") 
                or (isset($_SESSION['usertype']) && $_SESSION['usertype'] === "business owner")) {
                    $result = $business->updateProfilePicture($username, $web_path);
                } else if (isset($_SESSION['userType']) && $_SESSION['userType'] === "customer"){
                    $result = $user->updateProfilePicture($username, $web_path);
                }
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