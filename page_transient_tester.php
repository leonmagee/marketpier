<?php
/**
 * Template Name: Transient Test
 *
 * @package MarketPier
 */

get_header(); ?>
    <div id="primary" class="content-area">
        <main id="main" class="site-main">
            <div class="page-content-wrap">
                <h1>Transient Testing</h1>
				<?php
				/**
				 * Test Transients
				 */
//				$trans_new2      = set_transient( 'transient_test_name2', 'xxx yyy zzz ddd', 60 );
				$trans_retrieve2 = get_transient( 'transient_test_name2' );
				var_dump( $trans_retrieve2 );

				/**
				 * 1) Regardless of the age of the transient (or expiration time), you can change the value of a
                 * transient whenever you call 'set_transient'.
                 * 2) After transient expires it will return false when you attempt to 'get_transient'. Calling
                 * 'get_transient' on an expired transient will remove it from the database
                 * 3) If you never call 'get_transient' on an expired transient then it will never be removed.
                 * 4)
				 */

				?>
            </div>
        </main><!-- #main -->
    </div><!-- #primary -->
<?php get_footer();
