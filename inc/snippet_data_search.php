<?php

/**
 * Class snippet_data_search
 */
class snippet_data_search {
	public $snippet_object_array;
	public $map_data_array;

	public function __construct() {
		/**
		 * Data from $_GET
		 */
		$status            = filter_input( INPUT_GET, 'status', FILTER_SANITIZE_ENCODED );
		$property_type     = filter_input( INPUT_GET, 'property_type', FILTER_SANITIZE_SPECIAL_CHARS );
		$city_zip          = filter_input( INPUT_GET, 'city_zip', FILTER_SANITIZE_SPECIAL_CHARS );
		$city_zip          = rawurldecode( $city_zip );
		$meta_search_array = array();
		if ( $city_zip ) {
			if ( is_numeric( $city_zip ) ) {
				$meta_search_array[] = array(
					'key'   => 'listing_zip',
					'value' => $city_zip
				);
			} else {
				$meta_search_array[] = array(
					'key'     => 'listing_city',
					'value'   => $city_zip,
					'compare' => 'LIKE'
				);
			}
		}

		if ( $status ) {
			if ( $status == 'sold_listings' ) {
				$meta_search_array[] = array(
					'key'   => 'listing_status',
					'value' => 'sold'
				);
			} else {
				$meta_search_array[] = array(
					'key'   => 'listing_for_sale_or_for_lease',
					'value' => $status
				);
			}
		}
		if ( $property_type ) {
			if ( $property_type !== 'all_property_types' ) {
				$meta_search_array[] = array(
					'key'   => 'listing_type',
					'value' => $property_type
				);
			}
		}
		$snippet_objects    = array();
		$map_data_array_src = array();
		$args               = array(
			'post_type'  => 'mp-listing',
			'meta_query' => $meta_search_array,
		);
		$listing_query      = new WP_Query( $args );

		while ( $listing_query->have_posts() ) {

			$listing_query->the_post();

			$listing_data = new snippet_data();
			$listing_data->listing_data_from_WP();

			$snippet_objects[] = $listing_data;

			$price_label = $listing_data->price;

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

			/**
			 * Only add to this array if there are both lat and long, OR a complete address
			 * Otherwise the listing can't show up on the map.
			 */
			if ( ( $listing_data->lat && $listing_data->long ) || $listing_data->combined_address ) {

				$map_data_array_src[] = array(
					'lat'     => $listing_data->lat,
					'long'    => $listing_data->long,
					'address' => $listing_data->combined_address,
					'price'   => $price_label,
					'url'     => $listing_data->listing_url
				);

			}
		}
		$this->snippet_object_array = $snippet_objects;
		$this->map_data_array       = $map_data_array_src;
	}
}