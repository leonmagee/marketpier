<?php
/**
 * Template Name: Add New Listing Choice
 *
 * @package MarketPier
 */

logged_in_check_redirect();
acf_form_head(); // this should only be used on two pages - new listing and update profile?
get_header(); ?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main">
            <div class="page-content-wrap">
                <header class="entry-header">
                    <h1 class="entry-title">Choose Listing Type</h1>
                </header>
                <div class="logged-in-outer-wrap">
                    <div class="logged-in-user-content logged-in-user-add-listings add-or-edit-listing">

                        <div class="two-buttons">
                            <div class="listing-choice standard">
                                <a href="<?php echo site_url(); ?>/add-listing-for-sale">
                                    <button class="mp-button" id="sale-listing">Standard Listing</button>
                                    <div class="details">
                                        <h3>Free</h3>
                                        <ul>
                                            <li>Shows up in search results</li>
                                            <li>Shows up in search results</li>
                                            <li>Shows up in search results</li>
                                        </ul>
                                    </div>
                                </a>
                            </div>
                            <div class="listing-choice premium">
                                <a href="<?php echo site_url(); ?>/add-listing-for-lease">
                                    <button class="mp-button" id="lease-listing">Premium Listing</button>
                                </a>
                            </div>
                        </div>

                    </div>
					<?php get_template_part( 'template-parts/logged-in-user-sidebar' ); ?>
                </div>
            </div>
        </main><!-- #main -->
    </div><!-- #primary -->
<?php get_footer();

