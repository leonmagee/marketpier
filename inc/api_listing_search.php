<?php

/**
 * Class api_listing_search_new
 * This should really just be a method inside the search class that I already have.
 * I need to read through this and see exactly what it does. Then I can tweak out a method to just populate the fields that I
 * already have. For the other class, I need to break apart things that are specific for WP for not specific. Any functionality
 * that is manipulating the data after having been retrieved needs to be abstracted to a different method.
 */
class api_listing_search {

	public $market;
	public $search_result;
	public $total_listings;
	//public $search_parameters_array;
	public $details;
	public $extended;
	public $features;
	public $page_size;
	public $network_error;
	public $mls_number;
	public $listing_type;
	public $wp_listing_count;

	public function __construct( $token, $page_size, $market, $mls_number = false, $wp_listing_count = false ) {
		$this->market        = $market;
		$this->token         = $token;
		$this->details       = true;
		$this->extended      = true;
		$this->features      = true;
		$this->page_size     = $page_size;
		$this->network_error = false;
		//$mls_number = '170039114';
		$this->mls_number       = $mls_number;
		$this->listing_type     = 'Commercial';
		$this->wp_listing_count = $wp_listing_count;
		//$this->listing_type = false;
	}

	public function search_listings( $parameters = null, $page_number = 1 ) {

		$query_page_size = idx_listings_page_size(
			$this->page_size,
			$this->wp_listing_count,
			$page_number
		);

		//if ( $query_page_size ) {

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
			$cap_rate_field = get_key( $extended_fields, $this->market, 'cap_rate' );
			//$cap_rate_string = '&xf_lm_dec_10=' . $cap_rate_range;
			$cap_rate_string = '&' . $cap_rate_field . '=' . $cap_rate_range;
		}
//		if ( $id = $parameters['mls'] ) {
//			$id_string = '&id=' . $id;
//		}
		if ( $status = $parameters['status'] ) {
			$status_string = '&status=' . $status;
		}


		//$status_string = '&status=Contingent'; // @todo temp
		//$status_string = '&status=Back on Market'; // @todo temp ???
		//$status_string = '&status=Active'; // @todo temp
//		if ( $county = $parameters['county'] ) {
//			$county_string = '&county=' . $county;
//		}
		if ( $list_price = $parameters['listPrice'] ) {
			$list_price_string = '&listPrice=' . $list_price;
		}
//		if ( $sale_price = $parameters['salePrice'] ) {
//			$sale_price_string = '&salePrice=' . $sale_price;
//		}
//		if ( $keyword = $parameters['address-keyword'] ) {
//			$keyword_string = '&keyword=' . $keyword;
//		}
		//@todo this should be somewhere else
		//Commercial, Farm, Land, Multifamily, Rental, or Residential.
		//$listing_type = 'Commercial';
		//$listing_type = 'Residential';
		//$listing_type = 'Farm';
		//$listing_type = 'Land';
		//$listing_type = 'Multifamily';
		//$listing_type = 'Rental';
//		$listing_type = '';
//		if ( $listing_type ) {
//
//		}
//		if ( $listing_date = $parameters['listing_date'] ) {
//
//			$listing_date_new = strtotime($listing_date);
//			$listing_date_string = '&listingDate=' . $listing_date_new;
//		}

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


			//$listing_date_string = '&listingDate=' . $sale_date_start . ':' . $sale_date_end;
		}


		$url = 'https://slipstream.homejunction.com/ws/listings/search?market=' . $this->market . $listing_type_string . '&pageSize=' . $query_page_size . '&images=true&details=' . $this->details . '&extended=' . $this->extended . '&features=' . $this->features . $status_string . $id_string . $zip_string . $city_string . $size_string . $cap_rate_string . $keyword_string . $county_string . $list_price_string . $listing_date_string . '&pageNumber=' . $page_number;

		$listings = wp_remote_get( $url, array( 'headers' => array( 'HJI-Slipstream-Token' => $this->token ) ) );


		if ( $listings->errors['http_request_failed'] ) {

			$this->network_error = true;

		} else {

			$listing_data        = json_decode( $listings['body'] );
			if ( $query_page_size ) {
				$this->search_result = $listing_data->result;
			}
			$this->total_listings = $listing_data->result->total;
		}
		//}
	}
}
