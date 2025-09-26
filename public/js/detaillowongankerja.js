// JavaScript untuk Detail Lowongan Kerja

document.addEventListener('DOMContentLoaded', function() {
    initializeJobDetailPage();
});

function initializeJobDetailPage() {
    // Initialize animations
    initializeAnimations();
    
    // Setup button interactions
    setupButtonInteractions();
    
    // Setup status badges
    setupStatusBadges();
    
    // Setup applicants counter
    setupApplicantsCounter();
    
    // Setup table interactions
    setupTableInteractions();
    
    // Setup scroll animations
    setupScrollAnimations();
    
    // Setup responsive behavior
    setupResponsiveBehavior();
}

// Animation System
function initializeAnimations() {
    const animatedElements = document.querySelectorAll(
        '.grid > div, .mb-6, .bg-white.rounded-lg.shadow-md > .p-6 > div:last-child'
    );
    
    // Reset animation states
    animatedElements.forEach((element, index) => {
        element.style.opacity = '0';
        element.style.transform = 'translateY(20px)';
        element.style.transition = 'all 0.6s ease';
        
        // Stagger animations
        setTimeout(() => {
            element.style.opacity = '1';
            element.style.transform = 'translateY(0)';
        }, (index + 1) * 150);
    });
    
    // Header animation
    const header = document.querySelector('.flex.justify-between.items-center.mb-8');
    if (header) {
        header.style.opacity = '0';
        header.style.transform = 'translateY(-20px)';
        header.style.transition = 'all 0.6s ease';
        
        setTimeout(() => {
            header.style.opacity = '1';
            header.style.transform = 'translateY(0)';
        }, 100);
    }
}

// Button Interactions
function setupButtonInteractions() {
    const editButton = document.querySelector('a[href*="edit"]');
    const backButton = document.querySelector('a[href*="index"]');
    
    if (editButton) {
        editButton.addEventListener('click', function(e) {
            // Add loading animation
            addButtonLoadingState(this);
        });
        
        // Add icon to edit button
        addButtonIcon(editButton, 'edit');
    }
    
    if (backButton) {
        backButton.addEventListener('click', function(e) {
            // Add loading animation
            addButtonLoadingState(this);
        });
        
        // Add icon to back button
        addButtonIcon(backButton, 'back');
    }
    
    // Add hover effects
    const allButtons = document.querySelectorAll('.bg-blue-500, .bg-gray-500');
    allButtons.forEach(button => {
        button.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
        });
        
        button.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
}

function addButtonIcon(button, type) {
    const iconSVG = type === 'edit' 
        ? '<svg style="width: 1rem; height: 1rem; margin-right: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>'
        : '<svg style="width: 1rem; height: 1rem; margin-right: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>';
    
    button.innerHTML = iconSVG + button.textContent;
}

function addButtonLoadingState(button) {
    const originalText = button.textContent;
    button.innerHTML = '<svg style="width: 1rem; height: 1rem; margin-right: 0.5rem; animation: spin 1s linear infinite;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>Loading...';
    button.style.pointerEvents = 'none';
    
    // Reset after navigation (if it was cancelled)
    setTimeout(() => {
        button.innerHTML = originalText;
        button.style.pointerEvents = 'auto';
    }, 3000);
}

// Status Badge System
function setupStatusBadges() {
    const statusBadges = document.querySelectorAll('.px-2.inline-flex');
    
    statusBadges.forEach(badge => {
        const text = badge.textContent.toLowerCase();
        
        // Add animation class
        badge.style.transition = 'all 0.3s ease';
        badge.style.cursor = 'default';
        
        // Add hover effect for status badges
        badge.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.05)';
            this.style.boxShadow = '0 2px 8px rgba(0,0,0,0.15)';
        });
        
        badge.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
            this.style.boxShadow = 'none';
        });
        
        // Add status icon
        addStatusIcon(badge, text);
    });
}

function addStatusIcon(badge, status) {
    let iconSVG = '';
    
    if (status.includes('accepted')) {
        iconSVG = '<svg style="width: 0.75rem; height: 0.75rem; margin-right: 0.25rem;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>';
    } else if (status.includes('rejected')) {
        iconSVG = '<svg style="width: 0.75rem; height: 0.75rem; margin-right: 0.25rem;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>';
    } else {
        iconSVG = '<svg style="width: 0.75rem; height: 0.75rem; margin-right: 0.25rem;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/></svg>';
    }
    
    badge.innerHTML = iconSVG + badge.textContent;
}

// Applicants Counter
function setupApplicantsCounter() {
    const applicantsTitle = document.querySelector('div:last-child .text-xl.font-semibold');
    const applicantsTable = document.querySelector('.min-w-full tbody');
    
    if (applicantsTitle && applicantsTable) {
        const count = applicantsTable.querySelectorAll('tr').length;
        applicantsTitle.setAttribute('data-count', count);
        
        // Animate counter
        animateCounter(applicantsTitle, count);
    }
}

function animateCounter(element, targetCount) {
    let currentCount = 0;
    const increment = targetCount / 30; // 30 frames animation
    
    const timer = setInterval(() => {
        currentCount += increment;
        if (currentCount >= targetCount) {
            currentCount = targetCount;
            clearInterval(timer);
        }
        element.setAttribute('data-count', Math.floor(currentCount));
    }, 50);
}

// Table Interactions
function setupTableInteractions() {
    const tableRows = document.querySelectorAll('.min-w-full tbody tr');
    
    tableRows.forEach((row, index) => {
        // Add entrance animation
        row.style.opacity = '0';
        row.style.transform = 'translateX(-20px)';
        row.style.transition = 'all 0.4s ease';
        
        setTimeout(() => {
            row.style.opacity = '1';
            row.style.transform = 'translateX(0)';
        }, (index + 1) * 100 + 800);
        
        // Add click interaction for row details
        row.addEventListener('click', function() {
            highlightRow(this);
        });
        
        // Add hover sound effect (visual feedback)
        row.addEventListener('mouseenter', function() {
            this.style.transform = 'translateX(5px)';
            this.style.boxShadow = '0 2px 8px rgba(0,0,0,0.1)';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.transform = 'translateX(0)';
            this.style.boxShadow = 'none';
        });
    });
    
    // Make table responsive
    makeTableResponsive();
}

function highlightRow(row) {
    // Remove previous highlights
    document.querySelectorAll('.min-w-full tbody tr').forEach(r => {
        r.classList.remove('highlighted-row');
    });
    
    // Add highlight
    row.classList.add('highlighted-row');
    row.style.backgroundColor = '#e0f2fe';
    row.style.borderLeft = '4px solid #0284c7';
    
    // Remove highlight after 3 seconds
    setTimeout(() => {
        row.classList.remove('highlighted-row');
        row.style.backgroundColor = '';
        row.style.borderLeft = '';
    }, 3000);
}

function makeTableResponsive() {
    const table = document.querySelector('.min-w-full');
    const container = document.querySelector('.overflow-x-auto');
    
    if (table && container) {
        // Add scroll indicators
        const leftIndicator = createScrollIndicator('left');
        const rightIndicator = createScrollIndicator('right');
        
        container.appendChild(leftIndicator);
        container.appendChild(rightIndicator);
        
        // Handle scroll indicators
        container.addEventListener('scroll', function() {
            const scrollLeft = this.scrollLeft;
            const scrollWidth = this.scrollWidth;
            const clientWidth = this.clientWidth;
            
            leftIndicator.style.opacity = scrollLeft > 10 ? '1' : '0';
            rightIndicator.style.opacity = scrollLeft < scrollWidth - clientWidth - 10 ? '1' : '0';
        });
    }
}

function createScrollIndicator(direction) {
    const indicator = document.createElement('div');
    indicator.className = `scroll-indicator scroll-${direction}`;
    indicator.style.cssText = `
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 30px;
        height: 100%;
        background: linear-gradient(to ${direction === 'left' ? 'right' : 'left'}, rgba(0,0,0,0.1), transparent);
        pointer-events: none;
        opacity: 0;
        transition: opacity 0.3s ease;
        ${direction}: 0;
        z-index: 1;
    `;
    
    return indicator;
}

// Scroll Animations
function setupScrollAnimations() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-in-view');
                entry.target.style.transform = 'translateY(0)';
                entry.target.style.opacity = '1';
            }
        });
    }, observerOptions);
    
    // Observe elements for scroll animation
    const elementsToObserve = document.querySelectorAll('.mb-6, .grid > div');
    elementsToObserve.forEach(el => observer.observe(el));
}

// Responsive Behavior
function setupResponsiveBehavior() {
    let resizeTimer;
    
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            adjustLayoutForScreen();
        }, 250);
    });
    
    // Initial adjustment
    adjustLayoutForScreen();
}

function adjustLayoutForScreen() {
    const screenWidth = window.innerWidth;
    const container = document.querySelector('.container');
    const header = document.querySelector('.flex.justify-between.items-center.mb-8');
    const buttonGroup = document.querySelector('.space-x-4');
    const grid = document.querySelector('.grid.grid-cols-1.md\\:grid-cols-2');
    
    if (screenWidth <= 768) {
        // Mobile adjustments
        if (header) {
            header.style.flexDirection = 'column';
            header.style.gap = '1rem';
            header.style.textAlign = 'center';
        }
        
        if (buttonGroup) {
            buttonGroup.style.flexDirection = 'column';
            buttonGroup.style.width = '100%';
        }
        
        if (grid) {
            grid.style.gridTemplateColumns = '1fr';
            grid.style.gap = '1rem';
        }
        
        // Adjust table for mobile
        adjustTableForMobile();
    } else {
        // Desktop adjustments
        if (header) {
            header.style.flexDirection = 'row';
            header.style.textAlign = 'left';
        }
        
        if (buttonGroup) {
            buttonGroup.style.flexDirection = 'row';
            buttonGroup.style.width = 'auto';
        }
        
        if (grid) {
            grid.style.gridTemplateColumns = 'repeat(auto-fit, minmax(300px, 1fr))';
            grid.style.gap = '2rem';
        }
        
        // Reset table for desktop
        resetTableForDesktop();
    }
}

function adjustTableForMobile() {
    const table = document.querySelector('.min-w-full');
    const tableContainer = document.querySelector('.overflow-x-auto');
    
    if (table && tableContainer) {
        // Add mobile-friendly styles
        tableContainer.style.overflowX = 'auto';
        tableContainer.style.webkitOverflowScrolling = 'touch';
        
        // Make table more compact on mobile
        const cells = table.querySelectorAll('th, td');
        cells.forEach(cell => {
            cell.style.minWidth = '100px';
            cell.style.whiteSpace = 'nowrap';
        });
    }
}

function resetTableForDesktop() {
    const table = document.querySelector('.min-w-full');
    
    if (table) {
        const cells = table.querySelectorAll('th, td');
        cells.forEach(cell => {
            cell.style.minWidth = '';
            cell.style.whiteSpace = '';
        });
    }
}

// Data Management Functions
function updateJobData(data) {
    // Update job information
    updateElement('.text-sm.text-gray-900', data.title, 0);
    updateElement('.text-sm.text-gray-900', data.location, 1);
    updateElement('.text-sm.text-gray-900', data.employment_type, 2);
    updateElement('.text-sm.text-gray-900', data.salary || 'Tidak ditentukan', 3);
    
    // Update additional details
    updateElement('.text-sm.text-gray-900', data.company || 'N/A', 4);
    updateElement('.text-sm.text-gray-900', data.industry || 'N/A', 5);
    updateElement('.text-sm.text-gray-900', data.vacancies, 6);
    updateElement('.text-sm.text-gray-900', data.deadline || 'N/A', 7);
    
    // Update description and requirements
    updateElement('.text-gray-700', data.description, 0);
    updateElement('.text-gray-700', data.requirements, 1);
    
    // Update status
    updateStatus(data.status);
    
    // Update applicants
    updateApplicantsTable(data.applications || []);
}

function updateElement(selector, value, index = 0) {
    const elements = document.querySelectorAll(selector);
    if (elements[index]) {
        elements[index].textContent = value;
    }
}

function updateStatus(status) {
    const statusBadge = document.querySelector('.px-2.inline-flex');
    if (statusBadge) {
        statusBadge.className = 'px-2 inline-flex text-xs leading-5 font-semibold rounded-full';
        
        if (status === 'Accepted') {
            statusBadge.classList.add('bg-green-100', 'text-green-800');
        } else if (status === 'Rejected') {
            statusBadge.classList.add('bg-red-100', 'text-red-800');
        } else {
            statusBadge.classList.add('bg-yellow-100', 'text-yellow-800');
        }
        
        statusBadge.textContent = status;
        addStatusIcon(statusBadge, status.toLowerCase());
    }
}

function updateApplicantsTable(applications) {
    const tbody = document.querySelector('.min-w-full tbody');
    const applicantsSection = document.querySelector('div:last-child');
    
    if (!tbody || !applicantsSection) return;
    
    // Update counter in title
    const title = applicantsSection.querySelector('.text-xl.font-semibold');
    if (title) {
        const countText = `(${applications.length})`;
        title.innerHTML = title.innerHTML.replace(/\(\d+\)/, countText);
        title.setAttribute('data-count', applications.length);
    }
    
    if (applications.length === 0) {
        // Show no applicants message
        tbody.parentElement.innerHTML = '<p class="text-gray-500">Belum ada pelamar untuk lowongan ini.</p>';
        return;
    }
    
    // Clear existing rows
    tbody.innerHTML = '';
    
    // Add new rows
    applications.forEach((application, index) => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">${application.user.name}</td>
            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">${application.user.email}</td>
            <td class="px-4 py-2 whitespace-nowrap">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                    ${getStatusClasses(application.status)}">
                    ${capitalizeFirst(application.status)}
                </span>
            </td>
            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">${application.created_at}</td>
        `;
        
        // Add animation
        row.style.opacity = '0';
        row.style.transform = 'translateX(-20px)';
        row.style.transition = 'all 0.4s ease';
        
        tbody.appendChild(row);
        
        // Trigger animation
        setTimeout(() => {
            row.style.opacity = '1';
            row.style.transform = 'translateX(0)';
        }, index * 100);
        
        // Add interactions
        setupRowInteractions(row);
    });
}

function getStatusClasses(status) {
    switch (status) {
        case 'accepted':
            return 'bg-green-100 text-green-800';
        case 'rejected':
            return 'bg-red-100 text-red-800';
        default:
            return 'bg-yellow-100 text-yellow-800';
    }
}

function capitalizeFirst(str) {
    return str.charAt(0).toUpperCase() + str.slice(1);
}

function setupRowInteractions(row) {
    row.addEventListener('click', function() {
        highlightRow(this);
    });
    
    row.addEventListener('mouseenter', function() {
        this.style.transform = 'translateX(5px)';
        this.style.boxShadow = '0 2px 8px rgba(0,0,0,0.1)';
    });
    
    row.addEventListener('mouseleave', function() {
        this.style.transform = 'translateX(0)';
        this.style.boxShadow = 'none';
    });
}

// Loading States
function showLoadingState() {
    const sections = document.querySelectorAll('.grid > div, .mb-6, div:last-child');
    
    sections.forEach(section => {
        section.style.opacity = '0.5';
        section.style.pointerEvents = 'none';
        
        // Add loading spinner
        const spinner = document.createElement('div');
        spinner.className = 'loading-spinner';
        spinner.style.cssText = `
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 30px;
            height: 30px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid #3b82f6;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            z-index: 10;
        `;
        
        section.style.position = 'relative';
        section.appendChild(spinner);
    });
    
    // Add spin animation if not exists
    if (!document.querySelector('#spin-animation')) {
        const style = document.createElement('style');
        style.id = 'spin-animation';
        style.textContent = `
            @keyframes spin {
                0% { transform: translate(-50%, -50%) rotate(0deg); }
                100% { transform: translate(-50%, -50%) rotate(360deg); }
            }
        `;
        document.head.appendChild(style);
    }
}

function hideLoadingState() {
    const sections = document.querySelectorAll('.grid > div, .mb-6, div:last-child');
    
    sections.forEach(section => {
        section.style.opacity = '1';
        section.style.pointerEvents = 'auto';
        
        // Remove loading spinner
        const spinner = section.querySelector('.loading-spinner');
        if (spinner) {
            spinner.remove();
        }
    });
}

// Utility Functions
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

function throttle(func, limit) {
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
}

// Export functions for external use
window.JobDetailManager = {
    updateJobData,
    showLoadingState,
    hideLoadingState,
    setupStatusBadges,
    setupTableInteractions,
    initializeAnimations
};

// Add keyboard navigation
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        // Clear any highlights
        document.querySelectorAll('.highlighted-row').forEach(row => {
            row.classList.remove('highlighted-row');
            row.style.backgroundColor = '';
            row.style.borderLeft = '';
        });
    }
});

// Add print styles
function addPrintStyles() {
    const printStyles = `
        @media print {
            body { background: white !important; }
            .flex.justify-between.items-center.mb-8 { 
                background: white !important;
                box-shadow: none !important;
            }
            .bg-blue-500, .bg-gray-500 { display: none !important; }
            .bg-white.rounded-lg.shadow-md { 
                box-shadow: none !important;
                border: 1px solid #ccc;
            }
        }
    `;
    
    const styleElement = document.createElement('style');
    styleElement.textContent = printStyles;
    document.head.appendChild(styleElement);
}

// Initialize print styles
addPrintStyles();