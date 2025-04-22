
<?php 
    $messages = ["Test to show this works", "Second Button"];

function generate_convo_elements($convo) {

    
    foreach ($convo as $row) {
        
            echo "<div class=\"row text-center\" style=\"z-index: 1;color: black\">";

                echo "<div class=\"col-2\"></div>";

                echo "<div class=\"col-8 service-listing\">";
                    echo "<div class=\"group-container\">";
                        echo "<div class=\"row\">";

                            echo "<div class=\"col-10 d-flex align-items-center justify-content-center\">" ;
                                echo "<div class=\"group-container\">";
                                    echo "<div class=\"row\">";
                                        echo "<button>"  . htmlspecialchars($row) . "</button>"; 
                                        echo '<button class="review-submit-message-request" type="button">Message</button>';
                                    echo "</div>";
                                echo "</div>";
                            echo "</div>";

                        echo "</div>";
                    echo "</div>";
                echo "</div>";

                echo "<div class=\"col-2\"></div>";

            echo "</div>";

        echo "<BR>"; 
    }
    function generate_message($message, $timestamp){
        echo "<div class='row'>";
           echo "<div class='col grey-light' style='background-color: lightgrey; opacity: 0.5;'> </div>";
            echo '<div class="col-8">';
              echo '<div class="group-container">';
                    echo '<div class="row review-border-top">';
                       echo' <!-- User Profile Picture and Name --> ';
                        echo '<div class="col-8 grey">';
                            echo '<div class="review-user-info">';
                                echo '<img class="review-profile" src="default_profile.jpg" alt="profile picture">';
                                echo '<p>' ;
                                echo $message;
                                echo '</p>';
                            echo '</div>';
                        echo '</div>';
                    echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '<div class="col grey" style="background-color: grey; opacity: 0.5;"> </div>';
            echo '</div>';
    }
}
?>


<!DOCTYPE html>

<html lang = "en">
    <head>  
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../front-end/global/css/global-style.css">
    </head>



    <div id="header"></div>
        <div style="display: inline">
        <div style="width:20%; display: inline-block; float:left; margin-right: 10px; border: 1px solid blue">
            <?php generate_convo_elements($messages) ?>
        
        </div>
        <div style="width: 19%; display: inline-block; border: 1px solid red">
            <div  class = right>
                <table class='conversation' >

                <tbody style = image-item>
                    <?php
                        generate_message("This is a message", "9:00");
                    ?>
                    <tr>
                        <input type="message"  id="message" placeholder="Message" name="Message">
                        <button id="send_button">Send</button>
                    </tr>
                </tbody>
             </table>
            </div>
        </div>
    </div>
    </div>

</html>