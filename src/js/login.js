document.addEventListener('DOMContentLoaded', function() {
    const loginButton = document.getElementById('login');
    const errorMessage = document.getElementById('error_message');

    if (loginButton) {
        loginButton.style.pointerEvents = "auto";
        loginButton.style.opacity = "1";
        loginButton.style.visibility = "visible";
        loginButton.style.position = "relative";
        loginButton.style.zIndex = "1000";
        loginButton.disabled = false;
    }

    document.getElementById('username').addEventListener('input', function() {
        const username = this.value;
        const sanitizedInput = username.replace(/<[^>]*>/g, '');
        if (username !== sanitizedInput) {
            errorMessage.textContent = 'HTML tags are not allowed';
            errorMessage.style.setProperty('color', '#ff0000', 'important');
            loginButton.disabled = true;
            return;
        }
    });

    const form = document.getElementById('login_form');
    form.addEventListener('submit', function(event) {
        // stop the form submission
        event.preventDefault();

        if (!form.checkValidity()) {
            form.classList.add('was-validated');
            return; // Stop further execution if the form is invalid
        }

        const formData = new FormData(form);
        fetch('/api/users.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                console.log('Response data:', data);
                if (data.status === 'success') {
                    const modalHtml = `
                        <div class="modal fade show" id="successModal" tabindex="-1" aria-hidden="true" style="display: block;">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Success</h5>
                                    </div>
                                    <div class="modal-body">
                                        <p>${data.message}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    document.body.insertAdjacentHTML('beforeend', modalHtml);

                    setTimeout(() => {
                        window.location.href = data.redirect;
                    }, 500);
                } else if (data.status === 'error') {
                    if (errorMessage) {
                        console.log('Error message:', data.message);
                        errorMessage.innerHTML = data.message;
                    }
                }
                
            })
            .catch(error => {
                console.error('Error:', error);
                if (error.message.includes('504')) {
                    errorMessage.innerHTML = 'The server took too long to respond. Please try again later.';
        } else {
            errorMessage.innerHTML = 'An unexpected error occurred. Please try again.';
        }
        });
    });
});
