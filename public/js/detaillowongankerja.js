document.addEventListener('DOMContentLoaded', function() {
    
    // Smooth Scroll Animation
    initSmoothScroll();
    
    // Add hover effects to cards
    initCardAnimations();
    
    // Animate elements on scroll
    initScrollAnimations();
    
    // Add ripple effect to buttons
    initRippleEffect();
    
    // Animate table rows
    initTableAnimations();
    
    // Add copy to clipboard functionality
    initCopyFeature();
    
    // Initialize tooltips
    initTooltips();
});

// Smooth Scroll for anchor links
function initSmoothScroll() {
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
}

// Card Hover Animations
function initCardAnimations() {
    const cards = document.querySelectorAll('.grid > div');
    
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transition = 'all 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
        });
        
        // Add subtle parallax effect
        card.addEventListener('mousemove', function(e) {
            const rect = this.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;
            
            const deltaX = (x - centerX) / centerX;
            const deltaY = (y - centerY) / centerY;
            
            this.style.transform = `
                translateY(-5px) 
                rotateX(${deltaY * 2}deg) 
                rotateY(${deltaX * 2}deg)
            `;
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) rotateX(0) rotateY(0)';
        });
    });
}

// Scroll Reveal Animations
function initScrollAnimations() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animation = 'fadeInUp 0.6s ease-out forwards';
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);
    
    // Observe all sections
    const sections = document.querySelectorAll('.mb-6, .grid > div');
    sections.forEach(section => {
        section.style.opacity = '0';
        observer.observe(section);
    });
    
    // Add fadeInUp animation
    const style = document.createElement('style');
    style.textContent = `
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    `;
    document.head.appendChild(style);
}

// Ripple Effect for Buttons
function initRippleEffect() {
    const buttons = document.querySelectorAll('.space-x-4 a');
    
    buttons.forEach(button => {
        button.addEventListener('click', function(e) {
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.cssText = `
                position: absolute;
                width: ${size}px;
                height: ${size}px;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.6);
                left: ${x}px;
                top: ${y}px;
                animation: ripple 0.6s ease-out;
                pointer-events: none;
            `;
            
            this.appendChild(ripple);
            
            setTimeout(() => ripple.remove(), 600);
        });
    });
    
    // Add ripple animation
    const style = document.createElement('style');
    style.textContent = `
        @keyframes ripple {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }
    `;
    document.head.appendChild(style);
}

// Table Row Animations
function initTableAnimations() {
    const tableRows = document.querySelectorAll('tbody tr');
    
    tableRows.forEach((row, index) => {
        row.style.animation = `slideIn 0.4s ease-out ${index * 0.1}s forwards`;
        row.style.opacity = '0';
    });
    
    // Add slideIn animation
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
    `;
    document.head.appendChild(style);
    
    // Add click to highlight effect
    tableRows.forEach(row => {
        row.addEventListener('click', function() {
            tableRows.forEach(r => r.classList.remove('highlighted'));
            this.classList.add('highlighted');
            
            setTimeout(() => {
                this.classList.remove('highlighted');
            }, 2000);
        });
    });
    
    // Add highlight style
    const highlightStyle = document.createElement('style');
    highlightStyle.textContent = `
        tbody tr.highlighted {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%) !important;
            box-shadow: 0 0 15px rgba(59, 130, 246, 0.3);
        }
    `;
    document.head.appendChild(highlightStyle);
}

// Copy to Clipboard Feature
function initCopyFeature() {
    const emailCells = document.querySelectorAll('tbody td:nth-child(2)');
    
    emailCells.forEach(cell => {
        cell.style.cursor = 'pointer';
        cell.title = 'Klik untuk menyalin email';
        
        cell.addEventListener('click', function() {
            const email = this.textContent.trim();
            
            navigator.clipboard.writeText(email).then(() => {
                showToast('Email berhasil disalin!');
                
                // Visual feedback
                const originalText = this.innerHTML;
                this.innerHTML = '✓ Tersalin!';
                this.style.color = '#059669';
                
                setTimeout(() => {
                    this.innerHTML = originalText;
                    this.style.color = '';
                }, 1500);
            }).catch(err => {
                console.error('Failed to copy:', err);
            });
        });
    });
}

// Toast Notification
function showToast(message) {
    const toast = document.createElement('div');
    toast.textContent = message;
    toast.style.cssText = `
        position: fixed;
        bottom: 30px;
        right: 30px;
        background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 10px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        z-index: 1000;
        animation: slideInRight 0.4s ease-out, fadeOut 0.4s ease-out 2.6s forwards;
        font-weight: 600;
    `;
    
    document.body.appendChild(toast);
    
    setTimeout(() => toast.remove(), 3000);
    
    // Add animation
    const style = document.createElement('style');
    style.textContent = `
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
        @keyframes fadeOut {
            to {
                opacity: 0;
                transform: translateX(100%);
            }
        }
    `;
    document.head.appendChild(style);
}

// Tooltips
function initTooltips() {
    const badges = document.querySelectorAll('span.rounded-full');
    
    badges.forEach(badge => {
        badge.addEventListener('mouseenter', function(e) {
            const tooltip = document.createElement('div');
            const statusText = this.textContent.trim();
            let tooltipContent = '';
            
            switch(statusText.toLowerCase()) {
                case 'accepted':
                    tooltipContent = 'Lamaran diterima';
                    break;
                case 'pending':
                    tooltipContent = 'Menunggu review';
                    break;
                case 'rejected':
                    tooltipContent = 'Lamaran ditolak';
                    break;
                default:
                    tooltipContent = statusText;
            }
            
            tooltip.textContent = tooltipContent;
            tooltip.className = 'custom-tooltip';
            tooltip.style.cssText = `
                position: absolute;
                background: #1e293b;
                color: white;
                padding: 0.5rem 1rem;
                border-radius: 6px;
                font-size: 0.75rem;
                white-space: nowrap;
                z-index: 100;
                pointer-events: none;
                animation: tooltipFade 0.2s ease-out;
            `;
            
            document.body.appendChild(tooltip);
            
            const rect = this.getBoundingClientRect();
            tooltip.style.left = rect.left + (rect.width / 2) - (tooltip.offsetWidth / 2) + 'px';
            tooltip.style.top = rect.top - tooltip.offsetHeight - 10 + 'px';
            
            this.tooltipElement = tooltip;
        });
        
        badge.addEventListener('mouseleave', function() {
            if (this.tooltipElement) {
                this.tooltipElement.remove();
                this.tooltipElement = null;
            }
        });
    });
    
    // Add tooltip animation
    const style = document.createElement('style');
    style.textContent = `
        @keyframes tooltipFade {
            from {
                opacity: 0;
                transform: translateY(5px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    `;
    document.head.appendChild(style);
}

// Add print functionality
function initPrintButton() {
    const headerActions = document.querySelector('.space-x-4');
    if (headerActions) {
        const printBtn = document.createElement('a');
        printBtn.href = '#';
        printBtn.className = 'bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded';
        printBtn.textContent = 'Cetak';
        printBtn.style.background = 'linear-gradient(135deg, #06b6d4 0%, #0891b2 100%)';
        
        printBtn.addEventListener('click', function(e) {
            e.preventDefault();
            window.print();
        });
        
        headerActions.appendChild(printBtn);
    }
}

// Initialize print button
initPrintButton();

// Performance: Debounce function for scroll events
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Add scroll progress indicator
function initScrollProgress() {
    const progressBar = document.createElement('div');
    progressBar.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        height: 4px;
        background: linear-gradient(90deg, #1e40af 0%, #06b6d4 100%);
        width: 0%;
        z-index: 9999;
        transition: width 0.1s ease;
    `;
    document.body.appendChild(progressBar);
    
    const updateProgress = debounce(() => {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        const scrollHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        const progress = (scrollTop / scrollHeight) * 100;
        progressBar.style.width = progress + '%';
    }, 10);
    
    window.addEventListener('scroll', updateProgress);
}

initScrollProgress();