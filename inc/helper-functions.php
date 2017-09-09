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
				}
			}
		}
	}

	return $key;
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
 */
function idx_listings_page_size( $page_size, $wp_count, $current_page = 1 ) {
	/**
	 * I need to program this to subtract from the $current_page the number of times that there are no IDX results.
	 */
	$difference = ( $page_size * $current_page ) - $wp_count;
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
