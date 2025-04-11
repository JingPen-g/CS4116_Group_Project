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
    public function getUserName($user_id){
        return $this->find(['User_Id' => $user_id]);
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

    public function deleteUser($name){
        $criteria = [
            "Name" => $name
        ];

        return $this->delete($criteria);
    }
}

?>