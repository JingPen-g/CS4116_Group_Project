<?php

require_once("Model.php");

class Users extends Model {
    protected $table = "Users";

    public function getUser($name) {
        return $this->find(['Name' => $name]);
    }

    public function getAllUsers($admin = false) {
        return $this->find(['Admin' => $admin]);
    }

    public function getUserFromId($id) {
        return $this->find(['Users_ID' => $id]);
    }

    public function getUsernameByUserId($userId) {
        return $this->find(['Users_ID' => $userId]);
    }

    public function updateUserBanned($userId, $banned, $admin) {
        $conditions = [
            'Users_ID' => $userId,
            'Admin' => $admin,
        ];

        $data = [
            'Banned' => $banned,
        ];

        return $this->update($conditions, $data);
    }

    public function getUserByEmail($email) {
        return $this->find(['Email' => $email]);
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

    public function updatePassword($username, $new_password){
        $conditions = [
            'Name' => $username,
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
}

?>
