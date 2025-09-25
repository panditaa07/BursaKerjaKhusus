document.addEventListener('DOMContentLoaded', function() {
    
    // Form Enhancement
    const form = document.querySelector('form');
    const inputs = document.querySelectorAll('.form-control, .form-select');
    const submitBtn = document.querySelector('.btn-primary');
    
    // Input Focus Animation
    inputs.forEach(input => {
        const label = input.previousElementSibling;
        
        // Focus effect
        input.addEventListener('focus', function() {
            this.parentElement.style.transform = 'scale(1.02)';
            if (label && label.classList.contains('form-label')) {
                label.style.color = 'var(--primary-color)';
                label.style.transform = 'translateY(-2px)';
            }
        });
        
        // Blur effect
        input.addEventListener('blur', function() {
            this.parentElement.style.transform = 'scale(1)';
            if (label && label.classList.contains('form-label')) {
                label.style.color = 'var(--text-primary)';
                label.style.transform = 'translateY(0)';
            }
        });
        
        // Real-time validation styling
        input.addEventListener('input', function() {
            if (this.value.length > 0) {
                this.style.borderColor = 'var(--success-color)';
            } else {
                this.style.borderColor = 'var(--border-color)';
            }
        });
    });
    
    // Form Submission Enhancement
    if (form) {
        form.addEventListener('submit', function(e) {
            // Add loading state
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Updating...';
            submitBtn.disabled = true;
            form.classList.add('form-loading');
            
            // Add ripple effect
            createRipple(submitBtn, e);
        });
    }
    
    // Ripple Effect Function
    function createRipple(button, event) {
        const ripple = document.createElement('span');
        const rect = button.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        const x = event.clientX - rect.left - size / 2;
        const y = event.clientY - rect.top - size / 2;
        
        ripple.style.cssText = `
            position: absolute;
            width: ${size}px;
            height: ${size}px;
            left: ${x}px;
            top: ${y}px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            transform: scale(0);
            animation: ripple 0.6s ease-out;
            pointer-events: none;
        `;
        
        button.style.position = 'relative';
        button.appendChild(ripple);
        
        setTimeout(() => ripple.remove(), 600);
    }
    
    // Smooth Card Entrance Animation
    const cards = document.querySelectorAll('.card');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animationDelay = '0s';
                entry.target.classList.add('animate-in');
            }
        });
    }, { threshold: 0.1 });
    
    cards.forEach(card => observer.observe(card));
    
    // Auto-resize textarea
    const textareas = document.querySelectorAll('textarea');
    textareas.forEach(textarea => {
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = this.scrollHeight + 'px';
        });
    });
    
    // Floating Label Effect
    inputs.forEach(input => {
        const wrapper = document.createElement('div');
        wrapper.classList.add('input-wrapper');
        input.parentNode.insertBefore(wrapper, input);
        wrapper.appendChild(input);
        
        if (input.value) {
            wrapper.classList.add('has-value');
        }
        
        input.addEventListener('focus', () => wrapper.classList.add('is-focused'));
        input.addEventListener('blur', () => {
            wrapper.classList.remove('is-focused');
            if (input.value) {
                wrapper.classList.add('has-value');
            } else {
                wrapper.classList.remove('has-value');
            }
        });
    });
    
    // Toast Notification for Success/Error
    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;
        toast.innerHTML = `
            <div class="toast-content">
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
                <span>${message}</span>
            </div>
        `;
        
        toast.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: ${type === 'success' ? 'var(--success-color)' : 'var(--danger-color)'};
            color: white;
            padding: 1rem 1.5rem;
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-lg);
            z-index: 1000;
            animation: slideInFromRight 0.3s ease-out;
            max-width: 300px;
        `;
        
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.style.animation = 'slideOutToRight 0.3s ease-out';
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }
    
    // Enhanced Button Interactions
    const buttons = document.querySelectorAll('.btn');
    buttons.forEach(btn => {
        btn.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
        });
        
        btn.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
        
        btn.addEventListener('mousedown', function() {
            this.style.transform = 'translateY(0)';
        });
        
        btn.addEventListener('mouseup', function() {
            this.style.transform = 'translateY(-2px)';
        });
    });
    
    // Phone Number Formatting
    const phoneInput = document.getElementById('phone');
    if (phoneInput) {
        phoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.startsWith('62')) {
                value = '+' + value;
            } else if (value.startsWith('0')) {
                value = '+62' + value.substring(1);
            }
            e.target.value = value;
        });
    }
    
    // Date Input Enhancement
    const dateInput = document.getElementById('birth_date');
    if (dateInput) {
        const today = new Date();
        const maxDate = new Date(today.getFullYear() - 10, today.getMonth(), today.getDate());
        const minDate = new Date(today.getFullYear() - 100, today.getMonth(), today.getDate());
        
        dateInput.max = maxDate.toISOString().split('T')[0];
        dateInput.min = minDate.toISOString().split('T')[0];
    }
});

// Add CSS for additional animations
const additionalCSS = `
@keyframes slideInFromRight {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

@keyframes slideOutToRight {
    from {
        transform: translateX(0);
        opacity: 1;
    }
    to {
        transform: translateX(100%);
        opacity: 0;
    }
}

@keyframes ripple {
    to {
        transform: scale(2);
        opacity: 0;
    }
}

.input-wrapper {
    position: relative;
    transition: var(--transition);
}

.animate-in {
    animation: fadeInUp 0.8s ease-out both;
}

.toast-content {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
`;

const style = document.createElement('style');
style.textContent = additionalCSS;
document.head.appendChild(style);