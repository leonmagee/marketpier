<?php

/**
 * Class lv_create_table
 */
class lv_create_table {

	public static function create_table_hook() {
		add_action( 'init', array( 'lv_create_table', 'create_table_favorite_listings' ) );
		add_action( 'init', array( 'lv_create_table', 'create_table_saved_searches' ) );
	}

	public static function create_table_favorite_listings() {

		global $wpdb;
		$prefix          = $wpdb->prefix;
		$table_name      = $prefix . 'mp_favorite_listings';
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		user_id mediumint(9) NOT NULL,
		listing_id text NOT NULL,
		listing_title text NOT NULL,
		listing_url text NOT NULL,
		PRIMARY KEY  (id)
	) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}

	public static function create_table_saved_searches() {

		global $wpdb;
		$prefix          = $wpdb->prefix;
		$table_name      = $prefix . 'mp_saved_searches';
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		user_id mediumint(9) NOT NULL,
		search_url text NOT NULL,
		PRIMARY KEY  (id)
	) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}


}