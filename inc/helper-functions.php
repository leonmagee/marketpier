<?php

/**
 *  Parse URL
 */
function mp_parse_url( $url ) {

	$url_new = str_replace( array( 'http://', 'https://' ), '', $url );

	$url_final = 'https://' . $url_new;

	return $url_final;
}

/**
 *  Encrypt and Decrypt strings - mcrypt_decrypt not working on HJ server
 *  This is still secure since there is verification that the post belongs to
 *  the logged in user in functions.php
 */

function mp_encrypt( $hash ) {

	$key    = 323846238946239;
	$number = $hash * $key;

	return ( $number );
}

function mp_decrypt( $hash ) {

	$key    = 323846238946239;
	$number = $hash / $key;

	return ( $number );
}


function shorten_string( $text, $length = 150 ) {

	$text = strip_tags( $text );

	$text = preg_replace( '/\s+/', ' ', trim( $text ) );

	$string_length = strlen( $text );

	if ( $string_length > $length ) {

		$text = substr( $text, 0, $length );

		$text = explode( ' ', $text );

		array_pop( $text );

		$text = implode( ' ', $text );

		return $text . '... ';

	} else {

		return $text . ' ';
	}


}

/**
 * @todo Add checks for these to see if it's admin ajax happening...
 */
function logged_in_check_redirect() {
	if ( ! is_user_logged_in() ) {
		wp_redirect( site_url() );
		exit;
	}
}

function logged_in_check_redirect_profile() {
	if ( is_user_logged_in() ) {
		wp_redirect( site_url() . '/your-profile' );
		exit;
	}
}

/**
 * Return key for Slipstream market - these property names and keys are
 * entered into theme options in an ACF repeater field.
 *
 * @param $extended_fields
 * @param $market
 * @param $field_name
 *
 * @return string, bool
 */
function get_key( $extended_fields, $market, $field_name ) {
	$key = false;
	foreach ( $extended_fields as $fields ) {
		if ( $fields['market'] === $market ) {
			foreach ( $fields['fields'] as $field ) {
				if ( $field['field'] === $field_name ) {
					$key = $field['key'];
					continue;
				}
			}
		}
	}

	return $key;
}

/**
 * Return key for Slipstream market - these property names and keys are
 * entered into theme options in an ACF repeater field.
 *
 * @param $extended_fields
 * @param $market
 * @param $field_name
 * @param $class_name
 *
 * @return string, bool
 * @todo I can make this only count the class name when the market is sandicor... 
 * Then I can remove the extra string from the CRMLS data
 */
function get_key_class( $extended_fields, $market, $field_name, $class_name ) {
	$key = false;
	foreach ( $extended_fields as $fields ) {

		//var_dump($fields['market']); 
		$market_class = explode('|', $fields['market']);
		//var_dump($market_class);
		$market_acf = $market_class[0];
		if ( $market_acf === 'sandicor' ) {
		$class_acf = $market_class[1];
		if ( ($market_acf === $market) && ($class_acf === $class_name) ) {
			foreach ( $fields['fields'] as $field ) {
				if ( $field['field'] === $field_name ) {
					$key = $field['key'];
					continue;
				}
			}
		}
		} else {
			if ($market_acf === $market) {
				foreach ( $fields['fields'] as $field ) {
					if ( $field['field'] === $field_name ) {
						$key = $field['key'];
						continue;
					}
				}
			}	
		}
	}

	return $key;
}

/**
 * Get all keys
 *
 * @param [type] $extended_fields
 * @param [type] $market
 * @return void
 */
function get_all_keys( $extended_fields, $market ) {
	foreach ( $extended_fields as $fields ) {
		if ( $fields['market'] === $market ) {
			$key_array = array();
			foreach ( $fields['fields'] as $field ) {
				$key_array[] = $field['key'];
			}
		}
	}
	$fields_new = implode( '|', $key_array );

	return $fields_new;
}



/**
 * Get commercial search key and value
 *
 * @param [type] $extended_fields
 * @param [type] $market
 * @return void
 */
function get_commercial_lease_keys( $repeater_field, $market ) {
	foreach ( $repeater_field as $field ) {
		$key_array = null;
		if ( $field['market'] === $market ) {
			$key_array = array();					
			$key_array['key'] = $field['key'];
			$key_array['value'] = $field['value'];
		}
	}
	return $key_array;
}

/**
 * Determine how many idx listings to return based on page size, wp listing count, and current page
 *
 * @param $page_size
 * @param $wp_count
 * @param int $current_page
 * @param string $idx_count
 *
 * @return int
 * @todo also take in total number of listings, so idx listings needed will also account for that
 */
function idx_listings_page_size( $page_size, $wp_count, $current_page = 1, $total_idx_listings = false ) {
//	var_dump( 'page size', $page_size );
//	var_dump( 'wp count', $wp_count );
//	var_dump( 'current page', $current_page );
//	var_dump( 'total idx', $total_idx_listings );
	/**
	 * total_listings relies on a transient being set, so this
	 * can't run on the first page?
	 */
	if ( $total_idx_listings ) {

		$total_listings = ( $total_idx_listings + $wp_count );

		$max_pages = ceil( $total_listings / $page_size );
		if ( $current_page > $max_pages ) {
			return 0;
		}
	}
	//var_dump( 'max', $max_pages );
	/**
	 * I need to program this to subtract from the $current_page the number of times that there are no IDX results.
	 */


	if ( $total_idx_listings && $wp_count ) {
		//$total_listings      = ( $total_idx_listings + $wp_count );
		$max_listings_so_far = ( $current_page * $page_size );
		if ( $total_listings < $max_listings_so_far ) {
			$listing_diff       = ( $max_listings_so_far - $total_listings );
			$listings_this_page = ( $page_size - $listing_diff );

			return $listings_this_page;
		}
	}
	$difference = ( $page_size * $current_page ) - $wp_count;
	//var_dump( 'DIFF', $difference );
	if ( $difference <= 0 ) {
		$idx_listings_needed = 0;
	} elseif ( $difference >= $page_size ) {
		$idx_listings_needed = $page_size;
	} else {
		$idx_listings_needed = $difference;
	}

	return $idx_listings_needed;
}

function idx_listings_current_page( $page_size, $wp_count, $page_number ) {
	$divide             = ( $wp_count / $page_size );
	$subtraction_amount = intval( $divide );
	$page_number_new    = $page_number - $subtraction_amount;

	return $page_number_new;
}

/**
 * Use this function to do var dumps - it can be toggled on and off by changing $debug value
 * @todo remove instances of this function when site goes live
 *
 * @param null $one
 * @param null $two
 * @param bool $debug
 */
function debug_dump( $one = null, $two = null, $debug = false ) {
	if ( $debug ) {
		if ( $one ) {
			var_dump( $one );
		}
		if ( $two ) {
			var_dump( $two );
		}
	}
}

/**
 * Used output counties saved in repeater field for dropdown.
 *
 * @param $counties
 *
 * @return array
 */
function all_counties_array() {
	$all_counties = array();

	$counties_array = get_field( 'search_dropdown_counties', 'option' );
	foreach ( $counties_array as $county ) {
		$all_counties[] = $county['county'];
	}

	return $all_counties;
}

function get_disclaimer( $market ) {
	$disclaimers_array = get_field( 'market_disclaimers', 'option' );
	$disclaimer        = '';
	foreach ( $disclaimers_array as $disclaimer ) {
		if ( $market === $disclaimer['market'] ) {
			$disclaimer = $disclaimer['disclaimer'];
			break;
		}
	}

	return $disclaimer;
}

/**
 * Restrict wp-admin to administrators
 */
function restrict_user_access() {
	if ( is_user_logged_in() && is_admin() && ( ! current_user_can( 'administrator' ) ) &&
	     ( ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) && ( '/wp-admin/admin-ajax.php' != $_SERVER['PHP_SELF'] )
	) {
		wp_redirect( site_url() . '/your-profile' );
		exit;
	}
}

add_action( 'init', 'restrict_user_access' );
