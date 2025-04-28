<?php

require_once("Model.php");

class Business extends Model {
    protected $table = "Business";


    public function getBusiness($name) {
        return $this->find(['Name' => $name]);
    }

    public function updateDescription($username, $description){
        $conditions = [
            'Name' => $username,
        ];

        $data = [
            'Description' => $description,
        ];

        return $this->update($conditions, $data);
    }
    public function updatePhone($username, $phone){
        $conditions = [
            'Name' => $username,
        ];

        $data = [
            'Phone' => $phone,
        ];

        return $this->update($conditions, $data);
    }
    public function updateProfilePicture($username, $target_file){
        $conditions = [
            'Name' => $username,
        ];

        $data = [
            'ProfilePicturePath' => $target_file,
        ];

        return $this->update($conditions, $data);
    }   
    

    public function getAllBusiness() {
        return $this->find();
    }

    public function updateBusinessBanned($businessId, $banned) {
        $conditions = [
            'Business_ID' => $businessId,
        ];

        $data = [
            'Banned' => $banned,
        ];

        return $this->update($conditions, $data);
    }

    public function getBusinessByEmail($email) {
        return $this->find(['Email' => $email]);
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
