<?php

require_once("Model.php");

class Messages extends Model {
    protected $table = " Messages";


    public function insertMessage($userID, $messsage, $recieverId, $timestamp) {
        $insertableData = [
            'Sender_ID' => $userID,
            'Message' => $messsage,
            'Receiver_ID' => $recieverId,
            "Timestamp"=> $timestamp
        ];

        return $this->insert($insertableData);
    }

    public function getConversations($userID){

        $colVals = [$userID];
        $recieverIDs = ["Receiver_ID"];
        return $this->find(["User_Id" => $colVals], $recieverIDs);
        
        }

    public function getConversation($userID, $recieverID){
        $colVals = ["User_Id" => $userID, "Reciever_Id" => $recieverID];
        return $this->find($colVals, ["Message", "Timestamp"]);
    }

    }
?>