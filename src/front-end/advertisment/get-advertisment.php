<?php 
function generate_advertisment_header($advertisement_title, $advertisement_description) {

    $advertisment = ["Bobs Pet Grooming","Offering a wide range of grooming services for all your furry friends needs"];

    echo "<BR>" ;
    echo "<div class=\"row text-center\">" ;
    echo "<h1 id=\"ad_title\">" . htmlspecialchars($advertisement_title) . "</h1>" ;
    echo "<h3 style=\"margin-bottom: 100px;\" id=\"ad_description\">" . htmlspecialchars($advertisement_description) . "</h3>" ;
    echo "</div>" ;

    //Add Gap Under Header
    echo '<div class="row" style="margin: 25px"></div>';
}
?>
