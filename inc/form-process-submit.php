<?php
/**
 * Process search form submission
 */
if ( isset( $_POST['listing-search-form'] ) ) {

	$page_number           = filter_input( INPUT_POST, 'page-number', FILTER_SANITIZE_ENCODED );
	$search_for_sale_lease = filter_input( INPUT_POST, 'for-sale-lease', FILTER_SANITIZE_ENCODED );
	$search_status         = filter_input( INPUT_POST, 'status', FILTER_SANITIZE_ENCODED );
	$search_property_type  = filter_input( INPUT_POST, 'property-type', FILTER_SANITIZE_SPECIAL_CHARS );
	$search_city_zip       = filter_input( INPUT_POST, 'city-zip', FILTER_SANITIZE_SPECIAL_CHARS );
	$search_price_min      = filter_input( INPUT_POST, 'price-min', FILTER_SANITIZE_SPECIAL_CHARS );
	$search_price_max      = filter_input( INPUT_POST, 'price-max', FILTER_SANITIZE_SPECIAL_CHARS );
	$search_sqft_min       = filter_input( INPUT_POST, 'sqft-min', FILTER_SANITIZE_SPECIAL_CHARS );
	$search_sqft_max       = filter_input( INPUT_POST, 'sqft-max', FILTER_SANITIZE_SPECIAL_CHARS );
	$cap_rate_min          = filter_input( INPUT_POST, 'cap-rate-min', FILTER_SANITIZE_SPECIAL_CHARS );
	$cap_rate_max          = filter_input( INPUT_POST, 'cap-rate-max', FILTER_SANITIZE_SPECIAL_CHARS );
	$lot_size_min          = filter_input( INPUT_POST, 'lot-size', FILTER_SANITIZE_SPECIAL_CHARS );
	$days_on_market        = filter_input( INPUT_POST, 'days-on-market', FILTER_SANITIZE_SPECIAL_CHARS );
	$sold_in_last          = filter_input( INPUT_POST, 'sold-in-last', FILTER_SANITIZE_SPECIAL_CHARS );

	/**
	 * Encode string - necessary for inputs with empty spaces
	 */
	$search_city_zip = rawurlencode( $search_city_zip );

	$search_input_array = array();

	/**
	 * Search Defaults
	 */
	if ( ! $search_status ) {
		$search_status = 'active';
	}
	$search_status_string = 'status=' . $search_status;
	$search_input_array[] = $search_status_string;

	if ( ! $search_for_sale_lease ) {
		$search_for_sale_lease = 'for_sale';
	}
	$search_for_sale_lease_string = 'for_sale_lease=' . $search_for_sale_lease;
	$search_input_array[]         = $search_for_sale_lease_string;

	if ( $search_property_type ) {
		$property_type_string = 'property_type=' . $search_property_type;
		$search_input_array[] = $property_type_string;
	} else {
		$property_type_string = 'property_type=all_property_types';
		$search_input_array[] = $property_type_string;
	}

	if ( $search_city_zip ) {
		$city_zip_string      = 'city_zip=' . $search_city_zip;
		$search_input_array[] = $city_zip_string;
	}

	if ( $search_price_min ) {
		$price_min_string     = 'price_min=' . $search_price_min;
		$search_input_array[] = $price_min_string;
	}

	if ( $search_price_max ) {
		$price_max_string     = 'price_max=' . $search_price_max;
		$search_input_array[] = $price_max_string;
	}

	if ( $search_sqft_min ) {
		$sqft_min_string      = 'sqft_min=' . $search_sqft_min;
		$search_input_array[] = $sqft_min_string;
	}

	if ( $search_sqft_max ) {
		$sqft_max_string      = 'sqft_max=' . $search_sqft_max;
		$search_input_array[] = $sqft_max_string;
	}

	if ( $cap_rate_min ) {
		$cap_rate_min_string  = 'cap_rate_min=' . $cap_rate_min;
		$search_input_array[] = $cap_rate_min_string;
	}

	if ( $cap_rate_max ) {
		$cap_rate_max_string  = 'cap_rate_max=' . $cap_rate_max;
		$search_input_array[] = $cap_rate_max_string;
	}

	if ( $lot_size_min ) {
		$lot_size_min_string  = 'lot_size_min=' . $lot_size_min;
		$search_input_array[] = $lot_size_min_string;
	}

	if ( $days_on_market ) {
		$days_on_market_string = 'days_on_market=' . $days_on_market;
		$search_input_array[]  = $days_on_market_string;
	}

	if ( $sold_in_last ) {
		$sold_in_last_string  = 'sold_in_last=' . $sold_in_last;
		$search_input_array[] = $sold_in_last_string;
	}

	if ( $page_number ) {
		$page_number_string   = 'page_number=' . $page_number;
		$search_input_array[] = $page_number_string;
	} else {
		$page_number_string   = 'page_number=1';
		$search_input_array[] = $page_number_string;
	}

	$search_string_combo = implode( '&', $search_input_array );

	$search_string = '?' . $search_string_combo;

	$search_url = site_url() . '/search-listings/' . $search_string;

	wp_redirect( $search_url );

	exit;
}
