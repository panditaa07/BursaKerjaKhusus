// ===== Modern Blue Elegant JavaScript =====

document.addEventListener('DOMContentLoaded', function() {
    
    // ===== Smooth Copy to Clipboard with Animation =====
    window.copyToClipboard = function() {
        const url = window.location.href;
        
        navigator.clipboard.writeText(url).then(function() {
            showNotification('Link berhasil disalin!', 'success');
        }).catch(function(err) {
            console.error('Could not copy text: ', err);
            showNotification('Gagal menyalin link', 'error');
        });
    }

    // ===== Custom Notification System =====
    function showNotification(message, type = 'success') {
        // Remove existing notifications
        const existingNotif = document.querySelector('.custom-notification');
        if (existingNotif) {
            existingNotif.remove();
        }

        const notification = document.createElement('div');
        notification.className = `custom-notification ${type}`;
        notification.innerHTML = `
            <div class="notification-content">
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
                <span>${message}</span>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Animate in
        setTimeout(() => notification.classList.add('show'), 10);
        
        // Auto remove after 3 seconds
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }

    // ===== Auto-dismiss alerts =====
    const alerts = document.querySelectorAll('.alert-dismissible');
    alerts.forEach(alert => {
        setTimeout(() => {
            const closeBtn = alert.querySelector('.btn-close');
            if (closeBtn) {
                closeBtn.click();
            }
        }, 5000);
    });

    // ===== Animate elements on scroll =====
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-in');
            }
        });
    }, observerOptions);

    // Observe all main content sections
    const sections = document.querySelectorAll('.job-detail > div');
    sections.forEach(section => {
        section.classList.add('animate-on-scroll');
        observer.observe(section);
    });

    // ===== Form Validation Enhancement =====
    const form = document.querySelector('#applyModal form');
    if (form) {
        form.addEventListener('submit', function(e) {
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mengirim...';
                
                // Re-enable after 3 seconds if submission fails
                setTimeout(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Kirim Lamaran';
                }, 3000);
            }
        });

        // File input preview
        const fileInput = form.querySelector('input[type="file"]');
        if (fileInput) {
            fileInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const fileName = file.name;
                    const fileSize = (file.size / 1024 / 1024).toFixed(2);
                    
                    // Create or update file info display
                    let fileInfo = fileInput.parentElement.querySelector('.file-info');
                    if (!fileInfo) {
                        fileInfo = document.createElement('div');
                        fileInfo.className = 'file-info';
                        fileInput.parentElement.appendChild(fileInfo);
                    }
                    
                    fileInfo.innerHTML = `
                        <div class="file-preview">
                            <i class="fas fa-file-pdf text-danger me-2"></i>
                            <span class="file-name">${fileName}</span>
                            <span class="file-size">(${fileSize} MB)</span>
                        </div>
                    `;
                }
            });
        }
    }

    // ===== Smooth Modal Animations =====
    const modal = document.getElementById('applyModal');
    if (modal) {
        modal.addEventListener('show.bs.modal', function() {
            this.querySelector('.modal-dialog').classList.add('modal-animate-in');
        });

        modal.addEventListener('hide.bs.modal', function() {
            this.querySelector('.modal-dialog').classList.remove('modal-animate-in');
        });
    }

    // ===== Share Buttons Enhancement =====
    const shareButtons = document.querySelectorAll('.share-buttons .btn');
    shareButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            this.classList.add('btn-clicked');
            setTimeout(() => {
                this.classList.remove('btn-clicked');
            }, 300);
        });
    });

    // ===== Badge Hover Effect =====
    const badges = document.querySelectorAll('.badge');
    badges.forEach(badge => {
        badge.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.1) rotate(2deg)';
        });
        
        badge.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1) rotate(0deg)';
        });
    });

    // ===== Company Logo Error Handling =====
    const companyLogo = document.querySelector('.company-logo');
    if (companyLogo) {
        companyLogo.addEventListener('error', function() {
            this.src = '/images/logo-smk.png';
        });
    }

    // ===== Lazy Loading Enhancement =====
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.classList.add('loaded');
                    observer.unobserve(img);
                }
            });
        });

        document.querySelectorAll('img').forEach(img => {
            imageObserver.observe(img);
        });
    }

    // ===== Card Hover Effect Enhancement =====
    const cards = document.querySelectorAll('.card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(-2px)';
        });
    });

    // ===== Detail Item Click Animation =====
    const detailItems = document.querySelectorAll('.detail-item');
    detailItems.forEach(item => {
        item.addEventListener('click', function() {
            this.classList.add('pulse-once');
            setTimeout(() => {
                this.classList.remove('pulse-once');
            }, 600);
        });
    });

    // ===== Initialize Tooltips if Bootstrap is available =====
    if (typeof bootstrap !== 'undefined') {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }

    // ===== Add Loading State to Apply Button =====
    const applyBtn = document.querySelector('[data-bs-target="#applyModal"]');
    if (applyBtn) {
        applyBtn.addEventListener('click', function() {
            this.classList.add('btn-pulse');
            setTimeout(() => {
                this.classList.remove('btn-pulse');
            }, 600);
        });
    }

    // ===== Scroll to Top Button =====
    const scrollBtn = createScrollToTopButton();
    
    window.addEventListener('scroll', () => {
        if (window.pageYOffset > 300) {
            scrollBtn.classList.add('show');
        } else {
            scrollBtn.classList.remove('show');
        }
    });

    function createScrollToTopButton() {
        const btn = document.createElement('button');
        btn.className = 'scroll-to-top';
        btn.innerHTML = '<i class="fas fa-arrow-up"></i>';
        btn.onclick = () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        };
        document.body.appendChild(btn);
        return btn;
    }

});

// ===== Additional CSS for JavaScript Features =====
const additionalStyles = document.createElement('style');
additionalStyles.textContent = `
    .custom-notification {
        position: fixed;
        top: 20px;
        right: 20px;
        background: white;
        padding: 1rem 1.5rem;
        border-radius: 10px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        z-index: 9999;
        transform: translateX(400px);
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .custom-notification.show {
        transform: translateX(0);
    }

    .custom-notification.success {
        border-left: 4px solid #10b981;
    }

    .custom-notification.error {
        border-left: 4px solid #ef4444;
    }

    .notification-content {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        color: #374151;
    }

    .notification-content i {
        font-size: 1.25rem;
    }

    .notification-content .fa-check-circle {
        color: #10b981;
    }

    .notification-content .fa-exclamation-circle {
        color: #ef4444;
    }

    .file-preview {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem;
        background: #f3f4f6;
        border-radius: 8px;
        margin-top: 0.5rem;
        font-size: 0.875rem;
    }

    .file-name {
        font-weight: 500;
        color: #374151;
    }

    .file-size {
        color: #6b7280;
    }

    .modal-animate-in {
        animation: modalSlideIn 0.3s ease-out;
    }

    @keyframes modalSlideIn {
        from {
            opacity: 0;
            transform: translateY(-50px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .btn-clicked {
        transform: scale(0.95) !important;
    }

    .animate-on-scroll {
        opacity: 0;
        transform: translateY(30px);
        transition: opacity 0.6s ease, transform 0.6s ease;
    }

    .animate-on-scroll.animate-in {
        opacity: 1;
        transform: translateY(0);
    }

    .pulse-once {
        animation: pulseOnce 0.6s ease;
    }

    @keyframes pulseOnce {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.02);
        }
    }

    .btn-pulse {
        animation: btnPulse 0.6s ease;
    }

    @keyframes btnPulse {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.05);
        }
    }

    img.loaded {
        animation: fadeIn 0.5s ease;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    .scroll-to-top {
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
        color: white;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        box-shadow: 0 4px 15px rgba(30, 64, 175, 0.3);
        opacity: 0;
        transform: translateY(100px);
        transition: all 0.3s ease;
        z-index: 1000;
    }

    .scroll-to-top.show {
        opacity: 1;
        transform: translateY(0);
    }

    .scroll-to-top:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 20px rgba(30, 64, 175, 0.4);
    }

    .scroll-to-top:active {
        transform: translateY(-2px);
    }
`;
document.head.appendChild(additionalStyles);