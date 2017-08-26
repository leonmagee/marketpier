<?php
/**
 * Template Name: Add New Listing
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
                    <h1 class="entry-title">Add New Listing</h1>
                </header>
                <div class="logged-in-outer-wrap">
                    <div class="logged-in-user-content logged-in-user-add-listings add-or-edit-listing">

						<?php
						/**
						 * @todo this needs to be a multipart form - this will create a listing and then it will
                         * @todo navigate to other form pages that will then edit the listing
                         * @todo auto-generate listing id???
                         * @todo the post
						 *
						 */
						acf_form( array(
							'post_id'      => 'new_post',
							'post_title'   => false,
							'new_post'     => array(
								'post_type'   => 'mp-listing',
								'post_status' => 'publish',
								//'post_status' => 'draft',
							),
							//'return'       => site_url() . '/add-listing-2',
							//'uploader'     => 'basic',
							'fields'       => array(
								'listing_for_sale_or_for_lease',
								'listing_type',
								'lease_type',
								'listing_address',
								'listing_city',
								'listing_state',
								'listing_zip',
								'listing_space_available',
								'listing_price',
								'listing_monthly_rent',
								'rental_rate_sf_month',
								//'listing_unpriced',
								'listing_description',
								//'listing_mls_number',
								//'listing_status',
								//'listing_property_name',
								//'listing_neighborhood',
								//'listing_county',
								//'listing_year_built',
								//'listing_sub_type',
								//'listing_building_size',
								//'listing_lot_size',
								//'listing_apn_parcel_id',
								//'listing_number_of_units',
								//'listing_net_operating_income',
								//'listing_cap_rate',
								//'listing_image_gallery',
								//'listing_unit_mix',
								//'listing_file_upload'
							),
							'submit_value' => 'Create a new Listing'
						) );
						?>
                    </div>
	                <?php get_template_part( 'template-parts/logged-in-user-sidebar' ); ?>
                </div>
            </div>
        </main><!-- #main -->
    </div><!-- #primary -->
<?php get_footer();
