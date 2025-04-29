console.log("Hello, World login!");



btns = document.getElementsByClassName("convo-button");
console.log(btns);

for (var i = 0; i < btns.length; i++) {
    btns[i].addEventListener("click", function() {
        openExisting(userId, otherId);
    });
}


/*document.addEventListener("DOMContentLoaded", function() {
    var acceptReject = document.getElementById("pending");
    document.getElementById("accept").addEventListener("click", function(userId, otherId) {
        var message = "ACCEPTED";
        alert("accepted");
        acceptReject.className = "pending-hidden";
        fetch('/messaging', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                method: 'insertNewMessage',
                userId: userId,
                otherId: otherId,
                message: message
            })
        })
        .then(response => response.text())
        .then(data => {
            console.log('Response from PHP:', data);
            document.getElementById("message").value = "";
    
            if (data.includes("Conversation must be accepted")) {
                alert(data);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
        
    });
});*/
document.getElementById("reject").addEventListener("click", function(){
    alert("rejected")

    fetch('/messaging', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            method: 'insertmessage',
            userId: userId,
            otherId: otherId,
            message: message
        })
    })
    .then(response => response.text())
    .then(data => {
        console.log('Response from PHP:', data);
        
    })
    .catch(error => {
        console.error('Error:', error);
    });
    fetch()


}
)

document.getElementById("send_button").addEventListener("click", function(){
    alert("button works");
    var userId = 1; 
    var otherId = 2;      
    var message = document.getElementById("message").value;
    console.log(message);

    fetch('/messaging', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            method: 'insertNewMessage',
            userId: userId,
            otherId: otherId,
            message: message
        })
    })
    .then(response => response.text())
    .then(data => {
        console.log('Response from PHP:', data);
        document.getElementById("message").value = "";

        if (data.includes("Conversation must be accepted")) {
            alert(data);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
    ('/messaging', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            method: 'genereate_convo;',
            convo: userId
        })
    })
    .then(response => response.text())
    .then(data => {
        console.log('Response from PHP:', data);
        
    })
    .catch(error => {
        console.error('Error:', error);
    });
})

function openExisting(userId ,otherId) {
    alert("Button clicked with otherId: " + otherId);

    fetch('/messaging', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            method: 'setCurrentConversation',
            userId: userId,
            otherId: otherId
        })
    })
    .then(response => response.text())
    .then(data => {
        console.log('Response from PHP:', data);
        
    })
    .catch(error => {
        console.error('Error:', error);
    });

}
function send_button(userId, otherId){
    alert("button works");    
    var message = document.getElementById("message").value;
    console.log(message);

    fetch('/messaging', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            method: 'insertNewMessage',
            userId: userId,
            otherId: otherId,
            message: message
        })
    })
    .then(response => response.text())
    .then(data => {
        console.log('Response from PHP:', data);
        document.getElementById("message").value = "";

        if (data.includes("Conversation must be accepted")) {
            alert(data);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
    ('/messaging', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            method: 'genereate_convo;',
            convo: userId
        })
    })
    .then(response => response.text())
    .then(data => {
        console.log('Response from PHP:', data);
        
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
function report(){

}
function accept(userId, otherId) {
    var acceptReject = document.getElementById("pending");
    var message = "ACCEPTED";
    alert("accepted");
    acceptReject.className = "pending-hidden";
    fetch('/messaging', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            method: 'insertNewMessage',
            userId: userId,
            otherId: otherId,
            message: message
        })
    })
    .then(response => response.text())
    .then(data => {
        console.log('Response from PHP:', data);
    })
    .catch(error => {
        console.error('Error:', error);
    });
    
}