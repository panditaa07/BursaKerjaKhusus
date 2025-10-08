// ============================================
// MODERN BLUE ELEGANT THEME - BKK OPAT
// Interactive JavaScript Functions
// ============================================

(function() {
    'use strict';

    // ============================================
    // INITIALIZATION
    // ============================================
    
    document.addEventListener('DOMContentLoaded', function() {
        initPageAnimations();
        initScrollToTop();
        initSmoothScroll();
        initButtonRipple();
        initTooltips();
        initCardHoverEffects();
        initTableRowAnimations();
        initFormValidation();
        hideLoadingOverlay();
    });

    // ============================================
    // PAGE LOADING ANIMATION
    // ============================================
    
    function hideLoadingOverlay() {
        const overlay = document.querySelector('.loading-overlay');
        if (overlay) {
            setTimeout(() => {
                overlay.classList.add('hide');
                setTimeout(() => overlay.remove(), 300);
            }, 500);
        }
    }

    // ============================================
    // PAGE ANIMATIONS ON LOAD
    // ============================================
    
    function initPageAnimations() {
        // Animate cards on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -100px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }, index * 100);
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        // Observe all cards
        document.querySelectorAll('.card').forEach((card) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'all 0.6s ease-out';
            observer.observe(card);
        });
    }

    // ============================================
    // SCROLL TO TOP BUTTON
    // ============================================
    
    function initScrollToTop() {
        // Create scroll to top button if it doesn't exist
        let scrollBtn = document.querySelector('.scroll-to-top');
        
        if (!scrollBtn) {
            scrollBtn = document.createElement('div');
            scrollBtn.className = 'scroll-to-top';
            scrollBtn.innerHTML = '<i class="fas fa-arrow-up"></i>';
            document.body.appendChild(scrollBtn);
        }

        // Show/hide button on scroll
        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 300) {
                scrollBtn.classList.add('show');
            } else {
                scrollBtn.classList.remove('show');
            }
        });

        // Scroll to top on click
        scrollBtn.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }

    // ============================================
    // SMOOTH SCROLL FOR ANCHORS
    // ============================================
    
    function initSmoothScroll() {
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                if (href !== '#' && href !== '') {
                    e.preventDefault();
                    const target = document.querySelector(href);
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                }
            });
        });
    }

    // ============================================
    // BUTTON RIPPLE EFFECT
    // ============================================
    
    function initButtonRipple() {
        document.querySelectorAll('.btn').forEach(button => {
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

        // Add ripple styles
        if (!document.querySelector('#ripple-styles')) {
            const style = document.createElement('style');
            style.id = 'ripple-styles';
            style.textContent = `
                .ripple {
                    position: absolute;
                    border-radius: 50%;
                    background: rgba(255, 255, 255, 0.6);
                    transform: scale(0);
                    animation: ripple-animation 0.6s ease-out;
                    pointer-events: none;
                }
                @keyframes ripple-animation {
                    to {
                        transform: scale(2);
                        opacity: 0;
                    }
                }
            `;
            document.head.appendChild(style);
        }
    }

    // ============================================
    // TOOLTIP INITIALIZATION
    // ============================================
    
    function initTooltips() {
        // Initialize Bootstrap tooltips if available
        if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
            const tooltipTriggerList = [].slice.call(
                document.querySelectorAll('[data-bs-toggle="tooltip"]')
            );
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        }
    }

    // ============================================
    // CARD HOVER EFFECTS
    // ============================================
    
    function initCardHoverEffects() {
        document.querySelectorAll('.card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px) scale(1.02)';
            });

            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });
    }

    // ============================================
    // TABLE ROW ANIMATIONS
    // ============================================
    
    function initTableRowAnimations() {
        const tableRows = document.querySelectorAll('tbody tr');
        
        tableRows.forEach((row, index) => {
            row.style.opacity = '0';
            row.style.transform = 'translateX(-20px)';
            
            setTimeout(() => {
                row.style.transition = 'all 0.5s ease-out';
                row.style.opacity = '1';
                row.style.transform = 'translateX(0)';
            }, index * 50);
        });

        // Add click effect
        tableRows.forEach(row => {
            row.addEventListener('click', function(e) {
                // Don't trigger if clicking a button
                if (!e.target.closest('.btn')) {
                    this.style.transform = 'scale(0.98)';
                    setTimeout(() => {
                        this.style.transform = 'scale(1)';
                    }, 100);
                }
            });
        });
    }

    // ============================================
    // FORM VALIDATION & EFFECTS
    // ============================================
    
    function initFormValidation() {
        const forms = document.querySelectorAll('form');
        
        forms.forEach(form => {
            const inputs = form.querySelectorAll('.form-control, .form-select');
            
            inputs.forEach(input => {
                // Add focus animation
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('input-focused');
                    this.style.transform = 'scale(1.02)';
                });

                input.addEventListener('blur', function() {
                    this.parentElement.classList.remove('input-focused');
                    this.style.transform = 'scale(1)';
                });

                // Add typing animation
                input.addEventListener('input', function() {
                    if (this.value) {
                        this.classList.add('has-value');
                    } else {
                        this.classList.remove('has-value');
                    }
                });
            });
        });
    }

    // ============================================
    // BADGE PULSE ANIMATION
    // ============================================
    
    function initBadgeAnimations() {
        document.querySelectorAll('.badge').forEach(badge => {
            badge.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.1)';
            });

            badge.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1)';
            });
        });
    }

    // Call badge animations
    initBadgeAnimations();

    // ============================================
    // NOTIFICATION SYSTEM
    // ============================================
    
    window.showNotification = function(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.innerHTML = `
            <div class="notification-content">
                <i class="fas fa-${getNotificationIcon(type)}"></i>
                <span>${message}</span>
            </div>
        `;

        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 1rem 1.5rem;
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            z-index: 10000;
            animation: slideInRight 0.3s ease-out;
            min-width: 300px;
        `;

        document.body.appendChild(notification);

        setTimeout(() => {
            notification.style.animation = 'slideOutRight 0.3s ease-out';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    };

    function getNotificationIcon(type) {
        const icons = {
            'success': 'check-circle',
            'error': 'exclamation-circle',
            'warning': 'exclamation-triangle',
            'info': 'info-circle'
        };
        return icons[type] || icons.info;
    }

    // ============================================
    // CONFIRM DELETE WITH ANIMATION
    // ============================================
    
    window.confirmDelete = function(message = 'Apakah Anda yakin ingin menghapus?') {
        return new Promise((resolve) => {
            const overlay = document.createElement('div');
            overlay.className = 'confirm-overlay';
            overlay.innerHTML = `
                <div class="confirm-dialog">
                    <div class="confirm-icon">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <h5>Konfirmasi</h5>
                    <p>${message}</p>
                    <div class="confirm-buttons">
                        <button class="btn btn-secondary" onclick="this.closest('.confirm-overlay').remove()">
                            Batal
                        </button>
                        <button class="btn btn-danger confirm-yes">
                            Ya, Hapus
                        </button>
                    </div>
                </div>
            `;

            overlay.style.cssText = `
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.5);
                display: flex;
                justify-content: center;
                align-items: center;
                z-index: 10000;
                animation: fadeIn 0.3s ease-out;
            `;

            document.body.appendChild(overlay);

            overlay.querySelector('.confirm-yes').addEventListener('click', () => {
                overlay.remove();
                resolve(true);
            });

            overlay.addEventListener('click', (e) => {
                if (e.target === overlay) {
                    overlay.remove();
                    resolve(false);
                }
            });
        });
    };

    // ============================================
    // LOADING STATE FOR BUTTONS
    // ============================================
    
    window.setButtonLoading = function(button, isLoading) {
        if (isLoading) {
            button.dataset.originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
            button.disabled = true;
        } else {
            button.innerHTML = button.dataset.originalText;
            button.disabled = false;
        }
    };

    // ============================================
    // SEARCH HIGHLIGHT
    // ============================================
    
    function initSearchHighlight() {
        const searchInput = document.querySelector('input[type="search"], input[placeholder*="Cari"]');
        
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const rows = document.querySelectorAll('tbody tr');

                rows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    if (text.includes(searchTerm) || searchTerm === '') {
                        row.style.display = '';
                        row.style.animation = 'fadeIn 0.3s ease-out';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        }
    }

    initSearchHighlight();

    // ============================================
    // CONSOLE WELCOME MESSAGE
    // ============================================
    
    console.log('%c🚀 BKK OPAT System ', 'background: #1e40af; color: white; padding: 10px 20px; border-radius: 5px; font-size: 16px; font-weight: bold;');
    console.log('%cDeveloped with ❤️', 'color: #06b6d4; font-size: 12px;');

})();