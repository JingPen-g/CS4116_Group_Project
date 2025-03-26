<?php

require_once("Model.php");

class Users extends Model {
    protected $table = "Users";

    public function getUser($name) {
        return $this->find(['Name' => $name]);
    }

    public function getUserCount(){
        return $this->count();
    }

    public function insertUser($name, $email, $password) {
        $insertableData = [
            'Name' => $name,
            'Email' => $email,
            'Password' => $password
        ];

        return $this->insert($insertableData);
    }

    public function updatePassword($email, $new_password){
        $conditions = [
            'Email' => $email,
        ];

        $data = [
            'Password' => $new_password,
        ];

        return $this->update($conditions, $data);
    }
}

?>