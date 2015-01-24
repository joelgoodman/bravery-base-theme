<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package brvry
 */
?>

	</div><!-- #content -->
</section><!-- #page -->
<footer id="colophon" class="site-footer primary" role="contentinfo">
	<div class="site-info">
		<aside id="legal">&copy;<?php echo date("Y"); echo " "; bloginfo('name'); ?>. All Rights Reserved. All Content Used by Permission.</aside>
        <section id="site-meta">
            <?php wp_nav_menu( array( 'theme_location' => 'social-links' ) ); ?>
            <a href="http://braverymedia.co/?c" target="_blank" title="Site Design by Bravery Media" class="credit">Site design by Bravery Media</a>
        </section>
        <?php wp_nav_menu( array( 'theme_location' => 'footer-menu', 'container' => 'nav', ) ); ?>
	</div><!-- .site-info -->
</footer><!-- #colophon -->

<?php wp_footer(); ?>

</body>
</html>
