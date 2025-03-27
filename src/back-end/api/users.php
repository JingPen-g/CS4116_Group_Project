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
    $username = trim($_POST["username"] ?? "");
        $password = trim($_POST["password"] ?? ""); 
        $re_password = trim($_POST["re_password"] ?? "");
        $email = trim($_POST["email"] ?? "");

        $usernameErr = "";
        $passwordErr = "";
        $re_passwordErr = "";
        $emailErr = "";

        if (empty($username)) {
            $_SESSION['$usernameErr'] = "Username is required";
        } else {
            
            if (!preg_match("/^[a-zA-Z0-9]*$/",test_input($username))) {
                $usernameErr = "Only letters and white space allowed";
            }
                
        }
        if (empty($password)) {
            $_SESSION['$passwordErr'] = "Password is required";
        } else {
            $meetConditions = 0;
            $hasUppercase = "/(?=.*[A-Z])/";
            $hasLowercase = "/(?=.*[a-z])/";
            $hasNumber = "/(?=.*[0-9])/";
            $hasSpecial = "/(?=.*[\W_])/";

            $conditions = array($hasUppercase, $hasLowercase, $hasNumber, $hasSpecial);
            foreach ($conditions as $condition) {
                if (preg_match($condition,test_input($password))) {
                    $meetConditions++;
                }
            }
            if ($meetConditions < 3 && strlen($password) < 8) {
                $passwordErr = "Please choose a stronger password.";
            }
        }

        if (empty($re_password)) {
            $_SESSION['$re_passwordErr'] = "Please repeat your password";
        } else {
            if ($password != test_input($re_password)) {
                $_SESSION['$re_passwordErr'] = "Passwords do not match.";
            }
        }

        if (empty($email)) {
            $_SESSION['$emailErr'] = "Email is required";
        } else {
            if (!filter_var(test_input($email), FILTER_VALIDATE_EMAIL)) {
                $_SESSION['$emailErr'] = "Please enter a valid email address.";
            }
        }
        
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    
        
        $registration_success = $user->insertUser($username, $email, $hashedPassword);

        // If registration is successful (e.g., no errors in validation)
        if ($registration_success) {
            if (headers_sent($file, $line)) {
                die("Headers already sent in $file on line $line");
            }
            // to do - alert ("susccessful registration")
            echo json_encode([
                'status' => 'success',
                'message' => 'Registration successful! Redirecting you to the login page...',
                'redirect' => 'http://localhost:8080/login'
            ]);
            exit();

            // Redirect to login page after successful registration
            // header("Location: http://localhost:8080/login");
            // exit();  // Make sure to exit to prevent any further code execution
        } else {
            // Handle errors and redirect back to the registration page
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to register user. Please try again.'
            ]);
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