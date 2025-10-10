// Modern Blue Theme - Interactive JavaScript
document.addEventListener('DOMContentLoaded', function() {
    
    // Smooth Scroll Animation Observer
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, observerOptions);

    // Observe all cards and sections
    document.querySelectorAll('.card, .row, table').forEach(el => {
        el.classList.add('animate-on-scroll');
        observer.observe(el);
    });

    // Button Ripple Effect Enhancement
    document.querySelectorAll('.btn').forEach(button => {
        button.addEventListener('click', function(e) {
            const ripple = document.createElement('span');
            ripple.classList.add('ripple-effect');
            this.appendChild(ripple);

            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;

            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';

            setTimeout(() => ripple.remove(), 600);
        });
    });

    // Table Row Hover Animation
    const tableRows = document.querySelectorAll('tbody tr');
    tableRows.forEach((row, index) => {
        row.style.animationDelay = `${index * 0.05}s`;
        row.classList.add('fade-in-row');
    });

    // Search Input Auto-focus Animation
    const searchInputs = document.querySelectorAll('input[type="search"], input[type="text"]');
    searchInputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('input-focused');
        });
        input.addEventListener('blur', function() {
            this.parentElement.classList.remove('input-focused');
        });
    });

    // Image Lazy Load with Fade Effect
    const images = document.querySelectorAll('img');
    images.forEach(img => {
        img.style.opacity = '0';
        img.addEventListener('load', function() {
            this.style.transition = 'opacity 0.5s ease';
            this.style.opacity = '1';
        });
    });

    // Delete Confirmation with Animation
    document.querySelectorAll('.btn-delete, .btn[class*="hapus"]').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            
            const confirmation = confirm('Apakah Anda yakin ingin menghapus data ini?');
            if (confirmation) {
                this.innerHTML = '<span class="loading"></span> Menghapus...';
                this.disabled = true;
                
                setTimeout(() => {
                    const row = this.closest('tr');
                    if (row) {
                        row.style.animation = 'fadeOut 0.5s ease';
                        setTimeout(() => {
                            if (this.closest('form')) {
                                this.closest('form').submit();
                            }
                        }, 500);
                    }
                }, 500);
            }
        });
    });

    // Filter Button Animation
    const filterBtn = document.querySelector('.btn[class*="filter"], button:contains("Filter")');
    if (filterBtn) {
        filterBtn.addEventListener('click', function() {
            this.classList.add('btn-loading');
            setTimeout(() => {
                this.classList.remove('btn-loading');
            }, 1000);
        });
    }

    // Back Button with Smooth Transition
    document.querySelectorAll('.btn-secondary, a:contains("Kembali")').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            document.body.style.opacity = '0';
            document.body.style.transform = 'scale(0.98)';
            document.body.style.transition = 'all 0.3s ease';
            
            setTimeout(() => {
                window.location.href = this.href;
            }, 300);
        });
    });

    // Profile Info Card Stagger Animation
    const profileItems = document.querySelectorAll('.col-md-6 p');
    profileItems.forEach((item, index) => {
        item.style.opacity = '0';
        item.style.transform = 'translateX(-20px)';
        setTimeout(() => {
            item.style.transition = 'all 0.4s ease';
            item.style.opacity = '1';
            item.style.transform = 'translateX(0)';
        }, index * 50);
    });

    // Social Media Links Hover Effect
    const socialLinks = document.querySelectorAll('a[href*="linkedin"], a[href*="instagram"], a[href*="facebook"], a[href*="twitter"], a[href*="tiktok"]');
    socialLinks.forEach(link => {
        link.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-3px) scale(1.05)';
        });
        link.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });

    // Card Header Gradient Animation
    const cardHeaders = document.querySelectorAll('.card-header');
    cardHeaders.forEach(header => {
        header.addEventListener('mouseenter', function() {
            this.style.backgroundSize = '120% 120%';
        });
        header.addEventListener('mouseleave', function() {
            this.style.backgroundSize = '100% 100%';
        });
    });

    // Smooth Page Transition on Load
    document.body.style.opacity = '0';
    window.addEventListener('load', () => {
        setTimeout(() => {
            document.body.style.transition = 'opacity 0.5s ease';
            document.body.style.opacity = '1';
        }, 100);
    });

    // Auto-hide Alert Messages
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.animation = 'slideOut 0.5s ease';
            setTimeout(() => alert.remove(), 500);
        }, 5000);
    });

    // Number Counter Animation for Statistics
    const counters = document.querySelectorAll('[data-count]');
    counters.forEach(counter => {
        const target = parseInt(counter.getAttribute('data-count'));
        const duration = 2000;
        const step = target / (duration / 16);
        let current = 0;

        const updateCounter = () => {
            current += step;
            if (current < target) {
                counter.textContent = Math.floor(current);
                requestAnimationFrame(updateCounter);
            } else {
                counter.textContent = target;
            }
        };

        observer.observe(counter);
        counter.addEventListener('visible', updateCounter, { once: true });
    });

    // Enhanced Tooltip
    const tooltipElements = document.querySelectorAll('[data-tooltip]');
    tooltipElements.forEach(el => {
        el.addEventListener('mouseenter', function() {
            const tooltip = document.createElement('div');
            tooltip.className = 'custom-tooltip';
            tooltip.textContent = this.getAttribute('data-tooltip');
            document.body.appendChild(tooltip);

            const rect = this.getBoundingClientRect();
            tooltip.style.left = rect.left + (rect.width / 2) - (tooltip.offsetWidth / 2) + 'px';
            tooltip.style.top = rect.top - tooltip.offsetHeight - 10 + 'px';
            
            setTimeout(() => tooltip.classList.add('show'), 10);
        });

        el.addEventListener('mouseleave', function() {
            const tooltips = document.querySelectorAll('.custom-tooltip');
            tooltips.forEach(t => {
                t.classList.remove('show');
                setTimeout(() => t.remove(), 300);
            });
        });
    });

    // Dynamic Badge Color
    const badges = document.querySelectorAll('.badge, [class*="USER"], [class*="ADMIN"], [class*="COMPANY"]');
    badges.forEach(badge => {
        const text = badge.textContent.toLowerCase();
        if (text.includes('user')) {
            badge.style.background = 'linear-gradient(135deg, #06b6d4 0%, #0891b2 100%)';
        } else if (text.includes('admin')) {
            badge.style.background = 'linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%)';
        } else if (text.includes('company')) {
            badge.style.background = 'linear-gradient(135deg, #10b981 0%, #059669 100%)';
        }
    });

    // Parallax Effect on Scroll
    let ticking = false;
    window.addEventListener('scroll', () => {
        if (!ticking) {
            window.requestAnimationFrame(() => {
                const scrolled = window.pageYOffset;
                const cards = document.querySelectorAll('.card');
                
                cards.forEach((card, index) => {
                    const speed = 0.5 + (index * 0.1);
                    card.style.transform = `translateY(${scrolled * speed * 0.01}px)`;
                });
                
                ticking = false;
            });
            ticking = true;
        }
    });

});
