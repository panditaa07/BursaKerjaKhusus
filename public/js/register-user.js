// Register User JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const form = document.querySelector('form');
    const submitBtn = document.querySelector('.btn-info');
    const passwordInput = document.querySelector('input[name="password"]');
    const confirmPasswordInput = document.querySelector('input[name="password_confirmation"]');
    const nikNisnInput = document.querySelector('input[name="nik_nisn"]');
    
    // Add necessary elements for enhanced functionality
    setupEnhancedForm();
    
    // Setup enhanced form elements
    function setupEnhancedForm() {
        // Add password toggles
        const passwordFields = document.querySelectorAll('input[type="password"]');
        passwordFields.forEach(field => {
            const container = field.closest('.mb-3');
            if (!container.querySelector('.password-toggle')) {
                const toggle = document.createElement('span');
                toggle.className = 'password-toggle';
                toggle.innerHTML = '<i class="bi bi-eye"></i>';
                container.appendChild(toggle);
                
                // Add password toggle functionality
                toggle.addEventListener('click', function() {
                    const icon = this.querySelector('i');
                    
                    if (field.type === 'password') {
                        field.type = 'text';
                        icon.classList.remove('bi-eye');
                        icon.classList.add('bi-eye-slash');
                    } else {
                        field.type = 'password';
                        icon.classList.remove('bi-eye-slash');
                        icon.classList.add('bi-eye');
                    }
                });
            }
        });
        
        // Add password strength indicator for main password
        if (passwordInput && !passwordInput.nextElementSibling?.classList.contains('password-strength')) {
            const strengthContainer = document.createElement('div');
            strengthContainer.className = 'password-strength';
            const strengthBar = document.createElement('div');
            strengthBar.className = 'password-strength-bar';
            strengthBar.id = 'strengthBar';
            strengthContainer.appendChild(strengthBar);
            
            const passwordContainer = passwordInput.closest('.mb-3');
            const toggle = passwordContainer.querySelector('.password-toggle');
            if (toggle) {
                toggle.parentNode.insertBefore(strengthContainer, toggle.nextSibling);
            } else {
                passwordContainer.appendChild(strengthContainer);
            }
        }
        
        // Add validation messages containers
        const inputs = document.querySelectorAll('.form-control');
        inputs.forEach(input => {
            const container = input.closest('.mb-3');
            if (!container.querySelector('.validation-message')) {
                const validationMsg = document.createElement('div');
                validationMsg.className = 'validation-message';
                container.appendChild(validationMsg);
            }
        });
        
        // Add loading spinner to button
        if (submitBtn && !submitBtn.querySelector('.loading-spinner')) {
            const spinner = document.createElement('div');
            spinner.className = 'loading-spinner';
            const btnText = document.createElement('span');
            btnText.className = 'btn-text';
            btnText.textContent = submitBtn.textContent;
            submitBtn.innerHTML = '';
            submitBtn.appendChild(btnText);
            submitBtn.appendChild(spinner);
        }
        
        // Add NIK validation info
        if (nikNisnInput && !nikNisnInput.nextElementSibling?.classList.contains('nik-validation')) {
            const nikInfo = document.createElement('div');
            nikInfo.className = 'nik-validation';
            nikInfo.textContent = 'NIK harus 16 digit, NISN harus 10 digit';
            nikNisnInput.parentNode.insertBefore(nikInfo, nikNisnInput.nextSibling);
        }
    }
    
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
        const strengthBar = document.getElementById('strengthBar');
        
        if (!strengthBar) return;
        
        if (password.length === 0) {
            strengthBar.className = 'password-strength-bar';
            return;
        }
        
        const strength = checkPasswordStrength(password);
        strengthBar.className = `password-strength-bar ${strength.level}`;
    }
    
    // Validation functions
    const validations = {
        name: {
            validate: (value) => value.trim().length >= 2,
            message: 'Name must be at least 2 characters long'
        },
        email: {
            validate: (value) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value),
            message: 'Please enter a valid email address'
        },
        nik_nisn: {
            validate: (value) => {
                const cleanValue = value.replace(/\D/g, '');
                return cleanValue.length === 16 || cleanValue.length === 10;
            },
            message: 'NIK must be 16 digits or NISN must be 10 digits'
        },
        password: {
            validate: (value) => {
                const strength = checkPasswordStrength(value);
                return strength.score >= 3 && value.length >= 8;
            },
            message: 'Password must be at least 8 characters with mixed case, numbers, and symbols'
        },
        password_confirmation: {
            validate: (value) => value === passwordInput?.value && value.length > 0,
            message: 'Passwords do not match'
        }
    };
    
    // Real-time validation
    function validateField(field, validation) {
        const container = field.closest('.mb-3');
        const validationMsg = container.querySelector('.validation-message');
        
        field.addEventListener('blur', function() {
            const isValid = validation.validate(this.value);
            
            container.classList.remove('error', 'success');
            
            if (this.value.length > 0) {
                if (isValid) {
                    container.classList.add('success');
                    if (validationMsg) {
                        validationMsg.textContent = '✓ Valid';
                        validationMsg.className = 'validation-message success';
                    }
                } else {
                    container.classList.add('error');
                    if (validationMsg) {
                        validationMsg.textContent = validation.message;
                        validationMsg.className = 'validation-message error';
                    }
                }
            } else {
                if (validationMsg) {
                    validationMsg.className = 'validation-message';
                }
            }
        });
        
        field.addEventListener('input', function() {
            if (container.classList.contains('error')) {
                const isValid = validation.validate(this.value);
                if (isValid) {
                    container.classList.remove('error');
                    container.classList.add('success');
                    if (validationMsg) {
                        validationMsg.textContent = '✓ Valid';
                        validationMsg.className = 'validation-message success';
                    }
                }
            }
        });
    }
    
    // Apply validation to all fields
    Object.keys(validations).forEach(fieldName => {
        const field = document.querySelector(`input[name="${fieldName}"]`);
        if (field) {
            validateField(field, validations[fieldName]);
        }
    });
    
    // Special handling for NIK/NISN formatting
    if (nikNisnInput) {
        nikNisnInput.addEventListener('input', function(e) {
            // Remove non-numeric characters
            let value = e.target.value.replace(/\D/g, '');
            
            // Limit length based on type (NIK: 16, NISN: 10)
            if (value.length > 16) {
                value = value.substr(0, 16);
            }
            
            e.target.value = value;
            
            // Update validation info
            const nikInfo = e.target.parentNode.querySelector('.nik-validation');
            if (nikInfo) {
                const length = value.length;
                if (length === 0) {
                    nikInfo.textContent = 'NIK harus 16 digit, NISN harus 10 digit';
                    nikInfo.style.color = '#6b7280';
                } else if (length === 10) {
                    nikInfo.textContent = '✓ Valid NISN format';
                    nikInfo.style.color = '#16a34a';
                } else if (length === 16) {
                    nikInfo.textContent = '✓ Valid NIK format';
                    nikInfo.style.color = '#16a34a';
                } else {
                    nikInfo.textContent = `${length} digits - Need ${10 - length > 0 ? 10 - length + ' more for NISN or ' : ''}${16 - length} more for NIK`;
                    nikInfo.style.color = '#f59e0b';
                }
            }
        });
        
        // Prevent non-numeric input
        nikNisnInput.addEventListener('keypress', function(e) {
            if (!/[\d]/.test(e.key) && !['Backspace', 'Delete', 'Tab', 'Escape', 'Enter'].includes(e.key)) {
                e.preventDefault();
            }
        });
    }
    
    // Password strength indicator
    if (passwordInput) {
        passwordInput.addEventListener('input', updatePasswordStrength);
    }
    
    // Confirm password real-time validation
    if (confirmPasswordInput) {
        confirmPasswordInput.addEventListener('input', function() {
            const container = this.closest('.mb-3');
            const validationMsg = container.querySelector('.validation-message');
            
            container.classList.remove('error', 'success');
            
            if (this.value.length > 0) {
                if (this.value === passwordInput.value) {
                    container.classList.add('success');
                    if (validationMsg) {
                        validationMsg.textContent = '✓ Passwords match';
                        validationMsg.className = 'validation-message success';
                    }
                } else {
                    container.classList.add('error');
                    if (validationMsg) {
                        validationMsg.textContent = 'Passwords do not match';
                        validationMsg.className = 'validation-message error';
                    }
                }
            } else {
                if (validationMsg) {
                    validationMsg.className = 'validation-message';
                }
            }
        });
    }
    
    // Form submission with validation
    if (form) {
        form.addEventListener('submit', function(e) {
            // Show loading state
            if (submitBtn) {
                submitBtn.classList.add('loading');
                submitBtn.disabled = true;
            }
            
            // Validate all fields
            let isFormValid = true;
            const requiredFields = ['name', 'email', 'nik_nisn', 'password', 'password_confirmation'];
            
            requiredFields.forEach(fieldName => {
                const field = document.querySelector(`input[name="${fieldName}"]`);
                const container = field?.closest('.mb-3');
                const validationMsg = container?.querySelector('.validation-message');
                
                if (field && validations[fieldName]) {
                    const isValid = validations[fieldName].validate(field.value);
                    
                    if (!isValid || field.value.trim() === '') {
                        isFormValid = false;
                        container?.classList.add('error');
                        container?.classList.remove('success');
                        
                        if (validationMsg) {
                            validationMsg.textContent = field.value.trim() === '' ? 
                                'This field is required' : 
                                validations[fieldName].message;
                            validationMsg.className = 'validation-message error';
                        }
                    }
                }
            });
            
            // If form is not valid, prevent submission and remove loading state
            if (!isFormValid) {
                e.preventDefault();
                if (submitBtn) {
                    submitBtn.classList.remove('loading');
                    submitBtn.disabled = false;
                }
                
                // Scroll to first error
                const firstError = document.querySelector('.mb-3.error');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    const input = firstError.querySelector('.form-control');
                    if (input) {
                        setTimeout(() => input.focus(), 100);
                    }
                }
                
                // Shake animation for errors
                const errors = document.querySelectorAll('.mb-3.error');
                errors.forEach(error => {
                    error.style.animation = 'shake 0.5s ease-in-out';
                    setTimeout(() => {
                        error.style.animation = '';
                    }, 500);
                });
                
                return false;
            }
        });
    }
    
    // Auto-dismiss alerts
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
    
    // Enhanced accessibility
    const inputs = document.querySelectorAll('.form-control');
    inputs.forEach(input => {
        const label = input.closest('.mb-3')?.querySelector('label');
        if (label) {
            const labelId = `label-${input.name || Math.random().toString(36).substr(2, 9)}`;
            label.id = labelId;
            input.setAttribute('aria-labelledby', labelId);
        }
        
        input.addEventListener('input', function() {
            this.setAttribute('aria-invalid', 'false');
        });
        
        input.addEventListener('invalid', function() {
            this.setAttribute('aria-invalid', 'true');
        });
    });
    
    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && e.target.tagName === 'INPUT') {
            const inputs = Array.from(document.querySelectorAll('.form-control'));
            const currentIndex = inputs.indexOf(e.target);
            
            if (currentIndex < inputs.length - 1) {
                e.preventDefault();
                inputs[currentIndex + 1].focus();
            }
        }
    });
    
    // Focus management
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.closest('.mb-3')?.classList.add('focused');
        });
        
        input.addEventListener('blur', function() {
            this.closest('.mb-3')?.classList.remove('focused');
        });
    });
    
    // Focus first input after page load
    setTimeout(() => {
        const firstInput = document.querySelector('.form-control');
        if (firstInput) {
            firstInput.focus();
        }
    }, 300);
    
    // Prevent multiple submissions
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
});

// Add shake animation for error feedback
const style = document.createElement('style');
style.textContent = `
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
        20%, 40%, 60%, 80% { transform: translateX(5px); }
    }
`;
document.head.appendChild(style);