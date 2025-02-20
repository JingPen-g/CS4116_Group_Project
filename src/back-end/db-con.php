<?php
/*
*       This document is meant more as an example for how to use and connect to the db.
*       We don't want details hardcoded everywhere so instead we save them in config.php
*       and require the file. This file should be gitignored in the future.
*       Give me a shout once you've seen this and once everyone dm's me i will fix gitignore and untrack the file,
*       I just need to make sure everyone has it.
*       We probably also want to keep all db routines in one file or group of files, but we'll discuss that later.
*/


$config = require("db_config.php");

$dbHost = $config['DB_HOST'];
$dbName = $config['DB_NAME'];
$dbUser = $config['DB_USER'];
$dbPassword = $config['DB_PASSWORD'];

// OPTION 1
$conn = new mysqli($dbName, $dbUser, $dbPassword, $dbName);

if($conn->connect_error){
    die("Connection Failed.");
}

echo "Connected Successfully.";

// OPTION 2 
// This is probably what we should go with for error handling n logging n stuff
try {
    $conn = new mysqli($dbName, $dbUser, $dbPassword, $dbName);

    if($conn->connect_error){
        throw new mysqli_sql_exception("Connection Error: " . $conn->connect_error);
    }
} catch(mysqli_sql_exception $e){
    //This wouldnt actually be an echo
    //More like (yes error log is builtin php go look at docs we should use it):
    //error_log("Database Connection Error: ", $e->getMessage(), 3, "/logs/db_logs.log")
    //throw new $e
    echo "Propogate error up.";
}

?>