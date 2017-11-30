<?php

/**
 * Class api_listing_search
 */
class api_listing_search {

	public $market;
	public $search_result;
	public $total_listings;
	public $details;
	public $extended;
	public $features;
	public $page_size;
	public $network_error;
	public $mls_number;
	public $wp_listing_count;
	public $transient_name;
	public $is_search;
	public $sold_single;
	public $default_property_types;

	public function __construct( $token, $page_size, $market, $mls_number = false, $wp_listing_count = false, $is_search = true, $sold_single = false, $default_property_types = false ) {
		$this->market                 = $market;
		$this->token                  = $token;
		$this->details                = true;
		$this->extended               = true;
		$this->features               = true;
		$this->page_size              = $page_size;
		$this->network_error          = false;
		$this->mls_number             = $mls_number;
		$this->wp_listing_count       = $wp_listing_count;
		$this->is_search              = $is_search;
		$this->sold_single            = $sold_single;
		$this->default_property_types = $default_property_types;
	}

	public function search_listings( $parameters = null, $page_number = 1 ) {

		$extended_fields = get_field( 'home_junction_extended_fields', 'option' );
		/**
		 * Get submitted fields
		 */
		$listing_type_string = $id_string = $zip_string = $city_string = $size_string = $cap_rate_string = $county_string = $list_price_string = $keyword_string = $days_on_market_string = $sold_in_last_string = $lot_size_string = $commercial_lease_string = '';

		/**
		 * I need to make it sold here when it's a single sold listing....
		 */

		if ( $this->sold_single ) {
			$parameters['status'] = 'sold';
		}

		$active_sold_key = 'listings';
		$status          = 'active';
		if ( isset( $parameters['status'] ) ) {
			$status = $parameters['status'];
			if ( $status === 'sold' ) {
				$active_sold_key = 'sales';
			} else {
				$active_sold_key = 'listings';
			}
		}
		/**
		 * Property Type (Listing Type Not required if we are always specifying a property type)
		 */
		if ( $status !== 'sold' ) {
			if ( isset( $parameters['property_type'] ) ) {
				if ( $listing_property_type = $parameters['property_type'] ) {
					$listing_type_string = $listing_property_type;
				}
			} else {
				if ( $this->is_search ) {
					$listing_type_string = $this->default_property_types;
				}
			}
		}
		// just used for transient names
		if ( ! ( isset( $parameters['property_type_key'] ) ) ) {
			$prop_type_key = 'all_property_types';
		} else {
			$prop_type_key = $parameters['property_type_key'];
		}
		if ( $id = $this->mls_number ) {
			$id_string = '&id=' . $id;
		}
		if ( $active_sold_key === 'sales' ) {

			if ( isset( $parameters['zip'] ) ) {
				$zip_string = '&zip=' . $parameters['zip'];
			}
			if ( isset( $parameters['city'] ) ) {
				$city_string = '&city=' . $parameters['city'];
			}
		} else {
			if ( isset( $parameters['zip'] ) ) {
				$zip_string = '&address.zip=' . $parameters['zip'];
			}
			if ( isset( $parameters['city'] ) ) {
				$city_string = '&address.city=' . $parameters['city'];
			}
		}
		if ( isset( $parameters['county'] ) ) {
			$county_string = '&county=' . $parameters['county'];
		}
		if ( isset( $parameters['size'] ) ) {
			$size_string = '&size=' . $parameters['size'];
		}
		if ( isset( $parameters['lot_size'] ) ) {
			$lot_size_string = '&lotSize.sqft=' . $parameters['lot_size'] . ':1000000000000';
		}
		if ( isset( $parameters['cap_rate'] ) ) {
			$cap_rate_field  = get_key( $extended_fields, $this->market, 'cap_rate' );
			$cap_rate_string = '&' . $cap_rate_field . '=' . $parameters['cap_rate'];
		}
		if ( isset( $parameters['price_range'] ) && isset( $parameters['for_sale_for_lease'] ) ) {
			if ( ( $list_price = $parameters['price_range'] ) && ( $parameters['for_sale_for_lease'] !== 'for_lease' ) ) {
				$list_price_string = '&listPrice=' . $list_price;
			}
		} else {
			if ( isset( $parameters['for_sale_for_lease'] ) ) {
				if ( $for_sale_for_lease = $parameters['for_sale_for_lease'] ) {
					if ( $for_sale_for_lease === 'for_lease' ) {
						$list_price_string = '&listPrice=0:100000';
					} else {
						$list_price_string = '&listPrice=99999:1000000000000';
					}
				}
			} else {
				if ( $this->is_search ) {
					if ( isset( $parameters['price_range'] ) ) {
						$list_price        = $parameters['price_range'];
						$list_price_string = '&listPrice=' . $list_price;
					} else {
						$list_price_string = '&listPrice=99999:1000000000000';
					}
				}
			}
		}
		if ( isset( $parameters['days_on_market'] ) ) {
			$current_time          = time();
			$days_seconds          = $current_time - ( $parameters['days_on_market'] * 60 * 60 * 24 );
			$days_on_market_string = '&listingDate=' . $days_seconds . ':' . $current_time;
		}
		if ( isset( $parameters['sold_in_last'] ) ) {
			$current_time        = time();
			$days_seconds        = $current_time - ( $parameters['sold_in_last'] * 60 * 60 * 24 );
			$sold_in_last_string = '&saleDate=' . $days_seconds . ':' . $current_time;
		}
		if ( isset( $parameters['for_sale_for_lease'] ) ) {
			/**
			 * For rental search, max price is $100 - there is no 'rental price', we must filter by listPrice
			 */
			if ( $parameters['for_sale_for_lease'] === 'for_lease' ) {
				$list_price_string = '&listPrice=0:100000';
			}
		}

		//var_dump($prop_type_key);
		if ( ( isset( $parameters['for_sale_for_lease'] ) ) && ( $prop_type_key == 'all_property_types') ) {
			if ( $parameters['for_sale_for_lease'] === 'for_lease' ) {
				$comm_custom_field = get_field('home_junction_commercial_search', 'option');
				$commercial_lease = get_commercial_lease_keys($comm_custom_field, $this->market);
				if ( $commercial_lease ) {
					$commercial_lease_string = '&' . $commercial_lease['key'] . '=' . $commercial_lease['value']; 
				var_dump( $commercial_lease_string );
				}
			}
		}

		$transient_name_string = 'ex-' . $this->market . $prop_type_key . $this->page_size . $active_sold_key . $id_string . $zip_string . $city_string . $size_string . $cap_rate_string . $keyword_string . $county_string . $list_price_string . $days_on_market_string . $sold_in_last_string;

		$this->transient_name = str_replace( ' ', '', $transient_name_string );

		$count_listings_trans = 'n_' . $this->transient_name;
		$total_num_listings   = get_transient( $count_listings_trans );

		if ( $this->is_search ) {
			$idx_listings_needed = idx_listings_page_size(
				$this->page_size,
				$this->wp_listing_count,
				$page_number,
				$total_num_listings
			);

			$page_number = idx_listings_current_page( $this->page_size, $this->wp_listing_count, $page_number );
		}

		if ( $status === 'sold' ) {
			$url = 'https://slipstream.homejunction.com/ws/sales/search?market=' . $this->market . $listing_type_string . '&pageSize=' . $this->page_size . '&images=true&details=' . $this->details . $id_string . $zip_string . $city_string . $size_string . $cap_rate_string . $keyword_string . $county_string . $list_price_string . $commercial_lease_string . $sold_in_last_string . '&pageNumber=' . $page_number;
		} else {
			$url = 'https://slipstream.homejunction.com/ws/listings/search?market=' . $this->market . $listing_type_string . '&pageSize=' . $this->page_size . '&images=true&details=' . $this->details . '&extended=' . $this->extended . '&features=' . $this->features . $id_string . $zip_string . $city_string . $size_string . $cap_rate_string . $keyword_string . $county_string . $list_price_string . $days_on_market_string . $lot_size_string . $commercial_lease_string . '&pageNumber=' . $page_number . '&sortField=daysOnMarket';
		}

		$listings = wp_remote_get( $url, array( 'headers' => array( 'HJI-Slipstream-Token' => $this->token ) ) );

		if ( is_object( $listings ) ) {
			if ( $listings->errors['http_request_failed'] ) {

				$this->network_error = true;
			}
		} else {
			$listing_data = json_decode( $listings['body'] );

			if ( $this->is_search ) {
				if ( $idx_listings_needed ) {
					$number_results_returned = count( $listing_data->result->$active_sold_key );
					if ( $number_results_returned > $idx_listings_needed ) {
						/**
						 * Store extras in transient
						 */
						$extra_amount       = ( $number_results_returned - $idx_listings_needed );
						$save_listing_array = array();

						for ( $x = 0; $x < $extra_amount; ++ $x ) {
							$save_listing_array[] = array_pop( $listing_data->result->$active_sold_key );
						}
						$extra_listings_serial = serialize( $save_listing_array );
						set_transient( $this->transient_name, $extra_listings_serial, 7200 );

					} elseif ( $number_results_returned < $idx_listings_needed ) {

						$transient_listings_needed = ( $idx_listings_needed - $number_results_returned );

						/**
						 * here we get the transient data.
						 */
						$extra_data_serial = get_transient( $this->transient_name );
						if ( $extra_data_serial ) {
							$extra_data     = unserialize( $extra_data_serial );
							$new_data_array = array();
							for ( $x = 0; $x < $transient_listings_needed; ++ $x ) {
								$new_data_array[] = array_pop( $extra_data );
							}

							if ( $extra_data ) {
								$extra_listings_serial = serialize( $extra_data );
								set_transient( $this->transient_name, $extra_listings_serial, 7200 );
							}

							$listing_data->result->$active_sold_key = array_merge( $listing_data->result->$active_sold_key, $new_data_array );
						}
					}

					$this->search_result = $listing_data->result->$active_sold_key;
				} elseif ( $page_number > 1 ) {

					$extra_data_serial = get_transient( $this->transient_name );
					if ( $extra_data_serial ) {
						/**
						 * Here we can assume this will all go on one page
						 */
						$extra_data                             = unserialize( $extra_data_serial );
						$listing_data->result->$active_sold_key = $extra_data;
					}
					$this->search_result = $listing_data->result->$active_sold_key;
				}
			} else {
				/**
				 * Just a single listing
				 */
				$this->search_result = $listing_data->result->$active_sold_key;
			}

			if ( ! get_transient( $count_listings_trans ) ) {
				set_transient( $count_listings_trans, $listing_data->result->total, 7200 );
			}

			$this->total_listings = $listing_data->result->total;
		}
	}
}
