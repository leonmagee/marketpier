<?php
/**
 * Template Name: Slipstream Test
 *
 * @package MarketPier
 */

$slipstream_token_query = new get_slipstream_token();

get_header(); ?>
    <div id="primary" class="content-area">
        <main id="main" class="site-main">
            <div class="page-content-wrap">
                <h1>Slipstream Testing</h1>
				<?php var_dump( $slipstream_token_query->slipstream_token );
				//$market            = 'sandicor';
				$market            = 'crmls';
				$listing_page_size = 10;
				//				$search            = new api_listing_search(
				//					$slipstream_token_query->slipstream_token,
				//					$listing_page_size,
				//					$market,
				//					'160045736|130048559|170019867|170029761|170034990|170041457'
				//				);
				$search = new api_listing_search(
					$slipstream_token_query->slipstream_token,
					$listing_page_size,
					$market,
					//'OC17200945'
					//'PW16064313'
					'PW17208365'
                    //'PW17208365'
					//'OC16184742'
				);
				//160045736
				//130048559
				//170019867
				//170029761
				//170034990
				//170041457
				$parameters = false;
				//$parameters = array( 'status' => 'active', 'price_min' => '102342', 'cap_rate_min' => '3' );
				//$parameters = array( 'status' => 'sold' );
				//$parameters = array( 'property_type' => '&listingType=Commercial', 'status' => 'active' );
				$parameters = array( 'price_range' => '0:1000000000000' );
				//$parameters = array( 'zip' => '92108' );
				//$parameters = array( 'property_type' => '&propertyType=Mixed Usage' );
				//$parameters = array( 'property_type' => '&propertyType=Other/Remarks' );
				//					$parameters['property_type'] = '&propertyType=Res Income 2-4 Units';
				$search->search_listings( $parameters );
				//$search->search_listings();
				//var_dump( $search );
				var_dump( $search->search_result );
				echo "<h1>Listings</h1>";
				//var_dump( $search );
				//				if ( $search->search_result ) {
				//					//var_dump( $search->search_result );
				//					foreach ( $search->search_result as $listing ) {
				//						//foreach ( $search->search_result->listings as $listing ) {
				////					    echo 'MLS Number: ' . $listing->id . '<br />';
				////						echo 'Status: ' . $listing->status . '<br />';
				////						echo 'Listing Type: ' . $listing->listingType . '<br />';
				////						echo 'Style: ' . $listing->style . '<br />';
				////						echo 'Property Type: ' . $listing->propertyType . '<br />';
				////						echo 'List Price: ' . $listing->listPrice . '<br />';
				//						var_dump( $listing );
				//						//var_dump( $listing->status );
				//						//var_dump( $listing->listPrice);
				//						//var_dump( $listing->style );
				//						echo "<br /><br />";
				//						//var_dump( 'sold date', $listing->saleDate );
				//					}
				//				}

				//var_dump( $search->search_result->listings );
				?>


            </div>
        </main><!-- #main -->
    </div><!-- #primary -->
<?php get_footer();
