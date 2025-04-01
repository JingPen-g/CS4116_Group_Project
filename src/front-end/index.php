<?php
session_start();

echo '<pre>';
print_r($_SESSION);
echo '</pre>';

if (isset($_SESSION['usertype']) && isset($_SESSION['username'])) {
    $usertype = $_SESSION['usertype'];
    $username = $_SESSION['username'];
    $passwordDatabase = $_SESSION['passwordDatabase'];
    $NameDatabse = $_SESSION['userData'];
    $user_message = 'Hello ' . htmlspecialchars($username) . ', you are logged in as ' . htmlspecialchars($usertype) . ' passwordDatabase is .' . htmlspecialchars($passwordDatabase) . ' and NameDatabse is: ' . htmlspecialchars($NameDatabse);
} else {
    $user_message = "Username and user type are not set.";
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>User Data</title>
    </head>
    <body>
        <p><?php echo $user_message; ?></p>
    </body>

</html>