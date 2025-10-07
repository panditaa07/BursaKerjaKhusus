// Modern Blue Theme - Interactive Enhancements
document.addEventListener('DOMContentLoaded', function() {
    
    // ========== Table Row Animations ==========
    const tableRows = document.querySelectorAll('tbody tr');
    
    tableRows.forEach((row, index) => {
        // Staggered fade-in animation
        row.style.opacity = '0';
        row.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            row.style.transition = 'all 0.5s ease';
            row.style.opacity = '1';
            row.style.transform = 'translateY(0)';
        }, index * 50);
        
        // Enhanced hover effects
        row.addEventListener('mouseenter', function() {
            this.style.transform = 'translateX(8px) scale(1.01)';
            this.style.boxShadow = '-4px 0 0 #3b82f6 inset, 0 4px 12px rgba(59, 130, 246, 0.15)';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.transform = 'translateX(0) scale(1)';
            this.style.boxShadow = 'none';
        });
    });
    
    // ========== Button Ripple Effect ==========
    const buttons = document.querySelectorAll('.btn');
    
    buttons.forEach(button => {
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
            
            setTimeout(() => ripple.remove(), 600);
        });
    });
    
    // ========== Search Bar Enhancement ==========
    const searchInput = document.querySelector('input[name="search"]');
    
    if (searchInput) {
        // Add search wrapper
        const wrapper = searchInput.closest('.position-relative');
        if (wrapper) {
            wrapper.classList.add('search-wrapper');
        }
        
        // Floating label effect
        searchInput.addEventListener('focus', function() {
            this.parentElement.style.transform = 'scale(1.02)';
        });
        
        searchInput.addEventListener('blur', function() {
            this.parentElement.style.transform = 'scale(1)';
        });
        
        // Live search indicator
        let typingTimer;
        searchInput.addEventListener('keyup', function() {
            clearTimeout(typingTimer);
            this.style.borderColor = '#3b82f6';
            
            typingTimer = setTimeout(() => {
                this.style.borderColor = '';
            }, 1000);
        });
    }
    
    // ========== Badge Animation ==========
    const badges = document.querySelectorAll('.badge');
    
    badges.forEach((badge, index) => {
        badge.style.opacity = '0';
        badge.style.transform = 'scale(0.8)';
        
        setTimeout(() => {
            badge.style.transition = 'all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1)';
            badge.style.opacity = '1';
            badge.style.transform = 'scale(1)';
        }, index * 100);
    });
    
    // ========== Notification Cards Enhancement ==========
    const notificationCards = document.querySelectorAll('.border-secondary-subtle.rounded-lg');
    
    notificationCards.forEach((card, index) => {
        card.classList.add('notification-card');
        
        // Staggered entrance
        card.style.opacity = '0';
        card.style.transform = 'translateX(-20px)';
        
        setTimeout(() => {
            card.style.transition = 'all 0.5s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateX(0)';
        }, index * 100);
        
        // Pulse effect for unread notifications
        const markReadBtn = card.querySelector('.btn-primary');
        if (markReadBtn) {
            card.style.borderLeft = '4px solid #3b82f6';
            card.style.background = 'linear-gradient(to right, #eff6ff, #ffffff)';
            
            // Subtle pulse animation
            setInterval(() => {
                card.style.borderLeftColor = '#60a5fa';
                setTimeout(() => {
                    card.style.borderLeftColor = '#3b82f6';
                }, 500);
            }, 2000);
        }
    });
    
    // ========== Card Hover Effects ==========
    const cards = document.querySelectorAll('.card');
    
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-6px)';
            this.style.boxShadow = '0 12px 40px rgba(30, 64, 175, 0.18)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = '0 1px 3px rgba(30, 64, 175, 0.08)';
        });
    });
    
    // ========== Smooth Scroll to Top ==========
    window.addEventListener('scroll', function() {
        if (window.pageYOffset > 300) {
            createScrollTopButton();
        } else {
            removeScrollTopButton();
        }
    });
    
    function createScrollTopButton() {
        if (document.getElementById('scrollTopBtn')) return;
        
        const btn = document.createElement('button');
        btn.id = 'scrollTopBtn';
        btn.innerHTML = '<i class="fas fa-arrow-up"></i>';
        btn.style.cssText = `
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, #3b82f6, #1e40af);
            color: white;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(30, 64, 175, 0.3);
            z-index: 1000;
            transition: all 0.3s ease;
            animation: fadeInUp 0.4s ease;
        `;
        
        btn.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
        
        btn.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px) scale(1.1)';
            this.style.boxShadow = '0 8px 20px rgba(30, 64, 175, 0.4)';
        });
        
        btn.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
            this.style.boxShadow = '0 4px 12px rgba(30, 64, 175, 0.3)';
        });
        
        document.body.appendChild(btn);
    }
    
    function removeScrollTopButton() {
        const btn = document.getElementById('scrollTopBtn');
        if (btn) {
            btn.style.animation = 'fadeOutDown 0.4s ease';
            setTimeout(() => btn.remove(), 400);
        }
    }
    
    // ========== Loading Animation for Buttons ==========
    document.querySelectorAll('.btn-primary').forEach(btn => {
        btn.addEventListener('click', function(e) {
            if (this.classList.contains('loading')) return;
            
            const originalContent = this.innerHTML;
            this.classList.add('loading');
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            this.style.pointerEvents = 'none';
            
            // Simulate loading (remove this in production)
            setTimeout(() => {
                this.innerHTML = originalContent;
                this.classList.remove('loading');
                this.style.pointerEvents = '';
            }, 1000);
        });
    });
    
    // ========== Pagination Animation ==========
    const paginationLinks = document.querySelectorAll('.pagination .page-link');
    
    paginationLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            // Smooth transition
            document.querySelector('.table-responsive').style.opacity = '0.5';
            
            setTimeout(() => {
                // Will be reset on page load
            }, 300);
        });
    });
    
    // ========== Toast Notification System ==========
    window.showToast = function(message, type = 'success') {
        const toast = document.createElement('div');
        toast.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 1rem 1.5rem;
            background: ${type === 'success' ? 'linear-gradient(135deg, #10b981, #059669)' : 'linear-gradient(135deg, #ef4444, #dc2626)'};
            color: white;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            z-index: 9999;
            animation: slideInRight 0.4s ease;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        `;
        
        toast.innerHTML = `
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
            <span>${message}</span>
        `;
        
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.style.animation = 'slideOutRight 0.4s ease';
            setTimeout(() => toast.remove(), 400);
        }, 3000);
    };
    
    // ========== Add CSS Animations ==========
    const style = document.createElement('style');
    style.textContent = `
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes fadeOutDown {
            from {
                opacity: 1;
                transform: translateY(0);
            }
            to {
                opacity: 0;
                transform: translateY(20px);
            }
        }
        
        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        @keyframes slideOutRight {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }
        
        .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.6);
            transform: scale(0);
            animation: rippleEffect 0.6s ease-out;
            pointer-events: none;
        }
        
        @keyframes rippleEffect {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }
    `;
    document.head.appendChild(style);
    
    // ========== Initial Page Load Animation ==========
    document.body.style.opacity = '0';
    setTimeout(() => {
        document.body.style.transition = 'opacity 0.5s ease';
        document.body.style.opacity = '1';
    }, 100);
    
    console.log('🎨 Modern Blue Theme Loaded Successfully!');
});