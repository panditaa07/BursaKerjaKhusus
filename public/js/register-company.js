// Register Company JavaScript
(function() {
    'use strict';

    // Initialize when DOM is loaded
    document.addEventListener('DOMContentLoaded', function() {
        initializeForm();
    });

    function initializeForm() {
        const form = document.getElementById('registrationForm');
        const inputs = form.querySelectorAll('input');
        const submitBtn = document.getElementById('submitBtn');

        // Add animation to form elements
        addFormAnimations();

        // Password toggle functionality
        initializePasswordToggle();

        // Password strength indicator
        initializePasswordStrength();

        // Real-time validation
        inputs.forEach(input => {
            input.addEventListener('input', function() {
                validateField(this);
                
                // Update password strength if password field
                if (this.id === 'password') {
                    updatePasswordStrength(this.value);
                }
            });

            input.addEventListener('blur', function() {
                validateField(this);
            });

            input.addEventListener('focus', function() {
                clearFieldError(this);
            });
        });

        // Form submission
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (validateForm()) {
                showLoadingState(submitBtn);
                // Submit form after short delay to show loading animation
                setTimeout(() => {
                    form.submit();
                }, 500);
            }
        });

        // Password confirmation validation
        const password = document.getElementById('password');
        const passwordConfirm = document.getElementById('password_confirmation');

        if (password && passwordConfirm) {
            passwordConfirm.addEventListener('input', function() {
                validatePasswordConfirmation(password.value, this.value, this);
            });
        }
    }

    function addFormAnimations() {
        const container = document.querySelector('.registration-container');
        const formGroups = document.querySelectorAll('.form-group');
        
        // Add entrance animation to container
        container.classList.add('fadeIn');
        
        // Stagger form group animations
        formGroups.forEach((group, index) => {
            setTimeout(() => {
                group.classList.add('slideUp');
            }, index * 100);
        });
    }

    function initializePasswordToggle() {
        const passwordToggles = document.querySelectorAll('.password-toggle');
        
        // If no existing toggles, create them
        if (passwordToggles.length === 0) {
            const passwordFields = document.querySelectorAll('input[type="password"]');
            
            passwordFields.forEach(field => {
                // Wrap password field in container if not already wrapped
                if (!field.parentElement.classList.contains('form-group')) {
                    return; // Skip if not in proper form group structure
                }

                // Create toggle icon - mata tertutup untuk password tersembunyi
                const toggleIcon = document.createElement('span');
                toggleIcon.className = 'password-toggle';
                toggleIcon.innerHTML = '<i class="fas fa-eye-slash"></i>';
                toggleIcon.setAttribute('title', 'Show password');
                
                // Add click event
                toggleIcon.addEventListener('click', function() {
                    togglePasswordVisibility(field, this);
                });
                
                // Insert toggle icon in the form group
                field.parentElement.appendChild(toggleIcon);
            });
        } else {
            // Use existing toggles
            passwordToggles.forEach(toggle => {
                toggle.addEventListener('click', function() {
                    const passwordInput = this.parentElement.querySelector('input[type="password"], input[type="text"]');
                    togglePasswordVisibility(passwordInput, this);
                });
            });
        }
    }

    function togglePasswordVisibility(passwordInput, toggleElement) {
        const icon = toggleElement.querySelector('i');
        
        if (passwordInput.type === 'password') {
            // Password disembunyikan -> ubah jadi terlihat
            passwordInput.type = 'text';
            icon.className = 'fas fa-eye'; // mata terbuka = password terlihat
            toggleElement.setAttribute('title', 'Hide password');
        } else {
            // Password terlihat -> ubah jadi tersembunyi
            passwordInput.type = 'password';
            icon.className = 'fas fa-eye-slash'; // mata tertutup = password tersembunyi
            toggleElement.setAttribute('title', 'Show password');
        }
    }

    function initializePasswordStrength() {
        const passwordInput = document.getElementById('password');
        if (passwordInput) {
            passwordInput.addEventListener('input', function() {
                updatePasswordStrength(this.value);
            });
        }
    }

    function updatePasswordStrength(password) {
        const strengthBar = document.getElementById('strengthBar');
        if (!strengthBar) return;

        const strength = calculatePasswordStrength(password);
        
        // Remove existing classes
        strengthBar.classList.remove('weak', 'medium', 'strong');
        
        if (strength.score === 0) {
            strengthBar.style.width = '0%';
        } else if (strength.score <= 2) {
            strengthBar.classList.add('weak');
        } else if (strength.score <= 3) {
            strengthBar.classList.add('medium');
        } else {
            strengthBar.classList.add('strong');
        }
    }

    function calculatePasswordStrength(password) {
        let score = 0;
        const checks = {
            length: password.length >= 8,
            lowercase: /[a-z]/.test(password),
            uppercase: /[A-Z]/.test(password),
            numbers: /\d/.test(password),
            symbols: /[^A-Za-z0-9]/.test(password)
        };

        // Calculate score
        Object.values(checks).forEach(check => {
            if (check) score++;
        });

        return {
            score: score,
            checks: checks
        };
    }

    function validateField(field) {
        const value = field.value.trim();
        const fieldName = field.getAttribute('name');
        let isValid = true;
        let errorMessage = '';

        // Clear previous errors
        clearFieldError(field);

        // Required field validation
        if (!value) {
            errorMessage = `${getFieldLabel(fieldName)} is required`;
            isValid = false;
        } else {
            // Specific field validations
            switch (fieldName) {
                case 'name':
                    if (value.length < 2) {
                        errorMessage = 'Name must be at least 2 characters';
                        isValid = false;
                    }
                    break;
                
                case 'email':
                    if (!isValidEmail(value)) {
                        errorMessage = 'Please enter a valid email address';
                        isValid = false;
                    }
                    break;
                
                case 'company_name':
                    if (value.length < 2) {
                        errorMessage = 'Company name must be at least 2 characters';
                        isValid = false;
                    }
                    break;
                
                case 'password':
                    const strength = calculatePasswordStrength(value);
                    if (value.length < 8) {
                        errorMessage = 'Password must be at least 8 characters';
                        isValid = false;
                    } else if (strength.score < 3) {
                        errorMessage = 'Password should include uppercase, lowercase, numbers, and symbols';
                        isValid = false;
                    }
                    break;
            }
        }

        if (!isValid) {
            showFieldError(field, errorMessage);
        }

        return isValid;
    }

    function validatePasswordConfirmation(password, confirmation, field) {
        clearFieldError(field);
        
        if (confirmation && password !== confirmation) {
            showFieldError(field, 'Passwords do not match');
            return false;
        }
        
        return true;
    }

    function validateForm() {
        const inputs = document.querySelectorAll('#registrationForm input[required]');
        let isValid = true;

        inputs.forEach(input => {
            if (!validateField(input)) {
                isValid = false;
            }
        });

        // Additional password confirmation check
        const password = document.getElementById('password');
        const passwordConfirm = document.getElementById('password_confirmation');
        
        if (password && passwordConfirm) {
            if (!validatePasswordConfirmation(password.value, passwordConfirm.value, passwordConfirm)) {
                isValid = false;
            }
        }

        return isValid;
    }

    function showFieldError(field, message) {
        field.classList.add('invalid');
        
        // Remove existing error message
        const existingError = field.parentElement.querySelector('.error-message');
        if (existingError) {
            existingError.remove();
        }

        // Create and show new error message
        const errorDiv = document.createElement('div');
        errorDiv.className = 'error-message';
        errorDiv.textContent = message;
        field.parentElement.appendChild(errorDiv);
        
        // Animate error message
        setTimeout(() => {
            errorDiv.classList.add('show');
        }, 10);
    }

    function clearFieldError(field) {
        field.classList.remove('invalid');
        const errorMessage = field.parentElement.querySelector('.error-message');
        if (errorMessage) {
            errorMessage.classList.remove('show');
            setTimeout(() => {
                errorMessage.remove();
            }, 300);
        }
    }

    function showLoadingState(button) {
        button.classList.add('loading');
        button.disabled = true;
        
        const btnText = button.querySelector('.btn-text');
        const spinner = button.querySelector('.loading-spinner');
        
        if (btnText) btnText.textContent = 'Creating Account...';
        if (spinner) spinner.style.display = 'inline-block';
    }

    function hideLoadingState(button) {
        button.classList.remove('loading');
        button.disabled = false;
        
        const btnText = button.querySelector('.btn-text');
        const spinner = button.querySelector('.loading-spinner');
        
        if (btnText) btnText.textContent = 'Create Account';
        if (spinner) spinner.style.display = 'none';
    }

    function showSuccess() {
        const container = document.querySelector('.registration-container');
        const successDiv = document.createElement('div');
        successDiv.className = 'success-message';
        successDiv.innerHTML = '<i class="bi bi-check-circle"></i> Registration successful! Welcome to our platform!';
        
        container.insertBefore(successDiv, container.firstChild);
        
        setTimeout(() => {
            successDiv.classList.add('show');
        }, 10);
    }

    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    function getFieldLabel(fieldName) {
        const labels = {
            'name': 'Full Name',
            'email': 'Email Address',
            'company_name': 'Company Name',
            'password': 'Password',
            'password_confirmation': 'Confirm Password'
        };
        return labels[fieldName] || fieldName;
    }

    // Expose functions to global scope for Laravel integration
    window.RegisterCompany = {
        showSuccess: showSuccess,
        validateForm: validateForm,
        hideLoadingState: hideLoadingState
    };

})();