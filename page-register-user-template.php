<?php
/**
 * Template Name: Register User
 *
 * @package MarketPier
 *
 * @todo switching this to use ajax (to preserve user inputs when validation fails....
 */
//require_once( 'inc/mp_register_user.php' );
//
//// handling the post submission could be within a class too...
//$email_exists = false;
//if ( isset( $_POST['username'] ) ) {
//	$username      = filter_input( INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS );
//	$first_name    = filter_input( INPUT_POST, 'first_name', FILTER_SANITIZE_SPECIAL_CHARS );
//	$last_name     = filter_input( INPUT_POST, 'last_name', FILTER_SANITIZE_SPECIAL_CHARS );
//	$email_address = filter_input( INPUT_POST, 'email_address', FILTER_SANITIZE_SPECIAL_CHARS );
//
//	if ( email_exists( $email_address ) ) {
//		$email_exists = true;
//	} else {
//		$new_user = new mp_register_user( $username, $first_name, $last_name, $email_address );
//		$new_user->process_registration_form();
//	}
//
//}


//if ( ! is_user_logged_in() ) { // @todo check for type of author/agent?
//
//	wp_redirect( site_url() );
//
//	exit;
//}

//acf_form_head(); // this should only be used on two pages - new listing and update profile?

get_template_part( 'template-parts/spinner' );

get_header(); ?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main">
            <div class="page-content-wrap">
                <header class="entry-header">
                    <h1 class="entry-title">Register Your Account</h1>
                </header>
                <div class="mp-update-success success callout">Your account has been successfully created.</div>
                <div class="mp-required-fields callout alert">Plese fill out all required fields.</div>
                <div class="register-user-email-taken callout alert">
                    That email address is already taken! <a href="#">Login</a> - <a href="#">ForgotYour Password</a>
                </div>
				<?php get_template_part( 'template-parts/registration-form' ); ?>
            </div>
        </main><!-- #main -->
    </div><!-- #primary -->
<?php get_footer();
