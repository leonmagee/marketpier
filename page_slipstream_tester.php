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
				$market            = 'sandicor';
				$listing_page_size = 20;
				$search            = new api_listing_search(
					$slipstream_token_query->slipstream_token,
					$listing_page_size,
					$market,
					'160045736|130048559|170019867|170029761|170034990|170041457'
				);
				//160045736
				//130048559
				//170019867
				//170029761
				//170034990
				//170041457
				$search->search_listings();
				//var_dump( $search );
				if ( $search->search_result ) {
					//var_dump( $search->search_result );
					foreach ( $search->search_result->listings as $listing ) {
					    echo 'MLS Number: ' . $listing->id . '<br />';
						echo 'Status: ' . $listing->status . '<br />';
						echo 'Listing Type: ' . $listing->listingType . '<br />';
						echo 'Style: ' . $listing->style . '<br />';
						echo 'Property Type: ' . $listing->propertyType . '<br />';
						echo 'List Price: ' . $listing->listPrice . '<br />';
						//var_dump( $listing->status );
						//var_dump( $listing );
					}
				}

				//var_dump( $search->search_result->listings );
				?>


            </div>
        </main><!-- #main -->
    </div><!-- #primary -->
<?php get_footer();
