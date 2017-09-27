<?php

/**
 * Class get_slipstream_token
 * Get token and markets
 */
class get_slipstream_token {

	public $license_key;
	public $slipstream_token;
	public $markets;

	public function __construct() {
		$this->license_key = 'C698-55BF-F769-2B69';

		$slipstream = wp_remote_post( 'https://slipstream.homejunction.com/ws/api/authenticate?license=' . $this->license_key . '&version=v20160226' );
		if ( is_object( $slipstream ) ) {
			if ( $slipstream->errors['http_request_failed'] ) {
				die( 'can not authenticate slipstream - http request failed - from listing-search.php' );
			}
		}
		$slipstream_json = json_decode( $slipstream['body'] );
		/**
		 * Set Token
		 */
		$this->slipstream_token = $slipstream_json->result->token;
		/**
		 * Set Markets
		 */
//		$market_array = array();
//		foreach ( $slipstream_json->result->markets as $market ) {
//			$market_array[] = array( 'id' => $market->id, 'name' => $market->name );
//		}
//		$this->markets = $market_array;

		$market_array = array();
		//var_dump( $slipstream_json->result->markets );
		foreach ( $slipstream_json->result->markets as $market ) {
			//var_dump( $market->metadata );
			$market_array[] = $market->id;
		}
		$this->markets = $market_array;
	}
}
