// ===== INITIALIZATION =====
document.addEventListener('DOMContentLoaded', function() {
    initializeTableHover();
    initializeButtonEffects();
    initializeNotifications();
    initializeSearch();
    initializePagination();
    initializeAnimations();
    initializeTooltips();
});

// ===== TABLE HOVER EFFECTS =====
function initializeTableHover() {
    const tableRows = document.querySelectorAll('.table tbody tr');
    
    tableRows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.backgroundColor = '#f5f5f5';
            this.style.transform = 'scale(1.01)';
            this.style.boxShadow = '0 2px 8px rgba(0,0,0,0.1)';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.backgroundColor = '#ffffff';
            this.style.transform = 'scale(1)';
            this.style.boxShadow = 'none';
        });
    });
}

// ===== BUTTON EFFECTS =====
function initializeButtonEffects() {
    const buttons = document.querySelectorAll('.btn');
    
    buttons.forEach(button => {
        button.addEventListener('click', function(e) {
            // Ripple effect
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
    
    // Add ripple CSS
    if (!document.getElementById('ripple-style')) {
        const style = document.createElement('style');
        style.id = 'ripple-style';
        style.textContent = `
            .btn {
                position: relative;
                overflow: hidden;
            }
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
                    transform: scale(4);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);
    }
}

// ===== NOTIFICATION MANAGEMENT =====
function initializeNotifications() {
    const notificationCards = document.querySelectorAll('.border.border-secondary-subtle');
    const markReadButtons = document.querySelectorAll('.btn-sm.btn-primary');
    
    // Add hover effect to notification cards
    notificationCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateX(5px)';
            this.style.transition = 'all 0.3s ease';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateX(0)';
        });
    });
    
    // Handle mark as read buttons
    markReadButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            const card = this.closest('.border.border-secondary-subtle');
            
            // Add fade out animation
            card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            card.style.opacity = '0.5';
            card.style.transform = 'scale(0.95)';
            
            // Show loading state
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
            this.disabled = true;
        });
    });
}

// ===== SEARCH FUNCTIONALITY =====
function initializeSearch() {
    const searchInput = document.querySelector('input[name="search"]');
    const searchForm = document.querySelector('form[method="GET"]');
    
    if (searchInput) {
        // Add search icon animation
        searchInput.addEventListener('focus', function() {
            const icon = this.previousElementSibling;
            if (icon && icon.classList.contains('fa-search')) {
                icon.style.color = '#007bff';
                icon.style.transform = 'scale(1.2)';
                icon.style.transition = 'all 0.3s ease';
            }
        });
        
        searchInput.addEventListener('blur', function() {
            const icon = this.previousElementSibling;
            if (icon && icon.classList.contains('fa-search')) {
                icon.style.color = '#6c757d';
                icon.style.transform = 'scale(1)';
            }
        });
        
        // Clear search functionality
        if (!document.getElementById('clear-search')) {
            const clearBtn = document.createElement('button');
            clearBtn.id = 'clear-search';
            clearBtn.type = 'button';
            clearBtn.className = 'btn btn-link position-absolute top-50 end-0 translate-middle-y text-muted';
            clearBtn.style.display = searchInput.value ? 'block' : 'none';
            clearBtn.style.zIndex = '10';
            clearBtn.innerHTML = '<i class="fas fa-times"></i>';
            
            searchInput.parentElement.appendChild(clearBtn);
            
            clearBtn.addEventListener('click', function() {
                searchInput.value = '';
                this.style.display = 'none';
                searchForm.submit();
            });
            
            searchInput.addEventListener('input', function() {
                clearBtn.style.display = this.value ? 'block' : 'none';
            });
        }
    }
}

// ===== PAGINATION EFFECTS =====
function initializePagination() {
    const pageLinks = document.querySelectorAll('.page-link');
    
    pageLinks.forEach(link => {
        if (!link.parentElement.classList.contains('disabled')) {
            link.addEventListener('click', function(e) {
                // Show loading indicator
                const originalText = this.innerHTML;
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                
                // Simulate loading (will be replaced by actual page load)
                setTimeout(() => {
                    this.innerHTML = originalText;
                }, 500);
            });
        }
    });
}

// ===== SCROLL ANIMATIONS =====
function initializeAnimations() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);
    
    // Observe cards
    const cards = document.querySelectorAll('.card');
    cards.forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
        observer.observe(card);
    });
}

// ===== TOOLTIPS =====
function initializeTooltips() {
    const badges = document.querySelectorAll('.badge');
    
    badges.forEach(badge => {
        const statusText = badge.textContent.trim();
        let tooltipText = '';
        
        switch(statusText) {
            case 'Proses':
                tooltipText = 'Lamaran Anda sedang dalam proses review';
                break;
            case 'Wawancara':
                tooltipText = 'Anda telah dipanggil untuk wawancara';
                break;
            case 'Diterima':
                tooltipText = 'Selamat! Lamaran Anda diterima';
                break;
            case 'Ditolak':
                tooltipText = 'Lamaran Anda tidak dapat diproses lebih lanjut';
                break;
        }
        
        if (tooltipText) {
            badge.setAttribute('title', tooltipText);
            badge.style.cursor = 'help';
        }
    });
}

// ===== STATUS BADGE ANIMATION =====
function animateStatusBadges() {
    const acceptedBadges = document.querySelectorAll('.badge.bg-success');
    
    acceptedBadges.forEach(badge => {
        badge.style.animation = 'pulse 2s infinite';
    });
    
    // Add pulse animation CSS if not exists
    if (!document.getElementById('pulse-style')) {
        const style = document.createElement('style');
        style.id = 'pulse-style';
        style.textContent = `
            @keyframes pulse {
                0%, 100% {
                    transform: scale(1);
                }
                50% {
                    transform: scale(1.05);
                }
            }
        `;
        document.head.appendChild(style);
    }
}

// Call animation function
animateStatusBadges();

// ===== TABLE RESPONSIVE SCROLL INDICATOR =====
function initializeScrollIndicator() {
    const tableContainer = document.querySelector('.table-responsive');
    
    if (tableContainer) {
        const showScrollIndicator = () => {
            if (tableContainer.scrollWidth > tableContainer.clientWidth) {
                tableContainer.classList.add('has-scroll');
                
                if (!document.getElementById('scroll-indicator-style')) {
                    const style = document.createElement('style');
                    style.id = 'scroll-indicator-style';
                    style.textContent = `
                        .table-responsive.has-scroll::after {
                            content: '→';
                            position: absolute;
                            right: 0;
                            top: 50%;
                            transform: translateY(-50%);
                            background: linear-gradient(to right, transparent, #fff);
                            padding: 10px 20px;
                            font-size: 24px;
                            color: #007bff;
                            pointer-events: none;
                            animation: scroll-hint 2s infinite;
                        }
                        @keyframes scroll-hint {
                            0%, 100% { opacity: 1; transform: translateY(-50%) translateX(0); }
                            50% { opacity: 0.5; transform: translateY(-50%) translateX(5px); }
                        }
                        .table-responsive {
                            position: relative;
                        }
                    `;
                    document.head.appendChild(style);
                }
            }
        };
        
        showScrollIndicator();
        window.addEventListener('resize', showScrollIndicator);
        
        tableContainer.addEventListener('scroll', function() {
            if (this.scrollLeft > 0) {
                this.classList.remove('has-scroll');
            } else {
                showScrollIndicator();
            }
        });
    }
}

initializeScrollIndicator();

// ===== SMOOTH SCROLL FOR ANCHOR LINKS =====
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// ===== AUTO REFRESH NOTIFICATIONS =====
function autoRefreshNotifications() {
    const notificationContainer = document.querySelector('.overflow-auto');
    
    if (notificationContainer) {
        // Check for new notifications every 30 seconds
        setInterval(() => {
            // This would typically make an AJAX call to check for new notifications
            // For now, we'll just add a visual indicator
            console.log('Checking for new notifications...');
        }, 30000);
    }
}

autoRefreshNotifications();

// ===== EXPORT FUNCTIONS FOR EXTERNAL USE =====
window.lamaranApp = {
    refreshTable: initializeTableHover,
    refreshNotifications: initializeNotifications,
    showLoading: function(element) {
        element.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
    },
    hideLoading: function(element, originalText) {
        element.innerHTML = originalText;
    }
};