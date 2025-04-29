<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once(__DIR__ . "/../db/Users.php");
require_once(__DIR__ . "/../db/Business.php");


$user = new Users();
$business = new Business();

if($_SERVER["REQUEST_METHOD"] == "GET"){
    if (isset($_GET['username'])) {
        $userData = $user->getUser($_GET['username']);
        $businessData = $business->getBusiness($_GET['username']);
        if ($userData || $businessData) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Username already exists'
            ]);
            exit;
        } else {
            echo json_encode(['message' => 'User not found']);
        }
    } else if (isset($_GET['email'])) {

        $email = $_GET['email'];
        $uniqueUserEmail = $user->getUserByEmail($email);
        $uniqueBusinessEmail = $business->getBusinessByEmail($email);
        if ($uniqueUserEmail || $uniqueBusinessEmail) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Email already exists'
            ]);
            exit;
        } else {
            echo json_encode(['error' => 'Email not found']);
        }

    } else if(isset($_GET['usercount']) && $_GET['usercount'] == 1){
        $userData = $user->getUserCount();
    
        if ($userData !== null){
            echo json_encode($userData);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'User Count not found']);
        }

    /*
     * Gets all rows in the user table which contain a User_ID from the passed array of ID's
     */
    } else if(isset($_GET['method']) && $_GET['method'] === "getUsersOfID"){
    
        $user_ids = $_GET['user_ids'];
        $user_rows = [];
        foreach ($user_ids as $user_id) {
            $user_rows[] = $user->getUserFromID($user_id);
        }

        echo json_encode($user_rows);
    }

} 
else if($_SERVER["REQUEST_METHOD"] == "POST"){
    $formId = $_POST["id"] ?? "";

    if ($formId === "login_form") {
        $username = trim($_POST["username"] ?? "");
        $password = trim($_POST["password"] ?? "");

        // todo: validation
        $username = test_input($username); 
        $password = test_input($password); 

        if (empty($username) || empty($password)) {
            $_SESSION['error_message'] = "Please enter your usernamd and password";
        } else {
            $_SESSION['error_message'] = "";        
        }

        $customerData = $user->getUser($username);
        $businessData = $business->getBusiness($username);

        // Determine which one was found
        if (!empty($customerData)) {
            $userData = $customerData;
            $userData[0]['usertype'] = 'customer';
        } elseif (!empty($businessData)) {
            $userData = $businessData;
            $userData[0]['usertype'] = 'business owner';
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Invalid username or password.'
            ]);
            return;
        }

        // Store only one user array in the session
        $_SESSION['userData'] = $userData;

        if (!empty($userData) && password_verify($password, $userData[0]['Password']) && isset($userData[0]['Admin']) && $userData[0]['Admin'] == 1) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['usertype'] = 'admin';
            $_SESSION['username'] = $userData[0]['Name'];
            echo json_encode([                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          
                'status' => 'success',
                'message' => 'Login successful! Redirecting you to the admin page...',
                'redirect' => '/admins'
            ]);
            exit();
        }


        if (!empty($userData) && password_verify($password, $userData[0]['Password'])) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Login successful! Redirecting you to the search page...',
                'redirect' => '/search'
            ]);
            
        exit();
            
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Invalid username or password.'
            ]);
        }
    } else {
        $username = trim($_POST["username"] ?? "");
        $password = trim($_POST["password"] ?? ""); 
        $re_password = trim($_POST["re_password"] ?? "");
        $email = trim($_POST["email"] ?? "");
        $usertype = $_POST["usertype"];

        $usernameErr = "";
        $passwordErr = "";
        $re_passwordErr = "";
        $emailErr = "";
        $userTypeErr = "";

        if (empty($username)) {
            $_SESSION['usernameErr'] = "Username is required";
        } else {
            
            if (!preg_match("/^[a-zA-Z0-9]*$/",test_input($username))) {
                $usernameErr = "Only letters and white space allowed";
            } 
            test_input($username);  
        }
        if (empty($password)) {
            $_SESSION['passwordErr'] = "Password is required";
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
            $_SESSION['re_passwordErr'] = "Please repeat your password";
        } else {
            if ($password != test_input($re_password)) {
                $_SESSION['re_passwordErr'] = "Passwords do not match.";
            } else {
                $_SESSION['re_passwordErr'] = "";
            }
        }

        if (empty($email)) {
            $_SESSION['emailErr'] = "Email is required";
        } else {
            if (!filter_var(test_input($email), FILTER_VALIDATE_EMAIL)) {
                echo "Invalid email format.";
                $_SESSION['$emailErr'] = "Please enter a valid email address.";
                exit;
            } else {
                $_SESSION['emailErr'] = "";
            }
        }

        if (empty($usertype)) {
            $_SESSION['userTypeErr'] = "Usertype is required";
        } else {
            $_SESSION['userTypeErr'] = "";
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);


        if ($usertype === "customer") {
            $registration_success = $user->insertUser($username, $email, $hashedPassword);
            $customerData = $user->getUser($username);
        } else {
            $registration_success = $business->insertBusiness($username, $email, $hashedPassword);
            $businessData = $business->getBusiness($username);
        }
        if (!empty($customerData)) {
            $userData = $customerData;
            $userData[0]['usertype'] = 'customer';
        } elseif (!empty($businessData)) {
            $userData = $businessData;
            $userData[0]['usertype'] = 'business owner';
        }
        $_SESSION['registration_success'] = $registration_success;
        
        // If registration is successful (e.g., no errors in validation)
        if ($registration_success) {
            // to do - alert ("susccessful registration")
            $_SESSION['userData'] = $userData;
            echo json_encode([
                'status' => 'success',
                'message' => 'Registration successful! Redirecting you to the search page...',
                'redirect' => '/search'
            ]);
            exit();
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to register user. Please try again.'
            ]);
        }
        exit();   
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
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    $result = null;

    if(isset($data['type']) && $data['type'] == 'delete-user'){
        $result = $user->deleteUser($data['name']);
    }

    if ($result) {
        http_response_code(201); // Created
        echo json_encode(['success' => 'User inserted successfully']);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to insert user']);
    }
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
