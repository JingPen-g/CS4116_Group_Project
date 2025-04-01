/* 
 * The following file generates the paw prints that appear along the left and right margins of a page 
 * @author Oliver Fitzgerald
 * last updated April 1st 2025
 */

//DEFINE PARAMATERES
const randValues = [2,-3,4,1,3,-2,3,1,1,4,-2,-4,3]; //Used to create artifical randomness in the scale and rotation of images to keep UI visually interesting 

var body = document.body,
    html = document.documentElement;

const containerHeight = Math.max( body.scrollHeight, body.offsetHeight, 
                       html.clientHeight, html.scrollHeight, html.offsetHeight );
const imageHeight = parseInt(getComputedStyle(document.querySelector(".image-item")).height,10);
const spacing = 300; //Note: Does not include margin-top
const spaceForImages = Math.floor((containerHeight / 100) / 2); //!!! TODO factor out spacing in image clusters properly 


const imageItterationCycles = actualNoImages(spaceForImages, randValues); //We are using imageItterationCycles instead of noImages as the for loop generates clusters of images on some itterations i.e > 1 image so noImages would generate to many images

var container = document.querySelector('.left-container');
var left = 10;


//GENERATE MARGINS

//Left and Right
for (let side = 0; side < 2; side++) { //iiterate * 2 for left and right

    if (side === 1) { //i.e right
        container = document.querySelector('.rigth-container');
        left = 90;
    }


    //Image Cluster
    for (let i = 0; i < imageItterationCycles; i++) {//generates a cluster of images based on randValues[i] to keep ui visually interesting

        var pawPrintImage = document.createElement('div');
        pawPrintImage.classList.add('image-item');
      
        // Defines image location
        const yPosition = i * (imageHeight); //const yPosition = i * (imageHeight + spacing);
        pawPrintImage.style.top = `${yPosition}px`;
        pawPrintImage.style.left = left + "%";

        // Apply different scale/rotation for variety
        const scale = 1 + (.1 * randValues[i % 13]);
        const rotation = randValues[i % 13] * -10;
        pawPrintImage.style.transform = `translateX(-50%) scale(${scale}) rotate(${rotation}deg)`;
        
        container.appendChild(pawPrintImage);
      
        if (Math.abs(randValues[i]) > 3) { //adds a grouping of paw prints every couple or so itterations
            for (let j = 0; j < Math.abs(randValues[i % 1]); j++) { // determines number of image in grouping

                var additionalPawPrintImage = document.createElement('div');
                additionalPawPrintImage.classList.add('image-item');
                
                // Defines image location
                additionalPawPrintImage.style.top = `${yPosition}px`;
                if (j == 0)
                    additionalPawPrintImage.style.left = (left + 5) + "%";
                else 
                    additionalPawPrintImage.style.left = (left - 5) + "%";
                

                // Apply different scale/rotation for variety
                const additionalScale = 1 + (.3 * randValues[(i + j) % 13]);
                const additionalRotation =  randValues[(i + j) % 13] * -10;
                additionalPawPrintImage.style.transform = `translateX(-50%) scale(${additionalScale}) rotate(${additionalRotation}deg)`;
                
                container.appendChild(additionalPawPrintImage);
            }
        }
    }
}

/*
 * actualNoImages
 * As the number of images created in a cluster is pseudo random we can use this method to figure out
 * the total no of images that will be created for each itteration and compate it against the total No.
 * of images we can fit on the screen to decide how many imageGenerationCycles we should run.
 * @param spaceForImages - Is the total No of images we can fit on the screen
 * @param randVals - Is an array of "random" values that will be used to determine the numbre of images 
 *                      generated in a cluster (too keep the ui visualy interesting)
 * @return cycles - The number of image generation cycles to run
 */
function actualNoImages(spaceForImages, randValues) {


    var imagesGenerated = 0;
    var cycles = 0;

    for (let i = 0; i < spaceForImages; i++) {
        imagesGenerated++; 
        cycles++;

        if (Math.abs(randValues[i]) >= 3) { //adds a grouping of paw prints every couple or so itterations
            for (let j = 0; j < Math.abs(randValues[i % 1]); j++) { // determines number of image in grouping

                imagesGenerated++; 
                if (imagesGenerated > spaceForImages)
                    imagesGenerated--;

            }

            if (imagesGenerated >= spaceForImages)
                    return cycles;
        }
    }
}
