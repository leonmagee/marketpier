<?php

/**
 * Class snippet_data
 */
class snippet_data {

	public $title;
	public $price;
	//public $main_image;
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
	public function standardize_image_gallery_WP( $image_gallery ) {
		$this->image_gallery_first = $image_gallery[0]['sizes']['listing-gallery'];
	}

	public function standardize_image_gallery_IDX( $idx_image_data ) {
		//@todo process IDX image gallery data
		$image_gallery_array = array();
		$this->image_gallery = $image_gallery_array;
	}

	public function listing_data_from_WP() {
		$this->title = get_the_title();
		//$this->main_image           = get_field( 'listing_main_image' );
		$this->price              = get_field( 'listing_price' );
		$this->address            = get_field( 'listing_address' );
		$this->city               = get_field( 'listing_city' );
		$this->state              = get_field( 'listing_state' );
		$this->zip                = get_field( 'listing_zip' );
		$this->days_on_market     = get_field( 'listing_days_on_market' );
		$this->for_sale_for_lease = get_field( 'listing_for_sale_or_for_lease' );
		$this->lat                = get_field( 'listing_latitude' );
		$this->long               = get_field( 'listing_longitude' );
		$this->type               = get_field( 'listing_type' );
		$this->building_size      = get_field( 'listing_building_size' );
		$this->lot_size           = get_field( 'listing_lot_size' );
		$this->number_of_units    = get_field( 'listing_number_of_units' );
		$this->cap_rate           = get_field( 'listing_cap_rate' );
		$this->listing_url        = get_the_permalink();

		$this->standardize_image_gallery_WP( get_field( 'listing_image_gallery' ) );

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