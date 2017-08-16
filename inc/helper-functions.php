<?php

/**
 *  Parse URL
 */
function mp_parse_url( $url ) {

	$url_new = str_replace( array( 'http://', 'https://'  ), '', $url );

	$url_final = 'https://' . $url_new;

	return $url_final;
}

/**
 *  Encrypt and Decrypt strings - mcrypt_decrypt not working on HJ server
 *  This is still secure since there is verification that the post belongs to
 *  the logged in user in functions.php
 */

function mp_encrypt( $hash ) {

	$key = 323846238946239;
	$number = $hash * $key;
	return( $number );
}

function mp_decrypt( $hash ) {

	$key = 323846238946239;
	$number = $hash / $key;
	return( $number );
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