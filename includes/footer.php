    </main>

    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section footer-brand">
                    <h3 class="footer-logo">THE ROYAL</h3>
                    <p class="footer-tagline">Experience luxury and comfort at its finest.</p>
                    <div class="footer-accent-line"></div>
                </div>
                <div class="footer-section">
                    <h4 class="footer-title">Quick Links</h4>
                    <div class="footer-links">
                        <a href="index.php" class="footer-link">Home</a>
                        <a href="rooms.php" class="footer-link">Our Rooms</a>
                        <?php if (is_logged_in()): ?>
                            <a href="my-bookings.php" class="footer-link">My Bookings</a>
                        <?php else: ?>
                            <a href="login.php" class="footer-link">Login</a>
                            <a href="register.php" class="footer-link">Register</a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="footer-section">
                    <h4 class="footer-title">Contact</h4>
                    <div class="footer-contact">
                        <p class="footer-contact-item">
                            <span class="footer-contact-label">Email:</span>
                            <a href="mailto:info@theroyal.com" class="footer-contact-link">info@theroyal.com</a>
                        </p>
                        <p class="footer-contact-item">
                            <span class="footer-contact-label">Phone:</span>
                            <span>+1 (555) 123-4567</span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> The Royal. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="public/js/animations.js?v=1.0.0"></script>
    <script>
        // Mobile menu toggle
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const navMenu = document.getElementById('navMenu');

        if (mobileMenuToggle) {
            mobileMenuToggle.addEventListener('click', () => {
                navMenu.classList.toggle('active');
                mobileMenuToggle.classList.toggle('active');
            });
        }

        // Navbar scroll effect
        const navbar = document.querySelector('.navbar');

        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    </script>
    </body>

    </html>