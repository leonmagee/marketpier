<?php
/**
 * MarketPier functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package MarketPier
 */

/**
 * Require Classes
 * @todo move this
 */
require_once( 'inc/agent_update.php' );
require_once( 'inc/agent_update_input.php' );
require_once( 'inc/agent_update_user_input_meta.php' );
require_once( 'inc/agent_update_input_user.php' );
require_once( 'inc/agent_update_input_acf.php' );
require_once( 'inc/output_modal_acf.php' );
require_once( 'inc/output_modal_shortcode.php' );
require_once( 'inc/mp_ajax.php' );


/**
 * @todo temp - hide admin bar
 */
show_admin_bar( false );


if ( ! function_exists( 'marketpier_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function marketpier_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on MarketPier, use a find and replace
		 * to change 'marketpier' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'marketpier', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'marketpier' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'marketpier_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'marketpier_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function marketpier_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'marketpier_content_width', 640 );
}

add_action( 'after_setup_theme', 'marketpier_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function marketpier_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'marketpier' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'marketpier' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}

add_action( 'widgets_init', 'marketpier_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function marketpier_scripts() {

	wp_enqueue_style( 'marketpier-style', get_stylesheet_uri() );

	wp_enqueue_script( 'marketpier-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'marketpier-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	/**
	 * Custom Styles
	 */
	wp_register_style( 'font-awesome', get_template_directory_uri() . '/vendor/font-awesome/css/font-awesome.min.css', array() );

	wp_enqueue_style( 'font-awesome' );

	wp_register_style( 'foundation', get_template_directory_uri() . '/vendor/foundation/css/foundation.css', array() );

	wp_enqueue_style( 'foundation' );

	wp_register_style( 'marketpier-styles', get_template_directory_uri() . '/assets/css/main.min.css', '', '1.0.1' );

	wp_enqueue_style( 'marketpier-styles' );

	$google_fonts_open_sans = 'https://fonts.googleapis.com/css?family=Open+Sans:400,400i,600,600i,700,700i,800,800i';

	wp_register_style( 'google-fonts-open-sans', $google_fonts_open_sans, '', '1.0.1' );

	wp_enqueue_style( 'google-fonts-open-sans' );

	$google_fonts_libre_baskerville = 'https://fonts.googleapis.com/css?family=Libre+Baskerville:400,400i,700';

	wp_register_style( 'google-fonts-libre-baskerville', $google_fonts_libre_baskerville, '', '1.0.1' );

	wp_enqueue_style( 'google-fonts-libre-baskerville' );

	/**
	 * Custom Scripts
	 */
	wp_register_script( 'foundation-js', get_template_directory_uri() . '/vendor/foundation/js/vendor/foundation.js', '', '1.1.2', true );
	wp_register_script( 'custom-js', get_template_directory_uri() . '/js/custom.js', array(
		//'jquery',
		'foundation-js'
	), '1.1.2', true );
	wp_enqueue_script( 'custom-js' );

	wp_register_script( 'agent-profile-ajax', get_template_directory_uri() . '/js/agent-profile-ajax.js', array(
		'jquery',
		'foundation-js'
	), '1.1.1', true );
	wp_enqueue_script( 'agent-profile-ajax' );

//	$google_maps_url = "https://maps.googleapis.com/maps/api/js?callback=initMap&key=AIzaSyCicY4hdtrXeGNvBQSivkxAKOseNIDWZdc";
//	wp_register_script( 'google-maps-api', $google_maps_url, '1.0.0', false );
//	wp_enqueue_script( 'google-maps-api' );


	//wp_enqueue_script( 'foundation-js' );

}

add_action( 'wp_enqueue_scripts', 'marketpier_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Image Sizes
 */
function mp_custom_image_sizes() {
	add_image_size( 'listing-gallery', 600, 430, true );
}

add_action( 'after_setup_theme', 'mp_custom_image_sizes' );

/**
 * Custom Post Types
 */
include_once( 'inc/cpt.php' );
function lv_register_post_types() {
	//lv_create_wp_cpt::create_post_type( 'mp-testimonials', 'Testimonial', 'Testimonials', 'testimonials', 'format-quote' );

	lv_create_wp_cpt::create_post_type( 'mp-listing', 'Listing', 'Listings', 'listings', 'location' );

	//lv_create_wp_cpt::create_post_type( 'mp-building', 'Building', 'Buildings', 'buildings', 'building' );

	//lv_create_wp_cpt::create_post_type( 'mp-cities', 'City', 'Cities', 'cities', 'location-alt' );


}

add_action( 'init', 'lv_register_post_types' );


/**
 * Add ACF Theme Options Page
 */
if ( function_exists( 'acf_add_options_page' ) ) {

	acf_add_options_page( array(
		'page_title' => 'Theme General Settings',
		'menu_title' => 'Theme Settings',
		'menu_slug'  => 'theme-general-settings',
		'capability' => 'edit_posts',
		'redirect'   => false,
		'icon_url'   => 'dashicons-admin-settings',
		'position'   => 4
	) );
}


add_action( 'init', 'create_agent_role' );

function create_agent_role() {

	add_role( 'agent', 'Agent' );

	$role = get_role( 'agent' );

	$role->add_cap( 'publish_posts' );
	$role->add_cap( 'delete_posts' );
	$role->add_cap( 'delete_published_posts' );
	$role->add_cap( 'edit_posts' );
	$role->add_cap( 'edit_published_posts' );
	$role->add_cap( 'edit_private_posts' );
	$role->add_cap( 'edit_others_posts' );
	$role->add_cap( 'publish_pages' );
	$role->add_cap( 'edit_pages' );
	$role->add_cap( 'edit_others_pages' );
	$role->add_cap( 'read' );
	$role->add_cap( 'upload_files' );
	$role->add_cap( 'unfiltered_upload' );
}


/**
 * Add title automatically to listings
 */

add_action( 'acf/save_post', 'save_post_handler_acf_listing', 20 );

function save_post_handler_acf_listing( $post_id ) {
	if ( ! is_admin() ) {
		if ( get_post_type( $post_id ) == 'mp-listing' ) {
			$data['ID']         = $post_id;
			$prop_name          = get_field( 'listing_property_name', $post_id );
			$address            = get_field( 'listing_address', $post_id );
			$city               = get_field( 'listing_city', $post_id );
			$state              = get_field( 'listing_state', $post_id );
			$zip                = get_field( 'listing_zip', $post_id );
			$title_array        = array( $prop_name, $address, $city, $state, $zip );
			$title_string       = implode( ' - ', $title_array );
			$title              = $title_string;
			$data['post_title'] = $title;
			$data['post_name']  = sanitize_title( $title );
			wp_update_post( $data );
		}
	}
}

/* 'On save' events */
//function save_post_handler( $post_id ) {
//	if ( get_post_type( $post_id ) == $this->post_type ) {
//		$data['ID']         = $post_id;
//		$title              = get_field( 'voucher_id', $post_id );
//		$data['post_title'] = $title;
//		$data['post_name']  = sanitize_title( $title );
//		wp_update_post( $data );
//	}
//}