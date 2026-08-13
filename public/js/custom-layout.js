/**
 * Custom Layout JS 
 */
document.addEventListener('DOMContentLoaded', function() {
    // 1. Render Lucide icons
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }

    // 2. Mobile drawer toggle
    const mobileMenuBtn   = document.getElementById('mobileMenuBtn');
    const sidebar         = document.getElementById('sidebar');
    const mobileOverlay   = document.getElementById('mobileOverlay');

    function toggleSidebar() {
        if (sidebar && mobileOverlay) {
            sidebar.classList.toggle('mobile-open');
            mobileOverlay.classList.toggle('show');
        }
    }

    if (mobileMenuBtn) {
        mobileMenuBtn.addEventListener('click', toggleSidebar);
    }
    if (mobileOverlay) {
        mobileOverlay.addEventListener('click', toggleSidebar);
    }

    // 3. Generic Flyout Popover Toggle Handler for Mobile & Click Interactions
    const flyoutToggles = document.querySelectorAll('.flyout-toggle-btn');

    flyoutToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            const parentItem = this.closest('.designer-nav-item');
            const targetFlyout = parentItem ? parentItem.querySelector('.designer-flyout-panel') : null;

            if (window.innerWidth < 768) {
                e.preventDefault();
                if (parentItem && targetFlyout) {
                    const isOpen = parentItem.classList.contains('open');
                    
                    // Close other open flyouts on mobile
                    document.querySelectorAll('.designer-nav-item.open').forEach(item => {
                        if (item !== parentItem) item.classList.remove('open');
                    });

                    parentItem.classList.toggle('open', !isOpen);
                }
            }
        });
    });

    // 4. Reset state on window resize
    window.addEventListener('resize', () => {
        if (window.innerWidth >= 768) {
            document.querySelectorAll('.designer-nav-item.open').forEach(item => item.classList.remove('open'));
            sidebar?.classList.remove('mobile-open');
            mobileOverlay?.classList.remove('show');
        }
    });

    // 5. Live Date and Time for Top Bar
    function updateDateTime() {
        const dateElement = document.getElementById('currentDate');
        const timeElement = document.getElementById('currentTime');

        if (dateElement && timeElement) {
            const now = new Date();
            
            // Format date: e.g., "Tue, Aug 11, 2026"
            const dateOptions = { weekday: 'short', month: 'short', day: 'numeric', year: 'numeric' };
            dateElement.textContent = now.toLocaleDateString('en-US', dateOptions);

            // Format time: e.g., "10:45:12 AM"
            const timeOptions = { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: true };
            timeElement.textContent = now.toLocaleTimeString('en-US', timeOptions);
        }
    }

    // Initialize and update every second
    updateDateTime();
    setInterval(updateDateTime, 1000);
});
