<?php

/**
 * Class api_listing_search_new
 * This should really just be a method inside the search class that I already have.
 * I need to read through this and see exactly what it does. Then I can tweak out a method to just populate the fields that I
 * already have. For the other class, I need to break apart things that are specific for WP for not specific. Any functionality
 * that is manipulating the data after having been retrieved needs to be abstracted to a different method.
 *
 * @todo I broke this for single listngs when I made the changes for the searh.. there needs to be a conditional in here somewhere
 * when this is for snippets vs. for a single listing?
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
	public $listing_type;
	public $wp_listing_count;
	public $transient_name;
	public $is_search;

	public function __construct( $token, $page_size, $market, $mls_number = false, $wp_listing_count = false, $is_search = true ) {
		$this->market           = $market;
		$this->token            = $token;
		$this->details          = true;
		$this->extended         = true;
		$this->features         = true;
		$this->page_size        = $page_size;
		$this->network_error    = false;
		$this->mls_number       = $mls_number;
		$this->listing_type     = 'Commercial';
		$this->wp_listing_count = $wp_listing_count;
		$this->is_search        = $is_search;
	}

	public function search_listings( $parameters = null, $page_number = 1 ) {



		$extended_fields = get_field( 'home_junction_extended_fields', 'option' );
		/**
		 * Get submitted fields
		 */
		$listing_type_string = $id_string = $zip_string = $city_string = $size_string = $cap_rate_string = $county_string = $list_price_string = $keyword_string = $listing_date_string = $status_string = '';
		if ( $listing_type = $this->listing_type ) {
			$listing_type_string = '&listingType=' . $listing_type;
		}
		if ( $id = $this->mls_number ) {
			$id_string = '&id=' . $id;
		}
		if ( $zip = $parameters['zip'] ) {
			$zip_string = '&address.zip=' . $zip;
		}
		if ( $city = $parameters['city'] ) {
			$city_string = '&address.city=' . $city;
		}
		if ( $size = $parameters['size'] ) {
			$size_string = '&size=' . $size;
		}
		if ( $cap_rate_range = $parameters['cap_rate'] ) {
			$cap_rate_field  = get_key( $extended_fields, $this->market, 'cap_rate' );
			$cap_rate_string = '&' . $cap_rate_field . '=' . $cap_rate_range;
		}
		if ( $status = $parameters['status'] ) {
			$status_string = '&status=' . $status;
		}
		if ( $list_price = $parameters['listPrice'] ) {
			$list_price_string = '&listPrice=' . $list_price;
		}

		/**
		 * Create query string for Listing Date...
		 */
		if ( $parameters['listing_date_start'] || $parameters['listing_date_end'] ) {

			$listing_date_start = $parameters['listing_date_start'];
			$listing_date_end   = $parameters['listing_date_end'];

			if ( $listing_date_start && $listing_date_end ) {

				$listing_date_start  = strtotime( $listing_date_start );
				$listing_date_end    = strtotime( $listing_date_end );
				$listing_date_string = '&listingDate=' . $listing_date_start . ':' . $listing_date_end;

			} elseif ( $listing_date_start ) {

				$listing_date_start  = strtotime( $listing_date_start );
				$listing_date_string = '&listingDate=>' . $listing_date_start;

			} elseif ( $listing_date_end ) {

				$listing_date_end    = strtotime( $listing_date_end );
				$listing_date_string = '&listingDate=<' . $listing_date_end;
			}
		}

		$this->transient_name = 'ex-' . $this->market . $listing_type_string . $this->page_size . $status_string . $id_string . $zip_string . $city_string . $size_string . $cap_rate_string . $keyword_string . $county_string . $list_price_string . $listing_date_string;

		$count_listings_trans = 'n_' . $this->transient_name;
		$total_num_listings = get_transient( $count_listings_trans );

//		if ( ! get_transient( $count_listings_trans ) ) {
//			set_transient( $count_listings_trans, $listing_data->result->total, 3600 );
//		}

		if ( $this->is_search ) {
			$idx_listings_needed = idx_listings_page_size(
				$this->page_size,
				$this->wp_listing_count,
				$page_number,
				$total_num_listings
			);
			var_dump( 'IDX Needed', $idx_listings_needed );

			$page_number = idx_listings_current_page( $this->page_size, $this->wp_listing_count, $page_number );
			var_dump( 'IDX Page Number', $page_number );
		}

		$url = 'https://slipstream.homejunction.com/ws/listings/search?market=' . $this->market . $listing_type_string . '&pageSize=' . $this->page_size . '&images=true&details=' . $this->details . '&extended=' . $this->extended . '&features=' . $this->features . $status_string . $id_string . $zip_string . $city_string . $size_string . $cap_rate_string . $keyword_string . $county_string . $list_price_string . $listing_date_string . '&pageNumber=' . $page_number;

		$listings = wp_remote_get( $url, array( 'headers' => array( 'HJI-Slipstream-Token' => $this->token ) ) );


		if ( $listings->errors['http_request_failed'] ) {

			$this->network_error = true;

		} else {
			$listing_data = json_decode( $listings['body'] );

			/**
			 * I need a big conditional here to check to see if this is a snippet search or a single listing...
			 *
			 */

			if ( $this->is_search ) {

//				$this->transient_name = 'ex-' . $this->market . $listing_type_string . $this->page_size . $status_string . $id_string . $zip_string . $city_string . $size_string . $cap_rate_string . $keyword_string . $county_string . $list_price_string . $listing_date_string;
				if ( $idx_listings_needed ) {

					$number_results_returned = count( $listing_data->result->listings );
					//var_dump( $listing_data->result->listings );
					var_dump( 'count results: ', $number_results_returned );
					/**
					 * I need to remove two items here.
					 * @todo how to tell if this is one of the last two pages?
					 * maybe simply check to see if the returned IDX results are less than the page size, and if they are, then
					 * we can paste the transient back on...
					 */
					if ( $number_results_returned > $idx_listings_needed ) {
						/**
						 * Store extras in transient
						 */
						$extra_amount = ( $number_results_returned - $idx_listings_needed );
						//var_dump( 'extra: ', $extra_amount );

						var_dump( $this->transient_name );
						$save_listing_array = array();

						for ( $x = 0; $x < $extra_amount; ++ $x ) {
							$save_listing_array[] = array_pop( $listing_data->result->listings );
						}
						$extra_listings_serial = serialize( $save_listing_array );
						set_transient( $this->transient_name, $extra_listings_serial, 60000 );
						//var_dump( $save_listing_array );
						//$this->search_result = $listing_data->result->listings;

					} elseif ( $number_results_returned < $idx_listings_needed ) {

						$transient_listings_needed = ( $idx_listings_needed - $number_results_returned );
						//var_dump( 'trans needed: ' . $transient_listings_needed );

						//var_dump( 'this is happening!' );
						/**
						 * @todo I can do math here to see how many we need?
						 * here we get the transient data.
						 * Here we need to deal with situations where the number of extra IDX listings falls to two pages,
						 * in this case I need to pop off the required items from the transient (data should aways be retrieved
						 * like this, and then if the transient array still exists you can re-save it.
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
								// @todo resave transient with less data...
								set_transient( $this->transient_name, $extra_listings_serial, 60000 );
							}

							$listing_data->result->listings = array_merge( $listing_data->result->listings, $new_data_array );
						}
					}

					$this->search_result = $listing_data->result->listings;
				} else {
					/**
					 * Code repeated here, should be more try
					 */
					$extra_data_serial = get_transient( $this->transient_name );
					if ( $extra_data_serial ) { // here we can assume this will all go on one page
						$extra_data     = unserialize( $extra_data_serial );
						//var_dump( $extra_data );
//						$new_data_array = array();
//						for ( $x = 0; $x < $transient_listings_needed; ++ $x ) {
//							$new_data_array[] = array_pop( $extra_data );
//						}

//						if ( $extra_data ) {
//							$extra_listings_serial = serialize( $extra_data );
//							// @todo resave transient with less data...
//							set_transient( $this->transient_name, $extra_listings_serial, 60000 );
//						}

						$listing_data->result->listings = $extra_data;
					}
					$this->search_result = $listing_data->result->listings;
				}
			} else {
				$this->search_result = $listing_data->result->listings;
			}

			//$count_listings_trans = 'n_' . $this->transient_name;
			if ( ! get_transient( $count_listings_trans ) ) {
				set_transient( $count_listings_trans, $listing_data->result->total, 3600 );
			}

			$this->total_listings = $listing_data->result->total;
			/**
			 * Here we need to save the total number of listings into a transient
			 */
		}
	}
}
