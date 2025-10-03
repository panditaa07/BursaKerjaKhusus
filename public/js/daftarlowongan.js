// Modern Blue Theme - JavaScript Animations

document.addEventListener('DOMContentLoaded', function() {
    
    // Smooth Scroll Animation
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animation = 'slideUp 0.6s ease-out forwards';
            }
        });
    }, observerOptions);

    // Observe all job cards
    const jobCards = document.querySelectorAll('.job-card');
    jobCards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.1}s`;
        observer.observe(card);
    });

    // Add ripple effect to info buttons
    const infoButtons = document.querySelectorAll('.info-button');
    infoButtons.forEach(button => {
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

    // Add hover effect for job cards
    jobCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-4px) scale(1.01)';
        });

        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });

    // Animate job title on hover
    const jobTitles = document.querySelectorAll('.job-title');
    jobTitles.forEach(title => {
        const text = title.textContent;
        title.addEventListener('mouseenter', function() {
            this.style.letterSpacing = '0.5px';
        });
        
        title.addEventListener('mouseleave', function() {
            this.style.letterSpacing = '0px';
        });
    });

    // Add parallax effect to job images
    jobCards.forEach(card => {
        const img = card.querySelector('.job-image');
        
        card.addEventListener('mousemove', function(e) {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;
            
            const deltaX = (x - centerX) / centerX;
            const deltaY = (y - centerY) / centerY;
            
            if (img) {
                img.style.transform = `scale(1.05) translate(${deltaX * 5}px, ${deltaY * 5}px)`;
            }
        });
        
        card.addEventListener('mouseleave', function() {
            if (img) {
                img.style.transform = 'scale(1) translate(0, 0)';
            }
        });
    });

    // Badge animation on scroll
    const badges = document.querySelectorAll('.badge-job-type');
    const badgeObserver = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animation = 'bounceIn 0.6s ease-out';
            }
        });
    }, observerOptions);

    badges.forEach(badge => {
        badgeObserver.observe(badge);
    });

    // Add loading animation
    const style = document.createElement('style');
    style.textContent = `
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
                transform: scale(2);
                opacity: 0;
            }
        }

        @keyframes bounceIn {
            0% {
                transform: scale(0.3);
                opacity: 0;
            }
            50% {
                transform: scale(1.05);
            }
            70% {
                transform: scale(0.9);
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .job-title {
            transition: letter-spacing 0.3s ease;
        }

        .job-image {
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
    `;
    document.head.appendChild(style);

    // Smooth scroll for pagination
    const paginationLinks = document.querySelectorAll('.pagination a');
    paginationLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    });

    // Add skeleton loading effect (optional - for initial load)
    function addSkeletonLoading() {
        const jobList = document.querySelector('.job-list');
        if (jobList && jobCards.length === 0) {
            for (let i = 0; i < 3; i++) {
                const skeleton = document.createElement('div');
                skeleton.className = 'job-card skeleton';
                skeleton.innerHTML = `
                    <div class="skeleton-image"></div>
                    <div class="skeleton-content">
                        <div class="skeleton-line"></div>
                        <div class="skeleton-line short"></div>
                        <div class="skeleton-line medium"></div>
                    </div>
                `;
                jobList.appendChild(skeleton);
            }
        }
    }

    // Fade in animation for empty message
    const emptyMessage = document.querySelector('.empty-message');
    if (emptyMessage) {
        emptyMessage.style.animation = 'fadeIn 0.8s ease-out';
    }

    // Add focus effect for accessibility
    infoButtons.forEach(button => {
        button.addEventListener('focus', function() {
            this.style.outline = '3px solid rgba(59, 130, 246, 0.5)';
            this.style.outlineOffset = '2px';
        });

        button.addEventListener('blur', function() {
            this.style.outline = 'none';
        });
    });

    // Counter animation for salary
    const salaryElements = document.querySelectorAll('.salary');
    salaryElements.forEach(salary => {
        const text = salary.textContent;
        salary.style.opacity = '0';
        
        setTimeout(() => {
            salary.style.transition = 'opacity 0.5s ease-in';
            salary.style.opacity = '1';
        }, 300);
    });

    // Add stagger animation to job details
    jobCards.forEach((card, cardIndex) => {
        const details = card.querySelectorAll('.job-location, .job-deadline, .salary');
        details.forEach((detail, index) => {
            detail.style.opacity = '0';
            detail.style.transform = 'translateX(-10px)';
            
            setTimeout(() => {
                detail.style.transition = 'all 0.4s ease-out';
                detail.style.opacity = '1';
                detail.style.transform = 'translateX(0)';
            }, (cardIndex * 100) + (index * 50) + 200);
        });
    });

    console.log('✨ Modern Blue Theme loaded successfully!');
});

// Performance optimization
if ('IntersectionObserver' in window) {
    console.log('✅ IntersectionObserver supported');
} else {
    console.warn('⚠️ IntersectionObserver not supported, falling back to immediate animations');
}

// Add CSS variables for dynamic theming (optional)
function setThemeColor(primaryColor) {
    document.documentElement.style.setProperty('--primary-blue', primaryColor);
}

// Export for use in other scripts if needed
window.modernBlueTheme = {
    setThemeColor: setThemeColor
};