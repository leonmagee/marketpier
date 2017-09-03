<?php

/**
 * Class slipstream_market_extended
 * @todo these values will come from a repeater field in the theme admin
 */
class slipstream_market_extended {

	public $market;
	public $cap_rate;

	public function __construct( $market, $cap_rate ) {
		$this->market   = $market;
		$this->cap_rate = $cap_rate;
	}
}
