//Initalize
//DOM Elements
const overlay = document.getElementById('overlay');
var overlay_inner = document.getElementById('overlayInner');
var transactionComplete = document.getElementById('transactionConfirmation');
var mainContainer = document.getElementById('mainContainer');
var service_description = document.getElementById('serviceDescription');
var service_description_text = service_description.textContent;
var service_title = document.getElementById('serviceTitle');
var service_title_text = service_title.textContent;
var main_photo = document.getElementById('mainPhoto');
var payment_button = document.getElementById('payment');
var service_inquiry = document.getElementById('serviceInquiry');
var service_inquiry_text = document.getElementById('inquireText');
var service_transaction_button_box = document.getElementById('paymentAndServiceInquiryContainer');
var title_and_price_container = document.getElementById('titleAndPriceContainer');
var service_price = document.getElementById('servicePrice');
//Event Listeners
var exitButton = document.getElementById('closeOverlayButton');
var secondExitButton = document.getElementById('secondCloseOverlayButton');
var payButton = document.getElementById('payment');
var exitPaymentConfirmation = document.getElementById('exitTransactionComplete');


overlay.classList.add('transaction'); 
transactionComplete.classList.add('transaction'); 

//Add Transaction Overlay Trigger to Each Service Button 
const button = document.querySelectorAll('.aButton')
button.forEach(function(currentBtn){
    currentBtn.addEventListener('click', () => {

        var serviceName = currentBtn.dataset.serviceName;
        var serviceDescription = currentBtn.dataset.serviceDescription;
        var servicePrice = currentBtn.dataset.servicePrice;
        var serviceId = currentBtn.dataset.serviceId;
        var businessId = currentBtn.dataset.businessId;
        var userId = currentBtn.dataset.userId;
        var serviceImagePath = currentBtn.dataset.imagePath;
        

        if (serviceImagePath === "" || serviceImagePath == null)
            serviceImagePath = "images/image1.svg";

        var title_and_price_container = document.getElementById('serviceNameTransactionComplete');
        var service_price = document.getElementById('servicePriceTransactionComplete');
        title_and_price_container.textContent = `${serviceName}`;
        service_price.textContent = `${servicePrice}`;

        //Set the variables in overlay html
        overlay.innerHTML = `
            <div id="overlayInner" class="transaction-container">
            <div id="transaction_data" data-value="<?php echo htmlspecailchars(${servicePrice},${serviceId}, ${businessId}, ${userId}); ?>></div>
         
            <!-- Service Title And Price-->
            <div id="titleAndPriceContainer">
                <p id="serviceTitle">${serviceName}</p>
                <h1 id="servicePrice">${servicePrice}</h1>
                <button class="tag-container" type="button" id="closeOverlayButton"><b><h3>X</h3></b></button>
            </div>
            <!-- Service Description -->
            <div id="serviceDescription">
                <p style=" margin: 0 auto;max-height: 100%">${serviceDescription}</p>
            </div>
            <!-- Service Image -->
            <div style="display: flex; flex-direction: row; width: 100%;height: 40vh; align-items: center;padding-right: 20%; padding-left: 20%;margin-top: 5%">
                <img id="mainPhoto" alt="service image" src="${serviceImagePath}">
            </div>
            <!-- Payment/Messaging -->
            <div id="paymentAndServiceInquiryContainer">
                <button class="tag-container" type="button" id="payment"><b><h3>Pay</h3></b></button>
                <button class="tag-container" type="button" id="serviceInquiry"><b><h3 id="inquireText">Inquire about service</h3></b></button>
                <button class="tag-container" type="button" id="secondCloseOverlayButton"><b><h3>X</h3></b></button>
            </div>

            </div>
        `;

        //Re-set varriables
        var overlay_inner = document.getElementById('overlayInner');
        var transactionComplete = document.getElementById('transactionConfirmation');
        var mainContainer = document.getElementById('mainContainer');
        var service_description = document.getElementById('serviceDescription');
        var service_description_text = service_description.textContent;
        var service_title = document.getElementById('serviceTitle');
        var service_title_text = service_title.textContent;
        var main_photo = document.getElementById('mainPhoto');
        var payment_button = document.getElementById('payment');
        var service_inquiry = document.getElementById('serviceInquiry');
        var service_inquiry_text = document.getElementById('inquireText');
        var service_transaction_button_box = document.getElementById('paymentAndServiceInquiryContainer');
        var title_and_price_container = document.getElementById('titleAndPriceContainer');
        var service_price = document.getElementById('servicePrice');
        
        //Re-set event listeners
        var exitButton = document.getElementById('closeOverlayButton');
        var secondExitButton = document.getElementById('secondCloseOverlayButton');
        var payButton = document.getElementById('payment');
        var exitPaymentConfirmation = document.getElementById('exitTransactionComplete');

        //Close Transaction Overlay   
        exitButton.addEventListener('click', () => {

            document.documentElement.style.overflow = "visible";
            document.body.style.top = `0px`;
            overlay.classList.toggle('visible');
                button.forEach(function(btn){
                    btn.disabled = false;
                });

        });

        //Second Close Transaction Overlay   
        secondExitButton.addEventListener('click', () => {

            document.documentElement.style.overflow = "visible";
            document.body.style.top = `0px`;
            overlay.classList.toggle('visible');
                button.forEach(function(btn){
                    btn.disabled = false;
                });

        });
        //Pay 
        payButton.addEventListener('click', () => {

            var transactionData = document.getElementById('transaction_data').dataset.value;
            transactionData = transactionData.substring(transactionData.indexOf("(") + 1, transactionData.indexOf(")"));
            transactionData = transactionData.split(",");
            
            const serviceAmount = transactionData[0];
            const serviceId = transactionData[1];
            const businessId = transactionData[2];
            const userId = transactionData[3];

            
            //add transaction
            fetch('api/transactions.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    action: "insertNewTransaction",
                    user_id: userId,
                    business_id: businessId,
                    service_id: serviceId,
                    amount: serviceAmount,
                    status: 1 //transaction complete 
                }),
            })
            .then(response => response.json())
            .then(data => {
              console.log('Success:', data);
            })
            .catch(error => {
              console.error('Error:', error);
            });

            //add verified
            fetch('api/verification.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    action: "insertNewVerifiedCustomer",
                    user_id: userId,
                    service_id: serviceId
                }),
            })
            .then(response => response.json())
            .then(data => {
              console.log('Success:', data);
            })
            .catch(error => {
              console.error('Error:', error);
            });

            overlay.classList.toggle('visible');
            transactionComplete.classList.toggle('visible')

        });
        //Exit Payment Confirmation 
        exitPaymentConfirmation.addEventListener('click', () => {

            document.documentElement.style.overflow = "visible";
            document.body.style.top = `0px`;
            transactionComplete.classList.toggle('visible')
                button.forEach(function(btn){
                    btn.disabled = false;
                });
        });

        //Bring up pop up
        overlay.classList.toggle('visible');
        document.documentElement.style.overflow = "hidden";

        var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        document.body.style.top = `-${scrollTop}px`;
        
        //Disable all service listing buttons
        button.forEach(function(btn){
            btn.disabled = true;
        });

    });
});




var lastLine;
window.addEventListener('resize', function() {
    
    //1
    if (window.innerWidth >= 1476 && lastLine != 1) {
        lastLine = 1;


        //Service Title
        if (service_title_text.length > 35) {
            service_title.textContent = service_title_text.substring(0, 35) ;
            service_title.textContent = service_title.textContent.substring(0, service_title.textContent.lastIndexOf(" ")) + "...";
        } else 
            service_title.textContent = service_title_text;
        

        //Service Descritpion
        if (service_description.textContent.length > 250) {
            service_description.textContent = service_description_text.substring(0, 250) ;
            service_description.textContent = service_description.textContent.substring(0, service_description.textContent.lastIndexOf(" ")) + "...";
        }
        else
            service_description.textContent = service_description_text;

        //inquire button
        service_inquiry_text.textContent = "Inquire about service";
    }

    //2
    if (window.innerWidth >= 1422 && window.innerWidth <= 1475 && lastLine != 2) {
        lastLine = 2;

        if (service_title_text.length > 29) {
            service_title.textContent = service_title_text.substring(0, 29) ;
            service_title.textContent = service_title.textContent.substring(0, service_title.textContent.lastIndexOf(" ")) + "...";
        } else 
            service_title.textContent = service_title_text;

        //Service Descritpion
        if (service_description.textContent.length > 250) {
            service_description.textContent = service_description_text.substring(0, 250) ;
            service_description.textContent = service_description.textContent.substring(0, service_description.textContent.lastIndexOf(" ")) + "...";
        }
        else
            service_description.textContent = service_description_text;
        
        //inquire button
        service_inquiry_text.textContent = "Inquire about service";
    }

    //3
    if (window.innerWidth >= 836 && window.innerWidth <= 1421 && lastLine != 3) {
        lastLine = 3;


        if (service_title_text.length > 25) {
            service_title.textContent = service_title_text.substring(0, 25) ;
            service_title.textContent = service_title.textContent.substring(0, service_title.textContent.lastIndexOf(" ")) + "...";
        } else 
            service_title.textContent = service_title_text;

        //Service Descritpion
        if (service_description.textContent.length > 200) {
            service_description.textContent = service_description_text.substring(0, 200) ;
            service_description.textContent = service_description.textContent.substring(0, service_description.textContent.lastIndexOf(" ")) + "...";
        }
        else
            service_description.textContent = service_description_text;

        //inquire button
        service_inquiry_text.textContent = "Inquire about service";
    }

    //4
    if (window.innerWidth >= 486 && window.innerWidth <= 835 && lastLine != 4) {
            lastLine = 4;
            if (service_title_text.length > 30) {
                service_title.textContent = service_title_text.substring(0, 30) ;
                service_title.textContent = service_title.textContent.substring(0, service_title.textContent.lastIndexOf(" ")) + "...";
            } else
                service_title.textContent = service_title_text;

        //Service Descritpion
        if (service_description.textContent.length > 200) {
            service_description.textContent = service_description_text.substring(0, 200) ;
            service_description.textContent = service_description.textContent.substring(0, service_description.textContent.lastIndexOf(" ")) + "...";
        }
        else
            service_description.textContent = service_description_text;

        //inquire button
        service_inquiry_text.textContent = "Inquire";
        
    }

    //5
    if (window.innerWidth >= 451 && window.innerWidth <= 485 && lastLine != 5) {
            lastLine = 5;

        if (service_title_text.length > 25) {
            service_title.textContent = service_title_text.substring(0, 25) ;
            service_title.textContent = service_title.textContent.substring(0, service_title.textContent.lastIndexOf(" ")) + "...";
        } else
            service_title.textContent = service_title_text;
        

        //inquire button
        service_inquiry_text.textContent = "Inquire";
    }

    //6
    if (window.innerWidth <= 450 && lastLine != 6) {
            lastLine = 6;
        if (service_title_text.length > 20) {
            service_title.textContent = service_title_text.substring(0, 20) ;
            service_title.textContent = service_title.textContent.substring(0, service_title.textContent.lastIndexOf(" ")) + "...";
        } else
            service_title.textContent = service_title_text;

        //inquire button
        service_inquiry_text.textContent = "Inquire";
    }

}, true);
window.dispatchEvent(new Event('resize'));
