<?php
/**
 * Template Name: Search Listings
 *
 * @package MarketPier
 */

get_header();

?>

    <div class="search-listings-wrap">

        <div class="search-listings-half map-half">

        </div>

        <div class="search-listings-half snippet-half">


			<?php


			/**
			 * Query Listings
			 * @todo use a class for this - skrs?
			 */


			$args = array( 'post_type' => 'mp-listing' );

			$listing_query = new WP_Query( $args );

			while ( $listing_query->have_posts() ) {

				$listing_query->the_post();

				$price           = number_format( get_field( 'listing_price' ) );
				$image_url_array = get_field( 'listing_image_gallery' );
				$image_url       = $image_url_array[0]['sizes']['listing-gallery'];
				?>

                <div class="snippet-outer-wrap">
                    <div class="image-wrap">
                        <img src="<?php echo $image_url; ?>"/>
                    </div>
                    <div class="details-wrap">
                        <div class="title-wrap"><?php the_title(); ?></div>
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
