<?php
/**
 * Template Name: Search Listings
 * toggle different forms - with active vs. sold
 * @todo remove status field, combine Lot size and days on market / sold in last into one field
 *
 * @package MarketPier
 */
require_once( 'inc/snippet_data.php' );
require_once( 'inc/snippet_data_search.php' );
require_once( 'inc/lv_google_map_group.php' );
require_once( 'inc/form-process-submit.php' );
$snippets_query = new snippet_data_search();
//var_dump( $snippets_query );
$snippets = $snippets_query->snippet_object_array;
//var_dump( $snippets );
//var_dump( $snippets_query );
$page_number   = $snippets_query->page_number;
$page_size     = $snippets_query->page_size;
$total_results = $snippets_query->total_results;
$total_pages   = intval( ceil( ( $total_results / $page_size ) ) );
//var_dump( $page_number );
//var_dump( $page_size );
//var_dump( $total_results );
//var_dump( $total_pages );

get_header();
?>
    <div class="search-listings-wrap">
        <div class="search-listings-half map-half">
			<?php if ( $map_data_array = $snippets_query->map_data_array ) {
				$google_map_group = new lv_google_map_group( $map_data_array );
				$google_map_group->output_map();
			} ?>
        </div>
		<?php
		/**
		 * The navigation functionality should really be it's own class
		 * and I need to find a way to make this work smoothly between the two different types of search, and
		 * even combining the two types of search, so this is closely tied to that functionality.
		 * so I'll start by just making the search work with idx pagination, and then from there I can create a different
		 * functionality/class to combine it all together
		 * remember that pagination on the other sites I've built like this works as it's own form - it triggers the search
		 * form again passing all of the values again (hidden)
		 */
		?>
        <div class="search-listings-half snippet-half">
			<?php
			//$max_page_number = 3; //@todo set this?


			$listing_start  = 1;
			$listing_end    = $page_size;
			$count_listings = $total_results;

			if ( $page_number > 1 ) {
				$listing_start = ( $listing_start + ( $page_size * ( $page_number - 1 ) ) );
				$listing_end   = ( $listing_end + $page_size * ( $page_number - 1 ) );
			}

			if ( $listing_start > $count_listings ) {
				$listing_start = $count_listings;
			}

			$last_page = false;
			if ( $listing_end >= $count_listings ) {
				$listing_end = $count_listings;
				$last_page   = true;
			}

			if ( $page_number > 1 ) {
				$prev_page_class = 'active';
			} else {
				$prev_page_class = '';
			}
			if ( $page_number < $total_pages ) {
				$next_page_class = 'active';
			} else {
				$next_page_class = '';
			} ?>
            <div class="search-pagination">
                <div class="nav-link prev-page <?php echo $prev_page_class; ?>">
                    <i class="fa fa-chevron-left"></i> Prev
                </div>
                <div class="total-results">
                    Total
                    Results: <?php echo $snippets_query->total_results . ' (' . $listing_start . ' - ' . $listing_end . ' )'; ?>
                </div>
                <div class="nav-link next-page <?php echo $next_page_class; ?>">
                    Next <i class="fa fa-chevron-right"></i>
                </div>

            </div>
            <div class="search-active-sold-wrap">
                <a class="active-sold-link current">Active Listings</a>
                <a class="active-sold-link">Sold Listings</a>
            </div>
			<?php
			/**
			 * This template part doesn't have access to the data it needs...
			 */
			include( locate_template( 'template-parts/search-form-active.php' ) );
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
                                   class="contact-link save-listing <?php echo $saved_class; ?>"><i
                                            class="fa fa-heart"></i> Save<span>d</span><i class="fa fa-refresh fa-spin"
                                                                                          aria-hidden="true"></i></a>
							<?php } else { ?>
                                <a href="" data-open="login-modal" class="contact-link"><i class="fa fa-heart"
                                                                                           aria-hidden="true"></i> Save</a>

							<?php } ?>

                            <a href="" class="contact-link"><i class="fa fa-envelope" aria-hidden="true"></i>
                                Contact</a>
                        </div>
                        <a class="snippet-link-outer" href="<?php echo $snippet->listing_url; ?>">
                            <div class="snippet-outer-wrap">
                                <div class="image-wrap"
                                     style="background-image: url(<?php echo $snippet->image_gallery_first; ?>);">
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
									<?php if ( $status = $snippet->status ) { ?>
                                        <div class="status-bar">
                                            <span><?php echo $status; ?></span>
                                        </div>
									<?php } ?>
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
