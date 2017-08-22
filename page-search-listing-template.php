<?php
/**
 * Template Name: Search Listings
 *
 * @package MarketPier
 */
require_once( 'inc/snippet_data.php' );
require_once( 'inc/snippet_data_search.php' );
require_once( 'inc/lv_google_map_group.php' );
require_once( 'inc/form-process-submit.php' );
$snippets_query = new snippet_data_search();
$snippets       = $snippets_query->snippet_object_array;

get_header();
?>
    <div class="search-listings-wrap">
        <div class="search-listings-half map-half">
			<?php if ( $map_data_array = $snippets_query->map_data_array ) {
				$google_map_group = new lv_google_map_group( $map_data_array );
				$google_map_group->output_map();
			} ?>
        </div>
        <div class="search-listings-half snippet-half">
			<?php
			/**
			 * This template part doesn't have access to the data it needs...
			 */
			include( locate_template( 'template-parts/homepage-form-snippets.php' ) );
			//get_template_part( 'template-parts/homepage-form-snippets' );
			if ( $snippets ) {

				foreach ( $snippets as $snippet ) {
					if ( $snippet->combined_address ) {
						$address = $snippet->combined_address;
					} elseif ( $snippet->city_state_zip ) {

						$address = $snippet->city_state_zip;
					} else {
						$address = '';
					} ?>
                    <div class="snippet-outer-outer-wrap">
                        <div class="contact-wrap">


	                        <?php if ( is_user_logged_in() ) {
		                        if ( $snippet->favorite_listing == true ) {
			                        $saved_class = 'saved';
		                        } else {
			                        $saved_class = '';
		                        }
		                        ?>
                                <a href="#" user_id="<?php echo MP_LOGGED_IN_ID; ?>"
                                   listing_id="<?php echo $snippet->listing_id; ?>"
                                   class="contact-link save-listing <?php echo $saved_class; ?>"><i class="fa fa-heart"></i> Save<span>d</span><i class="fa fa-refresh fa-spin" aria-hidden="true"></i></a>
	                        <?php } else { ?>
                                <a href="" data-open="login-modal" class="contact-link"><i class="fa fa-heart" aria-hidden="true"></i> Save</a>

	                        <?php } ?>
















                            <a href="" class="contact-link"><i class="fa fa-envelope" aria-hidden="true"></i>
                                Contact</a>
                        </div>
                        <a class="snippet-link-outer" href="<?php echo $snippet->listing_url; ?>">
                            <div class="snippet-outer-wrap">
                                <div class="image-wrap">
                                    <div class="image-overlay">
                                        <div class="image-overlay-text">
											<?php if ( $title = $snippet->property_name ) { ?>
                                                <h3><?php echo $title; ?></h3>
											<?php } ?>
											<?php if ( $address ) { ?>
                                                <h5><?php echo $address; ?></h5>
											<?php } ?>
                                        </div>
                                    </div>
                                    <img src="<?php echo $snippet->image_gallery_first; ?>"/>
                                </div>
                                <div class="right-side-outer">
                                    <div class="top-line">
										<?php echo $snippet->type; ?>
                                    </div>
                                    <div class="details-wrap">
										<?php if ( $price = $snippet->price ) { ?>
                                            <div class="details-item-wrap">
                                                <div class="details-item price-item">
                                                    $<?php echo number_format( $price ); ?>
                                                </div>
                                                <label>Price</label>
                                            </div>
										<?php } ?>
										<?php if ( $units = $snippet->number_of_units ) { ?>
                                            <sep>|</sep>
                                            <div class="details-item-wrap">
                                                <div class="details-item units-item"><?php echo $units; ?></div>
                                                <label>Units</label>
                                            </div>
										<?php } ?>
										<?php if ( $building_size = $snippet->building_size ) { ?>
                                            <sep>|</sep>
                                            <div class="details-item-wrap">
                                                <div class="details-item sqft-item"><?php echo number_format( $building_size ); ?></div>
                                                <label>Bldg SF</label>
                                            </div>
										<?php } ?>
										<?php if ( $cap_rate = $snippet->cap_rate ) { ?>
                                            <sep>|</sep>
                                            <div class="details-item-wrap">
                                                <div class="details-item cap-rate-item"><?php echo $cap_rate; ?></div>
                                                <label>Cap Rate</label>
                                            </div>
										<?php } ?>
										<?php if ( $lot_size = $snippet->lot_size ) { ?>
                                            <sep>|</sep>
                                            <div class="details-item-wrap">
                                                <div class="details-item lot-size-item"><?php echo number_format( $lot_size ); ?></div>
                                                <label>Lot SF</label>
                                            </div>
										<?php } ?>
                                    </div>
                                    <div class="bottom-line">
										<?php if ( $days = $snippet->days_on_market ) {
											echo $days . 'd';
										} ?>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
				<?php }
			} else { ?>
                <div class="no-search-results callout alert">No results found for that search! <a
                            href="<?php echo site_url(); ?>">Return Home</a>.
                </div>
			<?php } ?>
        </div>
    </div><!-- #primary -->
<?php
get_footer();
