<?php
/**
 * Template Name: Register User
 * @package MarketPier
 */
if ( is_user_logged_in() ) {
	wp_redirect( site_url() . '/profile' );
	exit;
}
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
