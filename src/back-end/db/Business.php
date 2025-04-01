<?php

require_once("Model.php");

class Business extends Model {
    protected $table = "Business";


    public function getBusiness($name) {
        return $this->find(['Name' => $name]);
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