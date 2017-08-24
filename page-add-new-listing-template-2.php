<?php
/**
 * Template Name: Add New Listing Page 2
 *
 * @package MarketPier
 *
 * @todo maybe have a different template for each form part? Start by just creating two forms...
 */

logged_in_check_redirect();

acf_form_head(); // this should only be used on two pages - new listing and update profile?
get_header();

// @todo need to encrypt this
if ( isset( $_GET['post_id'] ) ) {
	$post_id = $_GET['post_id'];
}
?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main">
            <div class="page-content-wrap">
                <header class="entry-header">
                    <h1 class="entry-title">Add New Listing</h1>
                </header>
                <div class="logged-in-outer-wrap">
                    <div class="logged-in-user-content logged-in-user-add-listings add-or-edit-listing">

						<?php
						acf_form( array(
							'post_id'      => $post_id,
							'post_title'   => false,
							'new_post'     => array(
								'post_type'   => 'mp-listing',
								'post_status' => 'publish',
								//'post_status' => 'draft',
							),
							'return'       => site_url() . '/add-listing-3',
							//'uploader'     => 'basic',
							'fields'       => array(
//								'listing_for_sale_or_for_lease',
//								'listing_type',
//								'lease_type',
//								'listing_address',
//								'listing_city',
//								'listing_state',
//								'listing_zip',
//								'listing_space_available',
//								'listing_unpriced',
//								'listing_price',
//								'listing_monthly_rent',
//								'listing_description',


								'listing_mls_number',
								'listing_status',
								'listing_property_name',
								'listing_neighborhood',
								'listing_county',
								'listing_year_built',
								'listing_sub_type',
								'listing_building_size',
								'listing_lot_size',
								'listing_apn_parcel_id',
								'listing_number_of_units',
								'listing_net_operating_income',
								'listing_cap_rate',
								'listing_image_gallery',
								'listing_unit_mix',
								'listing_file_upload'
							),
							'submit_value' => 'Continue'
						) );
						?>
                    </div>
					<?php get_template_part( 'template-parts/logged-in-user-sidebar' ); ?>
                </div>
            </div>
        </main><!-- #main -->
    </div><!-- #primary -->
<?php get_footer();
