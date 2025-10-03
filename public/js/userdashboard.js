// ===== DOM READY =====
document.addEventListener('DOMContentLoaded', function() {
    
    // ===== SMOOTH SCROLL FOR ANCHORS =====
    const links = document.querySelectorAll('a[href^="#"]');
    links.forEach(link => {
        link.addEventListener('click', function(e) {
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

    // ===== INTERSECTION OBSERVER FOR ANIMATIONS =====
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    // Observe all cards
    const cards = document.querySelectorAll('.lowongan-card');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = `all 0.6s ease ${index * 0.1}s`;
        observer.observe(card);
    });

    // ===== PARALLAX EFFECT FOR HEADER =====
    const header = document.querySelector('.dashboard-header-bg');
    if (header) {
        window.addEventListener('scroll', function() {
            const scrolled = window.pageYOffset;
            const rate = scrolled * 0.5;
            header.style.transform = `translateY(${rate}px)`;
        });
    }

    // ===== HOVER EFFECT FOR CARDS =====
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.zIndex = '10';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.zIndex = '1';
        });
    });

    // ===== LAZY LOADING FOR IMAGES =====
    const images = document.querySelectorAll('img[data-src]');
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.removeAttribute('data-src');
                imageObserver.unobserve(img);
            }
        });
    });

    images.forEach(img => imageObserver.observe(img));

    // ===== DYNAMIC TIME UPDATE =====
    const timeElements = document.querySelectorAll('.lowongan-details div:has(.fa-clock)');
    timeElements.forEach(el => {
        const updateTime = () => {
            // This would need actual timestamp data from backend
            // Placeholder for dynamic time update functionality
        };
        setInterval(updateTime, 60000); // Update every minute
    });

    // ===== BUTTON RIPPLE EFFECT =====
    const buttons = document.querySelectorAll('.btn-primary');
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

    // ===== SCROLL TO TOP BUTTON =====
    const scrollTopBtn = document.createElement('button');
    scrollTopBtn.innerHTML = '<i class="fas fa-arrow-up"></i>';
    scrollTopBtn.className = 'scroll-to-top';
    scrollTopBtn.style.cssText = `
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #1e5bb8 0%, #2563eb 100%);
        color: white;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(30, 91, 184, 0.3);
        z-index: 1000;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    `;
    
    document.body.appendChild(scrollTopBtn);
    
    window.addEventListener('scroll', function() {
        if (window.pageYOffset > 300) {
            scrollTopBtn.style.opacity = '1';
            scrollTopBtn.style.visibility = 'visible';
        } else {
            scrollTopBtn.style.opacity = '0';
            scrollTopBtn.style.visibility = 'hidden';
        }
    });
    
    scrollTopBtn.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });

    scrollTopBtn.addEventListener('mouseenter', function() {
        this.style.transform = 'translateY(-5px) scale(1.1)';
    });

    scrollTopBtn.addEventListener('mouseleave', function() {
        this.style.transform = 'translateY(0) scale(1)';
    });

    // ===== PRELOAD IMAGES =====
    const preloadImages = () => {
        const imgElements = document.querySelectorAll('img');
        imgElements.forEach(img => {
            const src = img.getAttribute('src');
            if (src) {
                const newImg = new Image();
                newImg.src = src;
            }
        });
    };
    
    preloadImages();

    // ===== CARD TILT EFFECT (3D) =====
    cards.forEach(card => {
        card.addEventListener('mousemove', function(e) {
            const rect = this.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;
            
            const rotateX = (y - centerY) / 20;
            const rotateY = (centerX - x) / 20;
            
            this.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateY(-8px)`;
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'perspective(1000px) rotateX(0) rotateY(0) translateY(0)';
        });
    });

    // ===== LOADING STATE SIMULATION =====
    const showLoadingState = () => {
        cards.forEach(card => {
            card.classList.add('loading');
        });
        
        setTimeout(() => {
            cards.forEach(card => {
                card.classList.remove('loading');
            });
        }, 1000);
    };

    // ===== FOOTER LINK ANIMATION =====
    const footerLinks = document.querySelectorAll('.tautan a');
    footerLinks.forEach(link => {
        link.addEventListener('mouseenter', function() {
            this.style.letterSpacing = '0.5px';
        });
        
        link.addEventListener('mouseleave', function() {
            this.style.letterSpacing = '0';
        });
    });

    // ===== PERFORMANCE OPTIMIZATION =====
    let ticking = false;
    let lastScrollY = window.pageYOffset;

    const updateOnScroll = () => {
        lastScrollY = window.pageYOffset;
        ticking = false;
        
        // Add any scroll-based animations here
    };

    window.addEventListener('scroll', function() {
        if (!ticking) {
            window.requestAnimationFrame(updateOnScroll);
            ticking = true;
        }
    });

    // ===== CONSOLE WELCOME MESSAGE =====
    console.log('%c🎓 SMK Negeri 4 Bandung', 'font-size: 20px; font-weight: bold; color: #1e5bb8;');
    console.log('%cBursa Kerja Khusus Dashboard', 'font-size: 14px; color: #2563eb;');
    
});

// ===== UTILITY FUNCTIONS =====
const debounce = (func, wait) => {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
};

const throttle = (func, limit) => {
    let inThrottle;
    return function() {
        const args = arguments;
        const context = this;
        if (!inThrottle) {
            func.apply(context, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    };
};

// ===== EXPORT FOR MODULE USAGE =====
if (typeof module !== 'undefined' && module.exports) {
    module.exports = { debounce, throttle };
}