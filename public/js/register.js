// Create animated background particles
function createParticles() {
    const particlesContainer = document.getElementById('particles');
    const particleCount = 50;

    for (let i = 0; i < particleCount; i++) {
        const particle = document.createElement('div');
        particle.className = 'particle';
        
        // Random size between 4px and 12px
        const size = Math.random() * 8 + 4;
        particle.style.width = size + 'px';
        particle.style.height = size + 'px';
        
        // Random position
        particle.style.left = Math.random() * 100 + '%';
        particle.style.top = Math.random() * 100 + '%';
        
        // Random animation duration
        particle.style.animationDuration = (Math.random() * 4 + 3) + 's';
        particle.style.animationDelay = Math.random() * 2 + 's';
        
        particlesContainer.appendChild(particle);
    }
}

// Add click effects and loading states
document.addEventListener('DOMContentLoaded', function() {
    createParticles();
    
    const roleButtons = document.querySelectorAll('.role-btn');
    
    roleButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            // Add loading state
            const roleTitle = this.querySelector('.role-title').textContent;
            
            // Create loading content
            const loadingContent = `
                ${this.querySelector('.role-icon').outerHTML}
                <div class="role-title">${roleTitle}<span class="loading"></span></div>
                <div class="role-description">Redirecting...</div>
            `;
            
            this.innerHTML = loadingContent;
            this.style.pointerEvents = 'none';
            
            // Add some delay for the loading effect
            setTimeout(() => {
                window.location.href = this.href;
            }, 800);
            
            e.preventDefault();
        });
    });
});

// Add some interactive particles on mouse move
document.addEventListener('mousemove', function(e) {
    if (Math.random() < 0.05) { // 5% chance
        createInteractiveParticle(e.clientX, e.clientY);
    }
});

function createInteractiveParticle(x, y) {
    const particle = document.createElement('div');
    particle.style.position = 'fixed';
    particle.style.left = x + 'px';
    particle.style.top = y + 'px';
    particle.style.width = '4px';
    particle.style.height = '4px';
    particle.style.background = 'rgba(255, 255, 255, 0.6)';
    particle.style.borderRadius = '50%';
    particle.style.pointerEvents = 'none';
    particle.style.zIndex = '5';
    particle.style.animation = 'float 2s ease-out forwards';
    
    document.body.appendChild(particle);
    
    setTimeout(() => {
        particle.remove();
    }, 2000);
}

// Add keyboard navigation
document.addEventListener('keydown', function(e) {
    const roleButtons = document.querySelectorAll('.role-btn');
    let currentIndex = -1;
    
    // Find currently focused button
    roleButtons.forEach((button, index) => {
        if (document.activeElement === button) {
            currentIndex = index;
        }
    });
    
    if (e.key === 'ArrowRight' || e.key === 'ArrowDown') {
        e.preventDefault();
        const nextIndex = (currentIndex + 1) % roleButtons.length;
        roleButtons[nextIndex].focus();
    } else if (e.key === 'ArrowLeft' || e.key === 'ArrowUp') {
        e.preventDefault();
        const prevIndex = currentIndex > 0 ? currentIndex - 1 : roleButtons.length - 1;
        roleButtons[prevIndex].focus();
    }
});
