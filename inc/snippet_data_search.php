<?php

/**
 * Class snippet_data_search
 */
class snippet_data_search {

	public $snippet_object_array;

	public function __construct() {

		$snippet_objects = array();
		$args            = array( 'post_type' => 'mp-listing' );

		$listing_query = new WP_Query( $args );

		while ( $listing_query->have_posts() ) {

			$listing_query->the_post();


			$listing_data = new snippet_data();
			$listing_data->listing_data_from_WP();

			$snippet_objects[] = $listing_data;
		}

		$this->snippet_object_array = $snippet_objects;

	}

}