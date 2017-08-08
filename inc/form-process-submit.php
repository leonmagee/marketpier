<?php
/**
 * Process search form submission
 */
if ( isset( $_POST['listing-search-form'] ) ) {

	$search_status        = filter_input( INPUT_POST, 'status', FILTER_SANITIZE_ENCODED );
	$search_property_type = filter_input( INPUT_POST, 'property-type', FILTER_SANITIZE_SPECIAL_CHARS );
	$search_city_zip      = filter_input( INPUT_POST, 'city-zip', FILTER_SANITIZE_SPECIAL_CHARS );

	/**
	 * Encode string - necessary for inputs with empty spaces
	 */
	$search_city_zip = rawurlencode( $search_city_zip );

	$search_input_array = array();

	if ( ! $search_status ) {
		$search_status = 'for_sale';
	}
	$status_string        = 'status=' . $search_status;
	$search_input_array[] = $status_string;

	if ( $search_property_type ) {
		$property_type_string = 'property_type=' . $search_property_type;
		$search_input_array[] = $property_type_string;
	}

	if ( $search_city_zip ) {
		$city_zip_string      = 'city_zip=' . $search_city_zip;
		$search_input_array[] = $city_zip_string;
	}

	$search_string_combo = implode( '&', $search_input_array );

	$search_string = '?' . $search_string_combo;

	$search_url = site_url() . '/search-listings/' . $search_string;

	wp_redirect( $search_url );

	exit;
}
