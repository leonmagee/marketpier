<?php
/**
 * Template Name: Add New Listing Page 3
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

								'listing_unit_mix',
								'listing_file_upload',
								'listing_image_gallery',
								'listing_standard_or_premium',
								//'listing_status',
								//'listing_property_name',
								//'listing_neighborhood',
								//'listing_county',
								//'listing_year_built',
								//'listing_sub_type',
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
