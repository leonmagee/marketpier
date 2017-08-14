<?php
/**
 * Template Name: Edit Listing
 * @package MarketPier
 */
if ( ! is_user_logged_in() ) {
	wp_redirect( site_url() );
	exit;
}


if ( isset( $_GET['listing'] ) ) {

	//$post_hash = $_GET['listing'];
	$post_id = $_GET['listing'];

	/**
	 * @todo use encryption for listing ID here?
	 */

	//$post_id = skyrises_decrypt( $post_hash );
}

$args = array( 'post_type' => 'mp-listing', 'post__in' => array( $post_id ) );

$listing_query = new WP_Query( $args );

if ( $listing_query->have_posts() ) {

	while ( $listing_query->have_posts() ) {

		$listing_query->the_post();

		$current_user = wp_get_current_user();

		$listing_author_id = get_the_author_meta( 'ID' );

		if ( $listing_author_id !== $current_user->ID ) {

			/**
			 *  This should redirect to home or a 404 page instead, or
			 *  maybe just an error message?
			 * @todo maybe redirect ao a page template for 'you do not have access'
			 */
			die( '<div class="skyrises-alert visible">you do not have access</div>' );
		}
	}

} else {

	die( '<div class="skyrises-alert visible">you do not have access</div>' );
}


acf_form_head();
get_template_part( 'template-parts/spinner' );
get_header(); ?>
    <div id="primary" class="content-area">
        <main id="main" class="site-main">
            <div class="page-content-wrap">
                <header class="entry-header">
                    <h1 class="entry-title">Update Listing</h1>
                </header>
                <div class='create-new-listing-wrap'>
					<?php acf_form( array(
						'post_id'      => $post_id,
						'post_title'   => false,
						'new_post'     => array(
							'post_type'   => 'mp-listing',
							'post_status' => 'publish'
						),
						//'uploader'     => 'basic',
						'fields'       => array(
							'listing_mls_number',
							'listing_price',
							'listing_type',
							'listing_status',
							'listing_for_sale_or_for_lease',
							'listing_property_name',
							'listing_address',
							'listing_city',
							'listing_state',
							'listing_zip',
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
							'listing_description',
							'listing_image_gallery',
							'listing_unit_mix',
							'listing_file_upload'
						),
						'submit_value' => 'Save Changes'
					) );
					?>
                </div>
            </div>
        </main><!-- #main -->
    </div><!-- #primary -->
<?php get_footer();

