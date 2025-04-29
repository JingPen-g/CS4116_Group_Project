document.addEventListener('DOMContentLoaded', function() {
    const allReviews = document.getElementById('reviews');
    const allMessages = document.getElementById('messages');
    const allUsers = document.getElementById('all-users');

    if (allUsers) {
        allUsers.addEventListener('click', function() {
            fetch('/api/admins.php?action=getAllUsers', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                displayUsers(data);
            })
            .catch(error => {
                console.error('There was a problem with the fetch operation:', error);
            });
        });
    }


    if (allMessages) {
        allMessages.addEventListener('click', function() {
            fetch('/api/admins.php?action=getAllMessages', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                displayMassages(data);
            })
            .catch(error => {
                console.error('There was a problem with the fetch operation:', error);
            });
        });
    }

    if (allReviews) {
        allReviews.addEventListener('click', function() {
            fetch('/api/admins.php?action=getAllReviews', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                displayReviews(data);
            })
            .catch(error => {
                console.error('There was a problem with the fetch operation:', error);
            });
        });
    }    


    const bannedReviews = document.getElementById('banned-reviews');

    if (bannedReviews) {
        bannedReviews.addEventListener('click', function() {
            fetch(`/api/admins.php?action=getAllBannedReviews&Banned=1`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                displayBannedReviews(data);
            })
            .catch(error => {
                console.error('There was a problem with the fetch operation:', error);
            });
        });
    } 
    
    
    const bannedMessages = document.getElementById('banned-messages');

    if (bannedMessages) {
        bannedMessages.addEventListener('click', function() {
            fetch(`/api/admins.php?action=getAllBannedMessages&Banned=1`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                displayBannedMessages(data);
            })
            .catch(error => {
                console.error('There was a problem with the fetch operation:', error);
            });
        });
    } 
});

async function displayUsers(data) {
    const visiblePanel = document.querySelector('.content-panel.active');
    const tbody = visiblePanel.querySelector('.users-table tbody');
    tbody.innerHTML = '';
    data.users.forEach(user => {    
        const button = document.createElement('button');
        
        button.className = 'btn btn-danger';
        
        const row = document.createElement('tr');
        row.classList.add('userList');
        row.innerHTML = `
            <td>${user.Name}</td>
            <td>regular user</td>
            <td></td>`; 

        button.textContent = 'Ban User';
        if (Number(user.Banned) === 1) {
            button.disabled = true;
            button.classList.remove('btn-danger');
            button.classList.add('btn-secondary');
            button.textContent = 'Banned';
        }
        if (user.Users_ID) {
            button.addEventListener('click', () => banRegularUser(button, user.Users_ID, 1));
        }

        row.querySelector('td:last-child').appendChild(button);
        tbody.appendChild(row);      
    });

    data.businesses.forEach(business => {    
        const button = document.createElement('button');
        
        button.className = 'btn btn-danger';
        
        const row = document.createElement('tr');
        row.classList.add('userList');
        row.innerHTML = `
            <td>${business.Name}</td>
            <td>business user</td>
            <td></td>`; 

        button.textContent = 'Ban User';
        if (Number(business.Banned) === 1) {
            button.disabled = true;
            button.classList.remove('btn-danger');
            button.classList.add('btn-secondary');
            button.textContent = 'Banned';
        }
        if (business.Business_ID) {
            button.addEventListener('click', () => banBussinessUser(button, business.Business_ID, 1));
        }

        row.querySelector('td:last-child').appendChild(button);
        tbody.appendChild(row);      
    });
}

async function banRegularUser(button, userId, banned) {
    fetch('/api/admins.php?action=banRegularUser', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            Users_ID: userId,
            Banned: banned
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            button.disabled = true;
            button.classList.remove('btn-danger');
            button.classList.add('btn-secondary');
            button.textContent = 'Banned';
        } else {
            alert('Failed to ban user.');
        }
        
    });
}

async function banBussinessUser(button, businessId, banned) {
    fetch('/api/admins.php?action=banBussinessUser', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            Business_ID: businessId,
            Banned: banned
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            button.disabled = true;
            button.classList.remove('btn-danger');
            button.classList.add('btn-secondary');
            button.textContent = 'Banned';
        } else {
            alert('Failed to ban user.');
        }
        
    });
}

async function displayBannedMessages(data) {
    displayMassages(data);
}


async function displayMassages (data) {
    const visiblePanel = document.querySelector('.content-panel.active');

    const tbody = visiblePanel.querySelector('.messages-table tbody');
    tbody.innerHTML = '';

    data.forEach(message => {
        const button = document.createElement('button');
        
        button.className = 'btn btn-danger';
        
        const row = document.createElement('tr');
        row.classList.add('messageList');
        const date = new Date(message.Timestamp);
        row.innerHTML = `
            <td>${message.Receiver_ID}</td>
            <td>${message.Sender_ID}</td>
            <td>${message.Message}</td>   
            <td>${date.toLocaleString()}</td>
            <td></td>`;        

            button.textContent = 'Remove';
            if (Number(message.Banned) === 1) {
                button.disabled = true;
                button.classList.remove('btn-danger');
                button.classList.add('btn-secondary');
                button.textContent = 'Removed';
            }
            
            button.addEventListener('click', () => RemoveMessage(button, message.Message_ID, 1));

            row.querySelector('td:last-child').appendChild(button);
            tbody.appendChild(row);

    });
}

function RemoveMessage(button, messageId, banned) {
    fetch('/api/admins.php?action=removeMessage', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          Message_ID: messageId,
          Banned: banned
        })
      })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            button.disabled = true;
            button.classList.remove('btn-danger');
            button.classList.add('btn-secondary');
            button.textContent = 'Removed';
        } else {
            alert('Failed to remove message.');
        }
        
    });
}

async function displayBannedReviews(data) {
    displayReviews(data);
}

async function displayReviews(data) {
    const visiblePanel = document.querySelector('.content-panel.active');

    const tbody = visiblePanel.querySelector('.reviews-table tbody');
    tbody.innerHTML = '';

    data.forEach(review => {
        const button = document.createElement('button');
        button.className = 'btn btn-danger';
        
        const row = document.createElement('tr');
        row.classList.add('reviewList');
        row.innerHTML = `
            <td>${review.Users_ID}</td>
            <td>${review.Service_ID}</td>
            <td>${review.Comment}</td>   
            <td>${review.Response}</td>
            <td></td>`;        

            button.textContent = 'Remove';
            if (Number(review.Banned) === 1) {
                button.disabled = true;
                button.classList.remove('btn-danger');
                button.classList.add('btn-secondary');
                button.textContent = 'Removed';
            }
            
            button.addEventListener('click', () => RemoveReview(button, review.Review_ID, 1));

            row.querySelector('td:last-child').appendChild(button);
            tbody.appendChild(row);

    });
}

function RemoveReview(button, reviewId, banned) {
    fetch('/api/admins.php?action=removeReview', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          Review_ID: reviewId,
          Banned: banned
        })
      })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            button.disabled = true;
            button.classList.remove('btn-danger');
            button.classList.add('btn-secondary');
            button.textContent = 'Removed';
            
        } else {
            alert('Failed to remove review.');
        }
        
    });
}
    
function showPanel(panelId) {
    
    document.querySelectorAll('.content-panel').forEach(panel => {
      panel.classList.remove('active');
    });
    document.getElementById('panel-' + panelId).classList.add('active');
}


function manualSearch() {
    const value = document.getElementById('search').value.toLowerCase();
    document.querySelectorAll('.messageList').forEach(row => {
      const text = row.textContent.toLowerCase();
      row.style.display = text.includes(value) ? '' : 'none';
    });
}