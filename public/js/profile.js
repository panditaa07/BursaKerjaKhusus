// ==========================================
// MODERN PROFILE JAVASCRIPT
// Smooth Animations & Interactions
// ==========================================

document.addEventListener('DOMContentLoaded', function() {
    
    // === SMOOTH SCROLL ANIMATIONS ===
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
    document.querySelectorAll('.card').forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = 'all 0.6s ease-out';
        observer.observe(card);
    });

    // === BUTTON RIPPLE EFFECT ===
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

        button.appendChild(ripple);

        setTimeout(() => {
            ripple.remove();
        }, 600);
    }

    // Add ripple to all buttons
    document.querySelectorAll('.btn').forEach(button => {
        button.addEventListener('click', createRipple);
        
        // Add ripple CSS if not exists
        if (!document.getElementById('ripple-style')) {
            const style = document.createElement('style');
            style.id = 'ripple-style';
            style.textContent = `
                .btn { position: relative; overflow: hidden; }
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
    });

    // === IMAGE PREVIEW MODAL ===
    document.querySelectorAll('.card-body img').forEach(img => {
        img.style.cursor = 'pointer';
        img.addEventListener('click', function() {
            const modal = createImageModal(this.src, this.alt);
            document.body.appendChild(modal);
            setTimeout(() => modal.classList.add('show'), 10);
        });
    });

    function createImageModal(src, alt) {
        const modal = document.createElement('div');
        modal.className = 'image-modal';
        modal.innerHTML = `
            <div class="modal-backdrop">
                <div class="modal-content">
                    <img src="${src}" alt="${alt}">
                    <button class="modal-close">&times;</button>
                </div>
            </div>
        `;

        modal.querySelector('.modal-close').addEventListener('click', () => {
            modal.classList.remove('show');
            setTimeout(() => modal.remove(), 300);
        });

        modal.querySelector('.modal-backdrop').addEventListener('click', (e) => {
            if (e.target === e.currentTarget) {
                modal.classList.remove('show');
                setTimeout(() => modal.remove(), 300);
            }
        });

        // Add modal styles
        if (!document.getElementById('modal-style')) {
            const style = document.createElement('style');
            style.id = 'modal-style';
            style.textContent = `
                .image-modal {
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    z-index: 9999;
                    opacity: 0;
                    transition: opacity 0.3s ease;
                }
                .image-modal.show {
                    opacity: 1;
                }
                .modal-backdrop {
                    background: rgba(30, 58, 138, 0.95);
                    width: 100%;
                    height: 100%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    padding: 2rem;
                }
                .modal-content {
                    position: relative;
                    max-width: 90%;
                    max-height: 90%;
                    animation: zoomIn 0.3s ease;
                }
                .modal-content img {
                    max-width: 100%;
                    max-height: 80vh;
                    border-radius: 12px;
                    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
                }
                .modal-close {
                    position: absolute;
                    top: -15px;
                    right: -15px;
                    background: white;
                    border: none;
                    width: 40px;
                    height: 40px;
                    border-radius: 50%;
                    font-size: 24px;
                    cursor: pointer;
                    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
                    transition: all 0.3s ease;
                    color: #1e3a8a;
                }
                .modal-close:hover {
                    transform: rotate(90deg) scale(1.1);
                    background: #ef4444;
                    color: white;
                }
                @keyframes zoomIn {
                    from {
                        transform: scale(0.8);
                        opacity: 0;
                    }
                    to {
                        transform: scale(1);
                        opacity: 1;
                    }
                }
            `;
            document.head.appendChild(style);
        }

        return modal;
    }

    // === SMOOTH COUNTER ANIMATION ===
    function animateValue(element, start, end, duration) {
        let startTimestamp = null;
        const step = (timestamp) => {
            if (!startTimestamp) startTimestamp = timestamp;
            const progress = Math.min((timestamp - startTimestamp) / duration, 1);
            element.textContent = Math.floor(progress * (end - start) + start);
            if (progress < 1) {
                window.requestAnimationFrame(step);
            }
        };
        window.requestAnimationFrame(step);
    }

    // === TABLE INTERACTIONS ===
    const tableRows = document.querySelectorAll('tbody tr');
    tableRows.forEach((row, index) => {
        row.style.animationDelay = `${index * 0.05}s`;
        row.style.animation = 'fadeInUp 0.5s ease-out forwards';
        
        // Add hover sound effect (optional)
        row.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.02)';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    });

    // === SEARCH FUNCTIONALITY ===
    const searchInput = document.querySelector('input[placeholder*="Cari"]');
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            
            tableRows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    row.style.display = '';
                    row.style.animation = 'fadeInUp 0.3s ease-out';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }

    // === DELETE CONFIRMATION ===
    document.querySelectorAll('.btn-delete, .btn[class*="hapus"]').forEach(btn => {
        btn.addEventListener('click', function(e) {
            if (!confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                e.preventDefault();
            }
        });
    });

    // === TOOLTIP FOR TRUNCATED TEXT ===
    document.querySelectorAll('td').forEach(cell => {
        if (cell.scrollWidth > cell.clientWidth) {
            cell.title = cell.textContent;
        }
    });

    // === LOADING STATE FOR BUTTONS ===
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function() {
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
            }
        });
    });

    // === COPY TO CLIPBOARD ===
    document.querySelectorAll('.card-body a[href^="http"]').forEach(link => {
        link.addEventListener('dblclick', function(e) {
            e.preventDefault();
            navigator.clipboard.writeText(this.href).then(() => {
                showToast('Link berhasil disalin!');
            });
        });
    });

    // === TOAST NOTIFICATION ===
    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;
        toast.textContent = message;
        document.body.appendChild(toast);

        if (!document.getElementById('toast-style')) {
            const style = document.createElement('style');
            style.id = 'toast-style';
            style.textContent = `
                .toast {
                    position: fixed;
                    bottom: 2rem;
                    right: 2rem;
                    background: #3b82f6;
                    color: white;
                    padding: 1rem 1.5rem;
                    border-radius: 8px;
                    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
                    animation: slideInRight 0.3s ease, slideOutRight 0.3s ease 2.7s;
                    z-index: 10000;
                }
                .toast-success { background: #10b981; }
                .toast-error { background: #ef4444; }
                @keyframes slideInRight {
                    from {
                        transform: translateX(400px);
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
                        transform: translateX(400px);
                        opacity: 0;
                    }
                }
            `;
            document.head.appendChild(style);
        }

        setTimeout(() => toast.remove(), 3000);
    }

    // === SMOOTH SCROLL TO TOP ===
    const scrollBtn = document.createElement('button');
    scrollBtn.innerHTML = '<i class="fas fa-arrow-up"></i>';
    scrollBtn.className = 'scroll-to-top';
    document.body.appendChild(scrollBtn);

    const scrollStyle = document.createElement('style');
    scrollStyle.textContent = `
        .scroll-to-top {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            color: white;
            border: none;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            cursor: pointer;
            opacity: 0;
            transition: all 0.3s ease;
            z-index: 1000;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
        }
        .scroll-to-top.show {
            opacity: 1;
        }
        .scroll-to-top:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.6);
        }
    `;
    document.head.appendChild(scrollStyle);

    window.addEventListener('scroll', () => {
        if (window.pageYOffset > 300) {
            scrollBtn.classList.add('show');
        } else {
            scrollBtn.classList.remove('show');
        }
    });

    scrollBtn.addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });

    // === PAGE LOAD ANIMATION ===
    document.body.style.opacity = '0';
    setTimeout(() => {
        document.body.style.transition = 'opacity 0.5s ease';
        document.body.style.opacity = '1';
    }, 100);

    console.log('✨ Modern Profile JS Loaded Successfully!');
});