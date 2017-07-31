<?php

/**
 * Class listing_data
 */
class listing_data {

	public $title;
	public $main_image;
	public $mls;
	public $price;
	public $address;
	public $city;
	public $state;
	public $zip;
	public $neighborhood;
	public $county;
	public $year;
	public $days_on_market;
	public $status;
	public $for_sale_for_lease;
	public $lat;
	public $long;
	public $type;
	public $sub_type;
	public $building_size;
	public $lot_size;
	public $apn_parcel_id;
	public $number_of_units;
	public $net_operating_income;
	public $cap_rate;
	public $description;
	public $image_gallery;
	public $unit_mix;
	public $listing_date;
	public $city_state_zip;
	public $combined_address;
	public $price_per_unit;

	public function standardize_image_gallery_WP( $image_gallery ) {
		$image_gallery_array = array();
		foreach ( $image_gallery as $image ) {
			$image_gallery_array[] = array(
				'link'  => $image['sizes']['large'],
				'image' => $image['sizes']['listing-gallery']
			);
		}
		$this->image_gallery = $image_gallery_array;
	}

	public function standardize_image_gallery_IDX( $idx_image_data ) {
		//@todo process IDX image gallery data
		$image_gallery_array = array();
		$this->image_gallery = $image_gallery_array;
	}

	public function listing_data_from_WP() {
		$this->title                = get_the_title();
		$this->main_image           = get_field( 'listing_main_image' );
		$this->mls                  = get_field( 'listing_mls_number' );
		$this->price                = get_field( 'listing_price' );
		$this->address              = get_field( 'listing_address' );
		$this->city                 = get_field( 'listing_city' );
		$this->state                = get_field( 'listing_state' );
		$this->zip                  = get_field( 'listing_zip' );
		$this->neighborhood         = get_field( 'listing_neighborhood' );
		$this->county               = get_field( 'listing_county' );
		$this->year                 = get_field( 'listing_year_built' );
		$this->days_on_market       = get_field( 'listing_days_on_market' );
		$this->status               = get_field( 'listing_status' );
		$this->for_sale_for_lease   = get_field( 'listing_for_sale_or_for_lease' );
		$this->lat                  = get_field( 'listing_latitude' );
		$this->long                 = get_field( 'listing_longitude' );
		$this->type                 = get_field( 'listing_type' );
		$this->sub_type             = get_field( 'listing_sub_type' );
		$this->building_size        = get_field( 'listing_building_size' );
		$this->lot_size             = get_field( 'listing_lot_size' );
		$this->apn_parcel_id        = get_field( 'listing_apn_parcel_id' );
		$this->number_of_units      = get_field( 'listing_number_of_units' );
		$this->net_operating_income = get_field( 'listing_net_operating_income' );
		$this->cap_rate             = get_field( 'listing_cap_rate' );
		$this->description          = get_field( 'listing_description' );
		$this->unit_mix             = get_field( 'listing_unit_mix' );

		if ( $listing_data_timestamp = get_field( 'listing_date' ) ) {
			$this->listing_date = date( 'M jS Y', $listing_data_timestamp );
		}

		$this->standardize_image_gallery_WP( get_field( 'listing_image_gallery' ) );

		if ( $this->address && $this->city && $this->state && $this->zip ) {
			$this->combined_address = $this->address . ' ' . $this->city . ', ' . $this->state . ' ' . $this->zip;
		} else {
			$this->combined_address = false;
		}

		//$this->parking          = get_field( 'listing_parking' );
		$this->city_state_zip = $this->city . ', ' . $this->state . ' ' . $this->zip;

		if ( $this->price && $this->number_of_units ) {
			$this->price_per_unit = ( $this->price / $this->number_of_units );
		} else {
			$this->price_per_unit = false;
		}

	}

	public function listing_data_from_IDX() {

		$this->standardize_image_gallery_IDX( 'image data???' );

	}
}