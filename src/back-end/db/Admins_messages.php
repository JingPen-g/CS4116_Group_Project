<?php

require_once("Model.php");

class Admins_Messages extends Model {
    protected $table = "Messages";

    public function getAllMessages() {
        return $this->find();
    }

    public function updateMessageBanned($messageId, $banned) {
        $conditions = [
            'Message_ID' => $messageId,
        ];

        $data = [
            'Banned' => $banned,
        ];

        return $this->update($conditions, $data);
    }

    public function getAllBannedMessages($banned) {
        $criteria = [
            "Banned" => $banned
        ];
        return $this->find($criteria);
    }
    
    // for testing purposes
    public function addTestMessage($receiverId, $senderId, $message, $timestamp, $banned) {
        $insertableData = [
            'Receiver_Id' => $receiverId,
            'Sender_Id' => $senderId,
            'Message' => $message,
            'Timestamp' => $timestamp,
            'Banned' => $banned
        ];

        return $this->insert($insertableData);
    }

    public function getReviewsByUserid(int $userid) {
        $criteria = [
            "Users_ID" => $userid
        ];
        return $this->find($criteria);
    }


    public function updateReviewBanned($reviewId, $banned){
        $conditions = [
            'Review_ID' => $reviewId,
        ];

        $data = [
            'Banned' => $banned,
        ];

        return $this->update($conditions, $data);
    }

    public function getAllBannedReviews ($banned) {
        $criteria = [
            "Banned" => $banned
        ];
        return $this->find($criteria);
    }
}