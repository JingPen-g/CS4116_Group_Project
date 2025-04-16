console.log("Hello, World login!");

document.getElementById("exist_convo").addEventListener("click", openExisting);



document.getElementById("send_button").addEventListener("click", function(){
    if(input){

    }
    const formData = new FormData(form);
        fetch('/api/messages.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            
            if(data.status = success){
                const html = t;
            }
            else if (data.status === 'error') {
            window.location.reload();
        }
    })


});

function openExisting(){
    alert("button works")
    window.location.href = "front-end/messaging/convo.php";
    /*
    fetch('/api/users.php', {
            method: 'POST',
            body: formData
        })

    
    
    
    */
}


