<?php
/**
 * Template Name: User Dashboard
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
                    <h1 class="entry-title">Agent Dashboard</h1>
                    <h3>Agent Options for <span><?php echo $username; ?></span></h3>
                </header>

                <div class="user-profile-wrap">

                    <h4>Your Options</h4>

                    <div class="agent-home-option">
                        <i class="fa fa-chevron-right"></i>
                        <a href="<?php echo site_url(); ?>/profile">Update Your Profile</a>
                    </div>
                    <div class="agent-home-option">
                        <i class="fa fa-chevron-right"></i>
                        <a href="<?php echo site_url(); ?>/agent/<?php echo $username; ?>">View Your Profile</a>
                    </div>
                    <div class="agent-home-option">
                        <i class="fa fa-chevron-right"></i>
                        <a href="<?php echo site_url(); ?>/add-listing">Add a Listing</a>
                    </div>
                    <div class="agent-home-option">
                        <i class="fa fa-chevron-right"></i>
                        <a href="<?php echo site_url(); ?>">MarketPier Home</a>
                    </div>
                    <div class="agent-home-option">
                        <i class="fa fa-chevron-right"></i>
                        <a href="<?php echo wp_logout_url( site_url() ); ?>">Log Out</a>
                    </div>

					<?php

					$args = array(
						'post_type'   => 'mp-listing',
						'post_author' => $agent_id
					);

					$mp_listing_query = new WP_Query( $args ); ?>

                    <div class="user-listings-wrap">

                        <h4>Your Listings</h4>

						<?php

						while ( $mp_listing_query->have_posts() ) {
							$mp_listing_query->the_post(); ?>

                            <div class="agent-home-option">
                                <i class="fa fa-chevron-right"></i>
                                <span><?php the_title(); ?></span> -
                                <a href="<?php the_permalink(); ?>">view</a> -
                                <a href="<?php echo site_url(); ?>/edit-listing?listing=<?php echo $id_hash; ?>">edit</a>
                            </div>

						<?php } ?>

                    </div>

                </div><!-- #page row -->

            </div>
        </main><!-- #main -->
    </div><!-- #primary -->

<?php
get_footer();
