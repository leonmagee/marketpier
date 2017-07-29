<?php

/**
 *  Get custom fields for an individual listing
 * @todo make this a class - extend for both listings and snippets?
 */

$listing_id = $post->ID;

/**
 *  Retrieve Listing Custom Field Data
 */
$main_image       = get_field( 'large_background_image' );
$price            = get_field( 'price' );
$address          = get_field( 'address' );
$city             = get_field( 'city', $listing_id );
$state            = get_field( 'state' );
$zip              = get_field( 'zip' );
$combined_address = '';
$neighborhood     = get_field( 'neighborhood', $listing_id );
$area             = get_field( 'area', $listing_id );
$county           = get_field( 'county' );
$description      = get_field( 'description' );
$beds             = get_field( 'beds' );
$full_baths       = get_field( 'full_baths' );
$half_baths       = get_field( 'half_baths' );
$baths            = '';
$sqft             = get_field( 'sqft' );
$year             = get_field( 'year_built' );
$mls              = get_field( 'mls_number' );
$lat              = get_field( 'latitude' );
$long             = get_field( 'longitude' );
$parking          = get_field( 'parking' );
$virtual_tour_url = get_field( 'virtual_tour_url' );
$status           = get_field( 'status' );
$distressed       = get_field( 'distressed' );
if ( $field_data = get_field( 'listing_date' ) ) {
	$listing_date = date( 'M jS Y', $field_data );
}
$days_on_market = get_field( 'days_on_market' );
$brokerage_name = get_field( 'office_name' );

$image_gallery_urls = unserialize( get_option( 'image_gallery_urls_' . $mls ) );
$amenities          = unserialize( get_option( 'amenities_' . $mls ) );

$home_owner_fees          = get_field( 'home_owner_fees' );
$home_owner_total_fees    = get_field( 'home_owner_total_fees' );
$home_owner_fee_reflects  = get_field( 'home_owner_fee_reflects' );
$home_owners_payment_freq = get_field( 'home_owners_payment_freq' );
$home_owners_fee_includes = get_field( 'home_owners_fee_includes' );


$combined_address = $address . ' ' . $city . ', ' . $state . ' ' . $zip;
$city_state_zip   = $city . ', ' . $state . ' ' . $zip;

$apn_parcel_id = get_field( 'apnparcel_id' );

$type     = get_field( 'type' );
$sub_type = get_field( 'sub_type' );

$building_size   = get_field( 'building_size' );
$lot_size        = get_field( 'lot_size' );
$number_of_units = get_field( 'number_of_units' );

$net_operating_income = get_field( 'net_operating_income' );
$cap_rate             = get_field( 'cap_rate' );
$price_per_unit       = ( $price / $number_of_units );

/**
 *  Calculate Baths
 */


if ( $full_baths && ! $half_baths ) {

	$baths = $full_baths;

} elseif ( $full_baths && ( $half_baths == 1 ) ) {

	$baths = $full_baths . '.5';

} elseif ( ! $full_baths && $half_baths ) {

	$baths = $half_baths . '<span> half</span>';
} else {
	$baths = '';
}


/**
 * Image Gallery
 */
$image_gallery = get_field( 'image_gallery' );