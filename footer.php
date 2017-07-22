<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package MarketPier
 */

?>

</div><!-- #content -->

<footer id="colophon" class="site-footer">
    <div class="site-footer-inner">
        <div class="attribution">
			<?php echo bloginfo( 'site_title' ); ?> <?php echo date( 'Y' ); ?> All Rights Reserved
            <span class="sep"> | </span>
            Site by <a href="https://levon.io" target="_blank">Levon.io</a>
        </div>

        <div class="social">
			<?php get_template_part( 'template-parts/social-media' ); ?>
        </div>
    </div><!-- .site-info -->
</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
