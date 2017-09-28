<?php
/**
 * Template Name: Login Template
 * @todo remove - not currently used?
 * @package MarketPier
 */

logged_in_check_redirect_profile();

get_header(); ?>
    <div id="primary" class="content-area">
        <main id="main" class="site-main">
            <div class="page-content-wrap">
                <div class="login-page-wrap">
					<?php
					while ( have_posts() ) : the_post();
						get_template_part( 'template-parts/content', 'page' );
					endwhile; // End of the loop.
					?>
                </div>
            </div>
        </main><!-- #main -->
    </div><!-- #primary -->
<?php get_footer();
