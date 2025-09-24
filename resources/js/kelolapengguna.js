document.addEventListener('DOMContentLoaded', function() {
    
    // Initialize all animations and interactions
    initializeAnimations();
    initializeFormInteractions();
    initializeTableInteractions();
    initializeAlertSystem();
    initializeButtonEffects();
    
    function initializeAnimations() {
        // Add staggered animation to table rows
        const tableRows = document.querySelectorAll('.table tbody tr');
        tableRows.forEach((row, index) => {
            row.style.animationDelay = `${index * 0.05}s`;
            row.classList.add('slide-up');
        });
        
        // Add animation to form elements
        const formElements = document.querySelectorAll('.form-control, .form-select');
        formElements.forEach((element, index) => {
            element.style.animationDelay = `${index * 0.1}s`;
            element.classList.add('fade-in');
        });
    }
    
    function initializeFormInteractions() {
        const searchForm = document.querySelector('form[method="GET"]');
        const searchInput = document.querySelector('input[name="search"]');
        const roleSelect = document.querySelector('select[name="role"]');
        const submitBtn = document.querySelector('button[type="submit"]');
        
        if (searchForm && submitBtn) {
            // Add modern styling classes
            searchForm.classList.add('modern-search-form');
            
            // Real-time search with debounce
            let searchTimeout;
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    clearTimeout(searchTimeout);
                    this.style.borderColor = '#667eea';
                    
                    searchTimeout = setTimeout(() => {
                        this.style.borderColor = '';
                    }, 1000);
                });
            }
            
            // Enhanced form submission
            searchForm.addEventListener('submit', function(e) {
                submitBtn.classList.add('loading');
                submitBtn.disabled = true;
                
                setTimeout(() => {
                    // This would normally be handled by the form submission
                    // but we add a small delay to show the loading state
                }, 500);
            });
        }
    }
    
    function initializeTableInteractions() {
        const tableRows = document.querySelectorAll('.table tbody tr');
        
        tableRows.forEach(row => {
            // Add hover effects
            row.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.02)';
                this.style.zIndex = '5';
            });
            
            row.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1)';
                this.style.zIndex = '1';
            });
            
            // Add click effects for better UX
            row.addEventListener('click', function(e) {
                if (!e.target.closest('.btn') && !e.target.closest('form')) {
                    this.style.animation = 'pulse 0.3s ease-in-out';
                    setTimeout(() => {
                        this.style.animation = '';
                    }, 300);
                }
            });
        });
        
        // Enhanced delete confirmation
        const deleteForms = document.querySelectorAll('form[onsubmit*="confirm"]');
        deleteForms.forEach(form => {
            form.removeAttribute('onsubmit'); // Remove inline handler
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                showModernConfirm(
                    'Konfirmasi Hapus',
                    'Yakin ingin menghapus pengguna ini? Aksi ini tidak dapat dibatalkan.',
                    () => {
                        this.submit();
                    }
                );
            });
        });
    }
    
    function initializeAlertSystem() {
        const alerts = document.querySelectorAll('.alert');
        
        alerts.forEach(alert => {
            // Auto dismiss alerts after 5 seconds
            setTimeout(() => {
                if (alert && alert.parentNode) {
                    alert.style.animation = 'slideOutUp 0.5s ease-out forwards';
                    setTimeout(() => {
                        if (alert.parentNode) {
                            alert.remove();
                        }
                    }, 500);
                }
            }, 5000);
            
            // Enhanced close button functionality
            const closeBtn = alert.querySelector('.btn-close');
            if (closeBtn) {
                closeBtn.addEventListener('click', function() {
                    alert.style.animation = 'slideOutRight 0.3s ease-out forwards';
                    setTimeout(() => {
                        alert.remove();
                    }, 300);
                });
            }
        });
    }
    
    function initializeButtonEffects() {
        const buttons = document.querySelectorAll('.btn');
        
        buttons.forEach(button => {
            // Ripple effect
            button.addEventListener('click', function(e) {
                const ripple = document.createElement('span');
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;
                
                ripple.style.width = ripple.style.height = size + 'px';
                ripple.style.left = x + 'px';
                ripple.style.top = y + 'px';
                ripple.classList.add('ripple');
                
                this.appendChild(ripple);
                
                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });
    }
    
    function showModernConfirm(title, message, onConfirm) {
        // Create modern confirmation modal
        const modal = document.createElement('div');
        modal.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(10px);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            animation: fadeIn 0.3s ease-out;
        `;
        
        const dialog = document.createElement('div');
        dialog.style.cssText = `
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95), rgba(255, 255, 255, 0.9));
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 2rem;
            max-width: 400px;
            width: 90%;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            text-align: center;
            animation: slideInUp 0.4s ease-out;
        `;
        
        dialog.innerHTML = `
            <h3 style="color: #667eea; margin-bottom: 1rem; font-weight: 700;">${title}</h3>
            <p style="color: #4a5568; margin-bottom: 2rem; line-height: 1.6;">${message}</p>
            <div style="display: flex; gap: 1rem; justify-content: center;">
                <button id="confirmBtn" style="background: linear-gradient(135deg, #ff416c 0%, #ff4b2b 100%); color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 12px; font-weight: 600; cursor: pointer; transition: all 0.3s ease;">Ya, Hapus</button>
                <button id="cancelBtn" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 12px; font-weight: 600; cursor: pointer; transition: all 0.3s ease;">Batal</button>
            </div>
        `;
        
        modal.appendChild(dialog);
        document.body.appendChild(modal);
        
        // Add button event listeners
        dialog.querySelector('#confirmBtn').addEventListener('click', () => {
            modal.remove();
            onConfirm();
        });
        
        dialog.querySelector('#cancelBtn').addEventListener('click', () => {
            modal.style.animation = 'fadeOut 0.3s ease-out forwards';
            setTimeout(() => modal.remove(), 300);
        });
        
        // Close on backdrop click
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.style.animation = 'fadeOut 0.3s ease-out forwards';
                setTimeout(() => modal.remove(), 300);
            }
        });
    }
    
    // Add CSS animations dynamically
    const style = document.createElement('style');
    style.textContent = `
        @keyframes fadeOut {
            from { opacity: 1; }
            to { opacity: 0; }
        }
        
        @keyframes slideOutUp {
            from { transform: translateY(0); opacity: 1; }
            to { transform: translateY(-20px); opacity: 0; }
        }
        
        @keyframes slideOutRight {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(20px); opacity: 0; }
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.6);
            transform: scale(0);
            animation: ripple 0.6s linear;
            pointer-events: none;
        }
        
        @keyframes ripple {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }
    `;
    document.head.appendChild(style);
});

// Utility function for smooth scrolling
function smoothScrollTo(element) {
    element.scrollIntoView({
        behavior: 'smooth',
        block: 'center'
    });
}

// Enhanced page loading
window.addEventListener('load', function() {
    document.body.style.opacity = '0';
    document.body.style.transition = 'opacity 0.5s ease-in-out';
    
    requestAnimationFrame(() => {
        document.body.style.opacity = '1';
    });
});