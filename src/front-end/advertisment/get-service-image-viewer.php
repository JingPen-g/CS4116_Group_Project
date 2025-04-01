<?php 
function generate_service_image_viewer() {

    $service_images = [
        "images/carton-baby-dragon.png",
        "images/hello.jpg",
        "images/dog-and-turtle.jpg",
        "images/spot-the-dog.jpg",
    ];

echo "<div class=\"row\">" ;
echo "<div class=\"col-3\"></div>" ;
echo "<div class=\"col-6\">" ;
echo "<section class=\"wrapper\">" ;
echo "<img id=\"mainPhoto\" src=" . $service_images[0] . " alt=\"roar\">" ;
echo "<div class=\"d-flex justify-content-center\">" ;

    foreach ($service_images as $image_path) {
        echo "<img class=\"imgCarousel\" src=" . $image_path . " alt=\"roar\">" ;
    }

echo "</div>" ;

echo "</section>" ;
echo "</div>" ;
echo "<div class=\"col-3\"></div>" ;
echo "</div>" ;

}
?>
