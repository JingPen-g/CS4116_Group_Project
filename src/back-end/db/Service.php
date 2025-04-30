<?php
require_once("Model.php");

class Service extends Model {
    protected $table = "Service";


    public function getService($name) {
        return $this->find(['Name' => $name]);
    }

    public function getServiceId($id) {
        return $this->find(['Service_ID' => $id]);
    }

    public function getServiceCount(){
        return $this->count();
    }

    public function getAdvertServicesInformation($Business_ID){
        return $this->find(["Business_ID" => $Business_ID]);
    }
    public function insertService($serviceDetails){

        return $this->insert($serviceDetails);
    }
}
?>
