document.addEventListener('DOMContentLoaded', function() {
    const registerButton = document.getElementById('register');

    if (registerButton) {
        registerButton.style.pointerEvents = "auto";
        registerButton.style.opacity = "1";
        registerButton.style.visibility = "visible";
        registerButton.style.position = "relative";
        registerButton.style.zIndex = "1000";
        registerButton.disabled = false;
    }
    const usernameErr = document.getElementById('usernameErr');
    const passwordIn = document.getElementById('password');
    const re_passwordIn = document.getElementById('re_password');
    // Return a nodelist of all the meter sections
    const passwordMeter = document.querySelectorAll('.meter-section');
    const passwordMeterText = document.getElementById('meter-text');
    const email = document.getElementById('email');
    const emailErr = document.getElementById('emailErr');
    const form = document.getElementById('register_form');
    let strength = "";
    
    

    async function checkUsernameAvalibility(username) {
        if (usernameErr.textContent === 'HTML tags are not allowed') {
            return;
        }
        try {
            let response = await fetch(`/api/users.php?username=${encodeURIComponent(username)}`);
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            let data = await response.json();
            if (data.message === "Username already exists") {
                usernameErr.textContent = 'Username is already taken';
                usernameErr.style.setProperty('color', '#ff0000', 'important');
                registerButton.disabled = true;
            } else if (data.message === "User not found") {
                usernameErr.style.setProperty('color', '#38CF63', 'important');
                usernameErr.textContent = 'username is available';
                registerButton.disabled = false;
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }

    async function checkEmailAvalibility(email) {
        try {
            let response = await fetch(`/api/users.php?email=${encodeURIComponent(email)}`);
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            let data = await response.json();
            if (data.message === "Email already exists") {
                emailErr.textContent = 'You have already registered with this email.';
                emailErr.style.setProperty('color', '#ff0000', 'important');
                email.innerHTML = '';
            } else {
                emailErr.style.setProperty('color', '#38CF63', 'important');
                emailErr.textContent = 'Email is available';
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }

    document.getElementById("email").addEventListener("input", function() {
        let email = this.value;
        console.log("email", email);
        checkEmailAvalibility(email);
    });

    document.getElementById("username").addEventListener("input", function() {
        console.log("Input event triggered for username:", this.value);
        let username = this.value;
        const sanitizedInput = username.replace(/<[^>]*>/g, '');
        if (username !== sanitizedInput) {
            usernameErr.textContent = 'HTML tags are not allowed';
            usernameErr.style.setProperty('color', '#ff0000', 'important');
            registerButton.disabled = true;
            return;
        }

        if (username.length > 50) { 
            usernameErr.textContent = 'Username cannot exceed 50 characters';
            usernameErr.style.setProperty('color', '#ff0000', 'important');
            registerButton.disabled = true;
            return;
        }
        if (username.length > 2) { // Avoid too many requests
            checkUsernameAvalibility(username);
            
        }
    });

    email.addEventListener('input', function() {
        if (email.validity.typeMismatch) {
            emailErr.textContent = 'Please enter a valid email address.';
        } else {
            emailErr.textContent = '';
        }
    });

    console.log('Form element:', form);
    form.addEventListener('submit', function(event) {
        // stop the form submission
        console.log('Form submitted');
        event.preventDefault();

        if (!form.checkValidity()) {
            form.classList.add('was-validated');
            return; // Stop further execution if the form is invalid
        }
        if (strength === 'weak' || strength === 'medium') {
            passwordMeterText.textContent = 'Please choose a strong password.';
            passwordIn.classList.remove('is-valid');  // Remove Bootstrap green tick
            passwordIn.classList.add('is-invalid');   // Add Bootstrap red cross
            return;
        } 
        // Check if any radio button is selected
        const userTypeSelected = document.querySelector('input[name="usertype"]:checked');

        if (!userTypeSelected) {
            document.getElementById('error_message_radio').textContent = 'Please select a user type.';
            return; 
        } else {
            document.getElementById('error_message_radio').textContent = '';
        }

        form.classList.add('was-validated');
        
        const formData = new FormData(form);
        fetch('/api/users.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
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
                    window.location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    });



    passwordIn.addEventListener('input', function() {
        strength = getPasswordStrength(passwordIn.value);
        updateMeter(strength);
    });

    re_passwordIn.addEventListener('input', function() {
        if (re_passwordIn.value !== passwordIn.value) {
            document.getElementById('error_message_re').textContent = 'Passwords do not match.';
        } else {
            document.getElementById('error_message_re').textContent = '';
        }
    });

    function getPasswordStrength(password) {
        let strength = 0;

        if (password.length < 8) {
            passwordMeterText.textContent = 'Your password is too short';
            return 'weak';
        }

        const hasUppercase = /(?=.*[A-Z])/.test(password);
        const hasLowercase = /(?=.*[a-z])/.test(password);
        const hasNumber = /(?=.*[0-9])/.test(password);
        const hasSpecial = /(?=.*[\W_])/.test(password);    

        const conditions = [hasUppercase, hasLowercase, hasNumber, hasSpecial];
        const numConditions = conditions.filter(bool => bool).length;   

        if (numConditions < 2) {
            passwordMeterText.textContent = 'Your password is too short or missing one or more criteria.';
            return 'weak';
        }

        if (/(?=.*[A-Z])/.test(password) === true) {
            strength++;
        }
        if (/(?=.*[a-z])/.test(password) === true) {
            strength++;
        }
        if (/(?=.*[0-9])/.test(password) === true) {
            strength++;
        }
        if (/(?=.*[\W_])/.test(password) === true) {
            strength++;
        }

        if (strength === 1) {
            passwordMeterText.style.color = '#ff0000';
            return 'weak';
        }
        if (strength === 2) {
            passwordMeterText.classList.remove('text-danger');
            passwordMeterText.style.color = '#ff9900';
            passwordMeterText.textContent = 'Your password is decent, but with more mix criteria would make it stronger.';
            return 'medium';
        }
        if (strength === 3) {
            passwordMeterText.classList.remove('text-danger');
            passwordMeterText.style.color = '#00ff00';
            passwordMeterText.textContent = 'Great! Your password is strong.';
            return 'strong';
        }
        if (strength >= 4) {
            passwordMeterText.classList.remove('text-danger');
            passwordMeterText.style.color = '#15cc15';
            passwordMeterText.textContent = 'Excellent! Your password is very strong.';
            return 'very-strong';
        }

        
    }

    function updateMeter(strength) {
        const strengthLevels = ['weak', 'medium', 'strong', 'very-strong'];
        const strengthIndex = strengthLevels.indexOf(strength);

        passwordMeter.forEach(meter => {
            // Remove any existing strength classes
            meter.classList.remove('weak', 'medium', 'strong', 'very-strong');
            
        });
        // Add the new strength class
        for (let i = 0; i <= strengthIndex; i++) {
            passwordMeter[i].classList.add(strengthLevels[i]);
        }
    }

    document.querySelectorAll('input[type="radio"]').forEach(radio => {
        radio.style.pointerEvents = "auto";
        radio.style.opacity = "1";
        radio.style.visibility = "visible";
        radio.style.position = "relative";
        radio.style.zIndex = "1000";
        radio.disabled = false;
    });
    
});
