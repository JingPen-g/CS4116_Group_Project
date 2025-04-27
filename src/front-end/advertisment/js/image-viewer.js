let allServiceImages = Array.from(document.getElementsByClassName("imgCarousel"))
let mainPhoto = document.getElementById("imageViewerMain")

function updateImage(event) {

    let image = event.target
    mainPhoto.src = image.src
}

allServiceImages.forEach(function (image) {
    image.addEventListener("click", updateImage)
});
