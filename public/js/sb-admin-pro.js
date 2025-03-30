/*!
 * SB Admin Pro v2.0.0 (https://startbootstrap.com/theme/sb-admin-pro)
 * Copyright 2013-2023 Start Bootstrap
 * Licensed under Commercial (https://github.com/StartBootstrap/sb-admin-pro/blob/master/LICENSE)
 */

// Initialize scripts when document is ready
document.addEventListener('DOMContentLoaded', function() {
    "use strict";
    
    // Toggle the side navigation
    const sidebarToggle = document.body.querySelector('#sidebarToggle');
    
    if (sidebarToggle) {
        // Uncomment below to persist sidebar toggle between refreshes
        if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
            document.body.classList.toggle('sidenav-toggled');
        }
        
        sidebarToggle.addEventListener('click', event => {
            event.preventDefault();
            document.body.classList.toggle('sidenav-toggled');
            localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sidenav-toggled'));
        });
    }
    
    // Add active state to sidebar nav links
    const path = window.location.href;
    
    // Active links
    const navLinks = document.querySelectorAll('.sidenav .nav-link');
    
    navLinks.forEach(link => {
        if (link.href === path) {
            // Add active to link
            link.classList.add('active');
            
            // If inside a collapse, open the collapse and set parent active
            const collapseParent = link.closest('.collapse');
            if (collapseParent) {
                // Show the collapse
                const bsCollapse = new bootstrap.Collapse(collapseParent, {
                    toggle: false
                });
                bsCollapse.show();
                
                // Set parent nav-link to active
                const parentNavLink = document.querySelector(`[data-bs-target="#${collapseParent.id}"]`);
                if (parentNavLink) {
                    parentNavLink.classList.add('active');
                }
            }
        }
    });
    
    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Initialize popovers
    const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });
    
    // Auto-hide alerts
    const alertList = document.querySelectorAll('.alert:not(.alert-important)');
    alertList.forEach(function(alert) {
        setTimeout(function() {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });
    
    // Add loading state to buttons
    const buttons = document.querySelectorAll('button[type="submit"]:not(.no-loading)');
    buttons.forEach(button => {
        button.addEventListener('click', function() {
            button.classList.add('btn-loading');
            // Safety timeout to remove loading state if form submission takes too long
            setTimeout(function() {
                if (button.classList.contains('btn-loading')) {
                    button.classList.remove('btn-loading');
                }
            }, 10000);
        });
    });
    
    // Feather icons (if used)
    if (typeof feather !== 'undefined') {
        feather.replace();
    }
});