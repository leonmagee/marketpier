<?php
/**
 * Template Name: Deprecated
 *
 * @package MarketPier
 *
 * @todo add redirect if user is not logged in...
 */


//if ( ! is_user_logged_in() ) { // @todo check for type of author/agent?
//
//	wp_redirect( site_url() );
//
//	exit;
//}

//acf_form_head(); // this should only be used on two pages - new listing and update profile?

$user = wp_get_current_user();

$agent_id = $user->ID;

$username = $user->user_login;

get_header(); ?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main">
            <div class="page-content-wrap">
                <header class="entry-header">
                    <h1 class="entry-title">Your Listings</h1>
                </header>

                <div class="logged-in-outer-wrap">

					<?php get_template_part( 'template-parts/logged-in-user-sidebar' ); ?>

                    <div class="logged-in-user-content logged-in-user-listings">

						<?php

						$args = array(
							'post_type'   => 'mp-listing',
							'post_author' => $agent_id
						);

						$mp_listing_query = new WP_Query( $args ); ?>

                        <div class="user-listings-wrap">

                            <div class="callout warning">
                                You don't have any listings yet. <a href="<?php echo site_url(); ?>/add-listing">Add
                                    Listing</a>
                            </div>

							<?php

							while ( $mp_listing_query->have_posts() ) {
								$mp_listing_query->the_post();
								$listing_id = $post->ID;
								/**
								 * @todo use hash instead...
								 */
								?>

                                <div class="logged-in-user-listing">
                                    <span><?php the_title(); ?></span>
                                    <span class="view-edit-links">
                                    <a href="<?php the_permalink(); ?>">view</a>
                                    <a href="<?php echo site_url(); ?>/edit-listing?listing=<?php echo $listing_id; ?>">edit</a>
                                    </span>
                                </div>

							<?php } ?>

                        </div>

                    </div>

                </div>

            </div>
        </main><!-- #main -->
    </div><!-- #primary -->

<?php
get_footer();
