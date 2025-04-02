<?php
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>User Data</title>
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    </head>
    <body>
        <h1>Hello.</h1>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>isAdmin</th>
                </tr>
            </thead>
            <tbody id="db-test">
            </tbody>
        </table>

        <form action="/api/users.php" method="post" id="register_form">
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
            <input type="email" class="form-control" id="email" placeholder="Temp Email" name="email" required>
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

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        
        <!-- This is how you will call advertisment page Note: Note done yet but you will just pass it ad_id-->
        <form action="get-advertisment.php">
            <input type="submit" name="get-advertisment-button" value="hello">       
        </form>        
    </body>
</html>
