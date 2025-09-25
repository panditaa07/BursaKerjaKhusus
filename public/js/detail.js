document.addEventListener('DOMContentLoaded', function() {
            
            // Initialize animations
            initializeAnimations();
            
            // Initialize image interactions
            initializeImageInteractions();
            
            // Initialize status badges
            initializeStatusBadges();
            
            // Initialize tooltips
            initializeTooltips();
            
            // Initialize smooth scrolling
            initializeSmoothScrolling();
            
            // Initialize copy functionality
            initializeCopyFunctionality();
            
        });

        // Animation initialization
        function initializeAnimations() {
            const cards = document.querySelectorAll('.card');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            });

            cards.forEach(card => {
                observer.observe(card);
            });
        }

        // Image interactions
        function initializeImageInteractions() {
            const images = document.querySelectorAll('.profile-image, .company-logo');
            
            images.forEach(img => {
                // Add click to zoom functionality
                img.addEventListener('click', function() {
                    createImageModal(this.src, this.alt);
                });
                
                // Add loading state
                img.addEventListener('load', function() {
                    this.classList.remove('loading');
                });
                
                img.addEventListener('error', function() {
                    this.style.opacity = '0.5';
                    this.title = 'Gambar tidak dapat dimuat';
                });
            });
        }

        // Create image modal
        function createImageModal(src, alt) {
            const modal = document.createElement('div');
            modal.className = 'image-modal';
            modal.style.cssText = `
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.9);
                display: flex;
                justify-content: center;
                align-items: center;
                z-index: 9999;
                opacity: 0;
                transition: opacity 0.3s ease;
                cursor: pointer;
            `;
            
            const img = document.createElement('img');
            img.src = src;
            img.alt = alt;
            img.style.cssText = `
                max-width: 90%;
                max-height: 90%;
                border-radius: 12px;
                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
                transform: scale(0.8);
                transition: transform 0.3s ease;
            `;
            
            modal.appendChild(img);
            document.body.appendChild(modal);
            
            // Animate in
            setTimeout(() => {
                modal.style.opacity = '1';
                img.style.transform = 'scale(1)';
            }, 10);
            
            // Close on click
            modal.addEventListener('click', function() {
                modal.style.opacity = '0';
                img.style.transform = 'scale(0.8)';
                setTimeout(() => modal.remove(), 300);
            });
            
            // Close on escape
            const escapeHandler = (e) => {
                if (e.key === 'Escape') {
                    modal.click();
                    document.removeEventListener('keydown', escapeHandler);
                }
            };
            document.addEventListener('keydown', escapeHandler);
        }

        // Status badges initialization
        function initializeStatusBadges() {
            const statusElements = document.querySelectorAll('[data-status]');
            
            statusElements.forEach(element => {
                const status = element.textContent.trim().toLowerCase();
                const badge = document.createElement('span');
                badge.className = 'status-badge';
                
                if (status === 'aktif' || status === 'active') {
                    badge.classList.add('status-active');
                    badge.innerHTML = '<i class="fas fa-check-circle"></i> Aktif';
                } else if (status === 'nonaktif' || status === 'inactive') {
                    badge.classList.add('status-inactive');
                    badge.innerHTML = '<i class="fas fa-times-circle"></i> Nonaktif';
                } else {
                    badge.classList.add('status-pending');
                    badge.innerHTML = '<i class="fas fa-clock"></i> ' + status;
                }
                
                element.innerHTML = '';
                element.appendChild(badge);
            });
        }

        // Tooltips initialization
        function initializeTooltips() {
            const elementsWithTitles = document.querySelectorAll('[title]');
            
            elementsWithTitles.forEach(element => {
                element.addEventListener('mouseenter', showTooltip);
                element.addEventListener('mouseleave', hideTooltip);
                element.addEventListener('mousemove', moveTooltip);
            });
        }

        // Tooltip functions
        function showTooltip(e) {
            const tooltip = document.createElement('div');
            tooltip.className = 'custom-tooltip';
            tooltip.textContent = e.target.title;
            tooltip.style.cssText = `
                position: absolute;
                background: var(--navy);
                color: white;
                padding: 8px 12px;
                border-radius: 6px;
                font-size: 14px;
                z-index: 1000;
                pointer-events: none;
                opacity: 0;
                transition: opacity 0.3s ease;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            `;
            
            document.body.appendChild(tooltip);
            e.target.removeAttribute('title');
            e.target.dataset.originalTitle = tooltip.textContent;
            
            setTimeout(() => tooltip.style.opacity = '1', 10);
            
            moveTooltip(e);
        }

        function hideTooltip(e) {
            const tooltip = document.querySelector('.custom-tooltip');
            if (tooltip) {
                tooltip.style.opacity = '0';
                setTimeout(() => tooltip.remove(), 300);
            }
            
            if (e.target.dataset.originalTitle) {
                e.target.title = e.target.dataset.originalTitle;
                delete e.target.dataset.originalTitle;
            }
        }

        function moveTooltip(e) {
            const tooltip = document.querySelector('.custom-tooltip');
            if (tooltip) {
                tooltip.style.left = (e.pageX + 10) + 'px';
                tooltip.style.top = (e.pageY - 10) + 'px';
            }
        }

        // Smooth scrolling
        function initializeSmoothScrolling() {
            document.documentElement.style.scrollBehavior = 'smooth';
        }

        // Copy functionality
        function initializeCopyFunctionality() {
            const copyableElements = document.querySelectorAll('p:has(strong)');
            
            copyableElements.forEach(element => {
                element.style.cursor = 'pointer';
                element.title = 'Klik untuk menyalin';
                
                element.addEventListener('click', function() {
                    const text = this.textContent;
                    navigator.clipboard.writeText(text).then(() => {
                        showCopyNotification();
                    });
                });
            });
        }

        // Copy notification
        function showCopyNotification() {
            const notification = document.createElement('div');
            notification.textContent = 'Teks berhasil disalin!';
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: var(--success);
                color: white;
                padding: 12px 20px;
                border-radius: 8px;
                z-index: 9999;
                opacity: 0;
                transform: translateY(-20px);
                transition: all 0.3s ease;
                box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
            `;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.style.opacity = '1';
                notification.style.transform = 'translateY(0)';
            }, 10);
            
            setTimeout(() => {
                notification.style.opacity = '0';
                notification.style.transform = 'translateY(-20px)';
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }

        // Enhanced download functionality
        function enhanceDownloadLinks() {
            const downloadLinks = document.querySelectorAll('a[download]');
            
            downloadLinks.forEach(link => {
                link.classList.add('download-link');
                
                const icon = document.createElement('i');
                icon.className = 'fas fa-download';
                link.insertBefore(icon, link.firstChild);
                
                link.addEventListener('click', function() {
                    this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengunduh...';
                    
                    setTimeout(() => {
                        this.innerHTML = '<i class="fas fa-check"></i> Selesai';
                        setTimeout(() => {
                            this.innerHTML = '<i class="fas fa-download"></i> ' + this.textContent.replace('Selesai', '').trim();
                        }, 2000);
                    }, 1000);
                });
            });
        }

        // Call enhance function
        document.addEventListener('DOMContentLoaded', enhanceDownloadLinks);

        // Performance optimization
        function optimizePerformance() {
            // Lazy load images
            const images = document.querySelectorAll('img');
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src || img.src;
                        img.classList.remove('loading');
                        observer.unobserve(img);
                    }
                });
            });

            images.forEach(img => {
                imageObserver.observe(img);
            });
        }

        // Initialize performance optimizations
        document.addEventListener('DOMContentLoaded', optimizePerformance);