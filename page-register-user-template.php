<?php
/**
 * Template Name: Register User
 *
 * @package MarketPier
 */

require_once( 'inc/mp_register_user.php' );

// handling the post submission could be within a class too...
if ( isset( $_POST['username'] ) ) {
	$username      = filter_input( INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS );
	$first_name    = filter_input( INPUT_POST, 'first_name', FILTER_SANITIZE_SPECIAL_CHARS );
	$last_name     = filter_input( INPUT_POST, 'last_name', FILTER_SANITIZE_SPECIAL_CHARS );
	$email_address = filter_input( INPUT_POST, 'email_address', FILTER_SANITIZE_SPECIAL_CHARS );

	$new_user = new mp_register_user( $username, $first_name, $last_name, $email_address );
	$new_user->process_registration_form();

}


//if ( ! is_user_logged_in() ) { // @todo check for type of author/agent?
//
//	wp_redirect( site_url() );
//
//	exit;
//}

//acf_form_head(); // this should only be used on two pages - new listing and update profile?

get_header(); ?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main">
            <div class="page-content-wrap">
                <header class="entry-header">
                    <h1 class="entry-title">Register Your Account</h1>
                </header>
				<?php get_template_part( 'template-parts/registration-form' ); ?>
            </div>
        </main><!-- #main -->
    </div><!-- #primary -->

<?php
//get_sidebar();
get_footer();
