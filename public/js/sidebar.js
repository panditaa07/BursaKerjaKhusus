
document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.getElementById('sidebar');
    const menuToggle = document.getElementById('menuToggle');
    const mainContent = document.getElementById('mainContent');

    // Function to toggle sidebar
    const toggleSidebar = () => {
        if (window.innerWidth < 992) {
            // Mobile/Tablet: Toggle show class for overlay
            const isShown = sidebar.classList.contains('show');
            if (isShown) {
                sidebar.classList.remove('show');
                sidebarBackdrop.classList.remove('show');
            } else {
                sidebar.classList.add('show');
                sidebarBackdrop.classList.add('show');
            }
        } else {
            // Desktop: Toggle collapsed for narrow sidebar
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
        }
    };

    // Event listener for the menu toggle button
    if (menuToggle) {
        menuToggle.addEventListener('click', toggleSidebar);
    }

    // Backdrop click to close sidebar on mobile
    const sidebarBackdrop = document.getElementById('sidebarBackdrop');
    if (sidebarBackdrop) {
        sidebarBackdrop.addEventListener('click', () => {
            if (window.innerWidth < 992 && sidebar.classList.contains('show')) {
                sidebar.classList.remove('show');
                sidebarBackdrop.classList.remove('show');
            }
        });
    }

    // Handle window resize
    window.addEventListener('resize', () => {
        if (window.innerWidth >= 992) {
            // Desktop: Ensure sidebar is visible and remove show class
            sidebar.classList.remove('show');
            if (sidebarBackdrop) sidebarBackdrop.classList.remove('show');
        } else {
            // Mobile: Ensure collapsed and expanded are removed, sidebar hidden by default
            sidebar.classList.remove('collapsed');
            sidebar.classList.remove('show');
            mainContent.classList.remove('expanded');
            if (sidebarBackdrop) sidebarBackdrop.classList.remove('show');
        }
    });

    // Initial setup
    if (window.innerWidth < 992) {
        // Mobile: Sidebar hidden by default
        sidebar.classList.remove('collapsed');
        mainContent.classList.remove('expanded');
    }
});
