
<?php 
    $messages = ["Test to show this works", "Second Button"];

function generate_convo_elements($convo) {

    foreach ($convo as $row) {
        echo "<div class=\"col-10 d-flex align-items-center justify-content-center\">" ;
            echo "<div class=\"group-container\">";
                echo "<div class=\"row\">";
                    echo '<img src="user1.png" class="msgimg" />';
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
                                //echo '<img class="user-profile" src="default_profile.jpg" alt="profile picture">';
                                if($sender){
                                    echo '<div style = align:left>';
                                }else{
                                    echo '<div style = align:left>';
                                }
                                echo '<p>' ;
                                one_message_recieve($message, $timestamp);
                                one_message_sender($message, $timestamp);
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

    function one_message_sender($message, $time){
        echo '<div class="received">';
            echo '<div class="received-chats-img">';
                echo '</div>';
                echo '<div class="received">';
                  echo '<div class="received-msg">';
                    echo'<p>';
                    echo $message;
                    echo'</p>';
                    echo '<span class="time">18:06 PM | July 24</span>';
                  echo'</div>';
                echo'</div>';
              echo'</div>';
    }
    function one_message_recieve($message, $time){
        echo '<div class="outgoing">';
            echo '<div class="outgoing-chats-img">';
                echo '</div>';
                echo '<div class="outgoing">';
                  echo '<div class="outgoing-msg">';
                    echo'<p>';
                    echo $message;
                    echo'</p>';
                    echo '<span class="time">';
                    echo $time ;
                    echo '</span>';
                  echo'</div>';
                echo'</div>';
              echo'</div>';
    }
    function getUserId() {
        
        /*$id = $GLOBALS['users']->getUser(1);
        return $id;*/
        return isset($_SESSION['username']);
    }
    function generate_new_convo($User){}
    function generate_existing($User){}
    function acceptorReject($User){
        echo '<div class = pending>';
        echo '<p> Pending conversation from ' . $User .' Accept or Reject </p>';
        echo '<div class="make-an-offer-accept-or-reject-choice">';
        echo '<button type="button" id="accept" class="accept">Accept</button>';
        echo '<button type="button" id="reject" class="reject">Reject</button>';
        echo '</div>';
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

        <style>
            .pending {
                display: inline-block;
                padding: 20px;
                vertical-align: top;
                width: 92%;
                text-align: center 
            }
            .accept {
                width: 20%;
                color: black;
                font-size: 1rem;
                background-color: ;
                background-color: #c3cf62;
                margin-left: 20px;
                margin-right: 20px;
                margin-bottom: 10px;
                border-radius: 30px;
                border: solid 5px black;
                box-shadow: 5px 5px #4c4949;
            }
            .accept:hover {
                cursor: pointer;
                background-color:  #8f9c30;
            }
            .reject {
                width: 20%;
                color: black;
                font-size: 1rem;
                background-color: ;
                background-color:rgb(215, 145, 59);
                margin-left: 20px;
                margin-right: 20px;
                margin-bottom: 10px;
                border-radius: 30px;
                border: solid 5px black;
                box-shadow: 5px 5px #4c4949;
            }
            .reject:hover {
                cursor: pointer;
                background-color:  #8f9c30;
            }
            .convo-button {
                padding: 12px 70px;
                font-size: 16px;
                border-radius: 10px;
                border: 2px solid black;
                background-color: pink;
                min-width: 100%;
                max-width: 100%;
                min-height: 5%;
            }
            .convo-button:hover{
                cursor: pointer;
                background-color:rgb(209, 212, 184);
            }
            received-chats-img {
                display: inline-block;
                width: 50px;
                float: right;
            }

            .received {
                display: inline-block;
                padding: 0 0 0 10px;
                vertical-align: top;
                width: 92%;
            }
            .received-msg {
                width: 57%;
            }

            .received-msg p {
                background: #efefef none repeat scroll 0 0;
                border-radius: 10px;
                color: #646464;
                font-size: 14px;
                margin-left: 1rem;
                padding: 1rem;
                width: 100%;
                box-shadow: rgb(0 0 0 / 25%) 0px 5px 5px 2px;
            }
                p {
                overflow-wrap: break-word;
            }

            /* Styling the msg-sent time  */
            .time {
                color: #777;
                display: block;
                font-size: 12px;
                margin: 8px 0 0;
            }
            .outgoing{
                overflow: hidden;
                margin: 26px 20px;
            }

            .outgoing-msg p {
                background-color: #3a12ff;
                color: #fff;
                border-radius: 10px;
                font-size: 14px;
                color: #fff;
                padding: 5px 10px 5px 12px;
                width: 100%;
                padding: 1rem;
                box-shadow: rgb(0 0 0 / 25%) 0px 2px 5px 2px;
            }
            .outgoing-msg {
                    float: right;
                    width: 46%;
                }
         
        </style>

    </head>



    <div id="header"></div>
        <div style="display: inline">
        <div style="height: 100vh; width:20%;  display: inline-block; float:left; margin-right: 10px; border: 1px solid blue">
            
            <?php 
                generate_convo_elements($messages) ?>
        </div>
        <div style="height: 80vh;;width:50%;  display: inline-block; border: 1px solid red">
            <div  class = right>
                <table class='conversation' >
                <tbody style = image-item>
                    <?php
                        acceptorReject("jeff");
                        generate_message("This is a message", "9:00", true);
                    ?>
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