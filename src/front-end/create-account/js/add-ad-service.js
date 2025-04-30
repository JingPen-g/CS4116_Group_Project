
const addServiceSubmitButton = document.getElementById('ad-service-submit-button');
const addAdSubmitButton = document.getElementById('ad-ad-submit-button');
const addServiceLabelDropdown = document.getElementById('labels');

var labelsAdded = new Array();
const labelContainer = document.getElementById("label-container");
const adLabelContainer = document.getElementById("ad-label-container");

addServiceLabelDropdown.addEventListener('change', () => {
    var labelExists = false;
    labelsAdded.forEach((label) => {

        if (addServiceLabelDropdown.value == label || addServiceLabelDropdown.value == "")
            labelExists = true;
    });

    if (!labelExists) {
        if (labelsAdded.length % 2 == 0) {

            labelContainer.innerHTML += ' <div class="service-label-row"> <div class="service-label"> <h3 class="service-label-text">' + addServiceLabelDropdown.value + '</h3> <button data-label="' + addServiceLabelDropdown.value + '"class="add-service-remove-label" style="margin-left:10px">X</button> </div> </div>';
        }else {
            const labelRows = Array.from(labelContainer.querySelectorAll('div.service-label-row')); 
            const lastRow = labelRows[labelRows.length - 1];
            lastRow.innerHTML += '<div class="service-label"> <h3 class="service-label-text">' + addServiceLabelDropdown.value + '</h3> </h3> <button data-label="' + addServiceLabelDropdown.value + '"class="add-service-remove-label" style="margin-left:10px">X</button></div>';

        }
        labelsAdded.push(addServiceLabelDropdown.value);

        const allCloseLableButtons = Array.from(document.querySelectorAll('button.add-service-remove-label'));
        allCloseLableButtons.forEach((btn) => {
            btn.addEventListener('click', () => {
                btn.parentElement.remove();
                labelsAdded = labelsAdded.filter(element => element !== btn.dataset.label); 

            });
        });
    }
});

addServiceSubmitButton.addEventListener('click', () => {

    const addServiceName = document.getElementById('serviceName');
    const addServiceDescription = document.getElementById('serviceDescription');
    const addServicePrice = document.getElementById('price');
    const addServiceImage = document.getElementById('image');


    //Labels
    const labels = Array.from(document.getElementsByClassName("service-label-text"));
    var labelTempArray = new Array();
    var labelString = "";
    labels.forEach((label) => {

        labelString += label.textContent + ", ";
    });
    labelString = labelString.substring(0,labelString.length - 2);


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
    })
    .then(response => response.json())
    .then(data => {
      console.log('Success:', data);
        alert("Service Created");
        window.location.reload()
    })
    .catch(error => {
      console.error('Error:', error);
    });



});


const addAdLabelContainer = document.getElementById("ad-label-container");
const addAdLabelDropdown = document.getElementById('adServices');
var adlabelsAdded = new Array();
var adServiceIds = new Array();
var adLabels = new Array();
addAdLabelDropdown.addEventListener('change', () => {

    const selectedOption = addAdLabelDropdown.options[addAdLabelDropdown.selectedIndex];

    var labelExists = false;
    adlabelsAdded.forEach((label) => {

        if (addAdLabelDropdown.value == label[0] || addAdLabelDropdown.value == "")
            labelExists = true;
    });

    console.log(labelExists)
    if (!labelExists) {
        if (adlabelsAdded.length % 2 == 0) {


            addAdLabelContainer.innerHTML += ' <div class="service-label-row"> <div class="service-label"> <h3 class="service-label-text">' + addAdLabelDropdown.value + '</h3> <button data-label="' + addAdLabelDropdown.value + '"class="add-service-remove-label" style="margin-left:10px">X</button> </div> </div>';
        }else {

            const labelRows = Array.from(addAdLabelContainer.querySelectorAll('div.service-label-row')); 
            const lastRow = labelRows[labelRows.length - 1];
            lastRow.innerHTML += '<div class="service-label"> <h3 class="service-label-text">' + addAdLabelDropdown.value + '</h3> <button data-label="' + addAdLabelDropdown.value + '"class="add-service-remove-label" style="margin-left:10px">X</button></div>';

        }
        var temp = new Array();
        temp[0] = addAdLabelDropdown.value;
        temp[1] = selectedOption.dataset.serviceId;
        temp[2] = selectedOption.dataset.labels;
        adlabelsAdded.push(temp);

        const allCloseLableButtons = Array.from(document.querySelectorAll('button.add-service-remove-label'));
        allCloseLableButtons.forEach((btn) => {
            btn.addEventListener('click', () => {
                btn.parentElement.remove();
                adlabelsAdded = adlabelsAdded.filter(element => element[0] !== btn.dataset.label); 

            });
        });
    }
});


addAdSubmitButton.addEventListener('click', () => {

    const addAdName = document.getElementById('advertismentName');
    const addAdDescription = document.getElementById('advertismentDescription');

    //Name
    console.log("service name: " + addAdName.value);
    //Description
    console.log("service description: " + addAdDescription.value);


    var serviceIds = new Array();
    const lables = {};

    const targetObject = {
      labels: []
    };
    
    adlabelsAdded.forEach( (service) => {

        serviceIds.push(service[1]);

        // Process each JSON string
          const parsedObject = JSON.parse(service[2]);
          
          // Split the comma-separated labels and trim whitespace
          const labelsArray = parsedObject.labels.split(',').map(label => label.trim());
          
          // Add each label to the target object if it's not already there
          labelsArray.forEach(label => {
            if (!targetObject.labels.includes(label)) {
              targetObject.labels.push(label);
            }
          });

    });

    //Service Ids
    console.log("serviceIds: " + serviceIds);

    //Lablels
    console.log(targetObject);

    serviceIds = "[" + serviceIds + "]";

    //FETCH
    fetch('api/advertisement.php', {
        method: 'POST', 
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            action: "insertAdvert",
            name: addAdName.value,
            description: addAdDescription.value,
            service_ids: serviceIds,
            labels: JSON.stringify(targetObject)
        }),
    })
    .then(response => response.json())
    .then(data => {
      console.log('Success:', data);
        alert("AD Created");
    })
    .catch(error => {
      console.error('Error:', error);
    });



});
