<?php
include 'get-advertisment.php' ;
include 'get-services.php';
include 'get-service-image-viewer.php';
include 'get-reviews.php';
include __DIR__ . '/../global/get-footer.php';

$userType;
print_r($_SESSION);

$ad_data = null;
$ad_services_data = null;
$review_data = null;
$user_review_data = null;
$business_data = null;
$services_user_is_verifed_for = null;



if (!empty($_POST['Ad_ID'])) {

    if (empty($_SESSION['userType'])) 
        $userType = "not logged in";
    else if ($_SESSION['userType'] == "user")
        $userType = "user";
    else if ($_SESSION['userType'] == 'business')
        if ($_SESSION['userData'][0]['Business_ID'] == $_POST['Ad_ID'])
            $userType = "business owner";
        else
            $userType = "business";
    else {
        $userType = "error determining user type";
        echo "error determining user type";
    }


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

    /* retreive_review_data 
     * This method gets all the cols of rows who containg a 
     * matching service id with this ad
     * @param: array of service ids contained in this ad
     * @return: 
     */
    function retreive_review_data($ad_services_data){
        global $review_data;

        $service_ids = [];
        foreach ($ad_services_data as $service) 
            $service_ids[] = $service->Service_ID;
        //print_r($service_ids);

        //Get Information on posted Ad_ID 
        $_SERVER["REQUEST_METHOD"] = "GET";
        $_GET['method'] = 'getReviewsOfServiceId';
        $_GET['service_ids'] = $service_ids;
        ob_start(); // read in data echoed from advertisement.php
        include __DIR__ . '/../../back-end/api/reviews.php'; 
        $response = ob_get_clean();

        //echo "<BR>RAW RESPONSE<BR>" . $response ."<BR><BR>RAW RESPONSE END<BR>";//testing

        if (str_contains(substr($response, strpos($response,'}',0), strlen($response) - strpos($response,'}',0)), "{"))
            while (str_contains($response, "{")) {

                $review_object = substr($response, strpos($response, '{',0), strpos($response, '}',0) - strpos($response, '{',0) + 1);
                $decode_review_object = json_decode($review_object);
                $review_data[] = $decode_review_object;

                $response = substr($response, strpos($response,'}',0) + 1, strlen($response) - strpos($response,'}',0));

            }
        else
            $review_data[0] = "empty";
    }

    /* retreive_user_data 
     * This method gets the rows in the user table with User_ID
     * matching user_ids in a review
     * @param: array of user ids contained
     * @return: 
     */
    function retreive_user_data($users_who_made_a_review){
        global $user_review_data;

        //Get Information on posted Ad_ID 
        $_SERVER["REQUEST_METHOD"] = "GET";
        $_GET['method'] = 'getUsersOfID';
        $_GET['user_ids'] = $users_who_made_a_review;
        ob_start(); // read in data echoed from advertisement.php
        include __DIR__ . '/../../back-end/api/users.php'; 
        $response = ob_get_clean();

        //echo "<BR>RAW RESPONSE<BR>" . $response ."<BR><BR>RAW RESPONSE END<BR>";//testing

        //TEST PARSE RESPONSE
        if (str_contains(substr($response, strpos($response,'}',0), strlen($response) - strpos($response,'}',0)), "{"))
            while (str_contains($response, "{")) {

                $user_review_object = substr($response, strpos($response, '{',0), strpos($response, '}',0) - strpos($response, '{',0) + 1);
                $decode_user_review_object = json_decode($user_review_object);
                $user_review_data[] = $decode_user_review_object;

                $response = substr($response, strpos($response,'}',0) + 1, strlen($response) - strpos($response,'}',0));

            }
        else
            $user_review_data[0] = "empty";
    }


    retreive_review_data($ad_services_data);


    //Add Business Name to Review Data
    /* retreive_owning_business_data
     * This method gets the rows from TABLE Business with Business_ID
     * @param: Business_ID 
     */
    function retreive_owning_business_data($ad_data){
        
        global $business_data;

        //Get Information on posted Ad_ID 
        $_SERVER["REQUEST_METHOD"] = "GET";
        $_GET['method'] = 'getBusniessOfId';
        $_GET['Business_ID'] = $ad_data[0]->Business_ID; 
        ob_start(); // read in data echoed from advertisement.php
        include __DIR__ . '/../../back-end/api/business.php';
        $response = ob_get_clean();

        //echo "<BR>RAW RESPONSE<BR>" . $response ."<BR><BR>RAW RESPONSE END<BR>";//testing
        //Ensures a json object is contained in output
        if ( str_contains($response, ']') && str_contains($response, '[') && strrpos($response, ']',0) > strrpos($response, '[',0) ) {

            $raw_business_data = substr($response, strrpos($response, '[', 0), ( strrpos($response, ']',0) - strrpos($response, '[', 0)) + 1 );
            $business_data = json_decode($raw_business_data);
            //print_r($business_data);//testing
        }
    }
    retreive_owning_business_data($ad_data);

    //Add Users Name to Review Data
    $users_who_made_a_review = [];
    if ($review_data[0] != "empty") {
        foreach ($review_data as $review) {
            $users_who_made_a_review[] = $review->Users_ID;
        }
        retreive_user_data($users_who_made_a_review);

        foreach ($review_data as $review) {
            foreach ($user_review_data as $user) {
                if ($user->Users_ID == $review->Users_ID) {
                    $review->User_Name = $user->Name;
                    $review->Business_Name = $business_data[0]->Name;

                    if ($user->ProfilePicturePath) 
                        $review->User_Profile = $user->ProfilePicturePath;
                    else
                        $review->User_Profile = "../images/default_profile.jpg";

                    if ($business_data[0]->ProfilePicturePath) {
                        $review->Business_Profile = $business_data[0]->ProfilePicturePath;
                    }
                    else
                        $review->Business_Profile = "../images/default_profile.jpg";
                }
            }
        }
    }

    /* user_verification_data 
     * This method gets all the cols on a row for TABLE Advertisment
     * @param: User_ID
     * @param: Service_IDs - The ids of the services in this advertisment
     * @return: JSONArray of length 1 containg a JSONOBject
     */
    function user_verification_data($user_id, $ad_services_data){
        global $services_user_is_verifed_for;
        $services_user_is_verifed_for = [];

        foreach ($ad_services_data as $service) {
            $service_ids[] = $service->Service_ID;
        }
        if (count($ad_services_data) == 0)
            $service_ids[0] = "empty";

        $_SERVER["REQUEST_METHOD"] = "GET";
        $_GET['method'] = 'getServicesUserIsVerifiedFor';
        $_GET['user_id'] = $user_id;
        $_GET['service_ids'] = $service_ids;
        ob_start(); // read in data echoed from verification.php
        include __DIR__ . '/../../back-end/api/verification.php';
        $response = ob_get_clean();

        //echo "<BR>RAW RESPONSE<BR>" . $response ."<BR><BR>RAW RESPONSE END<BR>";//testing
        //Ensures a json object is contained in output
        if ( str_contains($response, ']') && str_contains($response, '[') && strrpos($response, ']',0) > strrpos($response, '[',0) ) {

            $raw_object = substr($response, strrpos($response, '[', 0), ( strrpos($response, ']',0) - strrpos($response, '[', 0)) + 1 );
            $services_user_is_verifed_for = json_decode($raw_object);
            //print_r($services_user_is_verifed_for); 

        }
    }
    user_verification_data('1', $ad_services_data);
}
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
    <link rel="stylesheet" href="../front-end/advertisment/css/transaction-popup.css">
    <link rel="stylesheet" href="../front-end/advertisment/css/review.css">
    <link rel="stylesheet" href="../front-end/advertisment/css/review.css">
    <link rel="stylesheet" href="../front-end/advertisment/css/review-reply.css">

</head>
<body>
    
    <div class="invisible image-item"></div>
    <div id="main" class="container-fluid">

        <!-- Used to generate paw print margin -->
        <div class="row">
                <div class="col left-container"></div>
                <div class="col rigth-container"></div>
        </div>

        <?php 

            if (!empty($_POST['Ad_ID'])) { //If ad was navigated to from the search page
                //Headder
                generate_advertisment_header($ad_data[0]->Name, $ad_data[0]->Description) ;
                //Image Viewer
                generate_service_image_viewer() ;

                //Display Services
                generate_service_elements($ad_services_data);

                //Reviews
                if ($review_data[0] == "empty")
                    generate_empty_review_section();
                else
                    generate_review_elements($review_data,$userType);

                generate_add_review_section($ad_services_data, $services_user_is_verifed_for);

                //Footer
                generate_footer(); 
            } else {
                echo '
                <div class="row">
                    <div class="col-3"></div>
                    <div class="col text-center h-100" style="position:absolute; display: flex; flex-direction: column; justify-content: center">
                        <div>
                            <h3>It Appears you have attempted to navigate to the ad page from somewhere unexpected</h3>
                            <h3>Please ensure you navigate to an Ad from the Search page</h3>
                        </div>
                    </div>
                    <div class="col-3"></div>
                </div>';
            }

        ?>


        <!-- Popups --!>
        <!-- Service Transaction Popup -->
        <div id="overlay">
            <div id="overlayInner" class="transaction-container">
         
            <!-- Service Title And Price-->
            <div id="titleAndPriceContainer">
                <p id="serviceTitle">Service Name Name Name Namea more and more words and or words god damn this is a very long title for a service</p>
                <h1 id="servicePrice">€10</h1>
                <button class="tag-container" type="button" id="closeOverlayButton"><b><h3>X</h3></b></button>
            </div>
            <!-- Service Description -->
            <div id="serviceDescription">
                <p style=" margin: 0 auto;max-height: 100%">Word Paws &amp; Shine, we believe every pet deserves to look and feel their best! Our comprehensive pet grooming service is designed to provide a safe, stress-free, and enjoyable experience for your furry friends. Whether your pet needs a quick touch-up or a full spa day, our experienced groomers are here to pam
            </div>
            <!-- Service Image -->
            <div style="display: flex; flex-direction: row; width: 100%;height: 40vh; align-items: center;padding-right: 20%; padding-left: 20%;margin-top: 5%">
                <img id="mainPhoto" alt="service image" src="../front-end/advertisment/images/hello.jpg">
            </div>
            <!-- Payment/Messaging -->
            <div id="paymentAndServiceInquiryContainer">
                <button class="tag-container" type="button" id="payment"><b><h3>Pay</h3></b></button>
                <button class="tag-container" type="button" id="serviceInquiry"><b><h3 id="inquireText">Inquire about service</h3></b></button>
                <button class="tag-container" type="button" id="secondCloseOverlayButton"><b><h3>X</h3></b></button>
            </div>

            </div>
        </div>


        <!-- Popup to Confirm Transaction -->
        <div style="position: fixed; height: 55vh;bottom: 30vh; margin-left: 30vw;display: none;flex-direction: row;justify-content: center;z-index: 1;width: 30vw" id="transactionConfirmation">
            <div class="transaction-container" style="background-color: orange;width: 50vw; display: flex; flex-direction: column">
            <!-- Tick To Indicate Completion -->
            <div style="display: flex; flex-direction: row; width: 50vw;height: 7vh; align-items: center;justify-content: center;">
                <span id="check" style="display: flex;align-items: center; justify-content: center"><h6>&#10004;</h6></span>
            </div>

            <div style="margin-top: 10vh;display: flex; flex-direction: row; width: 50vw;height: 7vh; align-items: center;justify-content: center">
                <h1 id="transactionComplete">Transaction Complete</h1>
            </div>

            <!-- Service Title And Price-->
            <div style="display: flex; flex-direction: row; width: 50vw;height: 7vh; align-items: center;justify-content: center">
                <h1 id="serviceNameTransactionComplete" style="margin-left: 5vw;margin-right: 5vw;">Service Name</h1> 
                <h1 id="servicePriceTransactionComplete" style="margin-right: 5vw;">€10</h1>
            </div>

            <!-- Payment/Messaging Buttons-->
            <div style="display: flex; flex-direction: row; width: 100%;height: 10vh; align-items: center;padding-right: 10%; padding-left: 10%;margin-top: 2%">
                <button class="tag-container" type="button" id="exitTransactionComplete" style="width: 100%; margin-right: 10%"><b><h3>Exit</h3></b></button>
            </div>

            </div>
        </div>


        <!-- Reply to review dialog -->
        <div id="reply-to-review-container" data-reviewId="null">

            <div style="display: flex; flex-direction: row;width: 100%;justify-content: center;align-items: center;">
                <h4 style="margin-right: 10%;color: black" id="reply-to-review-title">Respond to review</h4>
                <button type="button" id="close-reply-review"><h4 style="margin-left: 3%;">X</h4></button>
            </div>

            <div id="reply-to-review-input-container">
                <button type="button" style="height: 2rem" id="close-reply-review-second"><h4>X</h4></button>
                <textArea id="reply-to-review-text-input" type="text" placeholder="Enter Response" rows="3" maxlength="255"></textarea>
                <button id="reply-to-review-submit-button" type="button">Reply</button>
            </div>

            <h4 id="reply-to-review-error">&#8203;</h4>
        </div>


    <!-- scripts -->
    <script src="../front-end/advertisment/js/image-viewer.js"></script>
    <script src="../front-end/global/js/global-margin.js"></script>
    <script src="../front-end/advertisment/js/transaction-popup.js"></script>
    <script src="../front-end/advertisment/js/review.js"></script>
    <script src="../front-end/advertisment/js/review-reply.js"></script>

</body>
</html>
