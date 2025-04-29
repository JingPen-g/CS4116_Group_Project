<?php
//session_start();

require_once(__DIR__ . "/../db/Messaging.php");


$messaging = new Messaging();

if($_SERVER["REQUEST_METHOD"] == "GET"){
    if(isset($_GET['method']) && $_GET['method'] === "getMessageCount"){

        $userId = $_GET['userId'];
        $otherId = $_GET['otherId'];

        $total = [];
        $sent = $messaging->getMessageCount($userId, $otherId);
        $received = $messaging->getMessageCount($otherId, $userId);
        $total[] = $sent[0] + $received[0];

        echo json_encode($total);

    } else if(isset($_GET['method']) && $_GET['method'] === "getAllMessageForUsers"){

        echo json_encode($messaging->getMessages([$_GET['userId'], $_GET['otherId']]));

    } else if(isset($_GET['method']) && $_GET['method'] === "getAllConversations"){

        echo json_encode($messaging->getConversations($_GET['userId']));

    } else {

        echo json_encode(['error' => 'Method not defined']);
    }
} 
else if($_SERVER["REQUEST_METHOD"] == "POST"){

    print_r($_POST);
    if(isset($_POST['method']) && $_POST['method'] === "insertmessage"){
        echo json_encode($messaging->insertMessage($_POST['otherId'], $_POST['userId'], $_POST['message']));
    
    }else if(isset($_POST['method']) && $_POST['method'] === "gen_convo"){
        echo json_encode(genereate_convo($_POST['convo']));
    }else{
        echo json_encode(['error' => 'Method not defined this one' ]);
    }
    
} 
else if($_SERVER["REQUEST_METHOD"] == "PUT"){

    print_r($_PUT);
    if(isset($_PUT['method']) && $_PUT['method'] === "insertmessage"){

        echo json_encode($messaging->insertMessage($_PUT['otherId'], $_PUT['userId'], $_PUT['message']));

    }else if(isset($_PUT['method']) && $_PUT['method'] === "gen_convo"){
        echo json_encode(genereate_convo($_PUT['convo']));
    
    }else {

        echo json_encode(['error' => 'Method not defined for PUT in Messaging']);
    }
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

