<footer class="site-footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-widget">
                <h4>About StudySync Digital</h4>
                <p>Your trusted source for the latest tech reviews and recommendations for students and digital learners. We help you find the perfect technology to enhance your study experience.</p>
            </div>

            <?php if (is_active_sidebar('footer-1')) : ?>
                <?php dynamic_sidebar('footer-1'); ?>
            <?php else : ?>
                <div class="footer-widget">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="<?php echo home_url('/products'); ?>">All Products</a></li>
                        <li><a href="<?php echo home_url('/blog'); ?>">Blog</a></li>
                        <li><a href="<?php echo home_url('/about'); ?>">About Us</a></li>
                        <li><a href="<?php echo home_url('/contact'); ?>">Contact</a></li>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if (is_active_sidebar('footer-2')) : ?>
                <?php dynamic_sidebar('footer-2'); ?>
            <?php else : ?>
                <div class="footer-widget">
                    <h4>Categories</h4>
                    <ul>
                        <li><a href="#">Laptops</a></li>
                        <li><a href="#">Tablets</a></li>
                        <li><a href="#">Headphones</a></li>
                        <li><a href="#">Smart Devices</a></li>
                        <li><a href="#">Software</a></li>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if (is_active_sidebar('footer-3')) : ?>
                <?php dynamic_sidebar('footer-3'); ?>
            <?php else : ?>
                <div class="footer-widget">
                    <h4>Connect</h4>
                    <ul>
                        <li><a href="#">Twitter</a></li>
                        <li><a href="#">Facebook</a></li>
                        <li><a href="#">Instagram</a></li>
                        <li><a href="#">YouTube</a></li>
                    </ul>
                </div>
            <?php endif; ?>
        </div>

        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. All rights reserved. | <a href="<?php echo home_url('/privacy-policy'); ?>">Privacy Policy</a> | <a href="<?php echo home_url('/terms'); ?>">Terms of Service</a></p>
            <p style="margin-top: 0.5rem; font-size: 0.875rem;">Affiliate Disclosure: We may earn a commission when you purchase through links on our site.</p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
