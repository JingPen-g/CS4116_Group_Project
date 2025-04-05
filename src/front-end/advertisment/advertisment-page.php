<?php
include 'get-advertisment.php' ;
include 'get-services.php';
include 'get-service-image-viewer.php';
include __DIR__ . '/../global/get-footer.php';

$ad_data = null;
$ad_services_data = null;

/* retreive_ad_data 
 * This method gets all the cols on a row for TABLE Advertisment
 * @param: Ad_ID {passed in POST} from the search page
 * @return: JSONArray of length 1 containg a JSONOBject
 */
function retreive_ad_data(){
    global $ad_data;

    //Get Information on posted Ad_ID 
    $_POST['method'] = 'getAdvertInformation';
    ob_start(); // read in data echoed from advertisement.php
    include __DIR__ . '/../../back-end/api/advertisement.php';
    $response = ob_get_clean();

    //echo "<BR>RAW RESPONSE<BR>" . $response ."<BR><BR>RAW RESPONSE END<BR>";//testing
    //Ensures a json object is contained in output
    if ( str_contains($response, ']') && str_contains($response, '[') && strrpos($response, ']',0) > strrpos($response, '[',0) ) {

        $ad_data = substr($response, strrpos($response, '[', 0), ( strrpos($response, ']',0) - strrpos($response, '[', 0)) + 1 );
        $ad_data = json_decode($ad_data);
        //print_r($ad_data);//testing
    }
}

/* retreive_ad_services_data 
 * This method gets all the rows from TABLE Service with Business_ID that was
 * retreived in retreive_ad_data()
 * @param: Ad_ID {passed in POST} from the search page
 * @return: JSON Array of JSONOBjects
 */
function retreive_ad_services_data(){
    
    global $ad_services_data;
    global $ad_data;

    //Get Information on posted Ad_ID 
    $_POST['method'] = 'getAdvertServicesInformation';
    $_POST['Business_ID'] = $ad_data[0]->Business_ID; 
    ob_start(); // read in data echoed from advertisement.php
    include __DIR__ . '/../../back-end/api/advertisement.php';
    $response = ob_get_clean();

    //echo "<BR>RAW RESPONSE<BR>" . $response ."<BR><BR>RAW RESPONSE END<BR>";//testing
    //Ensures a json object is contained in output
    if ( str_contains($response, ']') && str_contains($response, '[') && strrpos($response, ']',0) > strrpos($response, '[',0) ) {

        $ad_services_data = substr($response, strrpos($response, '[', 0), ( strrpos($response, ']',0) - strrpos($response, '[', 0)) + 1 );
        $ad_services_data = json_decode($ad_services_data);
        //print_r($ad_services_data);//testing
    }
}

retreive_ad_data();
retreive_ad_services_data();
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
        <?php generate_advertisment_header($ad_data[0]->Name, $ad_data[0]->Description) ?>

        <div class="row" style="margin: 25px"></div>

        <!-- Image Viewer --!>
        <?php generate_service_image_viewer() ?>
        <div class="row" style="margin: 50px"></div>

        <!-- Service Details --!>
        <?php generate_service_elements($ad_services_data)?>

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
