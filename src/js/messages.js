console.log("Hello, World login!");



btns = document.getElementsByClassName("convo-button");
console.log(btns);

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.convo-button').forEach(function(button) {
        button.addEventListener('click', function() {
            const userId = this.getAttribute('data-user-id');
            const otherId = this.getAttribute('data-other-id');
            openExisting(userId, otherId);

        });
    });
});


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
// document.getElementById("reject").addEventListener("click", function(){
//     alert("rejected")

//     fetch('/messaging', {
//         method: 'POST',
//         headers: {
//             'Content-Type': 'application/json'
//         },
//         body: JSON.stringify({
//             method: 'insertmessage',
//             userId: userId,
//             otherId: otherId,
//             message: message
//         })
//     })
//     .then(response => response.text())
//     .then(data => {
//         console.log('Response from PHP:', data);
        
//     })
//     .catch(error => {
//         console.error('Error:', error);
//     });
//     fetch()


// }
// )

/*document.getElementById("send_button").addEventListener("click", function(){
    alert("button works");
    var userId = 1; 
    var otherId = 2;      
    var message = document.getElementById("message").value;
    console.log(message);

    fetch('/api/messaging.php', {
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
    fetch('/api/messaging.php', {
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
})*/

function openExisting(userId ,otherId) {
    alert("Button clicked with otherId: " + otherId);

    fetch('/api/messaging.php', {
        method: 'PUT',
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
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
    function send_button(userId, otherId) {
        alert("button works");    
        var message = document.getElementById("message").value;
        console.log(message);
        console.log(userId);
        console.log(otherId);

        fetch('/api/messaging.php', {
            method: 'POST',
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: new URLSearchParams({
                method: 'insertmessage',
                userId: userId,
                otherId: otherId,
                message: message
            }),
        })
        .then(response => console.log(response.text()))
        .then(data => {
            console.log('Response from PHP:', data);
            document.getElementById("message").value = "";
    
            // if (data.includes("Conversation must be accepted")) {
            //     alert(data);
            // }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
function report(){

}
function accept(userId, otherId) {
    var acceptReject = document.getElementById("pending");
    var responseValue = 0; 
    acceptReject.className = "pending-hidden";

    fetch('/api/messaging.php', {
        method: 'POST',
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: new URLSearchParams({
            method: 'insertmessage',
            userId: userId,
            otherId: otherId,
            message: "ACCEPTED123"
        }),
    })
    .then(response => console.log(response.text()))
    .then(data => {
        console.log('Response from PHP:', data);
        document.getElementById("message").value = "";

        // if (data.includes("Conversation must be accepted")) {
        //     alert(data);
        // }
    })
    .catch(error => {
        console.error('Error:', error);
    });
    
}
function reject(userId, otherId) {
    var acceptReject = document.getElementById("pending");
    var responseValue = 1; 
    acceptReject.className = "pending-hidden";

    fetch('/api/messaging.php', {
        method: 'POST',
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: new URLSearchParams({
            method: 'insertmessage',
            userId: userId,
            otherId: otherId,
            message: "REJECTED123"
        }),
    })
    .then(response => console.log(response.text()))
    .then(data => {
        console.log('Response from PHP:', data);
        document.getElementById("message").value = "";

        // if (data.includes("Conversation must be accepted")) {
        //     alert(data);
        // }
    })
    .catch(error => {
        console.error('Error:', error);
    });
    
}