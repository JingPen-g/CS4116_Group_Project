<?php

require_once("Model.php");

class Verification extends Model {
    protected $table = "Verification";


    public function getUserRows($name) {
        return $this->find(['Users_ID' => $name]);
    }
    public function getServiceRows($name) {
        return $this->find(['Service_ID' => $name]);
    }

    public function isVerified($user_id, $service_id) {
        return $this->find(['Service_ID' => $service_id, 'Users_ID' => $user_id ]);
    }

    function isUserVerifiedFor($user_id, $service_ids) {

        array_unshift($service_ids, $user_id);

        $values = [] ;
        $customWhere = 'Users_ID = ? AND Service_ID IN (';

        foreach ($service_ids as $service) {
            $customWhere .= '?, ';
        }

        $refs = [];
        foreach ($service_ids as $key => $value) {
            $refs[$key] = &$service_ids[$key];
        }

        $customWhere = substr($customWhere, 0, strlen($customWhere) - 5);
        $customWhere .= ")";


        return  $this->find([],[],$refs,$customWhere, "");

    }

    public function insertVerifiedUser($user_id, $service_id) {
        $insertableData = [
            'Users_ID' => $user_id,
            'Service_ID' => $service_id
        ];

        return $this->insert($insertableData);
    }
}
?>
