<?php
/**
 * Template Name: Slipstream Test Enumerate
 *
 * @package MarketPier
 */

$slipstream_token = new get_slipstream_token();
//var_dump( $slipstream_token );

/**
 * Transient Testings
 */

////set_transient( $transient, $value, $expiration );
//$trans_key = 'ex-sandicor&listingType=Commercial5&xf_lm_dec_10=3:4';
//$trans = get_transient( $trans_key );
//var_dump( $trans );
//
//$array            = array( 'leon', 'bonnie', array( 'maryana', 'kara' ) );
//$serialized_array = serialize( $array );
//var_dump( $serialized_array );
//
//set_transient( 'test_transient', $serialized_array, 600 );
//
//
//$testing_transient = get_transient( 'test_transient' );
//
//$testing_final = unserialize( $testing_transient );


//if ( $testing_transient ) {
//	var_dump( $testing_transient );
//	var_dump( $testing_final );
//}
/**
 * how to delete transient? this should happen after data is retreived.
 */


get_header(); ?>
    <div id="primary" class="content-area">
        <main id="main" class="site-main">
            <div class="page-content-wrap">
                <h1>Slipstream Testing</h1>
				<?php var_dump( $slipstream_token->slipstream_token );
				$token = $slipstream_token->slipstream_token;
				//$market            = 'sandicor';
				$market            = 'crmls';
				$listing_page_size = 10;
				//$commercial_string = '&listingType=commercial';
				$commercial_string = '';
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

				//$url     = 'https://slipstream.homejunction.com/ws/markets/enumerate?id=' . $market . '&property=propertyType' . $commercial_string;
				$url     = 'https://slipstream.homejunction.com/ws/markets/enumerate?id=' . $market . '&property=listingType';
				$request = wp_remote_get( $url, array( 'headers' => array( 'HJI-Slipstream-Token' => $token ) ) );

				$request_data = json_decode( $request['body'] );

				var_dump( $request_data );

				foreach ( $request_data->result->values as $value ) {
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
