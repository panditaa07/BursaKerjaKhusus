
document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.getElementById('sidebar');
    const menuToggle = document.getElementById('menuToggle');
    const mainContent = document.getElementById('mainContent');

    // Function to toggle sidebar
    const toggleSidebar = () => {
        sidebar.classList.toggle('collapsed');
        mainContent.classList.toggle('expanded');
    };

    // Event listener for the menu toggle button
    if (menuToggle) {
        menuToggle.addEventListener('click', toggleSidebar);
    }

    // Optional: Close sidebar by default on smaller screens
    if (window.innerWidth < 992) {
        sidebar.classList.add('collapsed');
        mainContent.classList.add('expanded');
    }
});
