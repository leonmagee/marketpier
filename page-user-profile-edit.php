<?php
/**
 * Template Name: User Profile Edit
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

acf_form_head(); // this should only be used on two pages - new listing and update profile?

$user = wp_get_current_user();

$agent_id = $user->ID;

$username = $user->user_login;

get_header(); ?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main">
            <div class="page-content-wrap">
                <header class="entry-header">
                    <h1 class="entry-title">Edit Profile</h1>
                    <h3>Agent Options for <span><?php echo $username; ?></span></h3>
                </header>






	            <?php


	            get_template_part( 'template-parts/spinner' );





	            get_template_part( 'template-parts/agent-profile' );

	            ?>







            </div>
        </main><!-- #main -->
    </div><!-- #primary -->

<?php
get_footer();
