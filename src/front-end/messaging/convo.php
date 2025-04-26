
<?php 
    $messages = ["Test to show this works", "Second Button"];

function generate_convo_elements($convo) {

    foreach ($convo as $row) {
        echo "<div class=\"col-10 d-flex align-items-center justify-content-center\">" ;
            echo "<div class=\"group-container\">";
                echo "<div class=\"row\">";
                    echo '<button class="convo-button" id=' . htmlspecialchars($row) .' style =" padding: 10px;">'  . htmlspecialchars($row) . "</button>"; 
                echo "</div>";
            echo "</div>";
        echo "</div>";
        echo'<script type="application/javascript" src="js/messages.js"></script>';

    }
    function generate_message($message, $timestamp, $sender){
        echo "<div class='row'>";
           echo "<div class='col grey-light' style='background-color: lightgrey; opacity: 0.5;'> </div>";
            echo '<div class="col-8">';
              echo '<div class="group-container">';
                    echo '<div class="row message-border-top">';
                        echo '<div class="col-8 grey">';
                            echo '<div class="message">';
                                echo '<img class="user-profile" src="default_profile.jpg" alt="profile picture">';
                                if($sender){
                                    echo '<div style = align:left>';
                                }else{
                                    echo '<div style = align:left>';
                                }
                                echo '<p>' ;
                                echo $timestamp;
                                echo $message;
                                echo '</p>';
                                echo '</div>';
                            echo '</div>';
                        echo '</div>';
                    echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '<div class="col grey" style="background-color: grey; opacity: 0.5;"> </div>';
            echo '</div>';
    }
    function getUserId() {
        
        /*$id = $GLOBALS['users']->getUser(1);
        return $id;*/
        return isset($_SESSION['username']);
    }
}
?>


<!DOCTYPE html>

<html lang = "en">
    <head>  
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../front-end/global/css/global-style.css">

        <style>
            .convo-button {
                padding: 12px 70px;
                font-size: 16px;
                border-radius: 10px;
                border: 2px solid black;
                background-color: pink;
                min-width: 10%;
                min-height: 5%;
            }
    </style>

    </head>



    <div id="header"></div>
        <div style="display: inline">
        <div style="height: 100vh; width:20%;  display: inline-block; float:left; margin-right: 10px; border: 1px solid blue">
            <?php generate_convo_elements($messages) ?>
            <button id="button"> test </button>
        </div>
        <div style="height: 80vh;;width:50%;  display: inline-block; border: 1px solid red">
            <div  class = right>
                <table class='conversation' >
                <tbody style = image-item>
                    <?php
                        generate_message("This is a message", "9:00", true);
                    ?>
                    <tr style="position: absolute; bottom: 0;">
                        <input type="message"  id="message" placeholder="Message" name="Message">
                        <button id="send_button">Send</button>
                    </tr>
                    </tbody>
                </table>
                <div style="position: absolute; bottom: 20%;">
                    <input type="message"  id="message" placeholder="Message" name="Message">
                    <button id="send_button">Send</button>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script type="application/javascript" src="js/messages.js"></script>

</html>// margin to left and right