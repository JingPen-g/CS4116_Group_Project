
const addServiceSubmitButton = document.getElementById('ad-service-submit-button');
const addServiceLabelDropdown = document.getElementById('labels');

var labelsAdded = new Array();
const labelContainer = document.getElementById("label-container");

addServiceLabelDropdown.addEventListener('change', () => {
    console.log()
    var labelExists = false;
    labelsAdded.forEach((label) => {

        if (addServiceLabelDropdown.value == label || addServiceLabelDropdown.value == "")
            labelExists = true;
    });

    console.log(labelExists)
    if (!labelExists) {
        if (labelsAdded.length % 2 == 0) {

            labelContainer.innerHTML += ' <div class="service-label-row"> <div class="service-label"> <h3 class="service-label-text">' + addServiceLabelDropdown.value + '</h3> <button data-label="' + addServiceLabelDropdown.value + '"class="add-service-remove-label" style="margin-left:10px">X</button> </div> </div>';
        }else {
            const labelRows = Array.from(labelContainer.querySelectorAll('div.service-label-row')); 
            const lastRow = labelRows[labelRows.length - 1];
            lastRow.innerHTML += '<div class="service-label"> <h3 class="service-label-text">' + addServiceLabelDropdown.value + '</h3> </h3> <button data-label="' + addServiceLabelDropdown.value + '"class="add-service-remove-label" style="margin-left:10px">X</button></div>';

        }
        console.log("hit: " + addServiceLabelDropdown.value);
        labelsAdded.push(addServiceLabelDropdown.value);

        const allCloseLableButtons = Array.from(document.querySelectorAll('button.add-service-remove-label'));
        allCloseLableButtons.forEach((btn) => {
            btn.addEventListener('click', () => {
                btn.parentElement.remove();
                labelsAdded = labelsAdded.filter(element => element !== btn.dataset.label); 

            });
        });
    }
    console.log(labelsAdded);
});

addServiceSubmitButton.addEventListener('click', () => {

    const addServiceName = document.getElementById('serviceName');
    const addServiceDescription = document.getElementById('serviceDescription');
    const addServicePrice = document.getElementById('price');
    const addServiceImage = document.getElementById('image');

    //Name
    console.log("service name: " + addServiceName.value);
    //Description
    console.log("service description: " + addServiceDescription.value);
    //Price
    console.log("service price: " + addServicePrice.value);

    //Labels
    const labels = Array.from(document.getElementsByClassName("service-label-text"));
    var labelTempArray = new Array();
    var labelString = "";
    labels.forEach((label) => {

        console.log("test: " + label.textContent);
        labelString += label.textContent + ", ";
    });
    labelString = labelString.substring(0,labelString.length - 2);
    console.log("labelString: " + labelString);

    //image
    const formData = new FormData();
    formData.append('file', file);

    //FETCH
    fetch('api/create-service.php', {
        method: 'POST', 
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            serviceName: addServiceName.value,
            serviceDescription: addServiceDescription.value,
            price: addServicePrice.value,
            labelString: labelString
        }),
        formData
    })
    .then(response => response.json())
    .then(data => {
      console.log('Success:', data);
        alert("Service Created");
    })
    .catch(error => {
      console.error('Error:', error);
    });



});
<<<<<<< Updated upstream
=======

// HTML: <input type="file" id="fileInput">
const fileInput = document.getElementById('image');

var file;
fileInput.addEventListener('change', function(event) {
  file = event.target.files[0];
});
>>>>>>> Stashed changes
