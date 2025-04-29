<?php

require_once(__DIR__ . "/../db/Business.php");


$business = new Business();

if($_SERVER["REQUEST_METHOD"] == "GET"){

    /*
     * Get a row in the business table matching the passed id
     */
    if(isset($_GET['method']) && $_GET['method'] === "getBusniessOfId"){

        $business_id = $_GET['Business_ID'];
        echo "here: " . $business_id;
        $business_row_data = $business->getBusinessFromID($business_id);

        echo "<BR>here: " . $business_row_data . "<BR>";

        echo json_encode($business_row_data);

    } else {

        echo json_encode(['error' => 'Method not defined']);
    }
} 
else if($_SERVER["REQUEST_METHOD"] == "POST"){

    echo json_encode(['error' => 'Method not defined']);
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

