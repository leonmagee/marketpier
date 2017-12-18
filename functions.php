<?php
/**
 * MarketPier functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package MarketPier
 */


/**
 * Constants
 * @todo move to different file
 */
if ( is_user_logged_in() ) {
	$user    = wp_get_current_user(); // @todo search for this to replace with constant
	$user_id = $user->ID;
	define( 'MP_LOGGED_IN_ID', $user_id );
}

/**
 * Require Classes
 */
require_once( 'inc/helper-functions.php' );
require_once( 'inc/agent_update.php' );
require_once( 'inc/account_settings.php' );
require_once( 'inc/agent_update_input.php' );
require_once( 'inc/agent_update_user_input_meta.php' );
require_once( 'inc/agent_update_input_user.php' );
require_once( 'inc/agent_update_input_acf.php' );
require_once( 'inc/output_modal_acf.php' );
require_once( 'inc/output_modal_shortcode.php' );
require_once( 'inc/output_modal_login.php' );
require_once( 'inc/output_modal_generic.php' );
require_once( 'inc/mp_ajax.php' );
require_once( 'inc/get_slipstream_token.php' );
require_once( 'inc/api_listing_search.php' );
require_once( 'inc/mp_send_email.php' );
require_once( 'inc/mp_send_email_misc.php' );

/**
 * Create Tables
 */
require_once( 'inc/lv_create_table.php' );

lv_create_table::create_table_hook();

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

	wp_register_style( 'marketpier-styles', get_template_directory_uri() . '/assets/css/main.min.css', '', '1.0.31' );

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
//  wp_enqueue_script( 'foundation-js' );
}

add_action( 'wp_enqueue_scripts', 'marketpier_scripts' );

function marketpier_admin_scripts() {
	$google_fonts_libre_baskerville = 'https://fonts.googleapis.com/css?family=Libre+Baskerville:400,400i,700';

	wp_register_style( 'google-fonts-libre-baskerville', $google_fonts_libre_baskerville, '', '1.0.1' );

	wp_enqueue_style( 'google-fonts-libre-baskerville' );
}

add_action( 'login_enqueue_scripts', 'marketpier_admin_scripts' );

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
	add_image_size( 'agent-headshot', 350, 400, true );
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

/**
 * @todo some of these capabilities probably aren't necessary, and some are probably necessary.
 */
function create_agent_role() {

	add_role( 'agent', 'Agent' );

	$role = get_role( 'agent' );

	$role->add_cap( 'publish_posts' );
	$role->add_cap( 'delete_posts' );
	$role->add_cap( 'delete_published_posts' );
	$role->add_cap( 'edit_posts' );
	$role->add_cap( 'edit_published_posts' );
	$role->add_cap( 'edit_published_pages' );
	$role->add_cap( 'edit_private_posts' );
	$role->add_cap( 'edit_others_posts' ); // not sure if this is good
	$role->add_cap( 'publish_pages' );
	$role->add_cap( 'edit_pages' );
	$role->add_cap( 'edit_others_pages' );
	$role->add_cap( 'read' );
	$role->add_cap( 'upload_files' );
	$role->add_cap( 'unfiltered_upload' );
	$role->add_cap( 'level_1' );
	//edit_dashboard ???
	//edit_theme_options ???
	//export
	//import
	//customize


//activate_plugins
//delete_others_pages
//delete_others_posts
//delete_pages
//delete_private_pages
//delete_private_posts
//delete_published_pages
//edit_dashboard
//edit_private_pages
//edit_published_pages
//edit_theme_options
//export
//import
//list_users
//manage_categories
//manage_links
//manage_options
//moderate_comments
//promote_users
//read_private_pages
//read_private_posts
//remove_users
//switch_themes
//customize
//delete_site
}


/**
 * Hook into ACF Save functionality - add title to listings - automatically set new listings as active
 *
 * @param $post_id
 */
function save_post_handler_acf_listing( $post_id ) {

	if ( ! is_admin() ) {

		if ( get_post_type( $post_id ) == 'mp-listing' ) {

			$data['ID']         = $post_id;
			$prop_name          = get_field( 'listing_property_name', $post_id );
			$address            = get_field( 'listing_address', $post_id );
			$city               = get_field( 'listing_city', $post_id );
			$state              = get_field( 'listing_state', $post_id );
			$zip                = get_field( 'listing_zip', $post_id );
			$title_array        = array_filter( array( $prop_name, $address, $city, $state, $zip ) );
			$title_string       = implode( ' - ', $title_array );
			$title              = $title_string;
			$data['post_title'] = $title;
			$data['post_name']  = sanitize_title( $title );
			$permalink          = site_url() . '/listings/' . $data['post_name'];
			wp_update_post( $data );

			/**
			 * Auto Set Listing ID
			 */
			$listing_id = 'mp-' . time();
			if ( ! get_field( 'listing_id', $post_id ) ) {
				update_field( 'listing_id', $listing_id, $post_id );
			}

			/**
			 * Auto set Active status
			 */
			if ( ! get_field( 'listing_status', $post_id ) ) {
				update_field( 'listing_status', 'active', $post_id );
			}

			/**
			 * Auto set Standard Status
			 */
			if ( ! get_field( 'marketpier_listing_type', $post_id ) ) {
				update_field( 'marketpier_listing_type', 111, $post_id );
			}

			/**
			 * Auto set for sale vs. for lease
			 */
			//update_field( 'listing_for_sale_or_for_lease', 'for_lease', $post_id );
			if ( ! get_field( 'listing_for_sale_or_for_lease', $post_id ) ) {
				//update_field( 'listing_for_sale_or_for_lease', 'for_lease', $post_id );
				if ( get_field( 'listing_monthly_rent', $post_id ) ) {
					update_field( 'listing_for_sale_or_for_lease', 'for_lease', $post_id );
				} else {
					update_field( 'listing_for_sale_or_for_lease', 'for_sale', $post_id );
				}

				/**
				 * Hijacking this conditional to send emails - this should happen only when listing is first created
				 * And not when form is updated.
				 */
				$admin_email_text = 'New Listing Created: ' . $permalink;
				$admin_email      = get_bloginfo( 'admin_email' );
				$send_admin_email = new mp_send_email_misc( $admin_email, 'MarketPier Admin', 'MarketPier Listing Creation', $admin_email_text );
				$send_admin_email->send_email();

				$logged_in_user       = wp_get_current_user();
				$logged_in_user_email = $logged_in_user->user_email;
				$admin_email_text     = get_field( 'new_listing_email_text', 'option' );
				$admin_email_text     .= '<br />New Listing Created: ' . $permalink;
				$send_user_email      = new mp_send_email_misc( $logged_in_user_email, 'MarketPier User', 'MarketPier Listing Creation', $admin_email_text );
				$send_user_email->send_email();
			}
		}
	}
}

add_action( 'acf/save_post', 'save_post_handler_acf_listing', 20 );

/**
 * Disable ACF Fields
 *
 * @param $field
 *
 * @return mixed
 */
function disable_acf_load_field( $field ) {
//	if ( $field['name'] == 'rental_rate_sf_month' || $field['name'] == 'listing_net_operating_income' ) {
//		$field['disabled'] = true;
//	}
	if ( $field['name'] == 'rental_rate_sf_month' ) {
		$field['disabled'] = true;
	}

	return $field;
}

add_filter( 'acf/load_field', 'disable_acf_load_field' );

/**
 * Link Slipstream API URL to 'single-mp-listings.php' template
 * This checks to see if '/idx/' is present in the url, and if so it uses the appropriate template.
 */
function link_slipstream_url() {
	$url_path = trim( parse_url( add_query_arg( array() ), PHP_URL_PATH ), '/' );
	$str_pos  = strpos( $url_path, '/idx/' );
	if ( $str_pos ) {
		$load = locate_template( 'single-mp-listing.php', true );
		if ( $load ) {
			exit();
		}
	}
}

add_action( 'init', 'link_slipstream_url' );

/**
 * Remove WordPress Logo
 */
function remove_login_logo() { ?>
    <style type="text/css">
        body.login div#login h1 a {
            background-image: none;
            background-size: 0 0;
            height: 0;
            margin: 0 auto 0;
            width: 0;
        }

        }
    </style>
<?php }

add_action( 'login_enqueue_scripts', 'remove_login_logo' );

/**
 * Add MarketPier Logo
 * @return string
 */
function marketpier_admin_logo_text() {
	$message = "<div style='color: #111; margin: 30px 0 30px; text-align: center; font-size: 45px; font-family: Libre Baskerville; font-weight: 700;'>MarketPier</div>";

	return $message;
}

add_filter( 'login_message', 'marketpier_admin_logo_text' );

/**
 * Restrict Media Library to current user
 *
 * @param $wp_query_obj
 */
function restrict_media_library_to_current_user( $wp_query_obj ) {

	if ( ! current_user_can( 'level_5' ) ) {

		global $current_user, $pagenow;

		if ( ! is_a( $current_user, 'WP_User' ) || 'admin-ajax.php' != $pagenow || $_REQUEST['action'] != 'query-attachments' ) {
			return;
		}

		$wp_query_obj->set( 'author', $current_user->ID );

		return;
	}
}

add_action( 'pre_get_posts', 'restrict_media_library_to_current_user' );

function update_caldera_form( $data ) {

	global $author_bio_email_address;
	if ( $author_bio_email_address ) {
		$data['config']['default'] = $author_bio_email_address;
	}

	return $data;
}

add_action( 'caldera_forms_render_get_field_slug-agent_email_address_hidden', 'update_caldera_form' );
//add_action( 'caldera_forms_render_get_field_slug-{field_slug}', 'update_caldera_form');



// function remove_more_link_scroll( $link ) {
// 	$link = preg_replace( '|#more-[0-9]+|', '', $link );
// 	return $link;
// }
// add_filter( 'the_content_more_link', 'remove_more_link_scroll' );

function new_excerpt_more( $more ) {
    return '...';
}
add_filter('excerpt_more', 'new_excerpt_more');


/**
 * Undocumented function
 *
 * @param [type] $content
 * @return void
 */
function content_featured_image($content) {
	//var_dump($content);
	global $post;
	$current_id = $post->ID;
	if ( has_post_thumbnail() ) {
		$post_thumbz = get_the_post_thumbnail($current_id,'listing-gallery');
		return $post_thumbz . $content;
	} else {
		return $content;
	}
}

add_filter('the_content', 'content_featured_image');