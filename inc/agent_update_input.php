<?php

/**
 * Class agent_update_input
 *
 * *** IMPORTANT *** The 'name' property must match the 'key' in the database for each property, either
 * user data, user meta data, or ACF field.
 */
class agent_update_input {

	public $label;
	public $name;
	public $value;
	public $placeholder;
	public $required;
	public $agent_id;

	public function __construct( $label, $name, $agent_id, $input_type = 'input', $required = false ) {

		$this->label = $label;
		$this->name = $name;
		$this->agent_id = $agent_id;
		$this->required = $required;
		$this->input_type = $input_type;
	}

	public function get_placeholder() {

		if ( $value = $this->value ) {

			$this->placeholder = $value;

		} else {

			$this->placeholder = 'enter value';
		}
	}

	/**
	 *  Methods to be defined by extending classes
	 */
	public function get_value() {}

	public function update_value() {}

//	public function get_current_input() {
//
//		$input_item = filter_input( INPUT_POST, $this->name, FILTER_SANITIZE_SPECIAL_CHARS );
//		var_dump( $input_item );
//		return $input_item;
//	}

}