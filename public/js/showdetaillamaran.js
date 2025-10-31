// Detail Lamaran JavaScript
document.addEventListener('DOMContentLoaded', function() {
    
    // Smooth scroll to top on page load
    window.scrollTo({ top: 0, behavior: 'smooth' });

    // Initialize tooltips if Bootstrap is available
    if (typeof bootstrap !== 'undefined') {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }

    // Animate cards on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const cardObserver = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '0';
                entry.target.style.transform = 'translateY(20px)';
                
                setTimeout(() => {
                    entry.target.style.transition = 'all 0.6s ease';
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }, 100);
                
                cardObserver.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Observe all cards
    document.querySelectorAll('.card').forEach(card => {
        cardObserver.observe(card);
    });

    // Handle document buttons
    const docButtons = document.querySelectorAll('.btn-doc');
    docButtons.forEach(button => {
        if (!button.disabled && button.href) {
            button.addEventListener('click', function(e) {
                // Add loading state
                const originalText = this.innerHTML;
                const icon = this.querySelector('i');
                
                if (icon) {
                    icon.className = 'fas fa-spinner fa-spin';
                }
                
                // Reset after 2 seconds
                setTimeout(() => {
                    this.innerHTML = originalText;
                }, 2000);
            });
        }
    });

    // Add ripple effect to buttons
    function createRipple(event) {
        const button = event.currentTarget;
        const ripple = document.createElement('span');
        const rect = button.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        const x = event.clientX - rect.left - size / 2;
        const y = event.clientY - rect.top - size / 2;

        ripple.style.width = ripple.style.height = size + 'px';
        ripple.style.left = x + 'px';
        ripple.style.top = y + 'px';
        ripple.classList.add('ripple');

        button.style.position = 'relative';
        button.style.overflow = 'hidden';
        button.appendChild(ripple);

        setTimeout(() => {
            ripple.remove();
        }, 600);
    }

    // Add ripple to all clickable buttons
    document.querySelectorAll('.btn-doc, .btn-kembali').forEach(button => {
        button.addEventListener('click', createRipple);
    });

    // Social media link tracking (optional analytics)
    const socialLinks = document.querySelectorAll('.d-flex.flex-wrap.gap-2 a');
    socialLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const platform = this.textContent.trim();
            console.log(`Social media clicked: ${platform}`);
            
            // Add subtle animation
            this.style.transform = 'scale(0.95)';
            setTimeout(() => {
                this.style.transform = '';
            }, 150);
        });
    });

    // Status chip animation enhancement
    const statusChip = document.querySelector('.status-chip');
    if (statusChip) {
        statusChip.addEventListener('mouseenter', function() {
            const dot = this.querySelector('.dot');
            if (dot) {
                dot.style.animation = 'none';
                setTimeout(() => {
                    dot.style.animation = '';
                }, 10);
            }
        });
    }

    // Copy ID Lamaran to clipboard
    const idLamaran = document.querySelector('td:contains("#")');
    if (idLamaran) {
        const idElements = document.querySelectorAll('.table-borderless td');
        idElements.forEach(el => {
            if (el.textContent.includes('#')) {
                el.style.cursor = 'pointer';
                el.title = 'Klik untuk menyalin ID';
                
                el.addEventListener('click', function() {
                    const id = this.textContent.replace('#', '').trim();
                    
                    // Modern clipboard API
                    if (navigator.clipboard) {
                        navigator.clipboard.writeText(id).then(() => {
                            showNotification('ID Lamaran berhasil disalin!', 'success');
                        }).catch(() => {
                            fallbackCopyText(id);
                        });
                    } else {
                        fallbackCopyText(id);
                    }
                });
            }
        });
    }

    // Fallback copy method for older browsers
    function fallbackCopyText(text) {
        const textArea = document.createElement('textarea');
        textArea.value = text;
        textArea.style.position = 'fixed';
        textArea.style.left = '-999999px';
        document.body.appendChild(textArea);
        textArea.select();
        
        try {
            document.execCommand('copy');
            showNotification('ID Lamaran berhasil disalin!', 'success');
        } catch (err) {
            showNotification('Gagal menyalin ID', 'error');
        }
        
        document.body.removeChild(textArea);
    }

    // Show notification
    function showNotification(message, type = 'info') {
        // Check if notification already exists
        const existing = document.querySelector('.custom-notification');
        if (existing) {
            existing.remove();
        }

        const notification = document.createElement('div');
        notification.className = `custom-notification notification-${type}`;
        notification.innerHTML = `
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'info-circle'}"></i>
            <span>${message}</span>
        `;
        
        document.body.appendChild(notification);
        
        // Trigger animation
        setTimeout(() => {
            notification.classList.add('show');
        }, 10);
        
        // Remove after 3 seconds
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => {
                notification.remove();
            }, 300);
        }, 3000);
    }

    // Print functionality
    function addPrintButton() {
        const headerDiv = document.querySelector('.d-flex.justify-content-between');
        if (headerDiv && !document.querySelector('.btn-print')) {
            const printBtn = document.createElement('button');
            printBtn.className = 'btn-print';
            printBtn.innerHTML = '<i class="fas fa-print"></i> Cetak';
            printBtn.onclick = function() {
                window.print();
            };
            headerDiv.appendChild(printBtn);
        }
    }

    // Uncomment if you want print button
    // addPrintButton();

    // Handle back button with confirmation if needed
    const backButton = document.querySelector('.btn-kembali');
    if (backButton) {
        backButton.addEventListener('click', function(e) {
            // Add smooth transition
            this.style.transform = 'scale(0.95)';
            setTimeout(() => {
                this.style.transform = '';
            }, 150);
        });
    }

    // Image lazy loading for company logo
    const companyLogo = document.querySelector('img[alt="Logo Perusahaan"]');
    if (companyLogo) {
        companyLogo.loading = 'lazy';
        
        companyLogo.addEventListener('error', function() {
            // Replace with placeholder if image fails to load
            const placeholder = document.createElement('div');
            placeholder.className = 'bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto';
            placeholder.style.cssText = 'width: 120px; height: 120px; font-size: 48px; font-weight: bold;';
            placeholder.innerHTML = '<i class="fas fa-building"></i>';
            
            this.parentNode.replaceChild(placeholder, this);
        });
    }

    // Add loading animation for page
    document.body.style.opacity = '0';
    setTimeout(() => {
        document.body.style.transition = 'opacity 0.5s ease';
        document.body.style.opacity = '1';
    }, 100);

    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Ctrl/Cmd + P for print
        if ((e.ctrlKey || e.metaKey) && e.key === 'p') {
            e.preventDefault();
            window.print();
        }
        
        // Escape to go back
        if (e.key === 'Escape') {
            const backBtn = document.querySelector('.btn-kembali');
            if (backBtn) {
                backBtn.click();
            }
        }
    });

    // Enhanced table responsiveness
    function makeTablesResponsive() {
        const tables = document.querySelectorAll('.table-borderless');
        tables.forEach(table => {
            if (window.innerWidth < 768) {
                table.querySelectorAll('tr').forEach(row => {
                    row.style.display = 'flex';
                    row.style.flexDirection = 'column';
                });
            }
        });
    }

    makeTablesResponsive();
    window.addEventListener('resize', makeTablesResponsive);

    console.log('Detail Lamaran page loaded successfully');
});

// Add ripple effect styles dynamically
const style = document.createElement('style');
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

    .custom-notification {
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px 20px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        display: flex;
        align-items: center;
        gap: 10px;
        z-index: 9999;
        transform: translateX(400px);
        transition: transform 0.3s ease;
    }

    .custom-notification.show {
        transform: translateX(0);
    }

    .notification-success {
        border-left: 4px solid #28a745;
        color: #155724;
    }

    .notification-error {
        border-left: 4px solid #dc3545;
        color: #721c24;
    }

    .notification-info {
        border-left: 4px solid #17a2b8;
        color: #0c5460;
    }

    .btn-print {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        background-color: #6C4F3D;
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-print:hover {
        background-color: #5a3f2f;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(108, 79, 61, 0.3);
    }

    @media print {
        .custom-notification,
        .btn-print {
            display: none !important;
        }
    }
`;
document.head.appendChild(style);