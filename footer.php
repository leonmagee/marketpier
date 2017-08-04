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
            <div class="attribution-top">
                <div class="attribution-line">
                    <a href="<?php echo site_url(); ?>/about">About</a>
                </div>
                <span class="sep"> | </span>
                <div class="attribution-line">
                    <a href="<?php echo site_url(); ?>/contact">Contact Us</a>
                </div>
            </div>
            <div class="attribution-middle">
                <div class="attribution-line">
					<?php echo bloginfo( 'site_title' ); ?> <?php echo date( 'Y' ); ?> All Rights Reserved
                </div>
            </div>
            <div class="attribution-bottom">
                <div class="attribution-line">
                    Site by <a href="https://levon.io" target="_blank">Levon.io</a>
                </div>
            </div>
        </div>

		<?php if ( $broker_agent_info = get_field( 'broker_agent_info', 'option' ) ) { ?>
            <div class="broker-info-line">
				<?php echo $broker_agent_info; ?>
            </div>
		<?php } ?>

		<?php if ( $broker_company_info = get_field( 'broker_company_info', 'option' ) ) { ?>
            <div class="broker-info-line">
				<?php echo $broker_company_info; ?>
            </div>
		<?php } ?>


        <div class="social">
			<?php get_template_part( 'template-parts/social-media' ); ?>
        </div>
    </div><!-- .site-info -->
</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
