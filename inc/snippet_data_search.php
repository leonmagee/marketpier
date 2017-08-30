<?php

/**
 * Class snippet_data_search
 *
 * Returns data for snippets
 * Handles form submission - just for WordPress
 * @todo make separate method? to query data for Slipstream API - you will want to be searching them both at once
 * @todo and returning the WordPress data first.
 */
class snippet_data_search {
	public $snippet_object_array;
	public $map_data_array;
	public $for_sale_lease;
	public $status_active;
	public $status_pending;
	public $status_sold;
	public $property_type;
	public $city_zip;
	public $price_min;
	public $price_max;
	public $sqft_min;
	public $sqft_max;
	public $cap_rate_min;
	public $cap_rate_max;
	public $lot_size_min;
	public $days_on_market;
	public $author_id;
	public $status_all; // fix to show all listings on author.php

	public function __construct( $author_id = false, $status_all = false ) {
		/**
		 * Data from $_GET
		 */
		$this->author_id      = $author_id;
		$this->status_all     = $status_all;
		$this->for_sale_lease = filter_input( INPUT_GET, 'for_sale_lease', FILTER_SANITIZE_ENCODED );
		$this->status_active  = filter_input( INPUT_GET, 'status_active', FILTER_SANITIZE_ENCODED );
		$this->status_pending = filter_input( INPUT_GET, 'status_pending', FILTER_SANITIZE_ENCODED );
		$this->status_sold    = filter_input( INPUT_GET, 'status_sold', FILTER_SANITIZE_ENCODED );
		$this->property_type  = filter_input( INPUT_GET, 'property_type', FILTER_SANITIZE_SPECIAL_CHARS );
		$city_zip             = filter_input( INPUT_GET, 'city_zip', FILTER_SANITIZE_SPECIAL_CHARS );
		$this->city_zip       = rawurldecode( $city_zip );
		$this->price_min      = intval( filter_input( INPUT_GET, 'price_min', FILTER_SANITIZE_SPECIAL_CHARS ) );
		$this->price_max      = intval( filter_input( INPUT_GET, 'price_max', FILTER_SANITIZE_SPECIAL_CHARS ) );
		$this->sqft_min       = intval( filter_input( INPUT_GET, 'sqft_min', FILTER_SANITIZE_SPECIAL_CHARS ) );
		$this->sqft_max       = intval( filter_input( INPUT_GET, 'sqft_max', FILTER_SANITIZE_SPECIAL_CHARS ) );
		$this->cap_rate_min   = floatval( filter_input( INPUT_GET, 'cap_rate_min', FILTER_SANITIZE_SPECIAL_CHARS ) );
		$this->cap_rate_max   = floatval( filter_input( INPUT_GET, 'cap_rate_max', FILTER_SANITIZE_SPECIAL_CHARS ) );
		$this->lot_size_min   = intval( filter_input( INPUT_GET, 'lot_size_min', FILTER_SANITIZE_SPECIAL_CHARS ) );
		$this->days_on_market = intval( filter_input( INPUT_GET, 'days_on_market', FILTER_SANITIZE_SPECIAL_CHARS ) );

		/**
		 * Here you can process the WP search and then the IDX search
		 */
		//$this->process_wp_search();

		$this->process_idx_search();
	}

	public function process_wp_search() {
		/**
		 * @todo step 1 - get data - step 2 - process WP search terms?
		 */
		//$this->price_min = $price_min;
		//var_dump( $price_min );
		//var_dump( $price_max );
		//var_dump( $sqft_min );
		//var_dump( $sqft_max );
		//var_dump( $cap_rate_min );
		//var_dump( $cap_rate_max );
		$status_array = array();
		if ( $this->status_active ) {
			$status_array[] = 'active';
		}
		if ( $this->status_pending ) {
			$status_array[] = 'pending';
		}
		if ( $this->status_sold ) {
			$status_array[] = 'sold';
		}

		/**
		 * @todo use this same function for IDX city or zip code search?
		 * @todo test this with WP and then IDX data to make it work
		 */
		$meta_search_array = array();
		if ( $city_zip = $this->city_zip ) {
			if ( is_numeric( $city_zip ) ) {
				$meta_search_array[] = array(
					'key'   => 'listing_zip',
					'value' => $city_zip
				);
			} else {
				$city_zip_strip      = str_replace( array( ',', '-', '/', '|', '.' ), '', $city_zip );
				$city_zip_array      = $this->get_string_array( $city_zip_strip );
				$meta_search_array[] = array(
					'key'     => 'listing_city',
					'value'   => $city_zip_array,
					'compare' => 'IN'
				);
			}
		}
		if ( $for_sale_lease = $this->for_sale_lease ) {
			$meta_search_array[] = array(
				'key'   => 'listing_for_sale_or_for_lease',
				'value' => $for_sale_lease
			);
		} else {
			$meta_search_array[] = array(
				'key'   => 'listing_for_sale_or_for_lease',
				'value' => 'for_sale'
			);
		}
		if ( $status_array ) {
			$meta_search_array[] = array(
				'key'     => 'listing_status',
				'value'   => $status_array,
				'compare' => 'IN'
			);
		} else {
			if ( ! $this->status_all ) {

				$meta_search_array[] = array(
					'key'   => 'listing_status',
					'value' => 'active'
				);
			}
		}
		if ( $property_type = $this->property_type ) {
			if ( $property_type !== 'all_property_types' ) {
				$meta_search_array[] = array(
					'key'   => 'listing_type',
					'value' => $property_type
				);
			}
		}
		if ( $price_min = $this->price_min ) {
			$meta_search_array[] = array(
				'key'     => 'listing_price',
				'value'   => $price_min,
				'compare' => '>=',
				'type'    => 'NUMERIC'
			);
		}
		if ( $price_max = $this->price_max ) {
			$meta_search_array[] = array(
				'key'     => 'listing_price',
				'value'   => $price_max,
				'compare' => '<=',
				'type'    => 'NUMERIC'
			);
		}
		if ( $sqft_min = $this->sqft_min ) {
			$meta_search_array[] = array(
				'key'     => 'listing_building_size',
				'value'   => $sqft_min,
				'compare' => '>=',
				'type'    => 'NUMERIC'
			);
		}
		if ( $sqft_max = $this->sqft_max ) {
			$meta_search_array[] = array(
				'key'     => 'listing_building_size',
				'value'   => $sqft_max,
				'compare' => '<=',
				'type'    => 'NUMERIC'
			);
		}
		if ( $cap_rate_min = $this->cap_rate_min ) {
			$meta_search_array[] = array(
				'key'     => 'listing_cap_rate',
				'value'   => $cap_rate_min,
				'compare' => '>=',
				'type'    => 'FLOAT'
			);
		}
		if ( $cap_rate_max = $this->cap_rate_max ) {
			$meta_search_array[] = array(
				'key'     => 'listing_cap_rate',
				'value'   => $cap_rate_max,
				'compare' => '<=',
				'type'    => 'FLOAT'
			);
		}
		if ( $lot_size_min = $this->lot_size_min ) {
			$meta_search_array[] = array(
				'key'     => 'listing_lot_size',
				'value'   => $lot_size_min,
				'compare' => '>=',
				'type'    => 'NUMERIC'
			);
		}
		if ( $days_on_market = $this->days_on_market ) {
			$date_query = array(
				'column' => 'post_date',
				'after'  => '- ' . $days_on_market . ' days'
			);
		} else {
			$date_query = null;
		}

		$snippet_objects    = array();
		$map_data_array_src = array();
		$args               = array(
			'post_type'  => 'mp-listing',
			'author'     => $this->author_id,
			'meta_query' => $meta_search_array,
			'date_query' => $date_query
		);
		$listing_query      = new WP_Query( $args );

		while ( $listing_query->have_posts() ) {

			$listing_query->the_post();

			$listing_data = new snippet_data();
			$listing_data->listing_data_from_WP();

			$snippet_objects[] = $listing_data;

			$price_label = $this->map_price_label( $listing_data->price );

			/**
			 * Only add to this array if there are both lat and long, OR a complete address
			 * Otherwise the listing can't show up on the map.
			 */
			//if ( ( $listing_data->lat && $listing_data->long ) || $listing_data->combined_address ) {
			if ( $listing_data->combined_address ) {

				$map_data_array_src[] = array(
					//'lat'     => $listing_data->lat,
					//'long'    => $listing_data->long,
					'address' => $listing_data->combined_address,
					'price'   => $price_label,
					'url'     => $listing_data->listing_url
				);
			}
		}
		$this->snippet_object_array = $snippet_objects;
		$this->map_data_array       = $map_data_array_src;
	}

	public function process_idx_search() {
		$parameters = array();

		// @todo do I need a status array?
		// @todo make this work with statuses available in api
		$status_array = array();
		if ( $this->status_active ) {
			$status_array[] = 'active';
		}
		if ( $this->status_pending ) {
			$status_array[] = 'pending';
		}
		if ( $this->status_sold ) {
			$status_array[] = 'sold';
		}

		/**
		 * @todo use this same function for IDX city or zip code search?
		 * @todo test this with WP and then IDX data to make it work
		 */
		//$meta_search_array = array();
		if ( $city_zip = $this->city_zip ) {
			if ( is_numeric( $city_zip ) ) {

				$parameters['zip'] = $city_zip;
//				$meta_search_array[] = array(
//					'key'   => 'listing_zip',
//					'value' => $city_zip
//				);
			} else {
				$city_zip_strip = str_replace( array( ',', '-', '/', '|', '.' ), '', $city_zip );
				$city_zip_array = $this->get_string_array( $city_zip_strip );
//				$meta_search_array[] = array(
//					'key'     => 'listing_city',
//					'value'   => $city_zip_array,
//					'compare' => 'IN'
//				);
			}
		}
		if ( $for_sale_lease = $this->for_sale_lease ) {
//			$meta_search_array[] = array(
//				'key'   => 'listing_for_sale_or_for_lease',
//				'value' => $for_sale_lease
//			);
		} else {
//			$meta_search_array[] = array(
//				'key'   => 'listing_for_sale_or_for_lease',
//				'value' => 'for_sale'
//			);
		}
		if ( $status_array ) {
//			$meta_search_array[] = array(
//				'key'     => 'listing_status',
//				'value'   => $status_array,
//				'compare' => 'IN'
//			);
		} else {
			if ( ! $this->status_all ) {

//				$meta_search_array[] = array(
//					'key'   => 'listing_status',
//					'value' => 'active'
//				);
			}
		}
		if ( $property_type = $this->property_type ) {
			if ( $property_type !== 'all_property_types' ) {
//				$meta_search_array[] = array(
//					'key'   => 'listing_type',
//					'value' => $property_type
//				);
			}
		}
		if ( $price_min = $this->price_min ) {
//			$meta_search_array[] = array(
//				'key'     => 'listing_price',
//				'value'   => $price_min,
//				'compare' => '>=',
//				'type'    => 'NUMERIC'
//			);
		}
		if ( $price_max = $this->price_max ) {
//			$meta_search_array[] = array(
//				'key'     => 'listing_price',
//				'value'   => $price_max,
//				'compare' => '<=',
//				'type'    => 'NUMERIC'
//			);
		}
		if ( $sqft_min = $this->sqft_min ) {
//			$meta_search_array[] = array(
//				'key'     => 'listing_building_size',
//				'value'   => $sqft_min,
//				'compare' => '>=',
//				'type'    => 'NUMERIC'
//			);
		}
		if ( $sqft_max = $this->sqft_max ) {
//			$meta_search_array[] = array(
//				'key'     => 'listing_building_size',
//				'value'   => $sqft_max,
//				'compare' => '<=',
//				'type'    => 'NUMERIC'
//			);
		}
		if ( $cap_rate_min = $this->cap_rate_min ) {
//			$meta_search_array[] = array(
//				'key'     => 'listing_cap_rate',
//				'value'   => $cap_rate_min,
//				'compare' => '>=',
//				'type'    => 'FLOAT'
//			);
		}
		if ( $cap_rate_max = $this->cap_rate_max ) {
//			$meta_search_array[] = array(
//				'key'     => 'listing_cap_rate',
//				'value'   => $cap_rate_max,
//				'compare' => '<=',
//				'type'    => 'FLOAT'
//			);
		}
		if ( $lot_size_min = $this->lot_size_min ) {
//			$meta_search_array[] = array(
//				'key'     => 'listing_lot_size',
//				'value'   => $lot_size_min,
//				'compare' => '>=',
//				'type'    => 'NUMERIC'
//			);
		}
		if ( $days_on_market = $this->days_on_market ) {
//			$date_query = array(
//				'column' => 'post_date',
//				'after'  => '- ' . $days_on_market . ' days'
//			);
		} else {
			//$date_query = null;
		}

//		$snippet_objects    = array();
//		$map_data_array_src = array();
//		$args               = array(
//			'post_type'  => 'mp-listing',
//			'author'     => $this->author_id,
//			'meta_query' => $meta_search_array,
//			'date_query' => $date_query
//		);
//		$listing_query      = new WP_Query( $args );


		$slipstream_token_query = new get_slipstream_token();
		$market                 = 'sandicor';
		$listing_page_size      = 10;
		$search                 = new api_listing_search(
			$slipstream_token_query->slipstream_token,
			$listing_page_size,
			$market
		);
		$search->search_listings( $parameters );

		$listings = $search->search_result->listings;

		foreach ( $listings as $listing ) {

			$listing_data = new snippet_data();
			$listing_data->listing_data_from_IDX( $listing );

			$snippet_objects[] = $listing_data;

			$price_label = $this->map_price_label( $listing_data->price );

			/**
			 * Only add to this array if there are both lat and long, OR a complete address
			 * Otherwise the listing can't show up on the map.
			 */
			//if ( ( $listing_data->lat && $listing_data->long ) || $listing_data->combined_address ) {
			if ( $listing_data->combined_address ) {

				$map_data_array_src[] = array(
					//'lat'     => $listing_data->lat,
					//'long'    => $listing_data->long,
					'address' => $listing_data->combined_address,
					'price'   => $price_label,
					'url'     => $listing_data->listing_url
				);
			}
		}


		$this->snippet_object_array = $snippet_objects;
		$this->map_data_array       = $map_data_array_src;
	}

	public function map_price_label( $price_label ) {

		if ( $price_label ) {
			if ( $price_label > 999999 ) {
				$decimal     = substr( $price_label, - 6, 1 );
				$price_label = substr( $price_label, 0, - 6 );
				if ( $decimal ) {
					$price_label = $price_label . '.' . $decimal . 'm';
				} else {
					$price_label = $price_label . 'm';
				}
			} elseif ( $price_label > 999 ) {
				$price_label = substr( $price_label, 0, - 3 );
				$price_label = $price_label . 'k';
			} else {
				$price_label = '$' . $price_label;
			}
		} else {
			$price_label = '';
		}

		return $price_label;
	}

	public function get_string_array( $var ) {
		$ex = explode( ' ', $var );
		$ac = count( $ex );
		if ( $ac > 1 ) {
			$ma   = $ex;
			$ma[] = $var;
			for ( $x = 0; $x < ( $ac - 2 ); ++ $x ) {
				array_pop( $ex );
				$new_string = implode( ' ', $ex );
				$ma[]       = $new_string;
			}
		} else {
			$ma[] = $var;
		}

		return $ma;
	}
}