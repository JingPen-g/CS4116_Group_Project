<?php
    session_start();
    
    // Check if there's an error message in the session and store it in a variable
    $usernameErr = isset($_SESSION['usernameErr']) ?? "";
    $passwordErr = isset($_SESSION["passwordErr"]) ??"";
    $re_password = isset($_SESSION["re_password"]) ?? "";
    $email = isset($_SESSION["email"]) ?? "";

    // After using the error message, clear it from the session
    unset($_SESSION['usernameErr']);
    unset($_SESSION['passwordErr']);
    unset($_SESSION['re_password']);
    unset($_SESSION['email']);
?>

<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css"
integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1"
crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/register_bootstrap.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </head>
    <body>
    <div class="container-fluid p-5 my-5 border">
        <div class="row">
            <div class="col">
                <img src="https://dummyimage.com/800x600/000/fff&text=register" alt="logo" class="img-fluid">
            </div>
            <div class="col">
            <form action="/api/users.php" method="post" id="register_form" novalidate>
            <div class="form-floating mb-3 mt-3">
                <input type="text" class="form-control" id="username" placeholder="Enter username" name="username" required>
                <label for="username" class="text-black-50">Enter Username</label>
            </div>
            <div class="me-2">
                <small id="usernameErr" class="text-danger"><?php echo $usernameErr ?></small>
            </div>
            <div class="form-floating mb-1 mt-1">
                <input type="password" class="form-control" id="password" placeholder="Enter password" name="password" required>
                <label for="password" class="text-black-50">Enter Password</label>
            </div>
            <div class="me-2">
                <small class="text-muted">Please use a mix of 8 numbers, uppercase, lowercase, and special letters.</small>
            </div>
            <div class="password-strength-meter">
                <div class="meter-section rounded me-2"></div>
                <div class="meter-section rounded me-2"></div>
                <div class="meter-section rounded me-2"></div>
                <div class="meter-section rounded me-2"></div>
            </div>
            <div class="me-2">
                <small id="meter-text" class="text-danger"><?php echo $passwordErr ?></small>
            </div>
            <div class="form-floating mb-3 mt-3">
                <input type="password" class="form-control" id="re_password" placeholder="Repeat password" name="re_password" required>
                <label for="Repeat password" class="text-black-50">Repeat password</label>
            </div>
            <div class="me-2">
                <small id="error_message_re" class="text-danger"><?php echo $re_password ?></small>
            </div>
            <div class="form-floating mb-3 mt-3">
                <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" required>
                <label for="Enter email" class="text-black-50">Enter email</label>
            </div>
            <div class="me-2">
                <small id="error_message_email" class="text-danger"><?php echo $email ?></small>
            </div>
            <div class="form-check mb-3">
                <label class="form-check-label">
                <input class="form-check-input" type="checkbox" name="remember"> Remember me
                </label>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
            </form> 
            </div>
        </div>
    </div> 
    <script type="application/javascript" src="js/register_bootstrap.js"></script>
    </body>
</html>