<?php

require_once("Model.php");

class Service extends Model {
    protected $table = "Service";


    public function getService($name) {
        return $this->find(['Name' => $name]);
    }

    public function getServiceCount(){
        return $this->count();
    }

    public function getAdvertServicesInformation($Business_ID){

        return $this->find(
            customWhere: "Business_ID = " . $Business_ID
        );
    }
}
?>
