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
	public $search_parameters_array;
	public $details;
	public $extended;
	public $features;
	public $page_size;
	public $counties;
	public $network_error;

	public function __construct( $token, $page_size, $market ) {
		$this->market        = $market;
		$this->token         = $token;
		$this->details       = true;
		$this->extended      = true;
		$this->features      = true;
		$this->page_size     = $page_size;
		$this->network_error = false;
	}

	public function search_listings( $parameters = null, $page_number = 1 ) {

		/**
		 * Get submitted fields
		 */
		//$id_string = $status_string = $county_string = $list_price_string = $keyword_string = $listing_date_string = '';
		$id_string = $county_string = $list_price_string = $keyword_string = $listing_date_string = $status_string = '';
		if ( $id = $parameters['mls'] ) {
			$id_string = '&id=' . $id;
		}
		if ( $status = $parameters['status'] ) {
			$status_string = '&status=' . $status;
		}
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
		$listing_type = 'residential';
//		if ( $listing_date = $parameters['listing_date'] ) {
//
//			$listing_date_new = strtotime($listing_date);
//			$listing_date_string = '&listingDate=' . $listing_date_new;
//			var_dump( $listing_date_string );
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

			//$listing_type = '';


			//$listing_date_string = '&listingDate=' . $sale_date_start . ':' . $sale_date_end;
			//var_dump( $sale_date_string );
		}


		$url = 'https://slipstream.homejunction.com/ws/listings/search?market=' . $this->market . '&listingType=' . $listing_type . '&pageSize=' . $this->page_size . '&details=' . $this->details . '&extended=' . $this->extended . '&features=' . $this->features . $status_string . $id_string . $keyword_string . $county_string . $list_price_string . $listing_date_string . '&pageNumber=' . $page_number;



		$listings = wp_remote_get( $url, array( 'headers' => array( 'HJI-Slipstream-Token' => $this->token ) ) );


		if ( $listings->errors['http_request_failed'] ) {

			$this->network_error = true;

		} else {

			$listing_data         = json_decode( $listings['body'] );
			$this->search_result  = $listing_data->result;
			$this->total_listings = $listing_data->result->total;
		}
	}
}
