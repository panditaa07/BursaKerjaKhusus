window.addEventListener('load', function() {
            setTimeout(function() {
                const loadingOverlay = document.getElementById('loadingOverlay');
                loadingOverlay.classList.add('fade-out');
                setTimeout(function() {
                    loadingOverlay.style.display = 'none';
                }, 500);
            }, 1000);
        });

        // Smooth scroll behavior
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Add ripple effect to buttons
        function createRipple(event) {
            const button = event.currentTarget;
            const circle = document.createElement('span');
            const diameter = Math.max(button.clientWidth, button.clientHeight);
            const radius = diameter / 2;

            circle.style.width = circle.style.height = `${diameter}px`;
            circle.style.left = `${event.clientX - button.offsetLeft - radius}px`;
            circle.style.top = `${event.clientY - button.offsetTop - radius}px`;
            circle.classList.add('ripple');

            const ripple = button.getElementsByClassName('ripple')[0];
            if (ripple) {
                ripple.remove();
            }

            button.appendChild(circle);
        }

        // Add ripple style
        const style = document.createElement('style');
        style.textContent = `
            .ripple {
                position: absolute;
                border-radius: 50%;
                background-color: rgba(255, 255, 255, 0.3);
                transform: scale(0);
                animation: ripple-animation 0.6s linear;
                pointer-events: none;
            }

            @keyframes ripple-animation {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }

            .social-btn, .download-link, .back-button {
                position: relative;
                overflow: hidden;
            }
        `;
        document.head.appendChild(style);

        // Apply ripple effect
        document.querySelectorAll('.social-btn, .download-link, .back-button').forEach(button => {
            button.addEventListener('click', createRipple);
        });

        // Intersection Observer for scroll animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.animationPlayState = 'running';
                }
            });
        }, observerOptions);

        // Observe elements for animation
        document.querySelectorAll('.info-item').forEach(item => {
            item.style.animationPlayState = 'paused';
            observer.observe(item);
        });

        // Add parallax effect to profile photo
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const profilePhoto = document.querySelector('.profile-photo');
            if (profilePhoto) {
                profilePhoto.style.transform = `scale(${1 + scrolled * 0.0001}) rotate(${scrolled * 0.05}deg)`;
            }
        });

        // Dynamic status badge animation
        document.querySelectorAll('.status-badge').forEach(badge => {
            badge.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.1) rotate(-2deg)';
            });
            
            badge.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1) rotate(0deg)';
            });
        });

        // Add floating animation to social buttons
        document.querySelectorAll('.social-btn').forEach((btn, index) => {
            btn.style.animationDelay = `${index * 0.1}s`;
            btn.style.animation = `float 3s ease-in-out infinite`;
        });

        // Add float animation
        const floatStyle = document.createElement('style');
        floatStyle.textContent = `
            @keyframes float {
                0%, 100% {
                    transform: translateY(0px);
                }
                50% {
                    transform: translateY(-5px);
                }
            }
        `;
        document.head.appendChild(floatStyle);

        // Copy to clipboard functionality (optional)
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                // Show toast notification
                showToast('Berhasil disalin ke clipboard!');
            });
        }

        function showToast(message) {
            const toast = document.createElement('div');
            toast.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: linear-gradient(135deg, var(--success-color), #22c55e);
                color: white;
                padding: 1rem 1.5rem;
                border-radius: 10px;
                box-shadow: var(--shadow-medium);
                z-index: 10000;
                animation: slideInRight 0.3s ease-out;
            `;
            toast.textContent = message;
            document.body.appendChild(toast);

            setTimeout(() => {
                toast.style.animation = 'slideOutRight 0.3s ease-out';
                setTimeout(() => {
                    document.body.removeChild(toast);
                }, 300);
            }, 3000);
        }

        // Add slide animations for toast
        const toastStyle = document.createElement('style');
        toastStyle.textContent = `
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
        `;
        document.head.appendChild(toastStyle);