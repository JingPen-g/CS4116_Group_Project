<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include __DIR__ . '/../global/get-nav.php';
  
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
    <link rel="stylesheet" type="text/css" href="css/userprofile.css">
    <link rel="stylesheet" type="text/css" href="../front-end/global/css/nav.css">
    </head>
    <body>

    <?php get_nav() ?>
    <div class="container-fluid p-5 border main-bgcolor">
        <div class="row">
            <!-- userprofile --- regular users -->
            
            <div class="p-4 border rounded-5 shadow custom-bd-color">
                <div class="text-center">
                    <h4 class="text-center">User Profile</h4>
                    <img src="../front-end/create-account//images/userprofile.jpeg" class="card-img-top rounded-circle mx-auto mt-3" style="width: 120px;" alt="Profile Picture">
                    <h5>Username: <span class="text-muted"><?php if (!empty($_SESSION['username'])) echo htmlspecialchars($_SESSION['username']); ?></span></h5>
                </div>
            </div>
        </div>

        <div class="row" >
            <!-- Editable Form -->
            <div class="col-md-8 m-3 mx-auto">
            <div class="card ">
                <div class="card-header">
                Edit Your Info
                </div>
                <div class="card-body">
                <form action="/api/userprofile.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="text" class="form-control" id="phone" name="phone">
                    </div>

                    <div class="mb-3">
                    <label for="profilePic" class="form-label">Profile Picture</label>
                    <input class="form-control" type="file" id="profilePic" name="profile_picture">
                    </div>

                    <button type="submit" class="btn btn-primary">Update Profile</button>
                </form>
                </div>
            </div>
            </div>
        </div>

        <div class="row">
            <!-- get either pet profile or business profile -->
             
        </div>
    </div>

    </body>
</html>
