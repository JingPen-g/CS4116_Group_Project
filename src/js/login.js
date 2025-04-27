console.log("Hello, World login!");
document.addEventListener('DOMContentLoaded', function() {
    const loginButton = document.getElementById('login');

    if (loginButton) {
        loginButton.style.pointerEvents = "auto";
        loginButton.style.opacity = "1";
        loginButton.style.visibility = "visible";
        loginButton.style.position = "relative";
        loginButton.style.zIndex = "1000";
        loginButton.disabled = false;
    }

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
                if (data.status === 'success') {
                    // Show success message in a modal
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

                    // Redirect after 1 second
                    setTimeout(() => {
                        window.location.href = data.redirect;
                    }, 1000);
                } else if (data.status === 'error') {
                    // Reload the page to display session-based errors
                    window.location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    });
});
