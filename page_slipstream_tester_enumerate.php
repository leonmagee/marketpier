<?php
/**
 * Template Name: Slipstream Test Enumerate
 *
 * @package MarketPier
 */

$slipstream_token = new get_slipstream_token();
//var_dump( $slipstream_token );


get_header(); ?>
    <div id="primary" class="content-area">
        <main id="main" class="site-main">
            <div class="page-content-wrap">
                <h1>Slipstream Testing</h1>
				<?php var_dump( $slipstream_token->slipstream_token );
				$token = $slipstream_token->slipstream_token;
				$market            = 'sandicor';
				$listing_page_size = 10;
				//				$search            = new api_listing_search(
				//					$slipstream_token_query->slipstream_token,
				//					$listing_page_size,
				//					$market
				//				);
				//				$search->search_listings();
				//
				//
				//

				//$url = 'https://slipstream.homejunction.com/ws/markets/enumerate?parameters';

				$url     = 'https://slipstream.homejunction.com/ws/markets/enumerate?id=sandicor&property=propertyType&listingType=commercial';
				$request = wp_remote_get( $url, array( 'headers' => array( 'HJI-Slipstream-Token' => $token ) ) );

				$request_data = json_decode( $request['body'] );

				var_dump( $request_data );

				foreach( $request_data->result->values as $value ) {
				    echo $value;
				    echo "<br />";
                }
				//				foreach ( $search->search_result->listings as $listing ) {
				//					var_dump( $listing->status );
				//					//var_dump( $listing);
				//                }

				//var_dump( $search->search_result->listings );
				?>


            </div>
        </main><!-- #main -->
    </div><!-- #primary -->
<?php get_footer();
