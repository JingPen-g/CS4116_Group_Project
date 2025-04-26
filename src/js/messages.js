console.log("Hello, World login!");



btns = document.getElementsByClassName("convo-button");
for(var i = 0; i < btns; i++){
    btns[i].addEventListener("click", function(){
        alert("button works"); 
    }) 

    
}

document.getElementById("send_button").addEventListener("click", function(){
    alert("button works")
    const formData = new FormData(form);
    fetch('/api/messages.php', {
        method: 'POST',
        body: formData
    })
    then

})
/*document.getElementById("button").addEventListener("click", function(){
    alert("button works")
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
*/
function openExisting(){
    alert("button works")
    window.location.href = "front-end/messaging/convo.php";
    
    fetch('/api/users.php', {
            method: 'POST',
            body: formData
        })

    
    
    
        
}


