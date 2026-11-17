
    <footer>

        <div class="footer-inner">

            <div class="footer-brand">PalaTrip</div>

            <p class="footer-tagline">Your guide to exploring Palawan, Philippines.</p>

            <nav class="footer-links" aria-label="Footer">
                <a href="landing.php">Explore</a>
                <a href="index.php">Home</a>
                <?php if (is_logged_in()): ?>
                    <a href="profile.php">My Profile</a>
                <?php else: ?>
                    <a href="login.php">Login</a>
                    <a href="register.php">Register</a>
                <?php endif; ?>
            </nav>

            <p class="copyright">&copy; 2026 PalaTrip &middot; Web Systems Project</p>

        </div>

    </footer>

    <script src="js/destinations.js"></script>
    <script src="js/script.js"></script>

</body>

</html>
