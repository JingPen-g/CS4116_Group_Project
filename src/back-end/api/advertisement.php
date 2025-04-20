<?php
session_start();

require_once(__DIR__ . "/../db/Advertisement.php");
require_once(__DIR__ . "/../db/Service.php");


$ad = new Advertisement();
$service = new Service();

if($_SERVER["REQUEST_METHOD"] == "GET"){
    if(isset($_GET['method']) && $_GET['method'] === "filterAdvertisementList"){
        header('Content-Type: application/json');
        $searchTerm = $_GET['searchTerm'] ?? "";
        $beforeDate = $_GET['beforeDate']?? null;
        $afterDate = $_GET['afterDate'] ?? null;
        $tags = isset($_GET['tags']) && $_GET['tags'] !== "" && $_GET['tags'] !== "null"
                ? explode(",", $_GET['tags'])
                : [];
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

    } else {
        echo json_encode(['error' => 'Method not defined']);
    }

} 
else if($_SERVER["REQUEST_METHOD"] == "POST"){

    if (isset($_POST['method']) && $_POST['method'] == "getAdvertInformation") {

        $ad_info = $ad->getAdvertInformation($_POST['Ad_ID']);

        echo json_encode($ad_info);
    }
    else if (isset($_POST['method']) && $_POST['method'] == "getAdvertServicesInformation") {

        $ad_services_info = $service->getAdvertServicesInformation($_POST['Business_ID']);

        echo json_encode($ad_services_info);
    }
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
