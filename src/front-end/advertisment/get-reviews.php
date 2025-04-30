<?php
function generate_review_elements($review_data, $userType, $businessId) {

        echo '<!-- Title Row -->
        <div class="row" style="margin-top: 10vh !important">
            <div class="col-4 grey"></div>
            <div class="col-4 grey-light">
                <div class="review-header">
                    <h1>Reviews</h1>
                </div>
            </div>
            <div class="col-4 grey"></div>
        </div>';
        echo '<!-- Gap Row -->
        <div class="row">
            <div class="col grey"></div>
            <div class="col grey-light"></div>
            <div class="col grey"></div>
            <div class="col grey-light"></div>
            <div class="col grey"></div>
            <div class="col grey-light"></div>
        </div>';
    foreach ($review_data as $row) {
        echo '

            <!-- Review Container One-->
            <div class="row">
                <div class="col grey-light"></div>
                <div class="col-8">
                    <div class="group-container">
                        <div class="row review-border-top">
                            <!-- User Profile Picture and Name -->
                            <div class="col-8 grey">
                                <div class="review-user-info">
                                    <img class="review-profile" src="' . $row->User_Profile . '" alt="profile picture">
                                    <h3 style="color: black">' . $row->User_Name . '</h3>
                                </div>
                            </div>
                            <!-- Message User -->
                            <div class="col-4 grey">
                                <div class="review-message-user">';
        if ($userType == "customer" || $userType == "business owner")
            echo                    '<button class="review-submit-message-request" onclick = "inquireUser(' . $row->Users_ID . ')" type="button">Message User</button>';
        else if ($userType == "this business owner")
            echo                    '<button class="review-submit-message-request" type="button" data-user-type="business" data-review-id="' . $row->Review_ID . '">Reply to review</button>';

        echo                    '</div>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="col grey"></div>
                </div>
            <!-- Review Container Two-->
            <div class="row">
                <div class="col grey"></div>
                <div class="col-8">
                    <div class="group-container">
                        <div class="row review-border-bottom">
                            <!-- Comment -->
                            <div class="col-8">
                                <div class="review-comment">
                                    <p style="color: black">' . $row->Comment . '</p>
                                </div>
                            </div>
                            <!-- Rating -->
                            <div class="col-4">
                                <div class="review-rating">
                                    <p style="color: black">Stars: ' . $row->Stars . '/5</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col"></div>
            </div>';


            if ($row->Response)

                echo '<!-- Business Response Container-->
                <div class="row">
                    <div class="col" style="height: 30px;"></div>
                </div>

                <!-- Review Response Container One-->
                <div class="row">
                    <div class="col-4 grey-light"></div>
                    <div class="col-6">
                        <div class="group-container">
                            <div class="row review-border-top">
                                <!-- Business Profile Picture and Name -->
                                <div class="col grey">
                                    <div class="review-user-info">
                                        <img class="review-profile" src="' . $businessId[0]->Business_Profile . '" alt="profile picture">
                                        <h3 style="color: black">' . $businessId[0]->Business_Name . '</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                        <div class="col grey"></div>
                    </div>
                <!-- Review Container Two-->
                <div class="row">
                    <div class="col-4 grey"></div>
                    <div class="col-6">
                        <div class="group-container">
                            <div class="row review-border-bottom">
                                <!-- Comment -->
                                <div class="col">
                                    <div class="review-comment">
                                        <p style="color: black">' . $row[0]->Response . '</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col"></div>
                </div>';

        echo '<!-- Gap Row -->
        <div class="row">
            <div class="col grey"></div>
            <div class="col grey-light"></div>
            <div class="col grey"></div>
            <div class="col grey-light"></div>
            <div class="col grey"></div>
            <div class="col grey-light"></div>
        </div>';
    }
}
function generate_empty_review_section(){
    echo '
        <!-- Title Row -->
        <div class="row" style="margin-top: 10vh !important">
            <div class="col-4 grey"></div>
            <div class="col-4 grey-light">
                <div class="review-header">
                    <h1>Reviews</h1>
                </div>
            </div>
            <div class="col-4 grey"></div>
        </div>

        <div class="row" style="margin-top: 10vh !important">
            <div class="col-4 grey"></div>
            <div class="col-4 grey-light">
                <div class="review-header">
                    <h3>There are currently no reviews for this advertisment</h3>
                </div>
            </div>
            <div class="col-4 grey"></div>
        </div>
';
}
function generate_add_review_section($services_data, $services_user_is_verifed_for) {

    echo '
        <div class="row">
            <div class="col-2"></div>

            <div class="col-8">
                 <div id="add-review-container">
                     <!-- comment -->
                    <textarea id="add-review-input" type="text" placeholder="Add a review ..." rows="3"></textarea>


                     <!-- service selection -->
                        <select id="add-review-service-selection-container" name="bob dylan">';



    foreach ($services_data as $row) {
        foreach ($services_user_is_verifed_for as $servicesUserIsVerifiedFor)
            if ($row[0]->Service_ID == $servicesUserIsVerifiedFor->Service_ID)
                echo '<option value="' . $row[0]->Service_ID . '">' . $row[0]->Name . '</option>';
    }

    echo '
       </select>

        <!-- stars -->
        <div id="add-review-stars-container">
            <div id="stars-slider-container">
                <input type="range" id="star-slider" min="0" max="5" value="0">
            </div>
            <div>
                <span class="star" data-value="5">&#9733;</span>
                <span class="star" data-value="5">&#9733;</span>
                <span class="star" data-value="5">&#9733;</span>
                <span class="star" data-value="5">&#9733;</span>
                <span class="star" data-value="5">&#9733;</span>
            </div>
        </div>

        <!-- submit -->
        <button id="add-review-submit" type="button">Submit Review</button>
        </div>
        </div>

        <div class="col-2"></div>
        </div>';

}
?>
