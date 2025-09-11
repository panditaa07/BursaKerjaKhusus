document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');
    const overlay = document.getElementById('overlay');

    // Toggle sidebar
    function toggleSidebar() {
        sidebar.classList.toggle('active');
        overlay.classList.toggle('active');
        
        if (window.innerWidth > 768) {
            mainContent.classList.toggle('shifted');
        }

        const icon = menuToggle.querySelector('i');
        if (sidebar.classList.contains('active')) {
            icon.style.transform = 'rotate(90deg)';
        } else {
            icon.style.transform = 'rotate(0deg)';
        }
    }

    // Event listeners
    menuToggle.addEventListener('click', toggleSidebar);
    overlay.addEventListener('click', toggleSidebar);

    window.addEventListener('resize', function() {
        if (window.innerWidth <= 768) {
            mainContent.classList.remove('shifted');
        } else if (sidebar.classList.contains('active')) {
            mainContent.classList.add('shifted');
        }
    });

    // Animate numbers
    function animateNumbers() {
        const numbers = document.querySelectorAll('.stat-number');
        numbers.forEach(number => {
            const finalNumber = parseInt(number.textContent);
            let currentNumber = 0;
            const increment = finalNumber / 30;
            
            const timer = setInterval(() => {
                currentNumber += increment;
                if (currentNumber >= finalNumber) {
                    currentNumber = finalNumber;
                    clearInterval(timer);
                }
                number.textContent = Math.floor(currentNumber);
            }, 50);
        });
    }

    // Hover effects
    const actionButtons = document.querySelectorAll('.action-btn');
    actionButtons.forEach(btn => {
        btn.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-3px) scale(1.1)';
        });
        
        btn.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });

    // Sidebar links
    const sidebarLinks = document.querySelectorAll('.sidebar-menu a');
    sidebarLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            sidebarLinks.forEach(l => l.classList.remove('active'));
            this.classList.add('active');
            
            if (window.innerWidth <= 768) {
                sidebar.classList.add('hidden');
                overlay.classList.remove('active');
            }
        });
    });

    // Table row click effect
    const tableRows = document.querySelectorAll('.modern-table tbody tr');
    tableRows.forEach(row => {
        row.addEventListener('click', function() {
            this.style.backgroundColor = '#e0f2fe';
            setTimeout(() => {
                this.style.backgroundColor = '';
            }, 200);
        });
    });

    // Animate on scroll
    function animateOnScroll() {
        const elements = document.querySelectorAll('.table-section');
        
        elements.forEach(element => {
            const elementTop = element.getBoundingClientRect().top;
            const elementVisible = 150;
            
            if (elementTop < window.innerHeight - elementVisible) {
                element.classList.add('fade-in-up');
            }
        });
    }
    window.addEventListener('scroll', animateOnScroll);

    // Initialize
    setTimeout(animateNumbers, 800);
    animateOnScroll();

    // Notification system
    function showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        notification.className = `alert alert-${type} position-fixed`;
        notification.style.cssText = `
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 300px;
            animation: slideInRight 0.5s ease;
        `;
        notification.innerHTML = `
            <strong>${type === 'success' ? 'Sukses!' : 'Error!'}</strong> ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 5000);
    }

    setTimeout(() => {
        showNotification('Dashboard berhasil dimuat!');
    }, 1000);
});

document.addEventListener('DOMContentLoaded', function () {
    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');
    const overlay = document.getElementById('overlay');

    function toggleSidebar() {
        sidebar.classList.toggle('active');
        overlay.classList.toggle('active');

        // Kalau bukan mobile, dorong konten
        if (window.innerWidth > 768) {
            mainContent.classList.toggle('shifted');
        }

        // Ubah ikon
        const icon = menuToggle.querySelector('i');
        if (sidebar.classList.contains('active')) {
            icon.classList.remove('fa-bars');
            icon.classList.add('fa-times');
        } else {
            icon.classList.remove('fa-times');
            icon.classList.add('fa-bars');
        }
    }

    // Klik tombol menu
    menuToggle.addEventListener('click', toggleSidebar);

    // Klik overlay untuk tutup sidebar
    overlay.addEventListener('click', toggleSidebar);

    // Reset state kalau resize window
    window.addEventListener('resize', () => {
        if (window.innerWidth <= 768) {
            mainContent.classList.remove('shifted');
        }
    });
});

// sidebar.js
document.addEventListener("DOMContentLoaded", function () {
    const toggleBtn = document.getElementById("toggleSidebar");
    const sidebar = document.querySelector(".sidebar");

    toggleBtn.addEventListener("click", function () {
        sidebar.classList.toggle("collapsed");
    });
});
