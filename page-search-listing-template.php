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
//var_dump( $snippets )
$map_data_array = false;
foreach ( $snippets as $snippet ) {
// get data
	$map_data_array[] = array(
		'lat'     => $snippet->lat,
		'long'    => $snippet->long,
		'address' => $snippet->combined_address
	);
}
//var_dump( $map_data_array );

get_header();

?>

    <div class="search-listings-wrap">

        <div class="search-listings-half map-half">

			<?php
			if ( $map_data_array ) {
				$city_zoom = 12;
				$google_map_group = new lv_google_map_group( $map_data_array, $city_zoom );

				$google_map_group->output_map();
			}
			?>
        </div>

        <div class="search-listings-half snippet-half">

			<?php foreach ( $snippets as $snippet ) {

				$price = number_format( $snippet->price );
				//$image_url_array = get_field( 'listing_image_gallery' );
				//$image_url       = $image_url_array[0]['sizes']['listing-gallery'];
				?>

                <div class="snippet-outer-wrap">
                    <div class="image-wrap">
                        <img src="<?php echo $snippet->image_gallery_first; ?>"/>
                    </div>
                    <div class="details-wrap">
                        <div class="title-wrap"><?php echo $snippet->title; ?></div>
                        <div class="price-wrap">$<?php echo $price; ?></div>
                    </div>
                </div>
			<?php }


			?>


        </div>

    </div><!-- #primary -->

<?php
//get_sidebar();
get_footer();
