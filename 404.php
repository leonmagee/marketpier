<?php
/**
 * 404 Page
 *
 * @package MarketPier
 */
get_header(); ?>
    <div id="primary" class="content-area">
        <main id="main" class="site-main">
            <div class="page-content-wrap">
                <h1>Sorry, that page can’t be found.</h1>
                <a href="<?php echo site_url(); ?>">Return Home</a>
	        <?php
	        while ( have_posts() ) : the_post();
		        get_template_part( 'template-parts/content', 'page' );
	        endwhile; // End of the loop.
	        ?>
            </div>
        </main><!-- #main -->
    </div><!-- #primary -->
<?php get_footer();

