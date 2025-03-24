<?php
session_start();

require_once("../db/Users.php");

// This is where API verification should happen
// if(!isset($_SESSION[""]))

header('Content-Type: application/json');

$user = new Users();

if(isset($_GET['name'])) {
    echo json_encode($user->getUser($_GET('name')));
}

?>
