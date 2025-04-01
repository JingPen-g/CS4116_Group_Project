<?php 
function generate_advertisment_header() {

    $advertisment = ["Bobs Pet Grooming","Offering a wide range of grooming services for all your furry friends needs"];

    echo "<BR>" ;
    echo "<div class=\"row text-center\">" ;
    echo "<h1 id=\"ad_title\">" . htmlspecialchars($advertisment[0]) . "</h1>" ;
    echo "<h3 id=\"ad_description\">" . htmlspecialchars($advertisment[1]) . "</h3>" ;
    echo "</div>" ;

}
?>
