<?php 
function generate_service_image_viewer() {

    $service_images = [
        "../front-end/advertisment/images/carton-baby-dragon.png",
        "../front-end/advertisment/images/hello.jpg",
        "../front-end/advertisment/images/dog-and-turtle.jpg",
        "../front-end/advertisment/images/spot-the-dog.jpg",
    ];

echo "<div class=\"row\">" ;
echo "<div class=\"col-3\"></div>" ;
echo "<div class=\"col-6\">" ;
echo "<section class=\"wrapper\">" ;
echo "<img id=\"imageViewerMain\" src=" . $service_images[0] . " alt=\"focused service image\">" ;
echo "<div class=\"d-flex justify-content-center\">" ;

    foreach ($service_images as $image_path) {
        echo "<img class=\"imgCarousel\" src=" . $image_path . " alt=\"service image\">" ;
    }

echo "</div>" ;

echo "</section>" ;
echo "</div>" ;
echo "<div class=\"col-3\"></div>" ;
echo "</div>" ;
//Gap after image display
echo '<div class="row" style="margin: 50px"></div>';
}
?>
