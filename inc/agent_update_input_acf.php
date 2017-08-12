<?php

/**
 * Class agent_update_input_acf
 */
class agent_update_input_acf extends agent_update_input {

	public function get_value() {

		$this->value = get_field( $this->name, 'user_' . $this->agent_id );
	}

	public function update_value() {

		$key = $this->name;

		$ajax_post = filter_input( INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS );

		update_field( $key, $ajax_post, 'user_' . $this->agent_id );
	}
}