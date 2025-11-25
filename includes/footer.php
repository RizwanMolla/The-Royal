    </main>

    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>The Royal</h3>
                    <p>Experience luxury and comfort at its finest.</p>
                </div>
                <div class="footer-section">
                    <h4>Quick Links</h4>
                    <a href="/the-royal/index.php">Home</a>
                    <?php if (is_logged_in()): ?>
                        <a href="/the-royal/my-bookings.php">My Bookings</a>
                    <?php endif; ?>
                </div>
                <div class="footer-section">
                    <h4>Contact</h4>
                    <p>Email: info@theroyal.com</p>
                    <p>Phone: +1 (555) 123-4567</p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> The Royal. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="/the-royal/public/js/animations.js"></script>
    <script>
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const navMenu = document.getElementById('navMenu');

        if (mobileMenuToggle) {
            mobileMenuToggle.addEventListener('click', () => {
                navMenu.classList.toggle('active');
                mobileMenuToggle.classList.toggle('active');
            });
        }
    </script>
    </body>

    </html>