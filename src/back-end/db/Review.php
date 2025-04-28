<?php

require_once("Model.php");

class Review extends Model {
    protected $table = "Review";


    public function getReview($name) {
        return $this->find(['Name' => $name]);
    }

    public function getServiceCount(){
        return $this->count();
    }

    /**
     * getRevuewsOfServiceId
     * @param Service_IDs - An array of ints which represent service id for which 
     *                      we will search for coresponding reviews
     */
    public function getReviewsOfServiceId($Service_IDs){

        $Reviews = [];
        foreach ($Service_IDs as $service_id) {
            $Reviews[] = $this->find( customWhere: "Service_ID = " . $service_id);
        }

        return $Reviews;
    }
    public function insertReview($review_details){

        $new_review['Comment'] = $review_details[0];
        $new_review['Stars'] = $review_details[1];
        $new_review['Users_ID'] = $review_details[2];
        $new_review['Service_ID'] = $review_details[3];

        return $this->insert($new_review);
    }

    public function insertResponse($reviewId, $response) {

        $update_row['Review_ID'] = $reviewId;
        $with_data['Response'] = $response;

        return $this->update($update_row, $with_data);
    }
}
?>
