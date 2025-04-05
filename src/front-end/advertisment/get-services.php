<?php 
function generate_service_elements($services_data) {


    foreach ($services_data as $row) {
        // Iterate through elements in the row
        
            echo "<div class=\"row text-center\" style=\"z-index: 1;color: black\">";

                echo "<div class=\"col-2\"></div>";

                echo "<div class=\"col-8 service-listing\">";
                    echo "<div class=\"group-container\">";
                        echo "<div class=\"row\">";

                            echo "<div class=\"col-10 d-flex align-items-center justify-content-center\">" ;
                                echo "<div class=\"group-container\">";
                                    echo "<div class=\"row\">";
                                        echo "<h3>" . htmlspecialchars($row->Name) . "</h3>"; //servie title
                                    echo "</div>";
                                    echo "<div class=\"row\">";
                                        echo "<p>" . htmlspecialchars($row->Description) . "This is a description of the service</p>"; //service description
                                    echo "</div>";
                                echo "</div>";
                            echo "</div>";

                            echo "<div class=\"col-2 d-flex align-items-center ms-auto\">";
                                echo "<h3>€" . htmlspecialchars($row->Price) . "</h3>"; //service price
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
