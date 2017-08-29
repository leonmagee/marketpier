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
	public $author_name;
	public $space_available;
	public $rate_sf_month;
	public $is_for_sale;
	public $is_for_lease;

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

	public function standardize_image_gallery_IDX( $idx_image_data ) {
		//@todo process IDX image gallery data
		$image_gallery_array = array();
		$this->image_gallery = $image_gallery_array;
	}

	public function listing_data_from_WP() {
		$this->listing_id           = get_the_ID();
		$this->main_image           = get_field( 'listing_main_image' );
		$this->mls                  = get_field( 'listing_mls_number' );
		$this->property_name        = get_field( 'listing_property_name' );
		$this->price                = get_field( 'listing_price' );
		$this->rent                 = get_field( 'listing_monthly_rent' );
		$this->address              = get_field( 'listing_address' );
		$this->city                 = get_field( 'listing_city' );
		$this->state                = get_field( 'listing_state' );
		$this->zip                  = get_field( 'listing_zip' );
		$this->neighborhood         = get_field( 'listing_neighborhood' );
		$this->county               = get_field( 'listing_county' );
		$this->year                 = get_field( 'listing_year_built' );
		$selected_status            = get_field( 'listing_status' );
		$field_object_status        = get_field_object( 'listing_status' );
		$this->status               = $field_object_status['choices'][ $selected_status ];
		$this->for_sale_for_lease   = get_field( 'listing_for_sale_or_for_lease' );
		$this->lat                  = get_field( 'listing_latitude' );
		$this->long                 = get_field( 'listing_longitude' );
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
		$author_id                  = get_post_field( 'post_author', $this->listing_id );
		$this->author               = get_the_author_meta( 'user_nicename', $author_id );
		$first_name                 = get_user_meta( $author_id, 'first_name', true );
		$last_name                  = get_user_meta( $author_id, 'last_name', true );
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

	public function listing_data_from_IDX( $mls_number ) {


		$slipstream_token_query = new get_slipstream_token();
		$market                 = 'sandicor';
		$listing_page_size      = 5;
		$search                 = new api_listing_search(
			$slipstream_token_query->slipstream_token,
			$listing_page_size,
			$market,
			$mls_number
		);
		$search->search_listings();

		var_dump( $search->search_result->listings[0]->listPrice );
		//var_dump( $search->search_result->listings );

		$listing_type = $search->search_result->listings[0]->listingType;
		if ( $listing_type == 'residential' ) {
			$this->for_sale_for_lease = 'for_sale';
		} elseif ( $listing_type == 'rental' ) {
			$this->for_sale_for_lease = 'for_lease';
		} else {
			$this->for_sale_for_lease = 'for_sale';
		}


		$this->listing_id = get_the_ID();

		$this->main_image    = get_field( 'listing_main_image' );
		$this->mls           = get_field( 'listing_mls_number' );
		$this->property_name = get_field( 'listing_property_name' );
		$this->price         = $search->search_result->listings[0]->listPrice;
		$this->rent          = get_field( 'listing_monthly_rent' );
		$this->address       = get_field( 'listing_address' );
		$this->city          = get_field( 'listing_city' );
		$this->state         = get_field( 'listing_state' );
		$this->zip           = get_field( 'listing_zip' );


//		public 'id' => string '150052562' (length=9)
//      public 'market' => string 'sandicor' (length=8)
//      public 'geoType' => string 'listing' (length=7)
//      public 'systemId' => string '150052562' (length=9)
//      public 'listingOffice' =>
//        object(stdClass)[1350]
//          public 'id' => string '69489' (length=5)
//          public 'name' => string 'Quality First Real Estate' (length=25)
//          public 'phone' => string '619-667-3377' (length=12)
//      public 'address' =>
//        object(stdClass)[1353]
//          public 'deliveryLine' => string '1973 Campo Truck' (length=16)
//          public 'city' => string 'Campo' (length=5)
//          public 'state' => string 'CA' (length=2)
//          public 'zip' => string '91906' (length=5)
//          public 'street' => string '1973 Campo Truck' (length=16)
//      public 'description' => string 'This 427 acre ranch is unlike anything else you will find in Southern California. As you drive through the gated entry you will be immediately be drawn to the beautiful oak groves, large pastures, meadows, and rolling hills. Youâll notice the amazing Tudor style architecture of the 3,200 sq ft 3 bed/2.5 bath home that sits elevated above the Ranch grounds with breathtaking views of the pastures below. Second home is a 2,400 sq ft 3 bed/2 ba. 12 stall horse barn.' (length=471)
//      public 'listPrice' => int 1900000
//      public 'yearBuilt' => int 1989
//      public 'daysOnHJI' => int 703
//      public 'lastUpdated' => int 1504001681
//      public 'county' => string 'San Diego' (length=9)
//      public 'modifiedDate' => int 1503703680
//      public 'listingType' => string 'Residential' (length=11)
//      public 'baths' =>
//        object(stdClass)[1354]
//          public 'total' => int 3
//          public 'full' => int 3
//          public 'half' => int 0
//      public 'listingAgent' =>
//        object(stdClass)[1355]
//          public 'id' => string '651088' (length=6)
//          public 'name' => string 'Willem De Ridder' (length=16)
//          public 'phone' => string '619-980-6634' (length=12)
//      public 'lotSize' =>
//        object(stdClass)[1356]
//          public 'sqft' => int 18600120
//          public 'acres' => int 427
//      public 'style' => string 'Tudor/French Normandy' (length=21)
//      public 'subdivision' => string 'Campo' (length=5)
//      public 'propertyType' => string 'Detached' (length=8)
//      public 'size' => int 3200
//      public 'coordinates' =>
//        object(stdClass)[1357]
//          public 'latitude' => float 32.6492331
//          public 'longitude' => float -116.4724095
//      public 'coListingAgent' =>
//        object(stdClass)[1358]
//          public 'name' => string 'Carol Snyder' (length=12)
//      public 'listingDate' => int 1443052800
//      public 'tourURL' => string 'http://www.propertypanorama.com/instaview/snd/150052562' (length=55)
//      public 'daysOnMarket' => int 705
//      public 'area' => string 'CAMPO (91906)' (length=13)
//      public 'beds' => int 4


		$this->neighborhood  = get_field( 'listing_neighborhood' );
		$this->county        = get_field( 'listing_county' );
		$this->year          = get_field( 'listing_year_built' );
		$selected_status     = get_field( 'listing_status' );
		$field_object_status = get_field_object( 'listing_status' );
		$this->status        = $field_object_status['choices'][ $selected_status ];

		$this->lat                  = get_field( 'listing_latitude' );
		$this->long                 = get_field( 'listing_longitude' );
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
		$author_id                  = get_post_field( 'post_author', $this->listing_id );
		$this->author               = get_the_author_meta( 'user_nicename', $author_id );
		$first_name                 = get_user_meta( $author_id, 'first_name', true );
		$last_name                  = get_user_meta( $author_id, 'last_name', true );
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

		//$this->standardize_image_gallery_WP( get_field( 'listing_image_gallery' ) );
		$this->standardize_image_gallery_IDX( 'image data???' );
		$this->listing_data_update();


	}
}