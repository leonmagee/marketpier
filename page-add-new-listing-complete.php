<?php
/**
 * Template Name: Add New Listing Complete
 *
 * @package MarketPier
 *
 * @todo maybe have a different template for each form part? Start by just creating two forms...
 */

logged_in_check_redirect();
get_header(); ?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main">
            <div class="page-content-wrap">
                <header class="entry-header">
                    <h1 class="entry-title">Listing Complete</h1>
                </header>
                <div class="logged-in-outer-wrap">
                    <div class="logged-in-user-content logged-in-user-add-listings add-or-edit-listing">

                        <h3>Thank you for adding a property listing on MarketPier. You will receive an email confirmation when your property listing is approved.</h3>

                    </div>
					<?php get_template_part( 'template-parts/logged-in-user-sidebar' ); ?>
                </div>
            </div>
        </main><!-- #main -->
    </div><!-- #primary -->
<?php get_footer();
