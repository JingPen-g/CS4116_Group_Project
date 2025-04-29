<?php 
function generate_service_elements($services_data) {


    foreach ($services_data as $row) {
        // Iterate through elements in the row
        
            echo "<div class=\"row text-center\" style=\"z-index: 1;color: black\">";

                echo "<div class=\"col-2\"></div>";

                echo "<div class=\"col-8 service-listing\">";
			// !!! INFO: Pass Info to PopUp here
			echo "<button type=\"button\" class=\"aButton\" style=\"z-index: 10; width: 100%;\" data-service-name=\"" . htmlspecialchars($row[0]->Name) . "\" data-service-price=\"" . htmlspecialchars($row[0]->Price) . "\" data-service-description=\"" . htmlspecialchars($row[0]->Description) . "\" data-image-path=\"" . htmlspecialchars($row[0]->Image) . "\" data-service-id=\"" . htmlspecialchars($row[0]->Service_ID) . "\" data-business-id=\"" . htmlspecialchars($row[0]->Business_ID) . "\" data-user-id=\"" . htmlspecialchars("1") . "\">";
			    echo "<div class=\"group-container\">";
				echo "<div class=\"row\">";

				    echo "<div class=\"col-10 d-flex align-items-center justify-content-center\">" ;
					echo "<div class=\"group-container\">";
					    echo "<div class=\"row\">";
						echo "<h3>" . htmlspecialchars($row[0]->Name) . "</h3>"; //servie title
					    echo "</div>";
					    echo "<div class=\"row\">";
						echo "<p>" . htmlspecialchars($row[0]->Description) . "This is a description of the service</p>"; //service description
					    echo "</div>";
					echo "</div>";
				    echo "</div>";

				    echo "<div class=\"col-2 d-flex align-items-center ms-auto\">";
					echo "<h3>€" . htmlspecialchars($row[0]->Price) . "</h3>"; //service price
				    echo "</div>";

				echo "</div>";
			    echo "</div>";
			echo "</button>";
                echo "</div>";

                echo "<div class=\"col-2\"></div>";
            echo "</div>";

        echo "<BR>"; 
    }
}
?>
