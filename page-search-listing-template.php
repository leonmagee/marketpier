<?php
/**
 * Template Name: Search Listings
 *
 * @package MarketPier
 */
require_once( 'inc/snippet_data.php' );
require_once( 'inc/snippet_data_search.php' );
require_once( 'inc/lv_google_map_group.php' );
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
			<?php foreach ( $snippets as $snippet ) {
				if ( $snippet->combined_address ) {
					$address = $snippet->combined_address;
				} elseif ( $snippet->city_state_zip ) {

					$address = $snippet->city_state_zip;
				} else {
					$address = '';
				} ?>
                <a class="snippet-link-outer" href="<?php echo $snippet->listing_url; ?>">
                    <div class="snippet-outer-wrap">
                        <div class="image-wrap">
                            <div class="image-overlay">
                                <div class="image-overlay-text">
                                    <h3><?php echo $snippet->title; ?></h3>
                                    <h5><?php echo $address; ?></h5>
                                </div>
                            </div>
                            <img src="<?php echo $snippet->image_gallery_first; ?>"/>
                        </div>
                        <div class="details-wrap">
                            <div class="details-item-wrap">
                                <div class="details-item price-item">$<?php echo number_format( $snippet->price ); ?></div>
                                <label>Price</label>
                            </div>
                            <sep>|</sep>
                            <div class="details-item-wrap">
                                <div class="details-item units-item"><?php echo $snippet->number_of_units; ?></div>
                                <label>Units</label>
                            </div>
                            <sep>|</sep>
                            <div class="details-item-wrap">
                                <div class="details-item sqft-item"><?php echo $snippet->building_size; ?></div>
                                <label>Bldg sq ft</label>
                            </div>
                            <sep>|</sep>
                            <div class="details-item-wrap">
                                <div class="details-item cap-rate-item"><?php echo $snippet->cap_rate; ?></div>
                                <label>Cap Rate</label>
                            </div>
                            <sep>|</sep>
                            <div class="details-item-wrap">
                                <div class="details-item lot-size-item"><?php echo $snippet->lot_size; ?></div>
                                <label>Lot Size</label>
                            </div>
                        </div>
                    </div>
                </a>
			<?php } ?>
        </div>
    </div><!-- #primary -->
<?php
get_footer();
