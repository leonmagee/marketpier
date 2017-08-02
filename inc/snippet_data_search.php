<?php

/**
 * Class snippet_data_search
 */
class snippet_data_search {

	public $snippet_object_array;
	public $map_data_array;

	public function __construct() {

		$snippet_objects    = array();
		$map_data_array_src = array();
		$args               = array( 'post_type' => 'mp-listing' );

		$listing_query = new WP_Query( $args );

		while ( $listing_query->have_posts() ) {

			$listing_query->the_post();


			$listing_data = new snippet_data();
			$listing_data->listing_data_from_WP();

			$snippet_objects[] = $listing_data;

			$price_label = $listing_data->price;

			if ( $price_label > 999999 ) {
				$decimal = substr($price_label, -6,1);
				$price_label = substr($price_label, 0,-6);
				if ( $decimal ) {
					$price_label = $price_label . '.' . $decimal . 'm';
				} else {
					$price_label = $price_label . 'm';
				}
			} elseif ( $price_label > 999 ) {
				$price_label = substr($price_label, 0,-3);
				$price_label = $price_label . 'k';
			} else {
				$price_label = '$' . $price_label;
			}

			$map_data_array_src[] = array(
				'lat'     => $listing_data->lat,
				'long'    => $listing_data->long,
				'address' => $listing_data->combined_address,
				'price'   => $price_label,
				'url'     => $listing_data->listing_url
			);

		}

		$this->snippet_object_array = $snippet_objects;
		$this->map_data_array       = $map_data_array_src;

	}

}