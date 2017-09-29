<?php
/**
 * Template Name: Your Listings
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
                    <h1 class="entry-title">Your Listings</h1>
                </header>

                <div class="logged-in-outer-wrap">

                    <div class="logged-in-user-content logged-in-user-listings">

						<?php

						$args = array(
							'post_type'   => 'mp-listing',
							'author' => $user_id
						);

						$mp_listing_query = new WP_Query( $args ); ?>

                        <div class="user-listings-wrap">
							<?php if ( $mp_listing_query->have_posts() ) {
								while ( $mp_listing_query->have_posts() ) {
									$mp_listing_query->the_post();
									$listing_id = $post->ID;
									?>
                                    <div class="logged-in-user-listing">
                                        <span><?php the_title(); ?></span>
                                        <span class="view-edit-links">
                                    <a href="<?php the_permalink(); ?>">view</a>
                                    <a href="<?php echo site_url(); ?>/edit-listing?listing=<?php echo $listing_id; ?>">edit</a>
                                    <a class="delete-listing-link">delete</a>
                                    </span>
                                    </div>
								<?php }
							} else { ?>
                                <div class="callout warning">
                                    You don't have any listings yet. <a href="<?php echo site_url(); ?>/add-listing">Add
                                        Listing</a>
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
