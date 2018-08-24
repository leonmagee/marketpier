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
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1,user-scalable=0">
    <!-- Google Analytics -->
    <script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-107566374-1', 'auto');
    ga('send', 'pageview');
    </script>
    <!-- End Google Analytics -->

    <link rel="profile" href="http://gmpg.org/xfn/11">
	<?php $favicon_url = get_field( 'favicon', 'option' ) . '?v=2'; ?>
    <link rel="shortcut icon" href="<?php echo $favicon_url ?>" type="image/x-icon"/>
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
				<?php if ( is_user_logged_in() ) {
					$logged_in_user = wp_get_current_user();
					$logged_in_id   = $logged_in_user->ID;
					if ( $first_name = $logged_in_user->first_name ) {
						$logged_in_name = $first_name;
					} else {
						$logged_in_name = $logged_in_user->user_login;
					}
					?>
                    <div class="logged-in-agent-headshot-wrap">
                        <div class="header-headshot">
							<?php
							$headshot_field = get_field( 'headshot', 'user_' . $logged_in_id );
							if ( $headshot_field ) {
								$headshot = $headshot_field['sizes']['thumbnail'];
							} else {
								$headshot = get_stylesheet_directory_uri() . '/assets/img/headshot-default.jpg';
							} ?>
                            <img src="<?php echo $headshot; ?>"/>
                        </div>
                        <div class="hello-user">
                            <span><?php echo $logged_in_name; ?></span>
                        </div>
                        <div class="menu-drop-down-icon">
                            <i class="fa fa-chevron-down"></i>
                        </div>
                        <div class="menu-drop-down">
							<?php get_template_part( 'template-parts/logged-in-user-sidebar' ); ?>
                        </div>
                    </div>
				<?php } else { ?>
                    <div class="create-listing-link">
                        <!--                        <a href="-->
						<?php //echo site_url(); ?><!--/add-listing">Create Listing</a>-->
                        <a data-open="login-modal">Create Listing</a>
                    </div>
                    <div class="login-sign-in">
                        <a data-open="login-modal">
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
		 *  Login Modal
		 */
		$log_in_modal = new mp_output_modal_login(
			'login-modal',
			'Log In',
			true
		);
		$log_in_modal->output_modal();
		?>
    </header><!-- #masthead -->

    <div id="content" class="site-content">