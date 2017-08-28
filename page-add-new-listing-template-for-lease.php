<?php
/**
 * Template Name: Add New Listing For Lease
 *
 * @package MarketPier
 *
 * @todo maybe have a different template for each form part? Start by just creating two forms...
 */

logged_in_check_redirect();
acf_form_head(); // this should only be used on two pages - new listing and update profile?
get_header(); ?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main">
            <div class="page-content-wrap">
                <header class="entry-header">
                    <h1 class="entry-title">Add For Lease Listing</h1>
                </header>
                <div class="logged-in-outer-wrap">
                    <div class="logged-in-user-content logged-in-user-add-listings add-or-edit-listing">

                        <div class="for-lease-listing add-a-listing-wrap">
		                    <?php
		                    /**
		                     * Add For Lease Form
		                     */
		                    acf_form( array(
			                    'post_id'      => 'new_post',
			                    'post_title'   => false,
			                    'new_post'     => array(
				                    'post_type'   => 'mp-listing',
				                    'post_status' => 'publish',
				                    //'post_status' => 'draft',
			                    ),
			                    'return'       => site_url() . '/add-new-listing-choice',
			                    'fields'       => array(
				                    'listing_for_sale_or_for_lease',
				                    'lease_type',
				                    'listing_address',
				                    'listing_city',
				                    'listing_state',
				                    'listing_zip',
				                    'listing_space_available',
				                    //'listing_price',
				                    'listing_monthly_rent',
				                    'rental_rate_sf_month',
				                    'listing_description',
			                    ),
			                    'submit_value' => 'Create Listing',
		                    ) );
		                    ?>
                        </div>
                    </div>
					<?php get_template_part( 'template-parts/logged-in-user-sidebar' ); ?>
                </div>
            </div>
        </main><!-- #main -->
    </div><!-- #primary -->
<?php get_footer();
