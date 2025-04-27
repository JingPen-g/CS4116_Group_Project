<?php

require_once("Model.php");

class Admins extends Model {
    protected $table = "Review";

    public function getAllReviews() {
        return $this->find();
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