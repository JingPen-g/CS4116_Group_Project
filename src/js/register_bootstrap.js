console.log("Hello, World!");
document.addEventListener('DOMContentLoaded', function() {
    const passwordIn = document.getElementById('password');
    const re_passwordIn = document.getElementById('re_password');
    // Return a nodelist of all the meter sections
    const passwordMeter = document.querySelectorAll('.meter-section');
    const passwordMeterText = document.getElementById('meter-text');
    const email = document.getElementById('email');
    const form = document.getElementById('register_form');
    let strength = "";

    document.querySelectorAll('input[type="radio"]').forEach(radio => {
        radio.style.pointerEvents = "auto";
        radio.style.opacity = "1";
        radio.style.visibility = "visible";
        radio.style.position = "relative";
        radio.style.zIndex = "1000";
        radio.disabled = false;
    });

    
    email.addEventListener('input', function() {
        if (email.validity.typeMismatch) {
            document.getElementById('error_message_email').textContent = 'Please enter a valid email address.';
        } else {
            document.getElementById('error_message_email').textContent = '';
        }
    });

    form.addEventListener('submit', function(event) {
        // stop the form submission
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
            console.log("Please select!");
            // If no radio button is selected, show an error message
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



    passwordIn.addEventListener('input', function() {
        strength = getPasswordStrength(passwordIn.value);
        console.log("strength", strength); // weak etc
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
});
console.log("Hello, World again!");