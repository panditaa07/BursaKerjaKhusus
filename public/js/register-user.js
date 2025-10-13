// Register User JavaScript
(function() {
    'use strict';

    // Initialize when DOM is loaded
    document.addEventListener('DOMContentLoaded', function() {
        initializeForm();
    });

    function initializeForm() {
        const form = document.getElementById('registrationForm');
        const inputs = form.querySelectorAll('input');
        const submitBtn = form.querySelector('button[type="submit"]');

        // Add animation to form elements
        addFormAnimations();

        // Initialize password toggle functionality
        initializePasswordToggle();

        // Real-time validation
        inputs.forEach(input => {
            input.addEventListener('input', function() {
                validateField(this);
                
                // Format NIK/NISN as user types
                if (this.id === 'nik_nisn') {
                    formatNikNisn(this);
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
        const card = document.querySelector('.card');
        const formGroups = document.querySelectorAll('.mb-3');
        
        // Add entrance animation to card
        card.classList.add('fadeIn');
        
        // Stagger form group animations
        formGroups.forEach((group, index) => {
            setTimeout(() => {
                group.classList.add('slideUp');
            }, index * 100);
        });
    }

    function initializePasswordToggle() {
        // Add password toggle icons to password fields
        const passwordFields = document.querySelectorAll('input[type="password"]');
        
        passwordFields.forEach(field => {
            // Wrap password field in container if not already wrapped
            if (!field.parentElement.classList.contains('password-field')) {
                const wrapper = document.createElement('div');
                wrapper.className = 'password-field';
                field.parentNode.insertBefore(wrapper, field);
                wrapper.appendChild(field);
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
            
            // Insert toggle icon after the input field
            field.parentElement.appendChild(toggleIcon);
        });
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

    function formatNikNisn(input) {
        // Remove all non-numeric characters
        let value = input.value.replace(/\D/g, '');
        
        // Limit to 16 digits for NIK or 10 digits for NISN
        if (value.length > 16) {
            value = value.substring(0, 16);
        }
        
        // Format with spaces for readability (NIK format: XXXX XXXX XXXX XXXX)
        if (value.length > 12) {
            value = value.replace(/(\d{4})(\d{4})(\d{4})(\d{0,4})/, '$1 $2 $3 $4').trim();
        } else if (value.length > 8) {
            value = value.replace(/(\d{4})(\d{4})(\d{0,4})/, '$1 $2 $3').trim();
        } else if (value.length > 4) {
            value = value.replace(/(\d{4})(\d{0,4})/, '$1 $2').trim();
        }
        
        input.value = value;
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
                    } else if (!/^[a-zA-Z\s]+$/.test(value)) {
                        errorMessage = 'Name should only contain letters and spaces';
                        isValid = false;
                    }
                    break;
                
                case 'email':
                    if (!isValidEmail(value)) {
                        errorMessage = 'Please enter a valid email address';
                        isValid = false;
                    }
                    break;
                
                case 'nik_nisn':
                    const cleanValue = value.replace(/\s/g, ''); // Remove spaces
                    if (!/^\d+$/.test(cleanValue)) {
                        errorMessage = 'NIK/NISN should only contain numbers';
                        isValid = false;
                    } else if (cleanValue.length < 10) {
                        errorMessage = 'NIK/NISN must be at least 10 digits';
                        isValid = false;
                    } else if (cleanValue.length > 16) {
                        errorMessage = 'NIK/NISN must not exceed 16 digits';
                        isValid = false;
                    }
                    break;
                
                case 'password':
                    if (value.length < 8) {
                        errorMessage = 'Password must be at least 8 characters';
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
        
        if (btnText) btnText.textContent = 'Registering...';
        if (spinner) spinner.style.display = 'inline-block';
    }

    function hideLoadingState(button) {
        button.classList.remove('loading');
        button.disabled = false;
        
        const btnText = button.querySelector('.btn-text');
        const spinner = button.querySelector('.loading-spinner');
        
        if (btnText) btnText.textContent = 'Register';
        if (spinner) spinner.style.display = 'none';
    }

    function showSuccess() {
        const cardBody = document.querySelector('.card-body');
        const successDiv = document.createElement('div');
        successDiv.className = 'success-message';
        successDiv.innerHTML = '<i class="bi bi-check-circle"></i> Registration successful! Welcome!';
        
        cardBody.insertBefore(successDiv, cardBody.firstChild);
        
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
            'nik_nisn': 'NIK/NISN',
            'password': 'Password',
            'password_confirmation': 'Confirm Password'
        };
        return labels[fieldName] || fieldName;
    }

    // Expose functions to global scope for Laravel integration
    window.RegisterUser = {
        showSuccess: showSuccess,
        validateForm: validateForm,
        hideLoadingState: hideLoadingState
    };

})();