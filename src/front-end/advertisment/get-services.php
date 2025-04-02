<?php 
function generate_service_elements() {

    $services = [
      ["service 1","This is a description for service 1", 10],  
      ["service 2","This is a description for service 2", 20],  
      ["service 3","This is a description for service 3", 30],  
    ];

    foreach ($services as $row) {
        // Iterate through elements in the row
        
            echo "<div class=\"row text-center\" style=\"color: black\">";

                echo "<div class=\"col-2\"></div>";

                echo "<div class=\"col-8 service-listing\">";
                    echo "<div class=\"group-container\">";
                        echo "<div class=\"row\">";

                            echo "<div class=\"col-10 d-flex align-items-center justify-content-center\">" ;
                                echo "<div class=\"group-container\">";
                                    echo "<div class=\"row\">";
                                        echo "<h3>" . htmlspecialchars($row[0]) . "</h3>"; //servie title
                                    echo "</div>";
                                    echo "<div class=\"row\">";
                                        echo "<p>" . htmlspecialchars($row[1]) . "This is a description of the service</p>"; //service description
                                    echo "</div>";
                                echo "</div>";
                            echo "</div>";

                            echo "<div class=\"col-2 d-flex align-items-center ms-auto\">";
                                echo "<h3>€" . htmlspecialchars($row[2]) . "</h3>"; //service price
                            echo "</div>";

                        echo "</div>";
                    echo "</div>";
                echo "</div>";

                echo "<div class=\"col-2\"></div>";

            echo "</div>";

        echo "<BR>"; 
    }
}
?>
