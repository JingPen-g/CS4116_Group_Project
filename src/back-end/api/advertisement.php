<?php
session_start();

require_once("../db/Advertisement.php");

header('Content-Type: application/json');

$ad = new Advertisement();

if($_SERVER["REQUEST_METHOD"] == "GET"){
    if(isset($_GET['method']) && $_GET['method'] === "filterAdvertisementList"){
        $searchTerm = $_GET['searchTerm'] ?? "";
        $beforeDate = isset($_GET['beforeDate']) ? $_GET['beforeDate'] : null;
        $afterDate = isset($_GET['afterDate']) ? $_GET['afterDate'] : null;
        $tags = isset($_GET['tags']) ? explode(",", $_GET['tags']) : [];
        $page = ((int) $_GET['page']) - 1;
        $count = (int) $_GET['count'];

        $amount = $count;
        $offset = $count * $page;

        $ads = $ad->getRecommendedAdvertisements(
            $searchTerm,
            tags: $tags,
            before: $beforeDate,
            after: $afterDate,
            amount: $amount,
            offset: $offset
        );

        if ($ads !== null) {
            echo json_encode($ads);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'User not found']);
        }
    }

} 
else if($_SERVER["REQUEST_METHOD"] == "POST"){

} 
else if($_SERVER["REQUEST_METHOD"] == "PUT"){

} 
else if($_SERVER["REQUEST_METHOD"] == "DELETE") {

} 
else {
    http_response_code(400);
    print_r($_POST);
    echo json_encode(['error' => 'Name parameter is required']);
}


?>