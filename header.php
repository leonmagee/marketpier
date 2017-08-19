<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package MarketPier
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="shortcut icon" href="<?php echo get_field( 'favicon', 'option' ); ?>" type="image/x-icon"/>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'marketpier' ); ?></a>

    <header id="masthead" class="site-header">
        <div class="header-inner">
            <div class="site-branding">
                <div class="marketpier-logo">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">MarketPier</a>
                </div>
				<?php if ( $broker_logo = get_field( 'broker_logo', 'option' ) ) { ?>
                    <div class="broker-logo">
                        <img src="<?php echo $broker_logo; ?>"/>
                    </div>
				<?php } ?>
            </div><!-- .site-branding -->
            <div class="header-right">
                <div class="create-listing-link">
                    <a href="<?php echo site_url(); ?>/add-listing">Create Listing</a>
                </div>
				<?php if ( is_user_logged_in() ) {
					$logged_in_user = wp_get_current_user();
					if ( $first_name = $logged_in_user->first_name ) {
						if ( $last_name = $logged_in_user->last_name ) {
							$logged_in_name = $first_name . ' ' . $last_name;
						} else {
							$logged_in_name = $first_name;
						}
					} else {
						$logged_in_name = $logged_in_user->user_login;
					}
					?>
                    <div class="header-headshot">
                        <?php
                        $headshot_field = get_field( 'headshot', 'user_' . $author );
                        if ( $headshot ) {
                        $headshot       = $headshot_field['sizes']['agent-headshot']; ?>
                       <img src="<?php echo $headshot; ?>" />
                        <?php } ?>
                    </div>
                    <div class="hello-user">
                        Hello <span><?php echo $logged_in_name; ?></span>!
                    </div>
                    <div class="log-out-wrap">
                        <a href="<?php echo wp_logout_url( site_url() ); ?>">Log Out</a>
                    </div>
				<?php } else { ?>
                    <div class="login-sign-in">
                        <a data-open="login-modal" href="#">
                            Log In
                            <sep>/</sep>
                            Sign Up
                        </a>
                    </div>
				<?php } ?>
            </div>
        </div>

		<?php
		/**
		 *  Button Modals
		 */
		$log_in_modal = new mp_output_modal_shortcode(
			'[caldera_form id="CF56d5c71c8a908"]',
			'login-modal',
			'Log In'
		);

		$log_in_modal->output_modal();
		?>


    </header><!-- #masthead -->

    <div id="content" class="site-content">
