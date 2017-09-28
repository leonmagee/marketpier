<?php
/**
 * Template Name: Edit Listing
 * @package MarketPier
 */

logged_in_check_redirect();

if ( isset( $_GET['listing'] ) ) {

	$post_id = $_GET['listing'];
}

$args = array( 'post_type' => 'mp-listing', 'post__in' => array( $post_id ) );

$listing_query = new WP_Query( $args );

if ( $listing_query->have_posts() ) {

	while ( $listing_query->have_posts() ) {

		$listing_query->the_post();

		$current_user = wp_get_current_user();

		$listing_author_id = get_the_author_meta( 'ID' );

		$permalink = get_the_permalink();

		if ( $listing_author_id !== $current_user->ID ) {

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
                    <h1 class="entry-title">Edit Listing</h1>
                </header>
                <div class="logged-in-outer-wrap">
                    <div class="logged-in-user-content logged-in-edit-listing add-or-edit-listing">
                        <div class="view-listing-link">
                            <a href="<?php echo $permalink; ?>">View Listing</a>
                        </div>
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
								'listing_for_sale_or_for_lease',
								'listing_price',
								'listing_monthly_rent',
								'listing_type',
								'lease_type',
								'listing_status',
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
					<?php get_template_part( 'template-parts/logged-in-user-sidebar' ); ?>
                </div>
            </div>
        </main>
    </div>
<?php
get_footer();