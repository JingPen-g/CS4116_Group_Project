<?php
require_once(__DIR__ . "/../db/Labels.php");

//header('Content-Type: application/json');

$labels = new Labels();

if($_SERVER["REQUEST_METHOD"] == "GET"){
    if(isset($_GET['method']) && $_GET['method'] === 'fetchAll'){

        $labelData = $labels->findAll();

        if ($labelData !== null) {
            echo json_encode($labelData);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Labels not found']);
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
    
}

function test_input($data)  {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>
