<?php

require_once("Model.php");

class Messaging extends Model {
    protected $table = "Messages";


    /**
     * getMessages
     * Gets all the messages between two ids
     * @param IDs {array} - of length 2 containg the two ids
     */
    public function getMessages($IDs) {

        $IDs[2] = $IDs[0];
        $IDs[3] = $IDs[1];

        $customWhere = 'Sender_ID IN (?, ?) AND Receiver_ID IN (?, ?)';

        $refs = [];
        foreach ($IDs as $key => $value) {
            $refs[$key] = &$IDs[$key];
        }

        return  $this->find([],[],$refs,$customWhere, "");
    }

    public function getConversations($userId) {

        $values = [$userId, $userId, $userId];
        return  $this->findCustom("SELECT DISTINCT CASE WHEN Sender_ID = ? THEN Receiver_ID WHEN Receiver_ID = ? THEN Sender_ID END AS Other_ID FROM Messages WHERE ? IN (Sender_ID, Receiver_ID)",$values);
    }

    public function getMessageCount($Sender_ID, $Receiver_ID){

        $criteriaForCount = ["Sender_ID" => $Sender_ID, "Receiver_ID" => $Receiver_ID];
        return $this->countWhere($criteriaForCount);
    }

    public function insertMessage($Receiver_ID, $Sender_ID, $Message) {

        $insertableData = [
            'Receiver_ID' => $Receiver_ID,
            'Sender_ID' => $Sender_ID,
            'Message' => $Message,
        ];

        return $this->insert($insertableData);
    }
}
?>
