<?php

/**
 * Class listing_data
 */
class listing_data {

	public $listing_id; // @todo idx vs. WP?
	public $title;
	public $main_image;
	public $mls;
	public $property_name;
	public $price;
	public $rent;
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
	public $rental_unit_mix;
	public $listing_date;
	public $city_state_zip;
	public $combined_address;
	public $price_per_unit;
	public $price_per_sqft;
	public $file_attachments;
	public $favorite_listing;
	public $author;
	public $author_id;
	public $author_name;
	public $author_email;
	public $space_available;
	public $rate_sf_month;
	public $is_for_sale;
	public $is_for_lease;
	public $listing_agent_name;
	public $listing_agent_phone;
	public $listing_agent_id;
	public $gross_rent_multiplier;
	public $gross_operating_income;
	public $operating_expenses;  // net oerating income = gross income - oerating expenses
	public $market;

	public function standardize_image_gallery_WP( $image_gallery ) {
		$image_gallery_array = array();
		if ( $image_gallery ) {
			foreach ( $image_gallery as $image ) {
				$image_gallery_array[] = array(
					'link'  => $image['sizes']['large'],
					'image' => $image['sizes']['listing-gallery']
				);
			}
		}
		$this->image_gallery = $image_gallery_array;
	}

	public function standardize_image_gallery_IDX( $image_gallery ) {
		$image_gallery_array = array();
		if ( $image_gallery ) {
			foreach ( $image_gallery as $image ) {
				$image_gallery_array[] = array(
					'link'  => $image,
					'image' => $image
				);
			}
		}
		$this->image_gallery = $image_gallery_array;
	}

	public function listing_data_from_WP() {
		$this->listing_id = get_the_ID();
		//$this->main_image           = get_field( 'listing_main_image' );
		$this->mls                = get_field( 'listing_mls_number' );
		$this->property_name      = get_field( 'listing_property_name' );
		$this->price              = get_field( 'listing_price' );
		$this->rent               = get_field( 'listing_monthly_rent' );
		$this->address            = get_field( 'listing_address' );
		$this->city               = get_field( 'listing_city' );
		$this->state              = get_field( 'listing_state' );
		$this->zip                = get_field( 'listing_zip' );
		$this->neighborhood       = get_field( 'listing_neighborhood' );
		$this->county             = get_field( 'listing_county' );
		$this->year               = get_field( 'listing_year_built' );
		$selected_status          = get_field( 'listing_status' );
		$field_object_status      = get_field_object( 'listing_status' );
		$this->status             = $field_object_status['choices'][ $selected_status ];
		$this->for_sale_for_lease = get_field( 'listing_for_sale_or_for_lease' );
//		$this->lat                  = get_field( 'listing_latitude' );
//		$this->long                 = get_field( 'listing_longitude' );
		$selected_type              = get_field( 'listing_type' );
		$field_object_type          = get_field_object( 'listing_type' );
		$this->type                 = $field_object_type['choices'][ $selected_type ];
		$this->sub_type             = get_field( 'listing_sub_type' );
		$this->building_size        = get_field( 'listing_building_size' );
		$this->lot_size             = get_field( 'listing_lot_size' );
		$this->apn_parcel_id        = get_field( 'listing_apn_parcel_id' );
		$this->number_of_units      = get_field( 'listing_number_of_units' );
		$this->net_operating_income = get_field( 'listing_net_operating_income' );
		$this->cap_rate             = get_field( 'listing_cap_rate' );
		$this->description          = get_field( 'listing_description' );
		$this->unit_mix             = get_field( 'listing_unit_mix' );
		$this->rental_unit_mix      = get_field( 'rental_unit_mix' );
		$this->file_attachments     = get_field( 'listing_file_attachments' );
		$this->space_available      = get_field( 'listing_space_available' );
		$this->author_id            = get_post_field( 'post_author', $this->listing_id );
		$this->author               = get_the_author_meta( 'user_nicename', $this->author_id );
		$first_name                 = get_user_meta( $this->author_id, 'first_name', true );
		$last_name                  = get_user_meta( $this->author_id, 'last_name', true );
		$user_data                  = get_userdata( $this->author_id );
		$this->author_email         = $user_data->data->user_email;
		//var_dump( get_field( 'phone_number', 'user_'  . $author_id) ); // @todo get ACF user data
		if ( $first_name && $last_name ) {
			$this->author_name = $first_name . ' ' . $last_name;
		} elseif ( $first_name ) {
			$this->author_name = $first_name;
		} else {
			$this->author_name = $this->author;
		}
		//get the listing date as post date
		$this->listing_date = get_the_date();
		$post_date          = get_the_date( 'U' );
		//$post_date = get_the_date( 'U', true ); // for GMT
		$current_date          = time();
		$days_passed_timestamp = $current_date - $post_date;
		$days_passed           = floor( $days_passed_timestamp / ( 60 * 60 * 24 ) );
		$this->days_on_market  = $days_passed;

		$this->standardize_image_gallery_WP( get_field( 'listing_image_gallery' ) );

		$this->listing_data_update();
	}


	public function listing_data_from_IDX( $mls_number ) {

		/**
		 * @todo - use the mls number as the id that works with the 'save listing' feature.
		 */

		$extended_fields = get_field( 'home_junction_extended_fields', 'option' );

		$slipstream_token_query = new get_slipstream_token();
		$market                 = 'sandicor';
		$listing_page_size      = 1;
		$search                 = new api_listing_search(
			$slipstream_token_query->slipstream_token,
			$listing_page_size,
			$market,
			$mls_number
		);
		$search->search_listings();

		$listing      = $search->search_result->listings[0];
		$listing_type = $listing->listingType;
		// also - public 'geoType' => string 'listing' (length=7)
		if ( $listing_type == 'residential' ) {
			$this->for_sale_for_lease = 'for_sale';
		} elseif ( $listing_type == 'rental' ) {
			$this->for_sale_for_lease = 'for_lease';
		} else {
			$this->for_sale_for_lease = 'for_sale';
		}


		// @todo what does 'rent' look like? - check api docs for rent data?
		//$this->rent          = $listing->???

		$this->market                 = $listing->market;
		$this->listing_id             = $mls_number; // @todo test with saving listing? do I need this twice?
		$this->mls                    = $mls_number;
		$this->price                  = $listing->listPrice;
		$this->address                = $listing->address->deliveryLine;
		$this->city                   = $listing->address->city;
		$this->state                  = $listing->address->state;
		$this->zip                    = $listing->address->zip;
		$this->neighborhood           = $listing->area;
		$this->county                 = $listing->county;
		$this->year                   = $listing->yearBuilt;
		$this->status                 = $listing->status;
		$this->type                   = $listing_type;
		$this->sub_type               = $listing->propertyType;
		$this->building_size          = $listing->size;
		$this->description            = $listing->description;
		$this->listing_agent_name     = $listing->listingAgent->name;
		$this->listing_agent_phone    = $listing->listingAgent->phone;
		$this->listing_agent_id       = $listing->listingAgent->id;
		$this->lat                    = $listing->coordinates->latitude;
		$this->long                   = $listing->coordinates->longitude;
		$gross_rent_field             = get_key( $extended_fields, $this->market, 'gross_rent_multiplier' );
		$this->gross_rent_multiplier  = $listing->$gross_rent_field; // gross rent multiplier
		$gross_income_field           = get_key( $extended_fields, $this->market, 'gross_operating_income' );
		$this->gross_operating_income = $listing->$gross_income_field; // gross operating income
		$op_expenses_field            = get_key( $extended_fields, $this->market, 'operating_expenses' );
		$this->operating_expenses     = $listing->$op_expenses_field; // operating expenses
		$this->lot_size               = $listing->lotSize->sqft; // @todo use acres if > 1 - can process this on fron end?
		$apn_id_field                 = get_key( $extended_fields, $this->market, 'apn_parcel_id' );
		$this->apn_parcel_id          = $listing->$apn_id_field;
		$number_of_units_field        = get_key( $extended_fields, $this->market, 'number_of_units' );
		$this->number_of_units        = $listing->$number_of_units_field; // number of units
		$cap_rate_field               = get_key( $extended_fields, $this->market, 'cap_rate' );
		$this->cap_rate               = $listing->$cap_rate_field; // cap rate
		$this->listing_date           = date( 'n/j/Y', $listing->listingDate );
		$this->days_on_market         = $listing->daysOnMarket;

		if ( $this->gross_operating_income && $this->operating_expenses ) {
			$this->net_operating_income = ( $this->gross_operating_income - $this->operating_expenses );
		}

		$this->standardize_image_gallery_IDX( $listing->images );
		$this->listing_data_update();


	}

	public function listing_data_update() {
		if ( $this->property_name ) {
			$this->title = $this->property_name;
		} else {
			$this->title = false;
		}

		if ( $this->rent && $this->space_available ) {
			$this->rate_sf_month = ( $this->rent / $this->space_available );
		}

		/**
		 * Not sure if this will be in IDX data too - should we pull info about listing agent?
		 */
//		$first_name   = get_user_meta( $author_id, 'first_name', true );
//		$last_name    = get_user_meta( $author_id, 'last_name', true );
//		if ( $first_name && $last_name ) {
//			$this->author_name = $first_name . ' ' . $last_name;
//		} elseif ( $first_name ) {
//			$this->author_name = $first_name;
//		} else {
//			$this->author_name = $this->author;
//		}
		/**
		 * @todo probably we can just get days on market and listing data right from slipstream data?
		 */
		//get the listing date as post date
//		$this->listing_date = get_the_date();
//		$post_date          = get_the_date( 'U' ); // this is the same as listing data?
//		//$post_date = get_the_date( 'U', true ); // for GMT
//		$current_date          = time();
//		$days_passed_timestamp = $current_date - $post_date;
//		$days_passed           = floor( $days_passed_timestamp / ( 60 * 60 * 24 ) );
//		$this->days_on_market  = $days_passed;


		if ( $this->for_sale_for_lease == 'for_sale' ) {
			$this->is_for_sale  = true;
			$this->is_for_lease = false;
		} elseif ( $this->for_sale_for_lease == 'for_lease' ) {
			$this->is_for_sale  = false;
			$this->is_for_lease = true;
		} else {
			$this->is_for_sale  = false;
			$this->is_for_lease = false;
		}

		if ( $this->address && $this->city && $this->state && $this->zip ) {
			$this->combined_address = $this->address . ' - ' . $this->city . ', ' . $this->state . ' ' . $this->zip;
		} else {
			$this->combined_address = false;
		}

		$this->city_state_zip = $this->city . ', ' . $this->state . ' ' . $this->zip;

		if ( $this->price && $this->number_of_units ) {
			$this->price_per_unit = ( $this->price / $this->number_of_units );
		} else {
			$this->price_per_unit = false;
		}

		if ( $this->price && $this->building_size ) {
			$this->price_per_sqft = ( $this->price / $this->building_size );
		} else {
			$this->price_per_sqft = false;
		}

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
}