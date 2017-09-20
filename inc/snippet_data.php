<?php

/**
 * Class snippet_data
 */
class snippet_data {

	public $listing_id; // @todo idx vs. WP?
	public $title;
	public $price;
	public $rent;
	public $status;
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
	public $favorite_listing;
	public $market;

	public function __construct( $market = false ) {
		$this->market = $market;
	}

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

	public function standardize_snippet_image_IDX( $image_gallery ) {
		if ( $first_image = $image_gallery[0] ) {
			$this->image_gallery_first = $first_image;
		} else {
			$default_image             = get_stylesheet_directory_uri() . '/assets/img/image-not-available.jpg';
			$this->image_gallery_first = $default_image;
		}
	}

	public function favorite_listing() {
		/**
		 * Check if listing is favorite of current user
		 */
		if ( is_user_logged_in() ) {
			global $wpdb;
			$prefix                 = $wpdb->prefix;
			$table_name             = $prefix . 'mp_favorite_listings';
			$user_id                = MP_LOGGED_IN_ID;
			$favorite_query         = "SELECT * FROM `{$table_name}` WHERE `user_id` = '{$user_id}' AND `listing_id` = '{$this->listing_id}'";
			$query_favorite_listing = $wpdb->get_results( $favorite_query );
			if ( $query_favorite_listing ) {
				$this->favorite_listing = true;
			}
		} else {
			$this->favorite_listing = false;
		}
	}

	public function listing_data_from_WP() {
		$this->listing_id = get_the_ID();
		$this->title      = get_the_title(); // @todo might not need this
		//$this->main_image           = get_field( 'listing_main_image' );
		$this->property_name = get_field( 'listing_property_name' );
		$this->price         = get_field( 'listing_price' );
		$this->rent          = get_field( 'listing_monthly_rent' );
		$this->address       = get_field( 'listing_address' );
		$this->city          = get_field( 'listing_city' );
		$this->state         = get_field( 'listing_state' );
		$this->zip           = get_field( 'listing_zip' );
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

		// @todo this might ger removed if I change how status works to fit with IDX data - no Pending or Sold
		$selected_status     = get_field( 'listing_status' );
		$field_object_status = get_field_object( 'listing_status' );
		$this->status        = $field_object_status['choices'][ $selected_status ];

		$this->standardize_snippet_image_WP( get_field( 'listing_image_gallery' ) );
		$this->favorite_listing();
		$this->snippet_data_update();
	}

	public function listing_data_from_IDX( $listing ) {

		$extended_fields = get_field( 'home_junction_extended_fields', 'option' );

		$listing_type = $listing->listingType;
		if ( $listing_type == 'residential' ) {
			$this->for_sale_for_lease = 'for_sale';
		} elseif ( $listing_type == 'rental' ) {
			$this->for_sale_for_lease = 'for_lease';
		} else {
			$this->for_sale_for_lease = 'for_sale';
		}

		$this->listing_id  = $listing->id; // mls number
		$this->status      = $listing->status;
		$this->listing_url = site_url() . '/listing/idx/' . $this->market . '/' . strtolower( $this->status ) . '/' . $this->listing_id;
		//var_dump( $this->listing_url );
		$this->price          = $listing->listPrice;
		$this->address        = $listing->address->deliveryLine;
		$this->city           = $listing->address->city;
		$this->state          = $listing->address->state;
		$this->zip            = $listing->address->zip;
		$this->type           = $listing_type;
		$this->building_size  = $listing->size;
		$this->days_on_market = $listing->daysOnMarket;
		$this->lat            = $listing->coordinates->latitude;
		$this->long           = $listing->coordinates->longitude;
		$cap_rate_field       = get_key( $extended_fields, $listing->market, 'cap_rate' );
		if ( $cap_rate_field ) {
			$this->cap_rate = $listing->$cap_rate_field; // cap rate
		}
		$number_of_units_field = get_key( $extended_fields, $listing->market, 'number_of_units' );
		if ( $number_of_units_field ) {
			$this->number_of_units = $listing->$number_of_units_field; // number of units
		}
		$this->lot_size = $listing->lotSize->sqft; // @todo use acres if > 1 - can process this on front end?
		$this->standardize_snippet_image_IDX( $listing->images );
		$this->favorite_listing();
		$this->snippet_data_update();
	}

	public function snippet_data_update() {
		if ( $this->address && $this->city && $this->state && $this->zip ) {
			$this->combined_address = $this->address . ' - ' . $this->city . ', ' . $this->state . ' ' . $this->zip;
		} else {
			$this->combined_address = false;
		}
		$this->city_state_zip = $this->city . ', ' . $this->state . ' ' . $this->zip;
	}
}