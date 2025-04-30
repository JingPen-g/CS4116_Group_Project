<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once(__DIR__ . "/../db/Review.php");


$review = new Review();

if($_SERVER["REQUEST_METHOD"] == "GET"){

    if(isset($_GET['method']) && $_GET['method'] === "getReviewsOfServiceId"){

        $service_ids = $_GET['service_ids'];
        print_r($service_ids); 
        $reviews = $review->getReviewsOfServiceId($service_ids);

        echo json_encode($reviews);

    } else {

        echo json_encode(['error' => 'Method not defined']);
    }
} 
else if($_SERVER["REQUEST_METHOD"] == "POST"){

    if(isset($_POST['action']) && $_POST['action'] === "insertReview"){

        $review_details = [$_POST['comment'], $_POST['stars'], $_POST['user'], $_POST['service']];
        echo json_encode($review->insertReview($review_details));

    } else if(isset($_POST['action']) && $_POST['action'] === "insertResponseToReview"){

        echo json_encode($review->insertResponse($_POST['reviewId'], $_POST['response']));

    } else {
        echo json_encode(['error' => 'Method not defined for POST in Review API']);
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

