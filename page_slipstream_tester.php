<?php
/**
 * Template Name: Slipstream Test
 *
 * @package MarketPier
 */

$slipstream_token_query = new get_slipstream_token();

$mls_number = false;
if ( isset( $_GET['mls_number'] ) ) {
	$mls_number = $_GET['mls_number'];
}
$market = 'sandicor';
if ( isset( $_GET['market'] ) ) {
	$market = $_GET['market'];
}

get_header(); ?>
    <div id="primary" class="content-area">
        <main id="main" class="site-main">
            <div class="page-content-wrap">
                <h1>Slipstream Testing</h1>
				<?php //var_dump( $slipstream_token_query->slipstream_token );
				$listing_page_size = 50;
				if ( $mls_number ) {
					$search = new api_listing_search(
						$slipstream_token_query->slipstream_token,
						$listing_page_size,
						$market,
						$mls_number
					);
				} else {
					$search = new api_listing_search(
						$slipstream_token_query->slipstream_token,
						$listing_page_size,
						$market
					);
				}

				$parameters = false;
				$parameters = array( 'price_range' => '0:1000000000000' );
				$search->search_listings( $parameters );
				var_dump( $search->search_result );
				?>
            </div>
        </main><!-- #main -->
    </div><!-- #primary -->
<?php get_footer();
