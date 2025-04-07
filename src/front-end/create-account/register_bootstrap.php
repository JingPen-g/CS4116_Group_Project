<?php

    include __DIR__ . '/../global/get-footer.php';
    include __DIR__ . '/../global/get-nav.php';
    // Check if there's an error message in the session and store it in a variable
    $usernameErr = isset($_SESSION['usernameErr']) ?? "";
    $passwordErr = isset($_SESSION["passwordErr"]) ??"";
    $re_password = isset($_SESSION["re_password"]) ?? "";
    $emailErr = isset($_SESSION["email"]) ?? "";
    $userTypeErr = $_SESSION['userTypeErr'] ??"";

    // After using the error message, clear it from the session
    unset($_SESSION['usernameErr']);
    unset($_SESSION['passwordErr']);
    unset($_SESSION['re_password']);
    unset($_SESSION['email']);
    unset($_SESSION['userTypeErr']);
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
    <link rel="stylesheet" type="text/css" href="css/register_bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../front-end/global/css/nav.css">
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
        <div class="container-fluid p-5 my-5 border">
            <div class="row">
                <div class="col">
                    <img src="../front-end/create-account/images/cat2.png" alt="logo" class="img-fluid">
                </div>
                <div class="col">
                    <form action="/api/users.php" method="post" id="register_form" novalidate>
                    <!-- Add a hidden input field to send the form's identifier -->
                    <input type="hidden" name="id" value="register_form">
                    <div class="form-floating mb-3 mt-3">
                        <input type="text" class="form-control" id="username" placeholder="Enter username" name="username" required>
                        <label for="username" class="text-black-50">Enter Username</label>
                    </div>
                    <div class="me-2 mb-3 mt-3">
                        <small id="usernameErr" class="text-danger"><?php if (!empty($usernameErr)) echo htmlspecialchars($usernameErr); ?></small>
                    </div>
                    <div class="form-floating mb-3 mt-3">
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
                        <small id="meter-text" class="text-danger"><?php if (!empty($passwordErr)) echo htmlspecialchars($passwordErr); ?></small>
                    </div>
                    <div class="form-floating mb-3 mt-3">
                        <input type="password" class="form-control" id="re_password" placeholder="Repeat password" name="re_password" required>
                        <label for="re_password" class="text-black-50">Repeat password</label>
                    </div>
                    <div class="me-2">
                        <small id="error_message_re" class="text-danger"><?php if (!empty($re_password)) echo htmlspecialchars($re_password); ?></small>
                    </div>
                    <div class="form-floating mb-3 mt-3">
                        <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" required>
                        <label for="email" class="text-black-50">Enter email</label>
                    </div>
                    <div class="me-2">
                        <small id="error_message_email" class="text-danger"><?php if (!empty($emailErr)) echo htmlspecialchars($emailErr); ?></small>
                    </div>
                    <div class="mb-3 mt-3">
                        <label class="text-dark mb-1 mt-1">Select User Type:</label>
                        <div>
                            <input type="radio" id="customer" name="usertype" value="customer" required>
                            <label for="customer">Customer</label>
                        </div>
                        <div>
                            <input type="radio" id="business owner" name="usertype" value="business owner" required>
                            <label for="business owner">Business owner</label>
                        </div>
                    </div>
                    <div class="me-2">
                        <small id="error_message_radio" class="text-danger"><?php if (!empty($userTypeErr)) echo htmlspecialchars($userTypeErr); ?></small>
                    </div>
                    <button type="submit" class="btn btn-primary">Register</button>
                    <div class="form-floating mb-3 mt-3">
                        <a href="http://localhost:8080/login">Already have account? login</a>
                    </div>
                    </form> 
                </div>
            </div>
            <?php generate_footer() ?>
        </div> 
    <script src="../front-end/global/js/global-margin.js"></script>
    <script type="application/javascript" src="js/register_bootstrap.js"></script>
    </body>
</html>
