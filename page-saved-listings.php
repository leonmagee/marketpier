<?php
/**
 * Template Name: Saved Listings
 *
 * @package MarketPier
 */

logged_in_check_redirect();

$user_id = MP_LOGGED_IN_ID;

get_header(); ?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main">
            <div class="page-content-wrap">
                <header class="entry-header">
                    <h1 class="entry-title">Saved Listings</h1>
                </header>

                <div class="logged-in-outer-wrap">

                    <div class="logged-in-user-content logged-in-user-listings">

						<?php

						global $wpdb;
						$prefix     = $wpdb->prefix;
						$table_name = $prefix . 'mp_favorite_listings';
						$user_id    = MP_LOGGED_IN_ID;

						$favorite_query = "SELECT * FROM `{$table_name}` WHERE `user_id` = '{$user_id}'";

						$favorite_result = $wpdb->get_results( $favorite_query ); 
                        ?>

                        <div class="user-listings-wrap">
							<?php if ( $favorite_result ) {
								foreach ( $favorite_result as $favorite ) { ?>
                                    <div class="logged-in-user-listing" saved-id="<?php echo $favorite->id; ?>">
                                        <span><?php echo $favorite->listing_title ?></span>
                                        <span class="view-edit-links">
                                    <a href="<?php echo $favorite->listing_url ?>">view</a>
                                    <a class="remove-saved-listing"><i class="fa fa-trash"></i></a>
                                    </span>
                                    </div>
								<?php }
							} else { ?>
                                <div class="callout warning">
                                    You don't have any saved listings yet.
                                </div>
							<?php } ?>
                        </div>
                    </div>

					<?php get_template_part( 'template-parts/logged-in-user-sidebar' ); ?>
                </div>
            </div>
        </main>
    </div>
<?php get_footer();
