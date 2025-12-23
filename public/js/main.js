document.addEventListener('DOMContentLoaded', function() {
    const userMenuBtn = document.getElementById('userMenuBtn');
    const userDropdown = document.getElementById('userDropdown');
    const mobileMenuToggle = document.getElementById('mobileMenuToggle');
    const navMenu = document.getElementById('navMenu');
    const navbar = document.querySelector('.navbar');

    if (userMenuBtn) {
        userMenuBtn.addEventListener('click', function(event) {
            userDropdown.classList.toggle('show');
            event.stopPropagation();
        });
    }

    window.addEventListener('click', function(event) {
        if (userDropdown && userDropdown.classList.contains('show') && !userMenuBtn.contains(event.target)) {
            userDropdown.classList.remove('show');
        }
    });

    if (mobileMenuToggle) {
        mobileMenuToggle.addEventListener('click', function() {
            navMenu.classList.toggle('show');
        });
    }

    // Handle navbar scroll effect
    window.addEventListener('scroll', function() {
        if (navbar) {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        }
    });
});
