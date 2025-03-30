/**
 * Sidebar.js - Enhanced sidebar functionality
 * Handles sidebar toggling, responsive behavior, and dropdown menus
 */

document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const sidebar = document.querySelector('.sidebar');
    const contentWrapper = document.querySelector('.content-wrapper');
    const toggleButtons = document.querySelectorAll('.sidebar-toggle');
    const dropdownToggles = document.querySelectorAll('.sidebar-dropdown-toggle');
    
    // Local storage key
    const SIDEBAR_STATE_KEY = 'nvogestion_sidebar_collapsed';
    
    // Check if sidebar should be collapsed based on saved state
    function initSidebarState() {
        const isCollapsed = localStorage.getItem(SIDEBAR_STATE_KEY) === 'true';
        
        if (isCollapsed) {
            sidebar.classList.add('sidebar-collapsed');
            contentWrapper.style.marginLeft = '70px';
        }
    }
    
    // Toggle sidebar collapsed state
    function toggleSidebar() {
        sidebar.classList.toggle('sidebar-collapsed');
        
        const isCollapsed = sidebar.classList.contains('sidebar-collapsed');
        localStorage.setItem(SIDEBAR_STATE_KEY, isCollapsed);
        
        if (isCollapsed) {
            contentWrapper.style.marginLeft = '70px';
        } else {
            contentWrapper.style.marginLeft = 'var(--sidebar-width, 250px)';
        }
    }
    
    // Handle mobile sidebar toggle
    function toggleMobileSidebar() {
        sidebar.classList.toggle('active');
        contentWrapper.classList.toggle('sidebar-active');
    }
    
    // Handle dropdown menus
    function setupDropdowns() {
        dropdownToggles.forEach(toggle => {
            toggle.addEventListener('click', function(e) {
                e.preventDefault();
                
                const dropdownId = this.getAttribute('data-target');
                const dropdownMenu = document.querySelector(dropdownId);
                
                // Toggle aria-expanded
                const isExpanded = this.getAttribute('aria-expanded') === 'true';
                this.setAttribute('aria-expanded', !isExpanded);
                
                // Toggle dropdown visibility
                dropdownMenu.classList.toggle('show');
            });
        });
    }
    
    // Add click event listeners to toggle buttons
    toggleButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Determine if we're in mobile view
            if (window.innerWidth <= 768) {
                toggleMobileSidebar();
            } else {
                toggleSidebar();
            }
        });
    });
    
    // Handle window resize
    function handleResize() {
        if (window.innerWidth <= 768) {
            // Mobile view - reset to default states
            sidebar.classList.remove('sidebar-collapsed');
            contentWrapper.style.marginLeft = '0';
            
            // If sidebar is active in mobile view
            if (sidebar.classList.contains('active')) {
                contentWrapper.classList.add('sidebar-active');
            }
        } else {
            // Desktop view - apply saved state
            sidebar.classList.remove('active');
            contentWrapper.classList.remove('sidebar-active');
            
            const isCollapsed = localStorage.getItem(SIDEBAR_STATE_KEY) === 'true';
            if (isCollapsed) {
                sidebar.classList.add('sidebar-collapsed');
                contentWrapper.style.marginLeft = '70px';
            } else {
                contentWrapper.style.marginLeft = 'var(--sidebar-width, 250px)';
            }
        }
    }
    
    // Set active menu item based on current URL
    function setActiveMenuItem() {
        const currentPath = window.location.pathname;
        const navLinks = document.querySelectorAll('.sidebar .nav-link');
        
        navLinks.forEach(link => {
            const href = link.getAttribute('href');
            if (href && (href === currentPath || currentPath.startsWith(href))) {
                link.classList.add('active');
                
                // If this is a dropdown item, also expand the parent dropdown
                const dropdownMenu = link.closest('.sidebar-dropdown-menu');
                if (dropdownMenu) {
                    dropdownMenu.classList.add('show');
                    const toggle = document.querySelector(`[data-target="#${dropdownMenu.id}"]`);
                    if (toggle) {
                        toggle.setAttribute('aria-expanded', 'true');
                    }
                }
            }
        });
    }
    
    // Initialize
    window.addEventListener('resize', handleResize);
    initSidebarState();
    handleResize();
    setupDropdowns();
    setActiveMenuItem();
    
    // Add toggle button to DOM if it doesn't exist
    if (toggleButtons.length === 0) {
        const toggleBtn = document.createElement('button');
        toggleBtn.className = 'sidebar-toggle';
        toggleBtn.innerHTML = '<i class="fas fa-bars"></i>';
        toggleBtn.setAttribute('aria-label', 'Toggle Sidebar');
        
        sidebar.appendChild(toggleBtn);
        
        toggleBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            if (window.innerWidth <= 768) {
                toggleMobileSidebar();
            } else {
                toggleSidebar();
            }
        });
    }
});