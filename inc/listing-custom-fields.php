<?php
/**
 *  Retrieve Listing Custom Field Data
 */
$main_image           = get_field( 'listing_main_image' );
$mls                  = get_field( 'listing_mls_number' );
$price                = get_field( 'listing_price' );
$address              = get_field( 'listing_address' );
$city                 = get_field( 'listing_city' );
$state                = get_field( 'listing_state' );
$zip                  = get_field( 'listing_zip' );
$neighborhood         = get_field( 'listing_neighborhood' );
$county               = get_field( 'listing_county' );
$year                 = get_field( 'listing_year_built' );
$days_on_market       = get_field( 'listing_days_on_market' );
$status               = get_field( 'listing_status' );
$for_sale_for_lease   = get_field( 'listing_for_sale_or_for_lease' );
$lat                  = get_field( 'listing_latitude' );
$long                 = get_field( 'listing_longitude' );
$type                 = get_field( 'listing_type' );
$sub_type             = get_field( 'listing_sub_type' );
$building_size        = get_field( 'listing_building_size' );
$lot_size             = get_field( 'listing_lot_size' );
$apn_parcel_id        = get_field( 'listing_apn_parcel_id' );
$number_of_units      = get_field( 'listing_number_of_units' );
$net_operating_income = get_field( 'listing_net_operating_income' );
$cap_rate             = get_field( 'listing_cap_rate' );
$description          = get_field( 'listing_description' );
$image_gallery        = get_field( 'listing_image_gallery' );
$unit_mix             = get_field( 'listing_unit_mix' );

if ( $listing_data_timestamp = get_field( 'listing_date' ) ) {
	$listing_date = date( 'M jS Y', $listing_data_timestamp );
}

//$combined_address = '';
//$combined_address = $address . ' ' . $city . ', ' . $state . ' ' . $zip;
//$parking          = get_field( 'listing_parking' );
$city_state_zip = $city . ', ' . $state . ' ' . $zip;

if ( $price && $number_of_units ) {
	$price_per_unit = ( $price / $number_of_units );
} else {
	$price_per_unit = false;
}
