<?php
/**
 * Template Name: Saved Searches
 *
 * @package MarketPier
 */

logged_in_check_redirect();

$user_id = MP_LOGGED_IN_ID;

get_header(); ?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main">
            <div class="page-content-wrap">
                <header class="entry-header">
                    <h1 class="entry-title">Saved Searches</h1>
                </header>

                <div class="logged-in-outer-wrap">

                    <div class="logged-in-user-content logged-in-user-listings">

						<?php

						global $wpdb;
						$prefix     = $wpdb->prefix;
						$table_name = $prefix . 'mp_saved_searches';
						$user_id    = MP_LOGGED_IN_ID;

						$saved_search_query = "SELECT * FROM `{$table_name}` WHERE `user_id` = '{$user_id}'";

						$saved_search_result = $wpdb->get_results( $saved_search_query );

						$saved_search_array = array();
						foreach ( $saved_search_result as $saved_search ) {
							$saved_search_array[] = $saved_search->search_url;
						}
						?>

                        <div class="user-listings-wrap">

							<?php

							function process_search( $search ) {
								$search2 = str_replace( '/search-listings/?', ' ', $search );
								$search3 = str_replace( '_', ' ', $search2 );
								$search4 = str_replace( '=', ' = ', $search3 );
								$search5 = str_replace( '&', ' / ', $search4 );

								return $search5;
							}


							//var_dump( $saved_search_array );
							if ( $saved_search_array ) {
								foreach ( $saved_search_array as $saved_search ) { ?>

                                    <div class="logged-in-user-listing saved-search">
                                        <span><?php echo process_search( $saved_search ); ?></span>
                                        <span class="view-edit-links">
                                    <a href="<?php echo site_url() . $saved_search; ?>">view search</a>
                                    </span>
                                    </div>
								<?php }
							} else { ?>
                                <div class="callout warning">
                                    You don't have any saved searches yet.
                                </div>
							<?php } ?>
                        </div>
                    </div>

					<?php get_template_part( 'template-parts/logged-in-user-sidebar' ); ?>
                </div>
            </div>
        </main>
    </div>
<?php get_footer();
