// Register Company JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const form = document.getElementById('registrationForm');
    const submitBtn = document.getElementById('submitBtn');
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('password_confirmation');
    const strengthBar = document.getElementById('strengthBar');
    const passwordToggles = document.querySelectorAll('.password-toggle');
    
    // Password strength checker
    function checkPasswordStrength(password) {
        let strength = 0;
        let strengthText = '';
        
        // Length check
        if (password.length >= 8) strength++;
        if (password.length >= 12) strength++;
        
        // Character variety checks
        if (/[a-z]/.test(password)) strength++;
        if (/[A-Z]/.test(password)) strength++;
        if (/[0-9]/.test(password)) strength++;
        if (/[^A-Za-z0-9]/.test(password)) strength++;
        
        // Determine strength level
        if (strength < 3) {
            strengthText = 'weak';
        } else if (strength < 5) {
            strengthText = 'medium';
        } else {
            strengthText = 'strong';
        }
        
        return {
            score: strength,
            level: strengthText
        };
    }
    
    // Update password strength indicator
    function updatePasswordStrength() {
        const password = passwordInput.value;
        
        if (password.length === 0) {
            strengthBar.className = 'password-strength-bar';
            return;
        }
        
        const strength = checkPasswordStrength(password);
        strengthBar.className = `password-strength-bar ${strength.level}`;
    }
    
    // Password toggle functionality
    passwordToggles.forEach(toggle => {
        toggle.addEventListener('click', function() {
            const passwordField = this.previousElementSibling;
            const icon = this.querySelector('i');
            
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                passwordField.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        });
    });
    
    // Real-time validation
    function validateField(field, validationFunction) {
        const formGroup = field.closest('.form-group');
        
        field.addEventListener('blur', function() {
            const isValid = validationFunction(this.value);
            
            formGroup.classList.remove('error', 'success');
            
            if (this.value.length > 0) {
                if (isValid) {
                    formGroup.classList.add('success');
                } else {
                    formGroup.classList.add('error');
                }
            }
        });
        
        field.addEventListener('input', function() {
            if (formGroup.classList.contains('error')) {
                const isValid = validationFunction(this.value);
                if (isValid) {
                    formGroup.classList.remove('error');
                    formGroup.classList.add('success');
                }
            }
        });
    }
    
    // Validation functions
    const validations = {
        name: (value) => value.trim().length >= 2,
        email: (value) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value),
        company_name: (value) => value.trim().length >= 2,
        password: (value) => {
            const strength = checkPasswordStrength(value);
            return strength.score >= 3;
        },
        password_confirmation: (value) => value === passwordInput.value && value.length > 0
    };
    
    // Apply validation to fields
    Object.keys(validations).forEach(fieldName => {
        const field = document.getElementById(fieldName);
        if (field) {
            validateField(field, validations[fieldName]);
        }
    });
    
    // Password strength indicator
    if (passwordInput) {
        passwordInput.addEventListener('input', updatePasswordStrength);
    }
    
    // Confirm password validation
    if (confirmPasswordInput) {
        confirmPasswordInput.addEventListener('input', function() {
            const formGroup = this.closest('.form-group');
            
            formGroup.classList.remove('error', 'success');
            
            if (this.value.length > 0) {
                if (this.value === passwordInput.value) {
                    formGroup.classList.add('success');
                } else {
                    formGroup.classList.add('error');
                }
            }
        });
    }
    
    // Form submission with loading state
    if (form) {
        form.addEventListener('submit', function(e) {
            // Show loading state
            submitBtn.classList.add('loading');
            submitBtn.disabled = true;
            
            // Validate all fields before submission
            let isFormValid = true;
            const requiredFields = ['name', 'email', 'company_name', 'password', 'password_confirmation'];
            
            requiredFields.forEach(fieldName => {
                const field = document.getElementById(fieldName);
                const formGroup = field?.closest('.form-group');
                
                if (field && validations[fieldName]) {
                    const isValid = validations[fieldName](field.value);
                    
                    if (!isValid) {
                        isFormValid = false;
                        formGroup?.classList.add('error');
                        formGroup?.classList.remove('success');
                    }
                }
            });
            
            // If form is not valid, prevent submission and remove loading state
            if (!isFormValid) {
                e.preventDefault();
                submitBtn.classList.remove('loading');
                submitBtn.disabled = false;
                
                // Scroll to first error
                const firstError = document.querySelector('.form-group.error');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    const input = firstError.querySelector('input');
                    if (input) input.focus();
                }
                
                return false;
            }
            
            // Form is valid, allow submission
            // Loading state will be removed when page reloads or redirects
        });
    }
    
    // Auto-dismiss alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            setTimeout(() => {
                alert.remove();
            }, 300);
        }, 5000);
    });
    
    // Smooth animations for form groups
    const formGroups = document.querySelectorAll('.form-group');
    formGroups.forEach((group, index) => {
        group.style.opacity = '0';
        group.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            group.style.transition = 'all 0.5s ease';
            group.style.opacity = '1';
            group.style.transform = 'translateY(0)';
        }, 100 * index);
    });
    
    // Prevent multiple form submissions
    let isSubmitting = false;
    
    if (form) {
        form.addEventListener('submit', function(e) {
            if (isSubmitting) {
                e.preventDefault();
                return false;
            }
            isSubmitting = true;
        });
    }
    
    // Enhanced accessibility
    const inputs = document.querySelectorAll('input');
    inputs.forEach(input => {
        // Add ARIA labels for better accessibility
        const label = input.closest('.form-group')?.querySelector('label');
        if (label) {
            input.setAttribute('aria-labelledby', label.id || `label-${input.id}`);
            if (!label.id) {
                label.id = `label-${input.id}`;
            }
        }
        
        // Add input event for better UX
        input.addEventListener('input', function() {
            this.setAttribute('aria-invalid', 'false');
        });
        
        input.addEventListener('invalid', function() {
            this.setAttribute('aria-invalid', 'true');
        });
    });
    
    // Keyboard navigation enhancement
    document.addEventListener('keydown', function(e) {
        // Enter key on input fields should move to next field or submit
        if (e.key === 'Enter' && e.target.tagName === 'INPUT') {
            const inputs = Array.from(document.querySelectorAll('input:not([type="hidden"])'));
            const currentIndex = inputs.indexOf(e.target);
            
            if (currentIndex < inputs.length - 1) {
                e.preventDefault();
                inputs[currentIndex + 1].focus();
            } else if (e.target.type !== 'submit') {
                e.preventDefault();
                submitBtn.click();
            }
        }
    });
    
    // Focus management for better UX
    const firstInput = document.querySelector('input[type="text"], input[type="email"]');
    if (firstInput) {
        // Focus first input after a short delay for better UX
        setTimeout(() => {
            firstInput.focus();
        }, 500);
    }
    
    // Add visual feedback for form interaction
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.closest('.form-group')?.classList.add('focused');
        });
        
        input.addEventListener('blur', function() {
            this.closest('.form-group')?.classList.remove('focused');
        });
    });
});