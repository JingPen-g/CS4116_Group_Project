<?php
header('Content-Type: application/json; charset=utf-8');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


require_once(__DIR__ . "/../db/Admins.php");
require_once(__DIR__ . "/../db/Users.php");
require_once(__DIR__ . "/../db/Business.php"); 
require_once(__DIR__ . "/../db/Admins_messages.php");



$admins = new Admins();
$user = new Users();
$business = new Business();
$admins_messages = new Admins_Messages();

$username = $_SESSION['username'] ?? "";
$action = $_GET['action'] ?? "";
if($_SERVER["REQUEST_METHOD"] == "GET") {
    if ($action === "getAllReviews") {
        $allReviews = $admins->getAllReviews();
        echo json_encode($allReviews); 
        exit;  
    } elseif ($action === "getUsernameById") {
        $userId = $_GET['Users_ID'] ?? null;
        if ($userId) {
            $username = $user->getUsernameByUserId($userId); // Fetch username from database
            echo json_encode(['username' => $username]);
            exit;
        } else {
            echo json_encode([]);
            exit;
        }
    } elseif ($action === "getAllBannedReviews") {
        $bannedReviews = $_GET['Banned'] ?? null;
        $allReviews = $admins->getAllBannedReviews($bannedReviews);
        echo json_encode($allReviews); 
        exit;
    } elseif ($action === "getAllMessages") {
        $allMessages = $admins_messages -> getAllMessages();
        echo json_encode($allMessages);
        exit;
    } elseif ($action === "getAllBannedMessages") {
        $bannedMessages = $_GET['Banned'] ?? null;
        $allMessages = $admins_messages->getAllBannedMessages($bannedMessages);
        echo json_encode($allMessages);
        exit;
    } elseif ($action === "getAllUsers") {
        $allUsers = $user->getAllUsers(0);
        $allBusiness = $business->getAllBusiness();

        $response = [
            'users' => $allUsers,
            'businesses' => $allBusiness
        ];
        echo json_encode($response);
        exit;
    }
} else if($_SERVER["REQUEST_METHOD"] == "POST"){
    if ($action === "removeReview") {
        $input = json_decode(file_get_contents("php://input"), true);
        $reviewId = $input['Review_ID'] ?? null;
        $banned = $input['Banned'] ?? null;

        try {
            if ($reviewId) {
                $admins->updateReviewBanned($reviewId,$banned);
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Invalid Review ID']);
            }
        } catch (Exception $e) {
            error_log('updateReviewBanned failed: ' . $e->getMessage());
            echo json_encode(['status' => 'error', 'message' => 'Update failed']);
        }
    } elseif ($action === "removeMessage") {
        $input = json_decode(file_get_contents("php://input"), true);
        $messageId = $input['Message_ID'] ?? null;
        $banned = $input['Banned'] ?? null;
        
        try {
            if ($messageId) {
                $admins_messages->updateMessageBanned($messageId,$banned);
                echo json_encode(['status' => 'success']);
                exit;
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Invalid Message ID']);
                exit;
            }
        } catch (Exception $e) {
            error_log('updateReviewBanned failed: ' . $e->getMessage());
            echo json_encode(['status' => 'error', 'message' => 'Update failed']);
            exit;
        }
    
    // }  elseif ($action === "addTestMessage") {
    //     $input = json_decode(file_get_contents("php://input"), true);
    //     $receiverId = $input['Receiver_Id'] ?? null;
    //     $senderId = $input['Sender_Id'] ?? null;
    //     $message = $input['Message'] ?? null;
    //     $timestamp = $input['Timestamp'] ?? null;
    //     $banned = $input['Banned'] ?? null;
    //     $add_success = $admins_messages -> addTestMessage($receiverId, $senderId, $message, $timestamp, $banned);
    //     if ($add_success) {
    //         echo json_encode(['status' => 'success']);
    //     } else {
    //         echo json_encode(['status' => 'error', 'message' => 'Insert failed']);
    //     }
    }  elseif ($action === "banRegularUser") {
        $input = json_decode(file_get_contents("php://input"), true);
        $userId = $input['Users_ID'] ?? null;
        $banned = 1;
        $admin = 0;
        try {
            if ($userId) {
                $user->updateUserBanned($userId, $banned, $admin);
                echo json_encode(['status' => 'success']);
                exit;
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Invalid Message ID']);
                exit;
            }
        } catch (Exception $e) {
            error_log('updateReviewBanned failed: ' . $e->getMessage());
            echo json_encode(['status' => 'error', 'message' => 'Update failed']);
            exit;
        }
    } elseif ($action === "banBussinessUser") {
        $input = json_decode(file_get_contents("php://input"), true);
        $businessId = $input['Business_ID'] ?? null;
        $banned = $input['Banned'] ?? null;
        
        try {
            if ($businessId) {
                $business->updateBusinessBanned($businessId, $banned);
                echo json_encode(['status' => 'success']);
                exit;
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Invalid Message ID']);
                exit;
            }
        } catch (Exception $e) {
            error_log('updateBusinessBanned failed: ' . $e->getMessage());
            echo json_encode(['status' => 'error', 'message' => 'Update failed']);
            exit;
        }
    } else {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
    }
    
    

} else if($_SERVER["REQUEST_METHOD"] == "PUT"){

} else if($_SERVER["REQUEST_METHOD"] == "DELETE") {

}
else {
    http_response_code(400);
    
}


?>