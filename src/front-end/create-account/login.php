<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (isset($_SESSION['username'])) {
        // User is already logged in, redirect them away from register page
        header("Location: http://localhost:8080/search"); // or wherever they should go
        exit();
    }
    include __DIR__ . '/../global/get-footer.php';
    include __DIR__ . '/../global/get-nav.php';

    if (isset($_SESSION['usertype']) && isset($_SESSION['username'])) {
        $usertype = $_SESSION['usertype'];
        $username = $_SESSION['username'];
        $password = $_SESSION['password'];
        $registration_success = $_SESSION['registration_success'];
        $hashedpassword = $_SESSION['hashedpassword'];
        $user_message = 'Hello ' . htmlspecialchars($username) . ', you are registered as ' . htmlspecialchars($usertype) . 'password is: ' . htmlspecialchars($password) . ' hashed password is: ' . htmlspecialchars($hashedpassword) . ' and registration success is: ' . htmlspecialchars($registration_success);
    } else {
        $user_message = "Username and user type are not set.";
    }
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../front-end/global/css/global-style.css">
    <link rel="stylesheet" type="text/css" href="../front-end/global/css/nav.css">
    <style>
        html, body {
            background-color: rgb(240, 227, 217) !important;
        }
    </style>
    </head>
    <body>
    <?php get_nav() ?>

    <div class="invisible image-item"></div>
        <div id="main" class="container-fluid">       
    
        <!-- Used to generate paw print margin -->
        <div class="row">                         
            <div class="col left-container"></div>
            <div class="col rigth-container"></div>
        </div>
        <div class="invisible image-item"></div>
            <div id="main" class="container-fluid">       
        
            <!-- Used to generate paw print margin -->
            <div class="row">                         
                <div class="col left-container"></div>
                <div class="col rigth-container"></div>
            </div>
            <div class="container-fluid p-5 my-5 border">
                <div class="row">
                    <div class="col">
                        <img src="../front-end/create-account/images/cat2.png" alt="logo" class="img-fluid">
                    </div>
                    <div class="col">
                    <form action="/api/users.php" method="post" id="login_form" novalidate>
                    <!-- Add a hidden input field to send the form's identifier -->
                    <input type="hidden" name="id" value="login_form">
                    <div class="form-floating mb-3 mt-3">
                        <input type="text" class="form-control" id="username" placeholder="Enter username" name="username" required>
                        <label for="username" class="text-black-50">Enter Username</label>
                    </div>
                    <div class="form-floating mb-3 mt-3">
                        <input type="password" class="form-control" id="password" placeholder="Enter password" name="password" required>
                        <label for="password" class="text-black-50">Enter Password</label>
                    </div>
                    <div class="me-2 mb-3 mt-3">
                        <small id="error_message" class="text-danger"><?php if (!empty($usernameErr)) echo htmlspecialchars($usernameErr); ?></small>
                    </div>
                    <button id="login" type="submit" class="btn btn-primary">Login</button>
                    <div class="form-floating mb-3 mt-3">
                        <a href="http://localhost:8080/register">Don't have account yet? register</a>
                    </div>
                    </form> 
                    </div>
                </div>
                <?php generate_footer() ?>
            </div> 
    </body>
    <script type="application/javascript" src="js/login.js"></script>
    <script src="../front-end/global/js/global-margin.js"></script>
</html>