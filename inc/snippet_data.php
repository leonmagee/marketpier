<?php

/**
 * Class snippet_data
 */
class snippet_data {

	public $title;
	public $price;
	//public $main_image;
	public $property_name;
	public $address;
	public $city;
	public $state;
	public $zip;
	public $days_on_market;
	public $for_sale_for_lease;
	public $lat;
	public $long;
	public $type;
	public $building_size;
	public $lot_size;
	public $number_of_units;
	public $cap_rate;
	public $image_gallery_first;
	public $city_state_zip;
	public $combined_address;
	public $listing_url;

	/**
	 * @param $image_gallery
	 *
	 * @todo this method only needs to get the first image, and just the $main_image(listing_main_image) if that is set.
	 */
	public function standardize_snippet_image_WP( $image_gallery ) {
		if ( $first_image = $image_gallery[0]['sizes']['listing-gallery'] ) {
			$this->image_gallery_first = $first_image;
		} else {
			$default_image             = get_stylesheet_directory_uri() . '/assets/img/image-not-available.jpg';
			$this->image_gallery_first = $default_image;
		}

	}

	public function standardize_snippet_image_IDX( $idx_image_data ) {
		//@todo process IDX image gallery data
		$image_gallery_array = array();
		$this->image_gallery = $image_gallery_array;
	}

	public function listing_data_from_WP() {
		$this->title = get_the_title(); // @todo might not need this
		//$this->main_image           = get_field( 'listing_main_image' );
		$this->property_name      = get_field( 'listing_property_name' );
		$this->price              = get_field( 'listing_price' );
		$this->address            = get_field( 'listing_address' );
		$this->city               = get_field( 'listing_city' );
		$this->state              = get_field( 'listing_state' );
		$this->zip                = get_field( 'listing_zip' );
		//$this->days_on_market     = get_field( 'listing_days_on_market' );
		$this->for_sale_for_lease = get_field( 'listing_for_sale_or_for_lease' );
		$this->lat                = get_field( 'listing_latitude' );
		$this->long               = get_field( 'listing_longitude' );
		$selected_type            = get_field( 'listing_type' );
		$field_object_type        = get_field_object( 'listing_type' );
		$this->type               = $field_object_type['choices'][ $selected_type ];
		$this->building_size      = get_field( 'listing_building_size' );
		$this->lot_size           = get_field( 'listing_lot_size' );
		$this->number_of_units    = get_field( 'listing_number_of_units' );
		$this->cap_rate           = get_field( 'listing_cap_rate' );
		$this->listing_url        = get_the_permalink();

		$post_date = get_the_date( 'U' );
		//$post_date = get_the_date( 'U', true ); // for GMT
		$current_date          = time();
		$days_passed_timestamp = $current_date - $post_date;
		$days_passed           = floor( $days_passed_timestamp / ( 60 * 60 * 24 ) );
		$this->days_on_market  = $days_passed;

		$this->standardize_snippet_image_WP( get_field( 'listing_image_gallery' ) );

		if ( $this->address && $this->city && $this->state && $this->zip ) {
			$this->combined_address = $this->address . ' - ' . $this->city . ', ' . $this->state . ' ' . $this->zip;
		} else {
			$this->combined_address = false;
		}

		$this->city_state_zip = $this->city . ', ' . $this->state . ' ' . $this->zip;
	}

	public function listing_data_from_IDX() {

		$this->standardize_image_gallery_IDX( 'image data???' );
	}
}