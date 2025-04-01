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

    email.addEventListener('input', function() {
        if (email.validity.typeMismatch) {
            document.getElementById('error_message_email').textContent = 'Please enter a valid email address.';
        } else {
            document.getElementById('error_message_email').textContent = '';
        }
    });

    form.addEventListener('submit', function(event) {
        if (!form.checkValidity()) {
            // stop the form submission
            event.preventDefault();
        }
        if (strength === 'weak' || strength === 'medium') {
            passwordMeterText.textContent = 'Please choose a strong password.';
            passwordIn.classList.remove('is-valid');  // Remove Bootstrap green tick
            passwordIn.classList.add('is-invalid');   // Add Bootstrap red cross
            event.preventDefault();
        } 
        form.classList.add('was-validated');
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
            passwordMeterText.style.color = '#ff9900';
            passwordMeterText.textContent = 'Your password is decent, but with more mix criteria would make it stronger.';
            return 'medium';
        }
        if (strength === 3) {
            passwordMeterText.style.color = '#00ff00';
            passwordMeterText.textContent = 'Great! Your password is strong.';
            return 'strong';
        }
        if (strength >= 4) {
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