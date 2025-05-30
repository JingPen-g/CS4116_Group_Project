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
    <link rel="stylesheet" href="../front-end/create-account/css/add-ad-service.css">
    </head>
    <body>

    <?php 
       get_nav();

       $profilePicture = isset($_SESSION['userData'][0]['ProfilePicturePath']) && !empty($_SESSION['userData'][0]['ProfilePicturePath'])
        ? $_SESSION['userData'][0]['ProfilePicturePath']
        : '../front-end/create-account/images/userprofile.jpeg';
?>
    <div class="container-fluid p-5 border main-bgcolor">
        <div class="row">
            <!-- userprofile --- regular users -->
            
            <div class="p-4 border rounded-5 shadow custom-bd-color">
                <div class="text-center">
                    <h4 class="text-center">User Profile</h4>
                    <img src="<?php echo htmlspecialchars($profilePicture); ?>" class="card-img-top rounded-circle mx-auto mt-3" style="width: 120px;" alt="Profile Picture">
                    <h5>Username: <span class="text-muted"><?php if (!empty($_SESSION['userData'])) echo htmlspecialchars($_SESSION['userData'][0]['Name']);?></span></h5>
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
                    <textarea class="form-control" id="description" name="description" rows="3" ><?php if (!empty($_SESSION['userData'][0])) echo htmlspecialchars($_SESSION['userData'][0]['Description']);?></textarea>
                    </div>

                    <div class="mb-3">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="text" class="form-control" id="phone" name="phone" value="<?php if (!empty($_SESSION['userData'][0])) echo htmlspecialchars($_SESSION['userData'][0]['Phone']);?>">
                    </div>

                    <div class="mb-3">
                    <label for="profilePic" class="form-label">Profile Picture</label>
                    <input class="form-control" type="file" id="profilePic" name="profile_picture">
                    </div>

                    <div class="me-2">
                        <small id="meter-text" class="text-danger">
                            <?php if (isset($_SESSION['fileTypeError'])) {
                                echo htmlspecialchars($_SESSION['fileTypeError']);
                                unset($_SESSION['fileTypeError']);
                            } ?>
                        </small>
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


        <!-- Add Service -->
        <?php
        if (!empty($_SESSION['userData']) && $_SESSION['userData'][0]["usertype"] == "business owner") {
            echo '<div class="row" style="height: 120vh; margin-top: 50px; margin-bottom: 50px">

                <div class="col-2"></div>

                <div class="col-8">
                    <div class="group-container" id="add-service" style="padding-left: 10%; padding-right: 10%;">

                    <!--<form action="/api/create-service.php" method="POST" enctype="multipart/form-data">-->

                         <!-- Add a Service -->
                        <div class="row">
                            <div class="col-12">
                                <h1 style="display: flex; justify-content: center; margin-bottom: 30px;">Add a Service</h1>
                            </div>
                        </div>

                        <!-- Input Row 1 -->
                        <div class="row">
                            <!-- Labels -->
                            <div class="col-4 form-col">

                                <label for="text1">Service Name:</label>
                                <label for="text2">Service Description:</label>
                                <label for="number">Price:</label>
                                <label for="dropdown">Labels:</label>
                            </div>

                            <!-- Values -->
                            <div class="col-8 form-col">
                                <!-- Service Name -->
                                <input type="text" id="serviceName" name="serviceName" placeholder="Enter text here" required>

                                <!-- Service Description -->
                                <input type="text" id="serviceDescription" name="serviceDescription" placeholder="Enter more text" required>

                                <!-- Price -->
                                <input type="number" id="price" name="price" placeholder="Enter a number" min="0" required>

                                <!-- Labels -->
                                <select id="labels" name="labels" required>
<option value="" disabled selected>Select an option</option>
                                ';}?>
                    
        <?php
        if (!empty($_SESSION['userData']) && $_SESSION['userData'][0]["usertype"] == "business owner") {



            $label_data = null;

            function retreiveLables(){
                                            
                global $label_data;

                //Get Information on posted Ad_ID 
                $_SERVER["REQUEST_METHOD"] = "GET";
                $_GET['method'] = 'fetchAll';
                ob_start(); // read in data echoed from advertisement.php
                include __DIR__ . '/../../back-end/api/tags.php';
                $response = ob_get_clean();

                //echo "<BR>RAW RESPONSE<BR>" . $response ."<BR><BR>RAW RESPONSE END<BR>";//testing
                //Ensures a json object is contained in output
                if ( str_contains($response, ']') && str_contains($response, '[') && strrpos($response, ']',0) > strrpos($response, '[',0) ) {

                    $label_data = substr($response, strrpos($response, '[', 0), ( strrpos($response, ']',0) - strrpos($response, '[', 0)) + 1 );
                    $label_data = json_decode($label_data);
                    //print_r($ad_services_data);//TESTING
                }
            }

            retreiveLables();
            foreach ($label_data as $row) {
                echo '<option value="' . $row->Description . '">' . $row->Description . '</option>';
            }

                                    echo '
                                </select>
                            </div>
                        </div>

                        <!-- Label Container -->
                        <div class="row">
                            <div class="col-12" id="label-container">
                            </div>
                        </div>

                         <!-- Submit Button -->
                        <div class="row" id="add-service-submit-container">
                            <div class="col-12">
                                 <button id="ad-service-submit-button" type="submit">Submit</button>
                            </div>
                        </div>
            </div>';}?>


        <!-- Add Advertisment -->
        <?php
        if (!empty($_SESSION['userData']) && $_SESSION['userData'][0]["usertype"] == "business owner") {
            echo '<div class="row" style="height: 60vh; margin-top: 50px; margin-bottom: 50px">

                <div class="col-2"></div>

                <div class="col-8">
                    <div class="group-container" id="add-ad-service" style="padding-left: 10%; padding-right: 10%;">

                    <!--<form action="/api/create-service.php" method="POST" enctype="multipart/form-data">-->

                         <!-- Add a Service -->
                        <div class="row">
                            <div class="col-12">
                                <h1 style="display: flex; justify-content: center; margin-bottom: 30px;">Add an Advertisment</h1>
                            </div>
                        </div>

                        <!-- Input Row 1 -->
                        <div class="row">
                            <!-- Labels -->
                            <div class="col-4 form-col">

                                <label for="text1">Ad Name:</label>
                                <label for="text2">Ad Description:</label>
                                <label for="dropdown">Services:</label>
                            </div>

                            <!-- Values -->
                            <div class="col-8 form-col">
                                <!-- Service Name -->
                                <input type="text" id="advertismentName" name="serviceName" placeholder="Enter text here" required>

                                <!-- Service Description -->
                                <input type="text" id="advertismentDescription" name="serviceDescription" placeholder="Enter more text" required>

                                <!-- Labels -->
                                <select id="adServices" name="adServices" required>
				    <option value="" disabled selected>Select an option</option>';
		}
        ?>
        <?php 

        if (!empty($_SESSION['userData']) && $_SESSION['userData'][0]["usertype"] == "business owner") {

            $ad_services_data = null;

            function retreive_ad_services_data(){
                                            
                global $ad_services_data;

                //Get Information on posted Ad_ID 
                $_SERVER["REQUEST_METHOD"] = "POST";
                $_POST['action'] = 'getAdvertServicesInformationBusiness';
                $_POST['Business_ID'] = $_SESSION['userData'][0]['Business_ID']; 
                ob_start(); // read in data echoed from advertisement.php
                include __DIR__ . '/../../back-end/api/advertisement.php';
                $response = ob_get_clean();

                //echo "<BR>RAW RESPONSE<BR>" . $response ."<BR><BR>RAW RESPONSE END<BR>";//testing
                //Ensures a json object is contained in output
                if ( str_contains($response, ']') && str_contains($response, '[') && strrpos($response, ']',0) > strrpos($response, '[',0) ) {

                    $ad_services_data = substr($response, strrpos($response, '[', 0), ( strrpos($response, ']',0) - strrpos($response, '[', 0)) + 1 );
                    $ad_services_data = json_decode($ad_services_data);
                    //print_r($ad_services_data);//TESTING
                }
            }

            retreive_ad_services_data();
            foreach ($ad_services_data as $row) {
                echo '<option data-service-id="'. $row->Service_ID . '" data-labels=\'' . $row->Label . '\'"value="' . $row->Name . '">' . $row->Name . '</option>';
            }
        }
	?>

	<?php
        if (!empty($_SESSION['userData']) && $_SESSION['userData'][0]["usertype"] == "business owner") {
 		echo '
                                </select>
                            </div>
                        </div>

                        

                        <!-- Label Container -->
                        <div class="row">
                            <div class="col-12" id="ad-label-container">
                            </div>
                        </div>


                         <!-- Submit Button -->
                        <div class="row" id="add-ad-submit-container">
                            <div class="col-12">
                                 <button id="ad-ad-submit-button" type="submit">Submit</button>
                            </div>
                        </div>

                    <!--</form>-->
                    </div>
                </div>
                <div class="col-2"></div>
            </div>
            ';
      }
      ?>

    </div>

    <script src="../front-end/create-account/js/add-ad-service.js"></script>
    </body>
</html>
