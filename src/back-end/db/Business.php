<?php

require_once("Model.php");

class Business extends Model {
    protected $table = "Business";


    public function getBusiness($name) {
        return $this->find(['Name' => $name]);
    }

    public function getBusinessFromID($business_id) {
        return $this->find(['Business_ID' => $business_id]);
    }

    public function getBusinessCount(){
        return $this->count();
    }

    public function insertBusiness($name, $email, $password) {
        $insertableData = [
            'Name' => $name,
            'Email' => $email,
            'Password' => $password
        ];

        return $this->insert($insertableData);
    }
}
?>
