<?php
include 'get-advertisment.php' ;
include 'get-services.php';
include 'get-service-image-viewer.php';
include __DIR__ . '/../global/get-footer.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, inital-scale=1.0">
    <title>advertisment</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="../front-end/global/css/global-style.css">
    <link rel="stylesheet" href="../front-end/advertisment/css/service-listing.css">
    <link rel="stylesheet" href="../front-end/advertisment/css/image-viewer.css">

</head>
<body>
    
    <div class="invisible image-item"></div>
    <div id="main" class="container-fluid">

        <!-- Used to generate paw print margin -->
        <div class="row">
                <div class="col left-container"></div>
                <div class="col rigth-container"></div>
        </div>

        <!-- Headder --!>
        <?php generate_advertisment_header() ?>

        <div class="row" style="margin: 25px"></div>

        <!-- Image Viewer --!>
        <?php generate_service_image_viewer() ?>
        <div class="row" style="margin: 50px"></div>

        <!-- Service Details --!>
        <?php generate_service_elements()?>

        <!-- Reviews --!>
        <div class="row"></div>

        <!-- Footer --!>
        <?php generate_footer() ?>

    </div>


    <!-- scripts -->
    <script src="../front-end/advertisment/js/image-viewer.js"></script>
    <script src="../front-end/global/js/global-margin.js"></script>
</body>
</html>
