<?php
/**
 * Template Name: Add New Listing
 *
 * @package MarketPier
 */

if ( ! is_user_logged_in() ) { //@todo check user type?
	wp_redirect( site_url() );
	exit;
}

acf_form_head(); // this should only be used on two pages - new listing and update profile?
get_header(); ?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main">
            <div class="page-content-wrap">
                <header class="entry-header">
                    <h1 class="entry-title">Add New Listing</h1>
                </header>

				<?php
				/**
				 * @todo somehow this needs to be a multipart form...
                 * and I also need to
				 */
				acf_form( array(
					'post_id'      => 'new_post',
					'post_title'   => false,
					'new_post'     => array(
						'post_type'   => 'mp-listing',
						'post_status' => 'publish',
						//'post_content' => 'post content'
					),
					'return'       => site_url() . '/user-dashboard',
					//'uploader'     => 'basic',
					'fields'       => array(
						//'listing_main_image',
						'listing_mls_number',
						//'listing_id', // @todo auto generate
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
						//'listing_latitude',
						//'listing_longitude',
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
					'submit_value' => 'Create a new Listing'
				) );

				//	            while ( have_posts() ) : the_post();
				//		            get_template_part( 'template-parts/content', 'page' );
				//	            endwhile; // End of the loop.
				?>
            </div>
        </main><!-- #main -->
    </div><!-- #primary -->
<?php get_footer();
