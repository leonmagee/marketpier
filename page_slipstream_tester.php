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
				$listing_page_size = 300;
				$search            = new api_listing_search(
					$slipstream_token_query->slipstream_token,
					$listing_page_size,
					$market
				);
				$search->search_listings();
				foreach ( $search->search_result->listings as $listing ) {
					var_dump( $listing->id );
                }

				var_dump( $search->search_result->listings );
				?>


            </div>
        </main><!-- #main -->
    </div><!-- #primary -->
<?php get_footer();
