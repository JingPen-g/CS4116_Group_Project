<?php
require_once("Model.php");

class Transaction extends Model {
    protected $table = "Transactions";


    public function getTransaction($name) {
        return $this->find(['Name' => $name]);
    }

    public function getTransactionFromID($id) {
        return $this->find(['Transaction_ID' => $id]);
    }

    public function getTransactionCount(){
        return $this->count();
    }

    public function insertTransaction($user_id, $business_id, $service_id, $amount, $status) {
        $insertableData = [
            'Users_ID' => $user_id,
            'Business_ID' => $business_id,
            'Service_ID' => $service_id,
            'Amount' => $amount,
            'Status' => $status
        ];
        return $this->insert($insertableData);
    }
}
?>

