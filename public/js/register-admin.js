// Modern Register Admin JavaScript
document.addEventListener('DOMContentLoaded', function() {
    
    // Add Font Awesome for icons if not already included
    if (!document.querySelector('link[href*="font-awesome"]')) {
        const fontAwesome = document.createElement('link');
        fontAwesome.rel = 'stylesheet';
        fontAwesome.href = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css';
        document.head.appendChild(fontAwesome);
    }

    // Create success overlay
    createSuccessOverlay();
    
    // Initialize form enhancements
    initializeFormEnhancements();
    
    // Setup password toggles
    setupPasswordToggles();
    
    // Setup password strength meter
    setupPasswordStrengthMeter();
    
    // Setup form validation
    setupFormValidation();
    
    // Setup form submission
    setupFormSubmission();
    
    // Add input focus effects
    addInputFocusEffects();
});

function createSuccessOverlay() {
    const overlay = document.createElement('div');
    overlay.className = 'success-overlay';
    overlay.id = 'successOverlay';
    overlay.innerHTML = `
        <div class="success-animation">
            <div class="checkmark"></div>
            <h3 style="color: #333; margin: 0 0 10px 0;">Registration Successful!</h3>
            <p style="color: #666; margin: 0;">Your admin account has been created successfully.</p>
        </div>
    `;
    document.body.appendChild(overlay);
}

function initializeFormEnhancements() {
    const form = document.querySelector('form');
    const inputs = form.querySelectorAll('input[type="text"], input[type="email"], input[type="password"]');
    
    // Add IDs and enhance inputs
    inputs.forEach((input, index) => {
        const formGroup = input.closest('.mb-3');
        
        // Add IDs for easier targeting
        switch(input.type) {
            case 'text':
                input.id = 'name';
                break;
            case 'email':
                input.id = 'email';
                break;
            case 'password':
                if (input.name === 'password') {
                    input.id = 'password';
                } else {
                    input.id = 'password_confirmation';
                }
                break;
        }
        
        // Add error message container
        if (!formGroup.querySelector('.error-message')) {
            const errorDiv = document.createElement('div');
            errorDiv.className = 'error-message';
            errorDiv.id = input.id + 'Error';
            formGroup.appendChild(errorDiv);
        }
    });
}

function setupPasswordToggles() {
    const passwordInputs = document.querySelectorAll('input[type="password"]');
    
    passwordInputs.forEach(input => {
        const formGroup = input.closest('.mb-3');
        
        // Create toggle icon
        const toggleIcon = document.createElement('i');
        toggleIcon.className = 'fas fa-eye password-toggle';
        toggleIcon.style.cursor = 'pointer';
        
        // Position the toggle
        formGroup.style.position = 'relative';
        formGroup.appendChild(toggleIcon);
        
        // Add click event
        toggleIcon.addEventListener('click', function() {
            const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
            input.setAttribute('type', type);
            
            // Toggle icon
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    });
}

function setupPasswordStrengthMeter() {
    const passwordInput = document.getElementById('password');
    if (!passwordInput) return;
    
    const formGroup = passwordInput.closest('.mb-3');
    
    // Create strength meter
    const strengthMeter = document.createElement('div');
    strengthMeter.className = 'strength-meter';
    strengthMeter.id = 'strengthMeter';
    
    const strengthBar = document.createElement('div');
    strengthBar.className = 'strength-bar';
    strengthBar.id = 'strengthBar';
    strengthBar.style.width = '0%';
    
    strengthMeter.appendChild(strengthBar);
    formGroup.appendChild(strengthMeter);
    
    // Add password input event
    passwordInput.addEventListener('input', function() {
        const password = this.value;
        
        if (password.length > 0) {
            strengthMeter.classList.add('active');
            
            let strength = 0;
            if (password.length >= 8) strength += 25;
            if (/[a-z]/.test(password)) strength += 25;
            if (/[A-Z]/.test(password)) strength += 25;
            if (/[0-9]/.test(password) || /[^A-Za-z0-9]/.test(password)) strength += 25;
            
            strengthBar.style.width = strength + '%';
            
            // Color coding
            if (strength < 50) {
                strengthBar.style.background = '#ff4757';
            } else if (strength < 75) {
                strengthBar.style.background = '#ffa502';
            } else {
                strengthBar.style.background = '#2ed573';
            }
        } else {
            strengthMeter.classList.remove('active');
        }
    });
}

function setupFormValidation() {
    // Validation rules
    const validationRules = {
        name: {
            validate: (value) => value.trim().length >= 2,
            message: 'Name must be at least 2 characters long'
        },
        email: {
            validate: (value) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value),
            message: 'Please enter a valid email address'
        },
        password: {
            validate: (value) => value.length >= 8,
            message: 'Password must be at least 8 characters long'
        }
    };
    
    // Setup validation for each field
    Object.keys(validationRules).forEach(fieldName => {
        const input = document.getElementById(fieldName);
        if (!input) return;
        
        const rule = validationRules[fieldName];
        
        // Validate on blur
        input.addEventListener('blur', function() {
            validateField(this, rule.validate, rule.message);
        });
        
        // Validate on input if already validated
        input.addEventListener('input', function() {
            if (this.classList.contains('valid') || this.classList.contains('invalid')) {
                validateField(this, rule.validate, rule.message);
            }
        });
    });
    
    // Confirm password validation
    const confirmPasswordInput = document.getElementById('password_confirmation');
    const passwordInput = document.getElementById('password');
    
    if (confirmPasswordInput && passwordInput) {
        confirmPasswordInput.addEventListener('input', function() {
            const password = passwordInput.value;
            const confirmPassword = this.value;
            
            if (confirmPassword.length > 0) {
                if (password === confirmPassword) {
                    setFieldValid(this);
                } else {
                    setFieldInvalid(this, 'Passwords do not match');
                }
            } else {
                clearFieldValidation(this);
            }
        });
        
        // Also validate when main password changes
        passwordInput.addEventListener('input', function() {
            const confirmPassword = confirmPasswordInput.value;
            if (confirmPassword.length > 0) {
                if (this.value === confirmPassword) {
                    setFieldValid(confirmPasswordInput);
                } else {
                    setFieldInvalid(confirmPasswordInput, 'Passwords do not match');
                }
            }
        });
    }
}

function validateField(input, validationFn, errorMsg) {
    if (validationFn(input.value)) {
        setFieldValid(input);
    } else {
        setFieldInvalid(input, errorMsg);
    }
}

function setFieldValid(input) {
    input.classList.remove('invalid');
    input.classList.add('valid');
    const errorElement = document.getElementById(input.id + 'Error');
    if (errorElement) {
        errorElement.textContent = '';
        errorElement.classList.remove('show');
    }
}

function setFieldInvalid(input, message) {
    input.classList.remove('valid');
    input.classList.add('invalid');
    const errorElement = document.getElementById(input.id + 'Error');
    if (errorElement) {
        errorElement.textContent = message;
        errorElement.classList.add('show');
    }
}

function clearFieldValidation(input) {
    input.classList.remove('valid', 'invalid');
    const errorElement = document.getElementById(input.id + 'Error');
    if (errorElement) {
        errorElement.textContent = '';
        errorElement.classList.remove('show');
    }
}

function setupFormSubmission() {
    const form = document.querySelector('form');
    const submitBtn = form.querySelector('button[type="submit"]');
    
    form.addEventListener('submit', function(e) {
        // Add loading state
        submitBtn.classList.add('loading');
        
        // Create loader icon if it doesn't exist
        if (!submitBtn.querySelector('.btn-loader')) {
            const loader = document.createElement('i');
            loader.className = 'fas fa-spinner btn-loader';
            submitBtn.insertBefore(loader, submitBtn.firstChild);
        }
        
        // Change button text
        const originalText = submitBtn.textContent.trim();
        submitBtn.innerHTML = '<i class="fas fa-spinner btn-loader"></i> Creating Account...';
        
        // Add form loading class
        form.classList.add('form-loading');
        
        // For demo purposes, show success after delay
        // Remove this and let the actual form submission handle the response
        setTimeout(() => {
            showSuccessAnimation();
            
            // Reset form after success
            setTimeout(() => {
                submitBtn.classList.remove('loading');
                submitBtn.innerHTML = originalText;
                form.classList.remove('form-loading');
            }, 3000);
        }, 1500);
        
        // Uncomment the line below if you want to prevent actual form submission for testing
        // e.preventDefault();
    });
}

function showSuccessAnimation() {
    const overlay = document.getElementById('successOverlay');
    if (overlay) {
        overlay.style.display = 'flex';
        
        // Hide after 3 seconds
        setTimeout(() => {
            overlay.style.display = 'none';
            // You can add redirect logic here
            // window.location.href = '/login';
        }, 3000);
    }
}

function addInputFocusEffects() {
    const inputs = document.querySelectorAll('.form-control');
    
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            const formGroup = this.closest('.mb-3');
            if (formGroup) {
                formGroup.style.transform = 'scale(1.01)';
                formGroup.style.transition = 'transform 0.3s ease';
            }
        });
        
        input.addEventListener('blur', function() {
            const formGroup = this.closest('.mb-3');
            if (formGroup) {
                formGroup.style.transform = 'scale(1)';
            }
        });
    });
}

// Utility functions for external use
window.RegisterAdmin = {
    showSuccess: showSuccessAnimation,
    validateForm: function() {
        const inputs = document.querySelectorAll('.form-control');
        let isValid = true;
        
        inputs.forEach(input => {
            if (input.classList.contains('invalid') || !input.value.trim()) {
                isValid = false;
            }
        });
        
        return isValid;
    },
    clearValidation: function() {
        const inputs = document.querySelectorAll('.form-control');
        inputs.forEach(clearFieldValidation);
    }
};